<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class PluginWidget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: 'Plugin', inversedBy: 'widgets')]
    #[ORM\JoinColumn(nullable: false)]
    private Plugin $plugin;

    #[ORM\Column(type: 'string', length: 255)]
    private string $widgetName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $componentName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPlugin(): Plugin
    {
        return $this->plugin;
    }

    public function setPlugin(Plugin $plugin): void
    {
        $this->plugin = $plugin;
    }

    public function getWidgetName(): string
    {
        return $this->widgetName;
    }

    public function setWidgetName(string $widgetName): void
    {
        $this->widgetName = $widgetName;
    }

    public function getComponentName(): string
    {
        return $this->componentName;
    }

    public function setComponentName(string $componentName): void
    {
        $this->componentName = $componentName;
    }


}
