<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocalSubscriber implements EventSubscriberInterface
{


    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function onKernelRequest(RequestEvent $event){
        $request = $event->getRequest();
        //$locale = $request->query->get('_locale', 'fr');
        $locale = $request->getPreferredLanguage(['fr', 'en']);
        $request->setLocale($locale);
        $this->translator->setLocale($locale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 10]
            ]
        ];
    }
}
