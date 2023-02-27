<?php

namespace App\Controller\Post;

use App\Controller\Page\PageController;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\AccountRepository;
use App\Repository\PostActionRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class postLikeController extends AbstractController
{
    #[Route('/mutateLikeCount/{post}', name: 'mutate_like_count', methods: ['GET','POST'])]
    public function __invoke(Post $post, RequestStack $requestStack, PostRepository $postRepository, PostActionRepository $postActionRepository, AccountRepository $accountRepository)
    {
        $session = $requestStack->getSession();
        $accountid = $session->get('accountid');
        $account = $accountRepository->findOneBy(['id' => $accountid]);

        $request = $requestStack->getCurrentRequest();

        if($accountid !== null){
            $postAction = $postActionRepository->findOneBy(['LikedAccount' => $account, 'ActionTarget' => $post]);
             if($post->getPostActions()->contains($postAction)){
                 $postActionRepository->remove($postAction, true);
             }else{
                 $postAction = new PostLike();
                 $postAction->setActionTarget($post)->setLikedAccount($account);
                 $post->addPostAction($postAction);
                 $postRepository->save($post, true);
             }
             $postRepository->save($post, true);
        }
        return $this->redirect($request->headers->get('referer'));
    }
}