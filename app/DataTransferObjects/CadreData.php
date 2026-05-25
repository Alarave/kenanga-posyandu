<?php

namespace App\DataTransferObjects;

class CadreData
{
    public function __construct(
        public string $name,
        public string $role,
        public string $ttl,
        public string $nik,
        public string $pendidikan,
        public string $alamat,
        public string $hp,
        public string $email,
        public string $image
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            role: $data['role'],
            ttl: $data['ttl'],
            nik: $data['nik'],
            pendidikan: $data['pendidikan'],
            alamat: $data['alamat'],
            hp: $data['hp'],
            email: $data['email'],
            image: $data['image']
        );
    }
}
