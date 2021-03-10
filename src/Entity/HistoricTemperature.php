<?php

namespace App\Entity;

use App\Repository\HistoricTemperatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoricTemperatureRepository::class)
 */
class HistoricTemperature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempMax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tempMin;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class, mappedBy="historicTemperature")
     */
    private $modules;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTempMax(): ?int
    {
        return $this->tempMax;
    }

    public function setTempMax(?int $tempMax): self
    {
        $this->tempMax = $tempMax;

        return $this;
    }

    public function getTempMin(): ?int
    {
        return $this->tempMin;
    }

    public function setTempMin(?int $tempMin): self
    {
        $this->tempMin = $tempMin;

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
            $module->addHistoricTemperature($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removeHistoricTemperature($this);
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
