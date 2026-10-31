<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        ServiceCategory::create(['name' => 'Rambut', 'is_active' => true]);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    private function fields(): array
    {
        return ['name' => 'Hair Spa', 'service_category_id' => ServiceCategory::firstOrFail()->id, 'category' => 'Rambut', 'price' => 100000, 'duration' => 60, 'status' => 'active'];
    }

    public function test_service_image_is_uploaded(): void
    {
        $this->post(route('admin.services.store'), [...$this->fields(), 'image' => UploadedFile::fake()->image('salon.jpg')])
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.services.index'));
        $service = Service::firstOrFail();
        Storage::disk('public')->assertExists($service->image);
        $this->assertSame(Storage::disk('public')->url($service->image), $service->image_url);
        $this->assertSame(ServiceCategory::firstOrFail()->id, (int) $service->service_category_id);
        $this->assertSame('Rambut', $service->getRawOriginal('category'));
    }

    public function test_service_category_can_be_changed(): void
    {
        $service = Service::create($this->fields());
        $category = ServiceCategory::create(['name' => 'Wajah', 'is_active' => true]);

        $this->put(route('admin.services.update', $service), [
            ...$this->fields(), 'service_category_id' => $category->id,
        ])->assertSessionHasNoErrors();

        $this->assertSame($category->id, (int) $service->fresh()->service_category_id);
        $this->assertSame('Wajah', $service->fresh()->getRawOriginal('category'));
        $this->assertTrue($category->services()->whereKey($service->id)->exists());
    }

    public function test_service_without_upload_uses_default(): void
    {
        $this->post(route('admin.services.store'), $this->fields())->assertSessionHasNoErrors();
        $service = Service::firstOrFail();
        $this->assertNull($service->image);
        $this->assertSame(asset('images/service-default.svg'), $service->image_url);
    }

    public function test_edit_without_upload_preserves_image(): void
    {
        Storage::disk('public')->put('services/old.jpg', 'old image');
        $service = Service::create([...$this->fields(), 'image' => 'services/old.jpg']);
        $this->put(route('admin.services.update', $service), $this->fields())->assertSessionHasNoErrors();
        $this->assertSame('services/old.jpg', $service->fresh()->image);
        Storage::disk('public')->assertExists('services/old.jpg');
    }

    public function test_replacement_deletes_old_image(): void
    {
        Storage::disk('public')->put('services/old.jpg', 'old image');
        $service = Service::create([...$this->fields(), 'image' => 'services/old.jpg']);
        $this->put(route('admin.services.update', $service), [...$this->fields(), 'image' => UploadedFile::fake()->image('new.png')])
            ->assertSessionHasNoErrors();
        Storage::disk('public')->assertMissing('services/old.jpg');
        Storage::disk('public')->assertExists($service->fresh()->image);
    }

    public function test_image_can_be_removed_to_use_default(): void
    {
        Storage::disk('public')->put('services/old.jpg', 'old image');
        $service = Service::create([...$this->fields(), 'image' => 'services/old.jpg']);
        $this->put(route('admin.services.update', $service), [...$this->fields(), 'remove_image' => '1'])
            ->assertSessionHasNoErrors();
        $this->assertNull($service->fresh()->image);
        Storage::disk('public')->assertMissing('services/old.jpg');
    }

    public function test_invalid_and_oversized_files_are_rejected(): void
    {
        foreach ([UploadedFile::fake()->create('file.pdf', 10, 'application/pdf'), UploadedFile::fake()->image('large.jpg')->size(2049)] as $file) {
            $this->post(route('admin.services.store'), [...$this->fields(), 'image' => $file])->assertSessionHasErrors('image');
        }
        $this->assertDatabaseCount('services', 0);
    }
}
