<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\Column(type="string", length=2000)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $mcc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="category")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=CategoryMcc::class, mappedBy="category")
     */
    private $categoryMccs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->categoryMccs = new ArrayCollection();
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

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getMcc(): ?string
    {
        return $this->mcc;
    }

    public function setMcc(string $mcc): self
    {
        $this->mcc = $mcc;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCategory($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCategory() === $this) {
                $transaction->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoryMcc[]
     */
    public function getCategoryMccs(): Collection
    {
        return $this->categoryMccs;
    }

    public function addCategoryMcc(CategoryMcc $categoryMcc): self
    {
        if (!$this->categoryMccs->contains($categoryMcc)) {
            $this->categoryMccs[] = $categoryMcc;
            $categoryMcc->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryMcc(CategoryMcc $categoryMcc): self
    {
        if ($this->categoryMccs->removeElement($categoryMcc)) {
            // set the owning side to null (unless already changed)
            if ($categoryMcc->getCategory() === $this) {
                $categoryMcc->setCategory(null);
            }
        }

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
