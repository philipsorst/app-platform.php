<?php

namespace IntegrationBundle\Service;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UrlService
{
    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        if (substr($this->baseUrl, -1) !== '/') {
            $this->baseUrl .= '/';
        }
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
        return $this->baseUrl . 'app/';
    }
}
