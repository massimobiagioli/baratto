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
     * 
     * @SWG\Post(
     *  path="/api/auth/login",  
     *  summary="Login applicativo",
     *  @SWG\Parameter(
     *    name="credentials",
     *    in="body",
     *    required=true,   
     *    type="array",
     *       @SWG\Schema(
     *          @SWG\Items(
     *             @SWG\Property(type="string",property="email",description="email"),
     *             @SWG\Property(type="string",property="password",description="password"), 
     *          )
     *       )
     *  ), 
     *  @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="accessToken",
     *          description="API Access Token"
     *        )
     *     )
     *  ),
     *  @SWG\Response(
     *     response=400,
     *     description="BAD REQUEST"     
     *  )
     * )
     */
    public function login(Request $request)
    {
        $loginCredentials = json_decode($request->getContent(), true);
        if (!$loginCredentials) {
            return new Response('Credenziali non specificate', 400);
        }
        if (empty($loginCredentials['email'])) {
            return new Response('Email non specificata', 400);
        }
        if (empty($loginCredentials['password'])) {
            return new Response('Password non specificata', 400);
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
     * @SWG\Get(
     *  path="/api/auth/logout",  
     *  summary="Logout applicativo",
     *  @SWG\Parameter(
     *    name="accessToken",
     *    in="query",
     *    required=true,
     *    type="string"
     *  ),
     *  @SWG\Response(
     *     response=200,
     *     description="OK"
     *  ),
     *  @SWG\Response(
     *     response=400,
     *     description="BAD REQUEST"     
     *  ),
     *  @SWG\Response(
     *     response=500,
     *     description="BAD TOKEN"     
     *  )
     * )
     */
    public function logout(Request $request)
    {
        $accessToken = $request->get('accessToken');
        if (empty($accessToken)) {
            return new Response('Token non specificato', 400);
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
