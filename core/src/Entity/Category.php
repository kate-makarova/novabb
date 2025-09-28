<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private int $position;

    #[ORM\OneToMany(targetEntity: Subforum::class, mappedBy: 'parentCategory')]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $subforums;

    public function __construct()
    {
        $this->subforums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getSubforums(): Collection
    {
        return $this->subforums;
    }

    public function setSubforums(ArrayCollection $subforums): void
    {
        $this->subforums = $subforums;
    }
}
