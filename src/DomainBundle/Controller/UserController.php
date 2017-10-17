<?php

namespace DomainBundle\Controller;

use DomainBundle\Entity\User;
use Dontdrinkandroot\RestBundle\Controller\ContainerAwareRestResourceController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends ContainerAwareRestResourceController
{
    /**
     * {@inheritdoc}
     */
    protected function fetchEntity($id)
    {
        $user = $this->getUser();

        if ('me' === $id) {
            if (null === $user) {
                throw new UnauthorizedHttpException('Access Token required');
            }

            return $user;
        }

        return parent::fetchEntity($id);
    }

    protected function getUser(): ?User
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        if ($user instanceof User) {
            return $user;
        }

        throw new \RuntimeException(sprintf('Unexpected user class %s', get_class($user)));
    }
}
