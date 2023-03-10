<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Domain\Factory\UserFactory;
use Faker\Factory;
use Faker\Generator;

class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->userFactory = static::getContainer()->get(UserFactory::class);
        $this->faker = Factory::create();
    }

    public function test_user_added_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this->userFactory->create($email,$password);

        // act
        $this->repository->add($user);

        // assert
        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}
