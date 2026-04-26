<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Illuminate\Support\Facades\Log;

/**
 * Custom Eloquent Cast untuk enkripsi kolom menggunakan Defuse PHP-Encryption.
 * Memberikan enkripsi dua-arah yang aman untuk data sensitif seperti NIK.
 */
class EncryptedCast implements CastsAttributes
{
    protected ?Key $key = null;

    public function __construct()
    {
        $keyString = config('app.encryption_key');
        if ($keyString) {
            try {
                $this->key = Key::loadFromAsciiSafeString($keyString);
            } catch (\Exception $e) {
                Log::error('EncryptedCast: Gagal memuat kunci enkripsi. ' . $e->getMessage());
            }
        }
    }

    /**
     * Cast the given value (Decrypt when getting from DB).
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value) || !$this->key) {
            return $value;
        }

        try {
            return Crypto::decrypt($value, $this->key);
        } catch (\Exception $e) {
            // Jika gagal dekripsi, mungkin data belum terenkripsi (plain text)
            return $value;
        }
    }

    /**
     * Prepare the given value for storage (Encrypt when saving to DB).
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value) || !$this->key) {
            return $value;
        }

        try {
            return Crypto::encrypt($value, $this->key);
        } catch (\Exception $e) {
            Log::error("EncryptedCast: Gagal mengenkripsi kolom {$key}. " . $e->getMessage());
            return $value;
        }
    }
}
