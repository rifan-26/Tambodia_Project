<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StaffManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create();
        
        // Fake storage
        Storage::fake('public');
    }

    /** @test */
    public function it_can_get_all_staff()
    {
        // Create test staff
        Staff::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->getJson('/api/staff');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'staff' => [
                    '*' => ['id', 'name', 'photo_path', 'position', 'is_active']
                ]
            ])
            ->assertJson(['success' => true]);
    }

    /** @test */
    public function it_can_create_staff_with_valid_data()
    {
        $file = UploadedFile::fake()->image('staff.jpg', 800, 800);

        $response = $this->actingAs($this->user)
            ->postJson('/api/staff', [
                'name' => 'John Doe',
                'photo' => $file,
                'position' => 1
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Staff berhasil ditambahkan'
            ]);

        $this->assertDatabaseHas('staff', [
            'name' => 'John Doe',
            'position' => 1,
            'is_active' => true
        ]);

        // Check file was stored
        $staff = Staff::where('name', 'John Doe')->first();
        Storage::disk('public')->assertExists($staff->photo_path);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_staff()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/staff', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'photo', 'position']);
    }

    /** @test */
    public function it_validates_photo_format_when_creating_staff()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->user)
            ->postJson('/api/staff', [
                'name' => 'John Doe',
                'photo' => $file,
                'position' => 1
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['photo']);
    }

    /** @test */
    public function it_validates_photo_size_when_creating_staff()
    {
        // Create file larger than 5MB (5120 KB)
        $file = UploadedFile::fake()->image('large.jpg')->size(6000);

        $response = $this->actingAs($this->user)
            ->postJson('/api/staff', [
                'name' => 'John Doe',
                'photo' => $file,
                'position' => 1
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['photo']);
    }

    /** @test */
    public function it_validates_position_value_when_creating_staff()
    {
        $file = UploadedFile::fake()->image('staff.jpg');

        $response = $this->actingAs($this->user)
            ->postJson('/api/staff', [
                'name' => 'John Doe',
                'photo' => $file,
                'position' => 3 // Invalid position
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['position']);
    }

    /** @test */
    public function it_can_update_staff()
    {
        $staff = Staff::factory()->create([
            'name' => 'Old Name',
            'position' => 1
        ]);

        $response = $this->actingAs($this->user)
            ->putJson("/api/staff/{$staff->id}", [
                'name' => 'New Name',
                'position' => 2
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Staff berhasil diupdate'
            ]);

        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'name' => 'New Name',
            'position' => 2
        ]);
    }

    /** @test */
    public function it_can_update_staff_with_new_photo()
    {
        $staff = Staff::factory()->create();
        $oldPhotoPath = $staff->photo_path;

        $newFile = UploadedFile::fake()->image('new-staff.jpg');

        $response = $this->actingAs($this->user)
            ->putJson("/api/staff/{$staff->id}", [
                'name' => $staff->name,
                'photo' => $newFile,
                'position' => $staff->position
            ]);

        $response->assertStatus(200);

        $staff->refresh();
        $this->assertNotEquals($oldPhotoPath, $staff->photo_path);
        Storage::disk('public')->assertExists($staff->photo_path);
    }

    /** @test */
    public function it_can_delete_staff()
    {
        $staff = Staff::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/staff/{$staff->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Staff berhasil dihapus'
            ]);

        $this->assertDatabaseMissing('staff', [
            'id' => $staff->id
        ]);
    }

    /** @test */
    public function it_deletes_photo_when_deleting_staff()
    {
        $file = UploadedFile::fake()->image('staff.jpg');
        Storage::disk('public')->put('staff/test.jpg', $file);

        $staff = Staff::factory()->create([
            'photo_path' => 'staff/test.jpg'
        ]);

        $this->actingAs($this->user)
            ->deleteJson("/api/staff/{$staff->id}");

        Storage::disk('public')->assertMissing('staff/test.jpg');
    }

    /** @test */
    public function it_returns_404_when_updating_non_existent_staff()
    {
        $response = $this->actingAs($this->user)
            ->putJson('/api/staff/999', [
                'name' => 'Test',
                'position' => 1
            ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_when_deleting_non_existent_staff()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson('/api/staff/999');

        $response->assertStatus(404);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_staff_api()
    {
        $response = $this->getJson('/api/staff');
        $response->assertStatus(401);

        $response = $this->postJson('/api/staff', []);
        $response->assertStatus(401);

        $response = $this->putJson('/api/staff/1', []);
        $response->assertStatus(401);

        $response = $this->deleteJson('/api/staff/1');
        $response->assertStatus(401);
    }
}
