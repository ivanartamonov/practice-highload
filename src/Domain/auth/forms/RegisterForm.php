<?php

declare(strict_types=1);

namespace App\Domain\auth\forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterForm extends AbstractType
{
    protected $name;
    protected $email;
    protected $password;
    protected $lastname;
    protected $age;
    protected $sex;
    protected $interests;
    protected $city;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

    public function getInterests(): string
    {
        return $this->interests;
    }

    public function setInterests(string $interests): void
    {
        $this->interests = $interests;
    }

    public function getCity(): int
    {
        return $this->city;
    }

    public function setCity(int $city): void
    {
        $this->city = $city;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('age', NumberType::class)
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Мужской' => 'MALE',
                    'Женский' => 'FEMALE',
                ]
            ])
            ->add('interests', TextType::class)
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'London' => 1,
                    'NewYork' => 2,
                    'Berlin' => 3
                ]
            ])
            ->add('save', SubmitType::class);
    }
}