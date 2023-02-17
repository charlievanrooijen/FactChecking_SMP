<?php

namespace App\Controller\Post;

use App\Controller\Page\PageController;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\AccountRepository;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class postLikeController extends AbstractController
{
    #[Route('/likeAction/{post}', name: 'mutate_like_count', methods: ['GET','POST'])]
    public function __invoke(Post $post, RequestStack $requestStack, PostLikeRepository $postLikeRepository, PageController $pageController, ManagerRegistry $doctrine)
    {
        $session = $requestStack->getSession();
        $account = $session->get('account');
        $request = $requestStack->getCurrentRequest();
        if($account !== null){
            $entityManager = $doctrine->getManager();
            $accountsLiked = $post->getAccountsLiked();
             if(in_array($account, $accountsLiked) === false){
                 $postLike = new PostLike();
                 $postLike->setLikedBy($account);
                 $postLike->setPostTarget($post);
                 $entityManager->persist($post);
                 $entityManager->persist($postLike);
                 $entityManager->flush();
             }else{
                 $postLikeRepository->remove();
             }
             return $this->redirect($request->headers->get('referer'));
        }else{
            $pageController->loginpage($request);
            return $this->redirectToRoute('login_page');
        }
    }
}