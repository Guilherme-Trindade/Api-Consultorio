<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {

        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarMedico(string $json): Medico
    {
        $dadosEmJson = json_decode($json);
        $espcialidadeId = $dadosEmJson->especialidadeid;
        $espcialidade = $this->especialidadeRepository->find($espcialidadeId);

        $medico = new Medico();
        $medico->setCrm($dadosEmJson);
        $medico->setName($dadosEmJson);
        $medico->setEspecialidade($espcialidade);

        return $medico;
    }

}