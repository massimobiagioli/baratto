<?php

namespace App\Controller;

use App\Service\Authenticator\AuthenticatorInterface;
use App\Service\Admin\AdminInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private $authenticator;
    private $adminService;

    public function __construct(
        AuthenticatorInterface $authenticator, 
        AdminInterface $adminService)
    {
        $this->authenticator = $authenticator;
        $this->adminService = $adminService;
    }

    /**
     * @Route("/api/admin/articoli", methods={"GET"})
     * @SWG\Get(
     *  path="/api/admin/articoli",  
     *  summary="Elenco articoli",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,   
     *    type="string"
     *  ), 
     *  @SWG\Response(
     *     response=200,
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="articoli",
     *          description="Elenco articoli"
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
    public function listArticoli(Request $request)
    {           
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
            if (!$accessToken->getAllowAdmin()) {
                return new Response('Accesso ad area amministratore non consentita', 401);
            }
        } catch (\Exception $e) {   
            return new Response($e->getMessage(), 401);
        }

        try {
            $articoli = $this->adminService->listArticoli();
            return new JsonResponse($this->serializeArticoliToArray($articoli));    
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }  
    }

    /**
     * @Route("/api/admin/articoli/{id}", methods={"GET"}, requirements={"id"="\d+"})
     * @SWG\Get(
     *  path="/api/admin/articoli/{id}",  
     *  summary="get Articolo by ID",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,   
     *    type="string"
     *  ), 
     *  @SWG\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,   
     *    type="integer"
     *  ), 
     *  @SWG\Response(
     *     response=200,
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="articolo",
     *          description="Articolo"
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
    public function getArticolo(Request $request, int $id)
    {
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
            if (!$accessToken->getAllowAdmin()) {
                return new Response('Accesso ad area amministratore non consentita', 401);
            }
        } catch (\Exception $e) {   
            return new Response($e->getMessage(), 401);
        }

        try {
            $articolo = $this->adminService->getArticolo($id);
            return new JsonResponse($this->$this->serializeArticoloToArray($articolo));  
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/admin/articoli", methods={"POST"})
     * @SWG\Post(
     *  path="/api/admin/articoli",  
     *  summary="Inserimento articolo",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,   
     *    type="string"
     *  ),
     *  @SWG\Response(
     *     response=201,
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="articolo",
     *          description="Articolo creato"
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
    public function insertArticolo(Request $request)
    {
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
            if (!$accessToken->getAllowAdmin()) {
                return new Response('Accesso ad area amministratore non consentita', 401);
            }
        } catch (\Exception $e) {   
            return new Response($e->getMessage(), 401);
        }

        $toInsert = json_decode($request->getContent(), true);
        if (!$toInsert) {
            return new Response('No login credentials specified', 400);
        }
        if (!isset($toInsert['nome'])) {
            return new Response('Nome non specificato', 400);
        }
        if (!isset($toInsert['monete'])) {
            return new Response('Monete non specificate', 400);
        }
        $articolo = new Articolo();
        $articolo->setNome($toUpdate['nome']);
        $articolo->setMonete($toUpdate['monete']);
        try {
            $articolo = $this->adminService->insert($articolo);
            return new JsonResponse($this->$this->serializeArticoloToArray($articolo));   
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/admin/articoli/{id}", methods={"UPDATE"}, requirements={"id"="\d+"})
     * @SWG\Update(
     *  path="/api/admin/articoli/{id}",  
     *  summary="Inserimento articolo",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,   
     *    type="string"
     *  ),
     *  @SWG\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,   
     *    type="integer"
     *  ), 
     *  @SWG\Response(
     *     response=200,
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="articolo",
     *          description="Articolo modificato"
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
    public function updateArticolo(Request $request)
    {
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
            if (!$accessToken->getAllowAdmin()) {
                return new Response('Accesso ad area amministratore non consentita', 401);
            }
        } catch (\Exception $e) {   
            return new Response($e->getMessage(), 401);
        }

        $oldArticolo = $this->adminService->getArticolo($id);
        $toUpdate = json_decode($request->getContent(), true);
        if (!$toUpdate) {
            return new Response('No login credentials specified', 400);
        }
        if (!isset($toUpdate['nome'])) {
            return new Response('Nome non specificato', 400);
        }
        if (!isset($toUpdate['monete'])) {
            return new Response('Monete non specificate', 400);
        }
        $oldArticolo->setNome($toUpdate['nome']);
        $oldArticolo->setMonete($toUpdate['monete']);
        try {
            $articolo = $this->adminService->update($id, $oldArticolo);
            return new JsonResponse($this->$this->serializeArticoloToArray($articolo));   
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/admin/articoli/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
      * @SWG\Delete(
     *  path="/api/admin/articoli/{id}",  
     *  summary="Inserimento articolo",
     *  @SWG\Parameter(
     *    name="X-AUTH-TOKEN",
     *    in="header",
     *    required=true,   
     *    type="string"
     *  ),
     *  @SWG\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,   
     *    type="integer"
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
     *     response=401,
     *     description="UNAUTHORIZED"     
     *  )
     * )
     */
    public function deleteArticolo(Request $request)
    {
        try {
            $tokenKey = $request->headers->get('X-AUTH-TOKEN');
            $accessToken = $this->authenticator->verify($tokenKey);
            if (!$accessToken->getAllowAdmin()) {
                return new Response('Accesso ad area amministratore non consentita', 401);
            }
        } catch (\Exception $e) {   
            return new Response($e->getMessage(), 401);
        }
        
        try {
            $this->adminService->deleteArticolo($id);
            return new Response('');
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }

    private function serializeArticoloToArray($articolo) {
        return [
            'id' => $articolo->getId(),
            'nome' => $articolo->getNome(),
            'monete' => $articolo->getMonete()
        ];
    }

    private function serializeArticoliToArray($articoli) {
        $ret = [];
        foreach ($articoli as $articolo) {
            $ret[] = $this->serializeArticoloToArray($articolo);
        }
        return $ret;
    }

}   
