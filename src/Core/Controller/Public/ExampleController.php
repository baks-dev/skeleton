<?php

namespace App\Core\Controller\Public;

use BaksDev\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class ExampleController extends AbstractController
{
    #[Route('/example', name: 'public.example')]
    public function example(): Response
    {
        return $this->render([
            'controller_name' => 'ExampleController',
        ]);
    }
}
