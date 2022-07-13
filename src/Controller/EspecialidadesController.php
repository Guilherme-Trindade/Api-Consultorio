<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EntityManagerInterface  $entityManager,
                                EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/especialidades", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $dadosJson = json_decode($dadosRequest);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosJson->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $especialidadeList = $this->especialidadeRepository->findAll();

        return new JsonResponse($especialidadeList);
    }

    /**
     * @Route("/especialidades/{id}", methods={"GET"})
     */

    public function buscarUma(int $id): Response
    {
        return new JsonResponse($this->especialidadeRepository->find($id));
    }

    /**
     * @Route("/especialidades/{id}", methods={PUT})
     */
    public function atualiza(int $id, Request $request): Response
    {

        $dadosRequest = $request->getContent();
        $dadosEmJson = json_decode($dadosRequest);

        $especialidade = $this->especialidadeRepository->find($id);
        $especialidade->setDescricao($dadosEmJson->descricao);

        $this->especialidadeRepository->flush();

        return new JsonResponse($especialidade);

    }

    /**
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */

    public function remove(int $id): Response
    {

        $especialidade = $this->especialidadeRepository->find($id);
        $this->especialidadeRepository->remove($especialidade);
        $this->especialidadeRepository->flush();

        return new Response('', Response::HTTP_NO_CONTENT);

    }

}