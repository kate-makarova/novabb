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

    #[ORM\Column(nullable: true)]
    #[ORM\ManyToOne(targetEntity: Subforum::class, inversedBy: 'subforums')]
    private ?int $parent_subforum = null;

    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'subforums')]
    private ?int $parent_category = null;

    #[ORM\Column]
    private int $position;
}
