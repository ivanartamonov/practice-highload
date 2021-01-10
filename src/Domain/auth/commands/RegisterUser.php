<?php

declare(strict_types=1);

namespace App\Domain\auth\commands;

use App\Core\traits\ErrorsTrait;
use App\Domain\auth\forms\RegisterForm;
use App\Domain\auth\repositories\UserRepositoryInterface;
use App\Entity\User;

class RegisterUser
{
    use ErrorsTrait;

    /** @var RegisterForm */
    private $form;

    /** @var UserRepositoryInterface */
    private $repository;

    public function __construct(RegisterForm $form, UserRepositoryInterface $repository)
    {
        $this->form = $form;
        $this->repository = $repository;
    }

    public function execute(): void
    {
        $user = new User();
        $user->setEmail($this->form->getEmail());
        $user->setPassword($this->form->getPassword());
        $user->setName($this->form->getName());
        $user->setLastname($this->form->getLastname());
        $user->setAge($this->form->getAge());
        $user->setSex($this->form->getSex());
        $user->setInterests($this->form->getInterests());
        $user->setCity($this->form->getCity());

        $this->repository->save($user);
    }

    public function validate(): bool
    {
        return !$this->hasErrors();
    }
}