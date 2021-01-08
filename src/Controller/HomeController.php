<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/")
     */
    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'title' => 'Home'
        ]);
    }
}