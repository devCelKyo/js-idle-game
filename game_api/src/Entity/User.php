<?php

namespace App\Entity;

use App\Entity\ItemModel;
use App\Entity\Cost;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdate;

    /**
     * @ORM\OneToMany(targetEntity=Factory::class, mappedBy="user")
     */
    private $factories;

    /**
     * @ORM\OneToOne(targetEntity=Inventory::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $inventory;

    public function __construct()
    {
        $this->factories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPlainPassword(string $password): self
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Ligne à changer

        $this->password = $hashedPassword;

        return $this;
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function getBalance(): ?int
    {
        return $this->getMoney();
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function giveMoney(int $money): self
    {
        $this->setMoney($this->getBalance() + $money);

        return $this;
    }

    public function removeMoney(int $money): self
    {
        $this->giveMoney(-1*$money);

        return $this;
    }

    public function getRate(): ?int
    {
        $rate = 0;
        foreach($this->getFactories() as $factory)
        {
            $rate = $rate + $factory->getRate();
        }
        return $rate;
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

    public function updatePlayer(): self
    {
        foreach($this->getFactories() as $factory) {
            $factory->updateFactory();
        }

        return $this;
    }

    public function clickPlayer(): self
    {
        $this->giveMoney(1);
        
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
            $factory->setUser($this);
        }

        return $this;
    }

    public function removeFactory(Factory $factory): self
    {
        if ($this->factories->removeElement($factory)) {
            // set the owning side to null (unless already changed)
            if ($factory->getUser() === $this) {
                $factory->setUser(null);
            }
        }

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function canPay(Cost $item): bool 
    {
        // wip
    }

    public function pay(Cost $item): bool
    {
        // wip
    }
}
