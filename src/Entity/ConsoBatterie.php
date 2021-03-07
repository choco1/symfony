<?php

namespace App\Entity;

use App\Repository\ConsoBatterieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsoBatterieRepository::class)
 */
class ConsoBatterie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameConnex;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pourcentage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeColor;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class, mappedBy="consoBatterie")
     */
    private $modules;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameConnex(): ?string
    {
        return $this->nameConnex;
    }

    public function setNameConnex(?string $nameConnex): self
    {
        $this->nameConnex = $nameConnex;

        return $this;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(?int $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getCodeColor(): ?string
    {
        return $this->codeColor;
    }

    public function setCodeColor(?string $codeColor): self
    {
        $this->codeColor = $codeColor;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addConsoBatterie($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removeConsoBatterie($this);
        }

        return $this;
    }
}
