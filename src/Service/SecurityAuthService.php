<?php

namespace App\Service;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityAuthService extends AbstractController
{
    private ManagerRegistry $managerRegistery;
    public function __construct(ManagerRegistry $managerRegistery)
    {
        $this->managerRegistery = $managerRegistery;
    }

    public function Authlogin(AuthenticationUtils $authenticationUtils, $lastUsername, $error, $name, $password): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'email' => $name,
            'password' => $password
        ]);
    }

    public function CheckCredentials($email, $password): array
    {
        $em = $this->managerRegistery->getManager();
        $accountRepo = $em->getRepository(Account::class);
        return $accountRepo->findOneByCredentials($email, $password);
    }
}
