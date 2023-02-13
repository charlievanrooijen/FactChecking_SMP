<?php

namespace App\Controller\Post;

use App\Controller\Page\PageController;
use App\Entity\Post\Post;
use App\Repository\AccountRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\postLikeService;

class postLikeController extends AbstractController
{
    private postLikeService $likeService;
    private AccountRepository $accountRepository;
    private PostRepository $postRepository;
    private RequestStack $requestStack;
    private PageController $pageController;

    public function __construct(
        postLikeService $likeService,
        PostRepository $postRepository,
        AccountRepository $accountRepository,
        RequestStack $requestStack,
        PageController $pageController)
    {
        $this->likeService = $likeService;
        $this->postRepository = $postRepository;
        $this->accountRepository = $accountRepository;
        $this->requestStack = $requestStack;
        $this->pageController = $pageController;
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
                $entityArray = $this->likeService->addLike($post, $account);
            } else {
                $entityArray = $this->likeService->removeLike($post, $account, $postLikes);
            }

            $this->postRepository->save($entityArray[0], true);
            $this->accountRepository->save($entityArray[1], true);

            return $this->redirect($request->headers->get('referer'));
        } else {
            $this->pageController->loginpage($request);

            return $this->redirectToRoute('login_page');
        }
    }
}