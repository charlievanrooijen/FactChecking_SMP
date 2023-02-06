<?php

namespace App\Controller\Page;

use App\Controller\Security\SecurityController;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class PageController extends AbstractController
{
    private SecurityController $securityController;
    private RequestStack $requestStack;
    private PostRepository $postRepository;

    public function __construct(SecurityController $securityController, RequestStack $requestStack, PostRepository $postRepository)
    {
        $this->securityController = $securityController;
        $this->requestStack = $requestStack;
        $this->postRepository = $postRepository;
    }

    #[Route('/', name: 'landing_page')]
    public function index(): Response
    {
        $session = $this->requestStack->getSession();
        return $this->render('page/index.html.twig', [
            'posts' => $this->postRepository->findAll(),
            'account' => $session->get('account'),
        ]);
    }

    #[Route('/login', name: 'login_page', methods: ['GET', 'POST'])]
    public function loginpage(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        return $this->render('security/login.html.twig', [
            'method' => $request->getMethod(),
            'account' => $session->get('account')
        ]);
    }

    #[Route('/checklogin', name: 'login_check', methods: ['GET', 'POST'])]
    public function checklogin(Request $request): Response
    {
        $account = $this->securityController->findAccountForLogin($request);

        if (is_array($account) && !($account === [])) {
            return $this->index();
        } else {
            return $this->render('security/login.html.twig', [
                'error' => $account,
                'asd' => $request->getSession()->get('account'),
                'method' => $request->getMethod()
            ]);
        }

    }
}
