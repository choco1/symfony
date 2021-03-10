<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberSerie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $functionState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=TypeModule::class, inversedBy="modules")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=PowerSupply::class, inversedBy="modules")
     */
    private $typePower;

    /**
     * @ORM\ManyToMany(targetEntity=Sensor::class, inversedBy="modules")
     */
    private $sensor;

    /**
     * @ORM\ManyToMany(targetEntity=Connection::class, inversedBy="modules")
     */
    private $connection;

    /**
     * @ORM\Column(type="integer")
     */
    private $autonomie;

    /**
     * @ORM\Column(type="integer")
     */
    private $temperatureModule;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxTemperature;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etatConnex;

    /**
     * @ORM\ManyToMany(targetEntity=ConsoBatterie::class, inversedBy="modules")
     */
    private $consoBatterie;

    /**
     * @ORM\ManyToMany(targetEntity=HistoricFonctionModule::class, inversedBy="modules")
     */
    private $historic;

    /**
     * @ORM\ManyToMany(targetEntity=HistoricTemperature::class, inversedBy="modules")
     */
    private $historicTemperature;







    public function __construct()
    {
        $this->sensor = new ArrayCollection();
        $this->connection = new ArrayCollection();
        $this->consoBatterie = new ArrayCollection();
        $this->historicFonctionModules = new ArrayCollection();
        $this->historic = new ArrayCollection();
        $this->historicTemperature = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumberSerie(): ?int
    {
        return $this->numberSerie;
    }

    public function setNumberSerie(int $numberSerie): self
    {
        $this->numberSerie = $numberSerie;

        return $this;
    }

    public function getFunctionState(): ?bool
    {
        return $this->functionState;
    }

    public function setFunctionState(bool $functionState): self
    {
        $this->functionState = $functionState;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?TypeModule
    {
        return $this->type;
    }

    public function setType(?TypeModule $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypePower(): ?PowerSupply
    {
        return $this->typePower;
    }

    public function setTypePower(?PowerSupply $typePower): self
    {
        $this->typePower = $typePower;

        return $this;
    }

    /**
     * @return Collection|Sensor[]
     */
    public function getSensor(): Collection
    {
        return $this->sensor;
    }

    public function addSensor(Sensor $sensor): self
    {
        if (!$this->sensor->contains($sensor)) {
            $this->sensor[] = $sensor;
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): self
    {
        $this->sensor->removeElement($sensor);

        return $this;
    }

    /**
     * @return Collection|Connection[]
     */
    public function getConnection(): Collection
    {
        return $this->connection;
    }

    public function addConnection(Connection $connection): self
    {
        if (!$this->connection->contains($connection)) {
            $this->connection[] = $connection;
        }

        return $this;
    }

    public function removeConnection(Connection $connection): self
    {
        $this->connection->removeElement($connection);

        return $this;
    }

    public function getAutonomie(): ?int
    {
        return $this->autonomie;
    }

    public function setAutonomie(int $autonomie): self
    {
        $this->autonomie = $autonomie;

        return $this;
    }

    public function getTemperatureModule(): ?int
    {
        return $this->temperatureModule;
    }

    public function setTemperatureModule(int $temperatureModule): self
    {
        $this->temperatureModule = $temperatureModule;

        return $this;
    }

    public function getMaxTemperature(): ?int
    {
        return $this->maxTemperature;
    }

    public function setMaxTemperature(int $maxTemperature): self
    {
        $this->maxTemperature = $maxTemperature;

        return $this;
    }

    public function getEtatConnex(): ?bool
    {
        return $this->etatConnex;
    }

    public function setEtatConnex(bool $etatConnex): self
    {
        $this->etatConnex = $etatConnex;

        return $this;
    }

    /**
     * @return Collection|ConsoBatterie[]
     */
    public function getConsoBatterie(): Collection
    {
        return $this->consoBatterie;
    }

    public function addConsoBatterie(ConsoBatterie $consoBatterie): self
    {
        if (!$this->consoBatterie->contains($consoBatterie)) {
            $this->consoBatterie[] = $consoBatterie;
        }

        return $this;
    }

    public function removeConsoBatterie(ConsoBatterie $consoBatterie): self
    {
        $this->consoBatterie->removeElement($consoBatterie);

        return $this;
    }

    /**
     * @return Collection|HistoricFonctionModule[]
     */
    public function getHistoric(): Collection
    {
        return $this->historic;
    }

    public function addHistoric(HistoricFonctionModule $historic): self
    {
        if (!$this->historic->contains($historic)) {
            $this->historic[] = $historic;
        }

        return $this;
    }

    public function removeHistoric(HistoricFonctionModule $historic): self
    {
        $this->historic->removeElement($historic);

        return $this;
    }

    /**
     * @return Collection|HistoricTemperature[]
     */
    public function getHistoricTemperature(): Collection
    {
        return $this->historicTemperature;
    }

    public function addHistoricTemperature(HistoricTemperature $historicTemperature): self
    {
        if (!$this->historicTemperature->contains($historicTemperature)) {
            $this->historicTemperature[] = $historicTemperature;
        }

        return $this;
    }

    public function removeHistoricTemperature(HistoricTemperature $historicTemperature): self
    {
        $this->historicTemperature->removeElement($historicTemperature);

        return $this;
    }







}
