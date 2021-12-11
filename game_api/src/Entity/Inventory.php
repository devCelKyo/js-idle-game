<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=ItemModel::class)
     */
    private $items;

    /**
     * @ORM\Column(type="array")
     */
    private $amounts = [];

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="inventory", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmounts(): ?array
    {
        return $this->amounts;
    }

    public function setAmounts(array $amounts): self
    {
        $this->amounts = $amounts;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setInventory(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getInventory() !== $this) {
            $user->setInventory($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getAmount(ItemModel $item): int
    {
        for ($i = 0; $i < count($this->getAmounts()); $i++) {
            if ($this->getItems()[$i] == $item) {
                return $this->getAmounts()[$i];
            }
        }
        return 0;
    }

    public function hasEnough(Cost $cost): bool 
    {
        for ($i = 0; $i < count($cost->getAmounts()); $i++) {
            $model = $this->getItems()[$i];
            $amount = $this->getAmounts()[$i];

            if ($this->getAmount($model) < $amount) {
                return false;
            }
        }

        return true;
    }

    public function withdraw(ItemModel $item, int $amount): bool 
    {
        for ($i = 0; $i < count($this->getAmounts()); $i++) {
            if ($this->getItems()[$i] == $item) {
                $this->amounts[$i] = $this->amounts[$i] - $amount;
            }
        }

        return true;
    }

    public function withdrawCost(Cost $cost): bool
    {
        if ($this->hasEnough($cost)) {
            for ($i = 0; $i < count($cost->getAmounts()); $i++) {
                $this->withdraw($cost->getItems()[$i], $cost->getAmounts()[$i]);
            }
            return true;
        }

        return false;
    }
}
