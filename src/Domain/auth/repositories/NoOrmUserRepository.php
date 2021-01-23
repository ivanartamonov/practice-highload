<?php

declare(strict_types=1);

namespace App\Domain\auth\repositories;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class NoOrmUserRepository implements UserRepositoryInterface, PasswordUpgraderInterface
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function save(User $user): bool
    {
        if ($user->getId()) {
            return $this->update($user);
        }

        return $this->insert($user);
    }

    private function insert(User $user): bool
    {
        $query = '
            INSERT INTO users VALUE (null, :email, :password, :name, :lastname, :age, :sex, :interests, :city)
        ';

        $stmt = $this->conn->prepare($query);

        return $stmt->execute(
            [
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'name' => $user->getName(),
                'lastname' => $user->getLastname(),
                'age' => $user->getAge(),
                'sex' => $user->getSex(),
                'interests' => $user->getInterests(),
                'city' => $user->getCity(),
            ]
        );
    }

    private function update(User $user): bool
    {
        $query = '
            UPDATE users 
            SET 
                email = :email,
                password = :password,
                name = :name,
                lastname = :lastname,
                age = :age,
                sex = :sex,
                interests = :interests,
                city = :city
            WHERE id = :id
        ';

        $stmt = $this->conn->prepare($query);

        return $stmt->execute(
            [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'name' => $user->getName(),
                'lastname' => $user->getLastname(),
                'age' => $user->getAge(),
                'sex' => $user->getSex(),
                'interests' => $user->getInterests(),
                'city' => $user->getCity(),
            ]
        );
    }

    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        $query = '
            UPDATE users 
            SET password = :password
            WHERE id = :id
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->execute(
            [
                'id' => $user->getId(),
                'password' => $newEncodedPassword
            ]
        );
    }

    public function getUserList(int $offset, int $limit): array
    {
        if ($offset < 0) {
            $offset = 0;
        }

        if ($limit < 0) {
            $limit = 0;
        }

        $query = '
            SELECT * FROM users 
            ORDER BY id DESC
            LIMIT :offset, :limit
        ';

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }
}
