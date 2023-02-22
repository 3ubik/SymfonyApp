<?php

namespace App\Users\Infrastructure\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use App\Users\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class JWTDecodedEventListener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @param JWTDecodedEvent $event
     *
     * @throws \Exception
     *
     * @return void
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        /**
         * As a mechanism to invalidate issued tokes we force token issue date to be higher than a date stored on User::tokenValidAfter
         * By updating the User::tokenValidAfter to current date all previously issued tokens become invalid
         *
         * Its intended we dont mark as invalid if user isnt found on persistence level because we rely on core JWT
         * implementation to handle this case. We want to handle only the validation of tokenValidAfter here.
         *
         * @var $user User
         */
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $payload[JWTCreatedEventListener::PAYLOAD_KEY_FOR_USERNAME]
        ]);
        if (
            $user &&
            $user->getTokenValidAfter() instanceof \DateTime &&
            $payload['iat'] < $user->getTokenValidAfter()->getTimestamp()
        ) {
            $event->markAsInvalid();
        }
    }
}