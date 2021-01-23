<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\auth\repositories\NoOrmUserRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="/")
     */
    public function home(Request $request): Response
    {
        $page = $request->get('page', 1) - 1;
        $limit = 20;

        /** @var Connection $conn */
        $conn = $this->getDoctrine()->getConnection();
        $repository = new NoOrmUserRepository($conn);

        $users = $repository->getUserList($page * $limit, $limit);

        return $this->render('home/home.html.twig', [
            'users' => $users
        ]);
    }
}