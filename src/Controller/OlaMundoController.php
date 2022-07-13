<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OlaMundoController
{
    /**
     * @Route("/ola")
     */
    public function OlaMundoAction(Request $request): Response
    {
        $parametro = $request->query->all();
        $pathInfo = $request->getPathInfo();
       return new JsonResponse(["mensagen" => "ola mundo!",
           "pathInfo" => $pathInfo,
           'parametro' =>$parametro
       ]);
    }
}