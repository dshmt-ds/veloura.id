<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Throwable;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function checkout(Booking $booking)
    {
        $user = auth()->user();

        if (
            $user->hasRole('customer') &&
            $booking->customer_id !== $user->id
        ) {
            abort(403, 'Akses ditolak.');
        }

        $booking->load([
            'customer',
            'staff',
            'items.service',
            'latestPayment'
        ]);

        if (in_array(strtolower($booking->status), ['confirmed', 'approved', 'completed', 'paid', 'cancelled', 'batal'])) {
            return redirect()
                ->route(
                    $user->hasRole('customer')
                        ? 'customer.bookings.show'
                        : 'admin.bookings.show',
                    $booking
                )
                ->with(
                    'error',
                    'Booking ini tidak sedang menunggu pembayaran.'
                );
        }

        $payment = $booking->payments()
            ->where('gateway_provider', 'midtrans')
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$payment) {
            $payment = $this->createPayment($booking);
        }

        if (!$payment->snap_token) {
            $payment = $this->createSnapTransaction(
                $booking,
                $payment
            );
        }

        return view('payments.checkout', [
            'booking' => $booking,
            'payment' => $payment,
        ]);
    }

    private function createPayment(Booking $booking): Payment
    {
        return DB::transaction(function () use ($booking) {
            $paymentReference =
                'VEL-' .
                $booking->booking_code .
                '-' .
                Str::upper(Str::random(6));

            return Payment::create([
                'booking_id' => $booking->id,
                'payment_reference' => $paymentReference,
                'gateway_provider' => 'midtrans',
                'amount' => $booking->total_amount,
                'currency' => 'IDR',
                'status' => 'pending',
                'expires_at' => $booking->payment_due_at ?? now()->addHours(24),
            ]);
        });
    }

    private function createSnapTransaction(
        Booking $booking,
        Payment $payment
    ): Payment {
        $itemDetails = [];

        if ($booking->items && $booking->items->count() > 0) {
            foreach ($booking->items as $item) {
                $itemDetails[] = [
                    'id' => (string) ($item->service_id ?? $item->id ?? 'ITEM-' . $booking->id),
                    'price' => (int) ($item->price ?? $item->amount ?? $booking->total_amount),
                    'quantity' => 1,
                    'name' => Str::limit($item->service_name ?? $item->service->name ?? 'Layanan Salon', 50),
                ];
            }
        } else {
            $itemDetails[] = [
                'id' => 'BOOKING-' . $booking->id,
                'price' => (int) $booking->total_amount,
                'quantity' => 1,
                'name' => Str::limit('Pembayaran Booking ' . $booking->booking_code, 50),
            ];
        }

        $itemTotal = collect($itemDetails)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $grossAmount = (int) $itemTotal > 0 ? (int) $itemTotal : (int) $booking->total_amount;

        $customer = $booking->customer;
        $customerName = $customer->name ?? 'Customer Veloura';
        $nameParts = preg_split('/\s+/', trim($customerName));
        $firstName = $nameParts[0] ?? 'Customer';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        $params = [
            'transaction_details' => [
                'order_id' => $payment->payment_reference,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $customer->email ?? 'customer@example.com',
                'phone' => $customer->phone ?? '081234567890',
            ],
            'expiry' => [
                'start_time' => now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $payment->update([
                'snap_token' => $snapToken,
                'expires_at' => $booking->payment_due_at ?? now()->addHours(24),
            ]);

            return $payment->fresh();

        } catch (Throwable $e) {
            report($e);
            abort(
                500,
                'Gagal membuat transaksi Midtrans: ' . $e->getMessage()
            );
        }
    }

    public function finish(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran sedang diproses. Status akan diperbarui setelah konfirmasi Midtrans.',
        ]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        $orderId           = $payload['order_id'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            return response()->json(['message' => 'Invalid notification payload.'], 400);
        }

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if (!hash_equals($expectedSignature, $signatureKey)) {
            return response()->json(['message' => 'Invalid signature.'], 403);
        }

        $payment = Payment::where('gateway_provider', 'midtrans')
            ->where('payment_reference', $orderId)
            ->with('booking')
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found.'], 404);
        }

        if (round((float) $payment->amount, 2) !== round((float) $grossAmount, 2)) {
            return response()->json(['message' => 'Invalid payment amount.'], 422);
        }

        $eventKey = 'midtrans:' . $orderId . ':' . ($transactionId ?? 'unknown') . ':' . ($transactionStatus ?? 'unknown');

        try {
            DB::transaction(function () use (
                $payment,
                $payload,
                $eventKey,
                $transactionStatus,
                $transactionId,
                $paymentType
            ) {
                $existingEvent = PaymentEvent::where('event_key', $eventKey)->first();
                if ($existingEvent) {
                    return;
                }

                $event = PaymentEvent::create([
                    'payment_id'        => $payment->id,
                    'gateway_provider'  => 'midtrans',
                    'event_key'         => $eventKey,
                    'payload'           => $payload,
                    'processing_status' => 'received',
                ]);

                $payment->gateway_transaction_id = $transactionId;
                $payment->payment_method         = $paymentType;

                if ($transactionStatus === 'settlement') {
                    $payment->status  = 'paid';
                    $payment->paid_at = now();
                    $payment->save();

                    if ($payment->booking) {
                        $payment->booking->update(['status' => 'confirmed']);
                    }
                } elseif ($transactionStatus === 'capture') {
                    $fraudStatus = $payload['fraud_status'] ?? null;
                    if ($fraudStatus === null || strtolower($fraudStatus) === 'accept') {
                        $payment->status  = 'paid';
                        $payment->paid_at = now();
                        $payment->save();

                        if ($payment->booking) {
                            $payment->booking->update(['status' => 'confirmed']);
                        }
                    }
                } elseif ($transactionStatus === 'pending') {
                    $payment->status = 'pending';
                    $payment->save();
                } elseif ($transactionStatus === 'expire') {
                    $payment->status = 'expired';
                    $payment->save();

                    if ($payment->booking) {
                        $payment->booking->update(['status' => 'expired']);
                    }
                } elseif ($transactionStatus === 'cancel') {
                    $payment->status = 'cancelled';
                    $payment->save();

                    if ($payment->booking) {
                        $payment->booking->update(['status' => 'cancelled']);
                    }
                } elseif ($transactionStatus === 'deny' || $transactionStatus === 'failure') {
                    $payment->status = 'failed';
                    $payment->save();
                } elseif ($transactionStatus === 'refund' || $transactionStatus === 'partial_refund') {
                    $payment->status = 'refunded';
                    $payment->save();
                }

                $event->update([
                    'processing_status' => 'processed',
                    'processed_at'      => now(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Notification processed.'
            ], 200);

        } catch (Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Notification processing failed.'
            ], 500);
        }
    }
}