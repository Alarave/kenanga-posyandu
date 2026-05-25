<?php

namespace App\DataTransferObjects;

class GoalData
{
    public function __construct(
        public string $icon,
        public string $title,
        public string $desc
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            icon: $data['icon'],
            title: $data['title'],
            desc: $data['desc']
        );
    }
}
