<?php

use App\Models\Gallery;
use App\Models\Pedukuhan;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('superadmin can access admin gallery index', function () {
    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);

    $this->actingAs($superadmin);
    $response = $this->get('/admin/gallery');

    $response->assertStatus(200);
});

test('can upload image file to gallery and it is saved as type image', function () {
    Storage::fake('public');

    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    $file = UploadedFile::fake()->image('kegiatan.jpg');

    $this->actingAs($admin);
    $response = $this->post('/admin/gallery', [
        'title' => 'Kegiatan Posyandu',
        'description' => 'Edukasi kesehatan anak',
        'posyandu_id' => $posyandu->id,
        'photo' => $file,
    ]);

    $response->assertRedirect('/admin/gallery');
    
    $gallery = Gallery::latest()->first();
    expect($gallery->type)->toBe('image');
    expect($gallery->photo)->not->toBeNull();
    Storage::disk('public')->assertExists($gallery->photo);
});

test('can upload video file to gallery and it is saved as type video', function () {
    Storage::fake('public');

    $pedukuhan = Pedukuhan::factory()->create();
    $posyandu = Posyandu::factory()->create(['pedukuhan_id' => $pedukuhan->id]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'posyandu_id' => $posyandu->id,
    ]);

    $file = UploadedFile::fake()->create('kegiatan.mp4', 500, 'video/mp4');

    $this->actingAs($admin);
    $response = $this->post('/admin/gallery', [
        'title' => 'Video Kegiatan Posyandu',
        'description' => 'Rekaman imunisasi rutin',
        'posyandu_id' => $posyandu->id,
        'photo' => $file,
    ]);

    $response->assertRedirect('/admin/gallery');
    
    $gallery = Gallery::latest()->first();
    expect($gallery->type)->toBe('video');
    expect($gallery->photo)->not->toBeNull();
    Storage::disk('public')->assertExists($gallery->photo);
});
