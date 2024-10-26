<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Galeri;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GaleriControllerTest extends TestCase
{
    use RefreshDatabase;

    // Setup to create a user and act as it for authentication
    protected function actingAsUser()
    {
        $user = User::create([
            'username' => 'testuser',
            'is_online' => 1,
            'last_login' => now(),
            'password' => bcrypt('password'), // Replace with an appropriate password
        ]);
        return $this->actingAs($user);
    }

    public function test_store_galeri()
    {
        // Mocking storage for file upload
        Storage::fake('public');
        
        // Simulating file upload
        $file = UploadedFile::fake()->image('sample.png');
    
        // Acting as a user and making POST request to store galeri
        $response = $this->actingAsUser()->post('/admin/galeri/store', [
            'judul' => 'Galeri Test',
            'foto' => $file,
        ]);
    
        // Assert redirect if successful
        $response->assertRedirect(); // Redirect after success
        $this->assertDatabaseHas('galeri', ['judul' => 'Galeri Test']);
    
        // Assert that the file was stored with the generated filename
        Storage::disk('public')->assertExists('foto_galeri/' . $file->hashName());
    }
    

    public function test_destroy_galeri()
    {
        // Create a galeri entry manually without using factory
        $galeri = Galeri::create([
            'judul' => 'Galeri Test',
            'foto' => 'dummy.jpg', // Dummy file name for testing
        ]);
    
        // Act as user and send delete request
        $response = $this->actingAsUser()->delete("/admin/galeri/delete/{$galeri->id}");
    
        // Assert response is success and JSON structure
        $response->assertJson(['success' => 'Galeri berhasil dihapus.']);
    
        // Assert the entry was deleted from the database
        $this->assertDatabaseMissing('galeri', ['id' => $galeri->id]);
    }
    
}
