<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use App\Repository\Post\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accountProfileController extends AbstractController
{
    #[Route('/user/{slug}/profile', name: 'app_account_profile', methods: ['GET','POST'])]
    public function __invoke(AccountRepository $accountRepository, RequestStack $requestStack, $slug, PostRepository $postRepository): Response
    {
        $session = $requestStack->getSession();
        return $this->render('account/profile.html.twig', [
            'account' => $session->get('account'),
            'posts' => $postRepository->findByAccount($accountRepository->findBySlug($slug))
        ]);
    }
}