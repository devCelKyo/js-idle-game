<?php

namespace App\Entity;

use App\Entity\Factory;

use App\Repository\FactoryModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactoryModelRepository::class)
 */
class FactoryModel
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\OneToOne(targetEntity=Cost::class, cascade={"persist", "remove"})
     */
    private $cost;

    /**
     * @ORM\OneToMany(targetEntity=Factory::class, mappedBy="model", orphanRemoval=true)
     */
    private $factories;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseRate;

    public function __construct()
    {
        $this->factories = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getCost(): ?Cost
    {
        return $this->cost;
    }

    public function setCost(?Cost $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return Collection|Factory[]
     */
    public function getFactories(): Collection
    {
        return $this->factories;
    }

    public function addFactory(Factory $factory): self
    {
        if (!$this->factories->contains($factory)) {
            $this->factories[] = $factory;
            $factory->setModel($this);
        }

        return $this;
    }

    public function removeFactory(Factory $factory): self
    {
        if ($this->factories->removeElement($factory)) {
            // set the owning side to null (unless already changed)
            if ($factory->getModel() === $this) {
                $factory->setModel(null);
            }
        }

        return $this;
    }

    public function getBaseRate(): ?int
    {
        return $this->baseRate;
    }

    public function setBaseRate(int $baseRate): self
    {
        $this->baseRate = $baseRate;

        return $this;
    }

    public function createFactory(): Factory
    {
        $factory = new Factory();
        $factory->setModel($this);
        $factory->setLevel(1);
        $factory->setLastUpdate(new \DateTime());
        $factory->setRate($this->getBaseRate());

        return $factory;
    }
}
