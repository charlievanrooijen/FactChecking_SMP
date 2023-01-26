<?php

namespace App\Controller\Page;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
}
