<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Routing\RouterInterface;
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private  $userRepository;
    private  $router;
    private $passwordEncoder;
    public function __construct(UserRepository $userRepository,RouterInterface $router,UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository=$userRepository;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }
    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login'
        && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);

    }



    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('admingit '));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

}
