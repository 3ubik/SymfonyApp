<?php

namespace App\Users\Infrastructure\Controller;

use App\Shared\Domain\Security\UserFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class GetUserInformation
{
    public function __construct(private readonly UserFetcherInterface $userFetcher)
    {
    }
    #[Route('/users/me', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->userFetcher->getAuthUser();
        return new JsonResponse([
            'ulid' => $user->getUlid(),
            'email' => $user->getEmail(),
        ]);
    }
}