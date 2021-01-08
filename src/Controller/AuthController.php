<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends BaseController
{
    /**
     * @Route("/register", name="auth/register")
     */
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    /**
     * @Route("/login", name="auth/login")
     */
    public function login(): Response
    {
        return $this->render('auth/login.html.twig');
    }
}