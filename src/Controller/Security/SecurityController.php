<?php

namespace App\Controller\Security;

use App\Repository\AccountRepository;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\SecurityAuthService;

class SecurityController extends AbstractController
{
    private SecurityAuthService $securityAuthService;
    private AuthenticationUtils $authenticationUtils;
    private RequestStack $requestStack;
    private SecurityService $securityService;
    private AccountRepository $accountRepository;
    public function __construct(
        SecurityAuthService $securityAuthService,
        AuthenticationUtils $AuthenticationUtils,
        RequestStack $requestStack,
        SecurityService $securityService,
        AccountRepository $accountRepository,
    )
    {
        $this->securityAuthService = $securityAuthService;
        $this->authenticationUtils = $AuthenticationUtils;
        $this->requestStack = $requestStack;
        $this->securityService = $securityService;
        $this->accountRepository = $accountRepository;
    }

    public function findAccountForLogin(Request $request): array|AuthenticationException
    {
        $session = $this->requestStack->getSession();
        $email = $request->request->get('_email');
        $account = $this->accountRepository->findOneByEmail($email);
        $password = $request->request->get('_password');
        $password = $this->securityService->setPasswordHash($account, $password);
        $authenticated = $this->securityAuthService->CheckCredentials($email, $password);
        $lastUsername = $this->authenticationUtils->getLastUsername();

        if ($authenticated) {
            $session->start();
            $session->set('account', $authenticated[0]);
            $session->set('accountid', $authenticated[0]->getId());
            return [$authenticated, $lastUsername];
        } else {
            return $this->authenticationUtils->getLastAuthenticationError() ?: [];
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
           $this->requestStack->getSession()->clear();
    }
}
