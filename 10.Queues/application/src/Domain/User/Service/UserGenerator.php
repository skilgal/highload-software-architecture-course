<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;
use Faker\Factory;

final class UserGenerator
{
    private Factory $fakerFactory;

    /**
     * Constructor.
     *
     * @param Factory $fakerFactory
     */
    public function __construct(Factory $fakerFactory)
    {
        $this->fakerFactory = $fakerFactory;
    }

    /**
     * Create a new user.
     *
     * @return User
     */
    public function createUser(): User
    {
        $faker = $this->fakerFactory::create();
        $user = new User();
        $user->uuid = $faker->uuid;
        $user->username = strtolower($faker->userName);
        $user->firstName = $faker->firstName;
        $user->lastName = $faker->lastName;
        $user->email = $faker->email;

        return $user;
    }
}
