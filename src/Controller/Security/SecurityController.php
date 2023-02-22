<?php

namespace App\Controller\Security;

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

    public function __construct(SecurityAuthService $securityAuthService, AuthenticationUtils $AuthenticationUtils, RequestStack $requestStack)
    {
        $this->securityAuthService = $securityAuthService;
        $this->authenticationUtils = $AuthenticationUtils;
        $this->requestStack = $requestStack;
    }

    public function findAccountForLogin(Request $request): array|AuthenticationException
    {
        $session = $this->requestStack->getSession();
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');
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
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
