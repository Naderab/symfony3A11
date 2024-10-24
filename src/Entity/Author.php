<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'idAuthor', orphanRemoval: true)]
    private Collection $listBooks;

    public function __construct()
    {
        $this->listBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getListBooks(): Collection
    {
        return $this->listBooks;
    }

    public function addListBook(Book $listBook): static
    {
        if (!$this->listBooks->contains($listBook)) {
            $this->listBooks->add($listBook);
            $listBook->setIdAuthor($this);
        }

        return $this;
    }

    public function removeListBook(Book $listBook): static
    {
        if ($this->listBooks->removeElement($listBook)) {
            // set the owning side to null (unless already changed)
            if ($listBook->getIdAuthor() === $this) {
                $listBook->setIdAuthor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id.' '.$this->name;
    }
}
