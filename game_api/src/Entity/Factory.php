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
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdate;

    /**
     * @ORM\ManyToOne(targetEntity=FactoryModel::class, inversedBy="factories", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factories")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function calculateRate(): ?int
    {
        return $this->getModel()->getBaseRate()*pow(1.5, $this->getLevel());
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function updateRate(): self
    {
        $this->setRate($this->calculateRate());

        return $this;
    }

    public function getUpgradeCost(): ?Cost
    {
        $level = $this->getLevel();
        $baseCost = $this->getModel()->getCost();
        
        $upgradeCost = new Cost();
        $upgradeCostAmounts = array();

        foreach($baseCost->getItems() as $item) {
            $upgradeCost->addItem($item);
        }

        foreach($baseCost->getAmounts() as $amount) {
            $upgradeCostAmounts[] = $amount*pow(1.5, $level);
        }
        $upgradeCost->setAmounts($upgradeCostAmounts);

        return $upgradeCost;
    }

    public function upgrade(): self 
    {
        $this->setLevel($this->getLevel() + 1);
        $this->updateRate();

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    public function updateFactory(): self
    {
        $now = new \DateTime();
        $now = $now->getTimestamp();
        $lastUpdate = $this->getLastUpdate()->getTimestamp();

        $diff = $now - $lastUpdate;

        $this->getUser()->giveMoney($diff*$this->getRate());
        $this->setLastUpdate(new \DateTime());

        return $this;
    }

    public function getModel(): ?FactoryModel
    {
        return $this->model;
    }

    public function setModel(?FactoryModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
