<?php

namespace App\Service;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class SecurityService extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher)
    {}

    function setPasswordHash(
        Account $account,
        String $plaintextPassword) : string
    {
        $passwordString = $account->getName() . $plaintextPassword;
        $hashedPassword = $this->passwordHasher->hashPassword(
            $account,
            $passwordString
        );
        return $hashedPassword;
    }
}
