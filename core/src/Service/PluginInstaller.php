<?php

namespace App\Service;

use App\Entity\Plugin;
use App\Entity\PluginConfig;
use App\Entity\PluginWidget;
use Doctrine\ORM\EntityManagerInterface;
use ZipArchive;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class PluginInstaller
{
    private string $tmpDir = 'var/plugin_tmp';
    private string $backendPluginDir = 'src/Plugins';
    private string $frontEndPluginDir = 'public/static/plugins';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }


    public function installFromZip(string $zipFile): bool
    {
        $zipPath = $this->tmpDir . '/' . $zipFile;

        if (!file_exists($zipPath)) {
            throw new \RuntimeException("Zip file not found: $zipPath");
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            throw new \RuntimeException("Cannot open zip file: $zipPath");
        }

        $extractPath = $this->tmpDir . '/' . pathinfo($zipFile, PATHINFO_FILENAME);
        $zip->extractTo($extractPath);
        $zip->close();

        // Find nova.json inside extracted dir
        $novaJsonPath = $extractPath . '/nova.json';
        if (!$novaJsonPath) {
            throw new \RuntimeException("nova.json not found inside $zipFile");
        }

        $metadata = json_decode(file_get_contents($novaJsonPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON in nova.json");
        }
        $pluginName = $metadata['vendorName'] . $metadata['pluginName'];


        // Move extracted plugin into src/Plugins
        $this->copyBackend($pluginName, $extractPath);
        $this->migrate();
        $this->copyFrontEnd($pluginName, $extractPath);
        $this->installMetadata($metadata);

        return true;
    }

    private function installMetadata(array $metadata) {
        $pluginName =$metadata['vendorName'] . $metadata['pluginName'];
        $config = new PluginConfig();
        $config->remoteName = $pluginName;
        $config->remoteEntry = "/plugins/{$pluginName}/remoteEntry.js";
        $config->exposedModule = "./plugins/{$pluginName}";
        $plugin = new Plugin();
        $plugin->setName($pluginName);
        $plugin->setPluginConfig($config);
        $plugin->setTitle($metadata['title']);
        $plugin->setVersion($metadata['version']);
        $plugin->setAuthor($metadata['vendorName']);
        $plugin->setMinForumVersion($metadata['minVersion']);
        $plugin->setVersion($metadata['version']);
        $plugin->setIsEnabled(true);
        $this->entityManager->persist($plugin);
        $this->entityManager->flush();

        foreach($metadata['widgets'] as $widgetName => $components) {
            foreach($components as $component) {
                $widget = new PluginWidget();
                $widget->setPlugin($plugin);
                $widget->setComponentName($component);
                $widget->setWidgetName($widgetName);
                $this->entityManager->persist($widget);
            }
        }
        $this->entityManager->flush();
    }

    private function runConsoleCommand(string $command, ?string $flag = null) {
        $process = new Process(['php', 'bin/console', $command, $flag]);
        $process->setTimeout(null);
        $process->run();
        return $process;
    }

    private function migrate() {
        $this->runConsoleCommand('cache:clear');
        $this->runConsoleCommand('doctrine:cache:clear-metadata');
        $diff = $this->runConsoleCommand('doctrine:migrations:diff');

        if (!$diff->isSuccessful()) {
            throw new \RuntimeException("Migration generation failed: " . $diff->getErrorOutput());
        }

        $output = $diff->getOutput() . $diff->getErrorOutput();

        if (stripos($output, 'No changes detected') !== false) {
            // Nothing to do
            echo "No new migrations needed for plugin.\n";
        } else {
            echo "Migrations generated, applying...\n";

            $migrate = $this->runConsoleCommand('doctrine:migrations:migrate', '--no-interaction');

            if (!$migrate->isSuccessful()) {
                throw new \RuntimeException("Migration execution failed: " . $migrate->getErrorOutput());
            }
        }
    }

    private function copyBackend(string $pluginName, string $tmpModulePath) {
        $targetPath = $this->backendPluginDir . '/' . $pluginName;
        $sourcePath = $tmpModulePath . '/backend';
        $this->copyFiles($pluginName, $sourcePath, $targetPath);
    }

    private function copyFrontEnd(string $pluginName, string $tmpModulePath) {
        $targetPath = $this->frontEndPluginDir . '/' . $pluginName;
        $sourcePath = $tmpModulePath . '/frontend';
        $this->copyFiles($pluginName, $sourcePath, $targetPath);
    }

    private function copyFiles (string $pluginName, string $sourcePath, string $targetPath) {
            $filesystem = new Filesystem();
            if ($filesystem->exists($targetPath)) {
                throw new \RuntimeException("Plugin $pluginName is already installed");
            }

            if (is_dir($sourcePath)) {
                $fileIterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($sourcePath, \FilesystemIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($fileIterator as $item) {
                    // Figure out relative path inside backend
                    $relativePath = substr($item->getPathname(), strlen($sourcePath) + 1);
                    $target = $targetPath . '/' . $relativePath;

                    if ($item->isDir()) {
                        $filesystem->mkdir($target);
                    } else {
                        $filesystem->copy($item->getPathname(), $target, true);
                    }
                }
            }
        }

}
