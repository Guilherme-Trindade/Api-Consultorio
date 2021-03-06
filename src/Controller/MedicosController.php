<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\MedicoFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends AbstractController
{
    public EntityManagerInterface $entityManager;

    private MedicoFactory $medicoFactory;

    public function __construct(EntityManagerInterface $entityManager, MedicoFactory $medicoFactory)
    {
        $this->entityManager = $entityManager;
        $this->medicoFactory = $medicoFactory;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $medico = $this->medicoFactory->criarMedico($corpoRequisicao);

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);
        $medicoList = $repositorioDeMedicos->findAll();
        return new JsonResponse($medicoList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"} )
     */
    public function buscarUm(int $id): Response
    {
        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);
        $medico = $repositorioDeMedicos->find($id);
        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;
        return new JsonResponse($medico, $codigoRetorno);

    }

    /**
     * @Route("/medicos/{id}", methods={"DELETE"})
     */
    public function deletarMedico(int $id): Response
    {
        $medico = $this->buscarUm($id);
        $this->entityManager->remove($medico);

        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);

    }


    /**
     * @Route("/medicos/{id}", methods={"PUT"} )
     */
    public function atualizar(int $id, Request $request): JsonResponse
    {
        $corpoRequisicao = $request->getContent();
        $medicoEnviado = $this->medicoFactory->criarMedico($corpoRequisicao);

        $repositorioDeMedicos = $this->entityManager->getRepository(Medico::class);

        $medicoExistente = $repositorioDeMedicos->find($id);
        $medicoExistente->crm = $medicoEnviado->crm;
        $medicoExistente->name = $medicoEnviado->name;

        $this->entityManager->flush();

        return new JsonResponse($medicoExistente);
    }

}