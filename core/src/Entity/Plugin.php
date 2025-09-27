<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'UNIQUE_IDENTIFIER_NAME', fields: ['name'])]
class Plugin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $author;

    #[ORM\Column]
    private float $version;

    #[ORM\Column]
    private float $minForumVersion;

    #[ORM\Column]
    private bool $isEnabled;

    #[ORM\Column(type: 'json_document')]
    private PluginConfig $pluginConfig;

    #[ORM\OneToMany(targetEntity: PluginWidget::class, mappedBy: 'plugin')]
    private Collection $pluginWidgets;

    public function __construct()
    {
        $this->pluginWidgets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getVersion(): float
    {
        return $this->version;
    }

    public function setVersion(float $version): void
    {
        $this->version = $version;
    }

    public function getMinForumVersion(): float
    {
        return $this->minForumVersion;
    }

    public function setMinForumVersion(float $minForumVersion): void
    {
        $this->minForumVersion = $minForumVersion;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    public function getPluginConfig(): PluginConfig
    {
        return $this->pluginConfig;
    }

    public function setPluginConfig(PluginConfig $pluginConfig): void
    {
        $this->pluginConfig = $pluginConfig;
    }

    public function getPluginWidgets(): Collection
    {
        return $this->pluginWidgets;
    }

    public function setPluginWidgets(Collection $pluginWidgets): void
    {
        $this->pluginWidgets = $pluginWidgets;
    }
}
