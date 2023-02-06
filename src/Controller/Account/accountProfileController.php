<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accountProfileController extends AbstractController
{
    #[Route('/user/account/profile', name: 'app_account_profile', methods: ['GET','POST'])]
    public function __invoke(AccountRepository $accountRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        return $this->render('account/profile.html.twig', [
            'account' => $session->get('account')
        ]);
    }
}