<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use App\Repository\PostActionRepository;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accountProfileController extends AbstractController
{
    #[Route('/user/{slug}/profile', name: 'app_account_profile', methods: ['GET', 'POST'])]
    public function __invoke(AccountRepository $accountRepository, RequestStack $requestStack, $slug, PostRepository $postRepository, PostActionRepository $postActionRepository): Response
    {
        $session = $requestStack->getSession();
        $userAccount = $session->get('account');
        $postsActionLiked = $postActionRepository->findByPostsByLiked($userAccount->getId());
        $blockSwitch = $requestStack->getCurrentRequest()->query->get('blockSwitch');
        if ($blockSwitch) {
            $posts = new ArrayCollection();
            foreach ($postsActionLiked as $value) {
                $posts->add($postRepository->findOneBy(['id' => $value->getActionTarget()]));
            }
        } else {
            $posts = $postRepository->findByAccount($accountRepository->findBySlug($slug));
        }

        return $this->render('account/profile.html.twig', [
            'account' => $userAccount,
            'accountProfile' => $accountRepository->findOneBy(['slug' => $slug]),
            'posts' => $posts,
            'blockSwitch' => !$blockSwitch
        ]);
    }
}