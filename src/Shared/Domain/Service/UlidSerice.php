<?php

namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Ulid;

class UlidSerice
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}