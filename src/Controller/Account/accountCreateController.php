<?php

namespace App\Controller\Account;

use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accountCreateController extends AbstractController
{
    #[Route('/account/new', name: 'app_account_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AccountRepository $accountRepository): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account->setSlug(str_replace("-", " ", $account->getName()));
            $accountRepository->save($account, true);

            return $this->redirectToRoute('app_account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account/new.html.twig', [
            'account' => $account,
            'form' => $form,
        ]);
    }
}