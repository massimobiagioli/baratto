<?php

namespace App\Controller;

use App\Service\Authenticator\AuthenticatorInterface;
use App\Service\User\UserInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $authenticator;
    private $userService;

    public function __construct(
        AuthenticatorInterface $authenticator,
        UserInterface $userService) {
        $this->authenticator = $authenticator;
        $this->userService = $userService;
    }

    /**
     * @Route("/api/sell", methods={"POST"})
     * @SWG\Post(
     *  path="/api/sell",
     *  summary="Vendita articolo",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,
     *    type="string"
     *  ),
     *  @SWG\Response(
     *     response=201,
     *     description="CREATED"
     *  ),
     *  @SWG\Response(
     *     response=400,
     *     description="BAD REQUEST"
     *  ),
     *  @SWG\Response(
     *     response=401,
     *     description="UNAUTHORIZED"
     *  )
     * )
     */
    public function sell(Request $request)
    {
        $tokenKey = $request->headers->get('X-AUTH-TOKEN');
        try {
            $accessToken = $this->authenticator->verify($tokenKey);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }

        $toInsert = json_decode($request->getContent(), true);
        if (!$toInsert) {
            return new Response('Dati da inserire non validi', 400);
        }
        if (!isset($toInsert['articoloId'])) {
            return new Response('Id Articolo specificato', 400);
        }
        if (!isset($toInsert['venditoreId'])) {
            return new Response('Id Venditore non specificate', 400);
        }
        if (!isset($toInsert['quantita'])) {
            return new Response('Quantità non specificata', 400);
        }
        try {
            $movimento = $this->userService->sell(
                $toInsert['articoloId'],
                $toInsert['venditoreId'],
                $toInsert['quantita']
            );
            return new Response('', 201);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/listItemsForSale", methods={"GET"})
     * @SWG\Get(
     *  path="/api/listItemsForSale/{utenteId}",
     *  summary="Elenco articoli in vendita",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,
     *    type="string"
     *  ),
     *  @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="movimenti",
     *          description="Elenco movimenti"
     *        )
     *     )
     *  ),
     *  @SWG\Response(
     *     response=400,
     *     description="BAD REQUEST"
     *  ),
     *  @SWG\Response(
     *     response=401,
     *     description="UNAUTHORIZED"
     *  )
     * )
     */
    public function listItemsForSale(Request $request)
    {
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }

        try {
            $utenteId = $this->authenticator->getUserId($tokenKey);
            $movimenti = $this->userService->listItemsForSale($utenteId);
            return new JsonResponse($this->serializeMovimentiToArray($movimenti));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/residualCoins", methods={"GET"})
     * @SWG\Get(
     *  path="/api/residualCoins/{utenteId}",
     *  summary="Elenco monete residue",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,
     *    type="string"
     *  ),
     *  @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="residualCoins",
     *          description="Elenco monete residue"
     *        )
     *     )
     *  ),
     *  @SWG\Response(
     *     response=400,
     *     description="BAD REQUEST"
     *  ),
     *  @SWG\Response(
     *     response=401,
     *     description="UNAUTHORIZED"
     *  )
     * )
     */
    public function residualCoins(Request $request)
    {
        try {
          $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 401);
        }

        try {
            $utenteId = $this->authenticator->getUserId($tokenKey);
            $residualCoins = $this->userService->residualCoins($utenteId);
            return new JsonResponse(['residualCoins' => $residualCoins]);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    private function serializeMovimentoToArray($movimento)
    {
        $data = [
            'id' => $movimento->getId(),
            'quantita' => $movimento->getQuantita(),
            'articolo' => [
                'id' => $movimento->getArticolo()->getId(),
                'nome' => $movimento->getArticolo()->getNome(),
                'monete' => $movimento->getArticolo()->getMonete(),
            ],
            'venditore' => [
                'id' => $movimento->getVenditore()->getId(),
                'nome' => $movimento->getVenditore()->getNome(),
                'cognome' => $movimento->getVenditore()->getCognome(),
                'email' => $movimento->getVenditore()->getEmail(),
            ],
            'dataOperazione' => $movimento->getDataOperazione(),
            'tipo' => $movimento->getTipo(),
            'stato' => $movimento->getStato(),
        ];

        if ($movimento->getCompratore()) {
            $data['compratore'] = [
                'id' => $movimento->getCompratore()->getId(),
                'nome' => $movimento->getCompratore()->getNome(),
                'cognome' => $movimento->getCompratore()->getCognome(),
                'email' => $movimento->getCompratore()->getEmail(),
            ];
            $data['ticket'] = $movimento->getTicket();
        }

        return $data;
    }

    private function serializeMovimentiToArray($movimenti)
    {
        $ret = [];
        foreach ($movimenti as $movimento) {
            $ret[] = $this->serializeMovimentoToArray($movimento);
        }
        return $ret;
    }

}
