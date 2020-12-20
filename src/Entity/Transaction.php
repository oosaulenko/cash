<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Card::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom_description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mcc;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cashback;

    /**
     * @ORM\Column(type="integer")
     */
    private $create_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getCustomDescription(): ?string
    {
        return $this->custom_description;
    }

    public function setCustomDescription(?string $custom_description): self
    {
        $this->custom_description = $custom_description;

        return $this;
    }

    public function getMcc(): ?int
    {
        return $this->mcc;
    }

    public function setMcc(?int $mcc): self
    {
        $this->mcc = $mcc;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCommission(): ?float
    {
        return $this->commission;
    }

    public function setCommission(?float $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function getCashback(): ?float
    {
        return $this->cashback;
    }

    public function setCashback(?float $cashback): self
    {
        $this->cashback = $cashback;

        return $this;
    }

    public function getCreateAt(): ?int
    {
        return $this->create_at;
    }

    public function setCreateAt(int $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}