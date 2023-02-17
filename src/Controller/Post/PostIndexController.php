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
    public function index(RequestStack $requestStack ,PostRepository $postRepository): Response
    {
        $session = $requestStack->getSession();
        $account = $session->get('account');
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'account' => $account
        ]);
    }
}
