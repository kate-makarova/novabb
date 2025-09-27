<?php

namespace App\Entity;

use App\Repository\SubforumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubforumRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQUE_IDENTIFIER_ID', fields: ['id'])]
class Subforum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Subforum::class, inversedBy: 'subforums')]
    private ?Subforum $parentSubforum = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'subforums')]
    private Category $parentCategory;

    #[ORM\Column]
    private int $position;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getParentSubforum(): ?int
    {
        return $this->parentSubforum;
    }

    public function setParentSubforum(?int $parentSubforum): void
    {
        $this->parentSubforum = $parentSubforum;
    }

    public function getParentCategory(): ?int
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?int $parentCategory): void
    {
        $this->parentCategory = $parentCategory;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
