<?php

namespace App\Entity;

class PluginConfig
{
    public string $remoteEntry;
    public string $remoteName;
    public string $exposedModule;

    public function toArray(): array
    {
        return [
            'remoteEntry' => $this->remoteEntry,
            'remoteName' => $this->remoteName,
            'exposedModule' => $this->exposedModule
        ];
    }
}
