<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use JetBrains\PhpStorm\ArrayShape;

final class User
{
    /**
     * @var string
     */
    public string $uuid;

    /** @var string */
    public string $username;

    /** @var string */
    public string $firstName;

    /** @var string */
    public string $lastName;

    /** @var string */
    public string $email;

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }

    public function toString(): string
    {
        return json_encode($this->toArray());
    }
}
