<?php

namespace App\Entity;

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

    #[ORM\OneToMany(targetEntity: Subforum::class, mappedBy: 'category')]
    private ?int $parent_category_id = null;
}
