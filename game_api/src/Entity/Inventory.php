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
        // wip
    }

    public function hasEnough(Cost $item): bool 
    {
        // wip
    }

    public function withdraw(Cost $item): bool
    {
        // wip
    }
}
