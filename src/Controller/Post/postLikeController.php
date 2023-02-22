<?php

namespace App\Controller\Post;

use App\Controller\Page\PageController;
use App\Entity\Post;
use App\Repository\AccountRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class postLikeController extends AbstractController
{
    #[Route('/mutateLikeCount/{post}', name: 'mutate_like_count', methods: ['GET','POST'])]
    public function __invoke(Post $post, RequestStack $requestStack, PostRepository $postRepository, PageController $pageController)
    {
        $session = $requestStack->getSession();
        $account = $session->get('account');
        $request = $requestStack->getCurrentRequest();
        if($account !== null){
             if(in_array($account->getId(), $post->getAccountsLiked())){
                 $post->removeAccountIdFromLikedList($account->getId());
                 $post->removeLike();
             }else{
                $post->addAccountIdToLikedList($account->getId());
                $post->addLike();
             }
             $postRepository->save($post, true);
             return $this->redirect($request->headers->get('referer'));
        }else{
            return $this->redirect($request->headers->get('referer'));
        }
    }
}