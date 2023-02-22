<?php

namespace App\Users\Infrastructure\EventListener;

use App\Shared\Domain\Security\UserFetcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Users\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UserFetcherInterface $userFetcher)
    {
    }
    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = $this->userFetcher->getAuthUser();
        $response = $event->getResponse();
    }
}