<?php

namespace IntegrationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $urlService = $this->get('app_platform.service.url');

        return $this->redirect($urlService->getAngularBaseHref());
    }
}
