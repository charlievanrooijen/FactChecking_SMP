<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostIndexController extends AbstractController
{
    #[Route('/post/index', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, RequestStack $requestStack): Response
    {
        $userAccount = $requestStack->getSession()->get('account');
        return $this->render('post/index.html.twig', [
            'account' => $userAccount,
            'posts' => $postRepository->findAll(),
        ]);
    }
}
