<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Service\UlidSerice;
class User
{
    private string $ulid;
    private string $email;
    private ?string $password = null;

    public function __construct(string $email, string $password)
    {
        $this->ulid = UlidSerice::generate();
        $this->email = $email;
        $this->password = $password;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }


}