<?php

namespace App\Controller;

use App\Service\Authenticator\AuthenticatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private $authenticator;

    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @Route("/api/auth/login", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Login",
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="accessToken",
     *          description="API Access Token"
     *        )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $loginCredentials = json_decode($request->getContent(), true);
        if (!$loginCredentials) {
            return new Response('No login credentials specified', 400);
        }
        if (empty($loginCredentials['email'])) {
            return new Response('No email specified', 400);
        }
        if (empty($loginCredentials['password'])) {
            return new Response('No password specified', 400);
        }
        
        try {
            $accessToken = $this->authenticator->login($loginCredentials['email'], $loginCredentials['password']);

            return new JsonResponse([
                'accessToken' => $accessToken->getValue(),
                'allowAdmin' => $accessToken->getAllowAdmin()
            ]);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }
    }

    /**
     * @Route("/api/auth/logout", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Logout"
     * )
     */
    public function logout(Request $request)
    {
        $accessToken = $request->get('accessToken');
        if (empty($accessToken)) {
            return new Response('No access token specified', 400);
        }

        try {
            if ($this->authenticator->logout($accessToken)) {
                return new Response('');
            } else {
                return new Response('', 500);
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }
}
