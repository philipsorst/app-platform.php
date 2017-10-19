<?php

namespace DomainBundle\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use DomainBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CurrentUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['setCurrentUserId', EventPriorities::PRE_READ],
        ];
    }

    public function setCurrentUserId(GetResponseEvent $event)
    {
        $resourceClass = $event->getRequest()->get('_api_resource_class');
        $id = $event->getRequest()->get('id');
        $operation = $event->getRequest()->get('_api_item_operation_name');
        if ($resourceClass === User::class && $id === 'me' && $operation === 'get') {
            $user = $this->tokenStorage->getToken()->getUser();
            if ($user instanceof User) {
                $event->getRequest()->attributes->set('id', $user->getId());
            }
        }
    }
}