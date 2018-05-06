<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                    => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                              => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class                      => ['all' => true],
    FOS\UserBundle\FOSUserBundle::class                                      => ['all' => true],
    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class           => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class                     => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class         => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle::class      => ['all' => true],
    Dontdrinkandroot\AppIntegrationBundle\DdrAppIntegrationBundle::class     => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class                                => ['all' => true],
    ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle::class          => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class                    => ['dev' => true],
];