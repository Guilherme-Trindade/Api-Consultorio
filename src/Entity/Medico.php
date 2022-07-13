<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Internal\TentativeType;

/**
 * @ORM\Entity()
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @ORM\Column(type="integer")
     */
    public $crm;




    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class, inversedBy="medicos")
     */
    private $especialidade;

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setCrm($crm): void
    {
        $this->crm = $crm;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCrm()
    {
        return $this->crm;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id'=>$this->getId(),
            'crm'=>$this->setCrm(),
            'name'=>$this->setName(),
            'especialidadeId'=>$this->getEspecialidade()->getId()
        ];
    }
}