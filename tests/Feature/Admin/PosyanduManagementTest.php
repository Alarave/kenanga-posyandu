<?php

use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->posyandu = Posyandu::factory()->create(['name' => 'Kenanga Test Unit']);

    $this->superadmin = User::factory()->create([
        'role' => 'superadmin',
        'posyandu_id' => null,
    ]);
});

describe('akses halaman manajemen posyandu', function () {
    it('superadmin dapat mengakses halaman manajemen posyandu dan melihat isinya', function () {
        $this->actingAs($this->superadmin);
        
        $response = $this->get('/admin/posyandu');
        
        $response->assertStatus(200);
        $response->assertSee('Unit Posyandu');
        $response->assertSee('Kenanga Test Unit');
    });
});
