<?php

namespace App\Entity;

use App\Repository\PowerSupplyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PowerSupplyRepository::class)
 */
class PowerSupply
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfPower;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="typePower")
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

    public function getTypeOfPower(): ?string
    {
        return $this->typeOfPower;
    }

    public function setTypeOfPower(string $typeOfPower): self
    {
        $this->typeOfPower = $typeOfPower;

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
            $module->setTypePower($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getTypePower() === $this) {
                $module->setTypePower(null);
            }
        }

        return $this;
    }
}
