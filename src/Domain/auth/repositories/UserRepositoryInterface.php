<?php

declare(strict_types=1);

namespace App\Domain\auth\repositories;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): bool;
}