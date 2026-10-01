<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_email()
    {
        $user = User::factory()->create([
            'email' => 'old@email.com',
            'role' => 'masyarakat',
            'password' => Hash::make('password123')
        ]);

        $response = $this->actingAs($user)->post('/profile', [
            'email' => 'new@email.com',
        ]);

        $response->assertSessionHas('success', 'Profile updated successfully.');
        $response->assertRedirect('/profile');
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'new@email.com'
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword')
        ]);

        $response = $this->actingAs($user)->post('/profile', [
            'email' => $user->email,
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertSessionHas('success', 'Profile updated successfully.');
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_user_cannot_update_password_with_wrong_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword')
        ]);

        $response = $this->actingAs($user)->post('/profile', [
            'email' => $user->email,
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertSessionHasErrors(['current_password' => 'Password saat ini salah']);
        $this->assertTrue(Hash::check('oldpassword', $user->fresh()->password));
    }

    public function test_user_can_upload_profile_photo()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post('/profile', [
            'email' => $user->email,
            'foto' => $file,
        ]);

        $response->assertSessionHas('success', 'Profile updated successfully.');
        
        $user->refresh();
        $this->assertNotNull($user->foto);
        Storage::disk('public')->assertExists('profile/' . $user->foto);
    }
}
