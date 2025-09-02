<?php

namespace App\Component\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserFactory $userFactory
    ) {}

    public function createUser(string $email, string $password, string $fullname, string $surname, int $age): User
    {
        $user = $this->userFactory->create($email, $password, $fullname, $surname, $age);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
