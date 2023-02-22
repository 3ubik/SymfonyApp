<?php

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Infrastructure\Service\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CreateUser extends AbstractController
{
    public function __construct(
        private readonly UserRepository     $userRepository,
        private readonly UserFactory        $userFactory,
        private readonly UserPasswordHasher $hasher
    )
    {

    }

    #[Route('/api/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $plaintextPassword = $decoded->password;
        if ($this->validateUser($email)) {
            $user = $this->userFactory->create($email, $plaintextPassword);
            $user->setPassword($plaintextPassword, $this->hasher);
            $this->userRepository->add($user);
            $message = ['message' => 'Registered Successfully'];
        } else {
            $message = ['message' => 'User Already exists'];
        }
        return $this->json($message);
    }

    private function validateUser(string $email): bool
    {
        $existingUser = $this->userRepository->findByEmail($email);
        $status = true;
        if (null !== $existingUser) {
            $status = false;
        }
        return $status;
    }
}