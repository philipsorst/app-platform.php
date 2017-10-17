<?php

namespace IntegrationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UrlService
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Router
     */
    private $router;

    public function __construct(string $baseUrl, Router $router)
    {
        $this->baseUrl = rtrim($baseUrl, "/");
        $this->router = $router;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getAngularBaseHref(): string
    {
        return $this->baseUrl . '/app/';
    }

    public function getApiBaseUrl(string $env = 'prod'): string
    {
        return $this->baseUrl . $this->getEnvPrefix($env) . $this->router->generate(
                'domain_index',
                [],
                Router::ABSOLUTE_PATH
            );
    }

    protected function getEnvPrefix(string $env): string
    {
        if ('prod' === $env) {
            return '';
        }

        return '/app_' . $env . '.php';
    }
}
