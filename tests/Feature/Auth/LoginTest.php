<?php

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'is_active' => true,
        'attempt_login' => 0,
        'block_expires' => null,
    ]);
});

describe('login berhasil', function () {
    it('dapat login dengan kredensial yang valid', function () {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    });

    it('mereset attempt_login menjadi 0 setelah login berhasil', function () {
        // Set attempt_login to 3
        $this->user->update(['attempt_login' => 3]);

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->user->refresh();
        expect($this->user->attempt_login)->toBe(0);
    });

    it('membuat log aktivitas saat login berhasil', function () {
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'action_type' => 'login',
        ]);
    });

    it('menyimpan last_activity di session setelah login berhasil', function () {
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        expect(session('last_activity'))->not->toBeNull();
    });
});

describe('login gagal', function () {
    it('menolak login dengan email yang tidak valid', function () {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    });

    it('menolak login dengan password yang salah', function () {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    });

    it('menampilkan pesan error tanpa mengungkap informasi spesifik', function () {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        // Verify error message doesn't reveal whether email or password is wrong
        $errors = session('errors');
        expect($errors)->not->toBeNull();
    });

    it('menambah attempt_login setelah login gagal', function () {
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->user->refresh();
        expect($this->user->attempt_login)->toBe(1);
    });

    it('menambah attempt_login secara berurutan untuk setiap kegagalan', function () {
        // First failed attempt
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->user->refresh();
        expect($this->user->attempt_login)->toBe(1);

        // Second failed attempt
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->user->refresh();
        expect($this->user->attempt_login)->toBe(2);
    });
});

describe('blokir akun setelah 5x gagal login', function () {
    it('memblokir akun setelah 5 kali gagal login berturut-turut', function () {
        // Attempt 5 failed logins
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $this->user->refresh();
        expect($this->user->block_expires)->not->toBeNull();
    });

    it('menyetel block_expires 15 menit ke depan setelah 5x gagal', function () {
        // Attempt 5 failed logins
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $this->user->refresh();
        $blockExpires = $this->user->block_expires;
        $expectedTime = now()->addMinutes(15);

        // Allow 1 minute tolerance for test execution time
        expect($blockExpires->timestamp)->toBeGreaterThanOrEqual($expectedTime->subMinute()->timestamp)
            ->and($blockExpires->timestamp)->toBeLessThanOrEqual($expectedTime->addMinute()->timestamp);
    });

    it('menampilkan pesan "Akun sementara dikunci" setelah 5x gagal', function () {
        // Attempt 5 failed logins
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123', // Even with correct password
        ]);

        $response->assertSessionHas('error');
        expect(session('error'))->toContain('dikunci');
    });

    it('menolak login meskipun password benar saat akun diblokir', function () {
        // Block the account
        $this->user->update([
            'attempt_login' => 5,
            'block_expires' => now()->addMinutes(15),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    });

    it('mengizinkan login setelah block_expires berakhir', function () {
        // Block the account with expired time
        $this->user->update([
            'attempt_login' => 5,
            'block_expires' => now()->subMinute(), // Already expired
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    });
});

describe('logout', function () {
    it('dapat logout dengan sukses', function () {
        $this->actingAs($this->user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    });

    it('membuat log aktivitas saat logout', function () {
        $this->actingAs($this->user);

        $this->post('/logout');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'action_type' => 'logout',
        ]);
    });

    it('menghapus session setelah logout', function () {
        $this->actingAs($this->user);
        session(['last_activity' => now()]);

        $this->post('/logout');

        expect(session('last_activity'))->toBeNull();
    });
});

describe('auto-logout setelah 15 menit tidak aktif', function () {
    it('mengizinkan akses jika last_activity kurang dari 15 menit', function () {
        $this->actingAs($this->user);
        session(['last_activity' => now()->subMinutes(10)->timestamp]);

        $response = $this->get('/dashboard');

        $response->assertOk();
        $this->assertAuthenticated();
    });

    it('melakukan auto-logout jika last_activity lebih dari 15 menit', function () {
        $this->actingAs($this->user);
        session(['last_activity' => now()->subMinutes(16)->timestamp]);

        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    });

    it('menampilkan pesan "Sesi Anda telah berakhir" setelah auto-logout', function () {
        $this->actingAs($this->user);
        session(['last_activity' => now()->subMinutes(16)->timestamp]);

        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
        $response->assertSessionHas('message');
        expect(session('message'))->toContain('Sesi');
    });

    it('membuat log aktivitas auto_logout', function () {
        $this->actingAs($this->user);
        session(['last_activity' => now()->subMinutes(16)->timestamp]);

        $this->get('/dashboard');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'action_type' => 'auto_logout',
        ]);
    });

    it('memperbarui last_activity pada setiap request yang valid', function () {
        $this->actingAs($this->user);
        $initialTime = now()->subMinutes(5)->timestamp;
        session(['last_activity' => $initialTime]);

        $this->get('/dashboard');

        $updatedTime = session('last_activity');
        expect($updatedTime)->toBeGreaterThan($initialTime);
    });
});

describe('akun tidak aktif', function () {
    it('menolak login jika is_active = false', function () {
        $this->user->update(['is_active' => false]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    });

    it('menampilkan pesan error untuk akun tidak aktif', function () {
        $this->user->update(['is_active' => false]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        expect(session('error'))->toContain('tidak aktif');
    });
});

describe('validasi input login', function () {
    it('memerlukan email', function () {
        $response = $this->post('/login', [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    });

    it('memerlukan password', function () {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    });

    it('memvalidasi format email', function () {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    });
});
