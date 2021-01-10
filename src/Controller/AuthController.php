<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\auth\commands\RegisterUser;
use App\Domain\auth\forms\RegisterForm;
use App\Domain\auth\repositories\NoOrmUserRepository;
use App\Entity\User;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends BaseController
{
    /**
     * @Route("/register", name="auth/register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $registerForm = new RegisterForm();

        $form = $this->createForm(RegisterForm::class, $registerForm);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registerForm = $form->getData();

            /** @var Connection $conn */
            $conn = $this->getDoctrine()->getConnection();

            try {
                $registerForm->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $regCmd = new RegisterUser($registerForm, new NoOrmUserRepository($conn));
                $regCmd->execute();
            } catch (\Exception $exception) {
                $this->addFlash('danger', $exception->getMessage());
                //return $this->redirectToRoute('auth/register');
            }

            //return $this->redirectToRoute('task_success');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="auth/login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('/');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="auth/logout")
     */
    public function logout(): void
    {
    }
}