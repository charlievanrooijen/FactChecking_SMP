<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accountIndexController extends AbstractController
{
    #[Route('/account/index', name: 'app_account_index', methods: ['GET'])]
    public function __invoke(AccountRepository $accountRepository): Response
    {
        return $this->render('account/index.html.twig', [
            'accounts' => $accountRepository->findAll(),
        ]);
    }
}