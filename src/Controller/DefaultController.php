<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response('jest w pyte.');
    }
}
