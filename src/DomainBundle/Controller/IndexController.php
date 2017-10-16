<?php

namespace DomainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    public function indexAction()
    {
        return new JsonResponse('ok');
    }
}
