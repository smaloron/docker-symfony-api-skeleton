<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event:'lexik_jwt_authentication.on_jwt_created',method: 'addToPayload')]
class JwtCreationListener
{

    public function addToPayload(JWTCreatedEvent $event): void
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload['name'] = $user->getName();
        $payload['exp'] = new \DateTime('+20 minutes');

        $event->setData($payload);

    }

}
