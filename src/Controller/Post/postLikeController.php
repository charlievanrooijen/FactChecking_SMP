<?php

namespace App\Controller\Post;

use App\Controller\Page\PageController;
use App\Entity\Post\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\postLikeService;
use App\Repository\Post\PostLikeRepository;

class postLikeController extends AbstractController
{
    private postLikeService $likeService;
    private RequestStack $requestStack;
    private PageController $pageController;
    private PostLikeRepository $postLikeRepository;

    public function __construct(
        postLikeService $likeService,
        RequestStack $requestStack,
        PageController $pageController,
        PostLikeRepository $postLikeRepository)
    {
        $this->likeService = $likeService;
        $this->requestStack = $requestStack;
        $this->pageController = $pageController;
        $this->postLikeRepository = $postLikeRepository;
    }

    #[Route('/mutateLikeCount/{post}', name: 'mutate_like_count', methods: ['GET', 'POST'])]
    public function __invoke(Post $post)
    {
        $session = $this->requestStack->getSession();
        $account = $session->get('account');
        $request = $this->requestStack->getCurrentRequest();

        if ($account !== null) {
            $postLikes = $post->getPostLikes();

            if($postLikes === null) {
                $postLikeObj = $this->likeService->addLike($post, $account);
                $this->postLikeRepository->save($postLikeObj, true);
            } else {
                $this->likeService->removeLike($post, $account, $postLikes);
            }

            return $this->redirect($request->headers->get('referer'));
        } else {
            $this->pageController->loginpage($request);

            return $this->redirectToRoute('login_page');
        }
    }
}