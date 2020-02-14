<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class ApiV1Controller extends AbstractController
{
    /**
     * @Route("/api/v1/ping", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Ping response",
     *     @SWG\Schema(
     *        @SWG\Property(
     *          property="message",
     *          description="pong"
     *        ),
     *        @SWG\Property(
     *          property="date",
     *          description="pong datetime"
     *        )
     *     )
     * )
     */
    public function ping()
    {
        return new JsonResponse([
            'message' => 'pong',
            'date' => date('Y-m-d h:i:s'),
        ]);
    }
}
