<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\User;

/**
 * Class AuthenticationController.
 */
class AuthenticationController extends Controller
{

    /**
     * @var AuthenticationSuccessHandler
     */
    protected $jwtSuccessHandler;

    /**
     * @var AuthenticationFailureHandler
     */
    protected $jwtFailureHandler;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationSuccessHandler $jwtSuccessHandler
     * @param AuthenticationFailureHandler $jwtFailureHandler
     */
    public function __construct(AuthenticationSuccessHandler $jwtSuccessHandler, AuthenticationFailureHandler $jwtFailureHandler)
    {
        $this->jwtSuccessHandler = $jwtSuccessHandler;
        $this->jwtFailureHandler = $jwtFailureHandler;
    }

    /**
     * Build auth token and find user data.
     *
     * @Route("/api/get-token", name="get_token", methods={"POST"})
     *
     * @param Request $request
     *
     * @return \Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getToken(Request $request)
    {
        $content = json_decode($request->getContent());
        if (empty($content->username) || empty($content->password)) {
            return $this->jwtFailureHandler->onAuthenticationFailure($request, new AuthenticationException());
        }

        $user = new User(
            $content->username,
            $content->password,
            ['ROLE_USER']
        );


        if ($user) {
            return $this->jwtSuccessHandler->handleAuthenticationSuccess($user);
        }

        return $this->jwtFailureHandler->onAuthenticationFailure($request, new BadCredentialsException());
    }
}
