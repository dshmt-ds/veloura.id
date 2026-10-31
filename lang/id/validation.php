<?php
return [
    'required' => ':attribute wajib diisi.', 'string' => ':attribute harus berupa teks.',
    'email' => ':attribute harus berupa alamat email yang valid.', 'unique' => ':attribute sudah digunakan.',
    'confirmed' => 'Konfirmasi :attribute tidak sesuai.', 'current_password' => 'Kata sandi saat ini tidak sesuai.',
    'lowercase' => ':attribute harus menggunakan huruf kecil.', 'date' => ':attribute harus berupa tanggal yang valid.',
    'date_format' => 'Format :attribute harus :format.', 'after' => ':attribute harus setelah :date.',
    'after_or_equal' => ':attribute harus sama atau setelah :date.', 'exists' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa bilangan bulat.', 'numeric' => ':attribute harus berupa angka.',
    'array' => ':attribute harus berupa daftar.', 'distinct' => ':attribute tidak boleh duplikat.',
    'boolean' => ':attribute harus bernilai benar atau salah.', 'in' => ':attribute yang dipilih tidak valid.',
    'image' => ':attribute harus berupa gambar.', 'mimes' => ':attribute harus berformat :values.',
    'uploaded' => ':attribute gagal diunggah.',
    'max' => ['string'=>':attribute maksimal :max karakter.', 'numeric'=>':attribute maksimal :max.', 'file'=>':attribute maksimal :max KB.', 'array'=>':attribute maksimal :max pilihan.'],
    'min' => ['string'=>':attribute minimal :min karakter.', 'numeric'=>':attribute minimal :min.', 'file'=>':attribute minimal :min KB.', 'array'=>':attribute minimal :min pilihan.'],
    'attributes' => ['name'=>'Nama', 'email'=>'Email', 'phone'=>'Nomor telepon', 'password'=>'Kata sandi', 'current_password'=>'Kata sandi saat ini', 'password_confirmation'=>'Konfirmasi kata sandi', 'customer_id'=>'Pelanggan', 'staff_id'=>'Staff', 'services'=>'Layanan', 'services.*'=>'Layanan', 'service_category_id'=>'Kategori layanan', 'price'=>'Harga', 'duration'=>'Durasi', 'image'=>'Gambar', 'start_at'=>'Waktu mulai', 'start_time'=>'Jam mulai', 'end_time'=>'Jam selesai', 'schedule_date'=>'Tanggal jadwal', 'payment_due_at'=>'Batas pembayaran', 'status'=>'Status', 'description'=>'Deskripsi', 'notes'=>'Catatan'],
];
