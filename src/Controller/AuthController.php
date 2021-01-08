<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends BaseController
{
    /**
     * @Route("/auth/hello", name="auth/hello")
     */
    public function hello(): Response
    {
        return new Response('Hello, world from AuthController');
    }
}