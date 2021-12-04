<?php

namespace App\Entity;

use App\Entity\Cost;
use App\Repository\FactoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactoryRepository::class)
 */
class Factory
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
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\OneToOne(targetEntity=Cost::class, cascade={"persist", "remove"})
     */
    private $cost;

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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

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

    public function getUpgradeCost(): ?Cost
    {
        $level = $this->getLevel();
        $baseCost = $this->getCost();
        
        $upgradeCost = new Cost();
        $upgradeCostAmounts = array();

        foreach($baseCost->getItems() as $item) {
            $newCost->addItem($item);
        }

        foreach($baseCost->getAmounts() as $amount) {
            $upgradeCostAmounts[] = $amount*pow(1.5, $level);
        }
        $upgradeCost->setAmounts($upgradeCostAmounts);

        return $upgradeCost;
    }
}
