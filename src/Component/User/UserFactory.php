<?php

namespace App\Component\User;

use App\Entity\User;

class UserFactory
{
    public function create(string $email, string $password, string $fullname, string $surname, int $age): User




    {
        // To'g'ridan-to'g'ri User entitydan foydalanish
        $user = new User();
        $user->setEmail ($email);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setFullname($fullname);
        $user->setSurname($surname);
        $user->setAge($age);

        return $user;
    }
}
