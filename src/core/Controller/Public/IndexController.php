<?php

namespace Core\Controller\Public;

use BaksDev\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class IndexController extends AbstractController
{
    #[Route('/', name: 'public.homepage', priority: 100)]
    public function index(): Response
    {
        return $this->render([
            'controller_name' => 'IndexController',
        ]);
    }

}
