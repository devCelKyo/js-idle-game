<?php

namespace App\Entity;

use App\Repository\CostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CostRepository::class)
 */
class Cost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $amounts = [];

    /**
     * @ORM\ManyToMany(targetEntity=ItemModel::class)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    public function setAmounts(array $amounts): self
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * @return Collection|ItemModel[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemModel $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function removeItem(ItemModel $item): self
    {
        $this->items->removeElement($item);

        return $this;
    }
}
