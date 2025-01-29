<?php
// scripts/customize.php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class CustomizePluginCommand extends Command
{
    protected static $defaultName = 'customize';
    private $rootDir;

    public function __construct(string $rootDir)
    {
        parent::__construct();
        $this->rootDir = $rootDir;
    }

    protected function configure()
    {
        $this->setDescription('Customizes the plugin boilerplate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Get plugin information
        $pluginName = $io->ask('What is your plugin name?', 'My Awesome Plugin');
        $pluginNamespace = $io->ask('What is your plugin namespace?', 'MyAwesomePlugin');
        $pluginPrefix = $io->ask('What is your plugin prefix?', 'map');
        $pluginDescription = $io->ask('What is your plugin description?', '');
        $authorName = $io->ask('What is your name?', '');
        $authorEmail = $io->ask('What is your email?', '');

        // Replace in all PHP files
        $this->processDirectory($this->rootDir, [
            'MyPluginBoilerplate' => $pluginNamespace,
            'my-plugin-boilerplate' => $this->sanitizeFileName($pluginName),
            'mpb_' => $pluginPrefix . '_',
            'My Plugin Boilerplate' => $pluginName,
            'Plugin boilerplate description' => $pluginDescription,
            'Author Name' => $authorName,
            'author@email.com' => $authorEmail
        ]);

        // Rename main plugin file
        $oldMainFile = $this->rootDir . '/my-plugin-boilerplate.php';
        $newMainFile = $this->rootDir . '/' . $this->sanitizeFileName($pluginName) . '.php';
        if (file_exists($oldMainFile)) {
            rename($oldMainFile, $newMainFile);
        }

        // Clean up unnecessary files and directories
        $this->cleanup();

        $io->success('Plugin has been customized successfully!');
        return Command::SUCCESS;
    }

    private function processDirectory(string $dir, array $replacements)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                $content = str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $content
                );
                file_put_contents($file->getPathname(), $content);
            }
        }
    }

    private function cleanup()
    {
        // Remove scripts directory
        $scriptsDir = $this->rootDir . '/scripts';
        if (is_dir($scriptsDir)) {
            $this->removeDirectory($scriptsDir);
        }

        // Remove any other unnecessary files or directories
        $unnecessaryFiles = [
            $this->rootDir . '/.git',           // Remove Git history
            $this->rootDir . '/composer.lock',   // Remove composer.lock as it's a new project
        ];

        foreach ($unnecessaryFiles as $file) {
            if (is_dir($file)) {
                $this->removeDirectory($file);
            } elseif (file_exists($file)) {
                unlink($file);
            }
        }

        // Update composer.json to remove the post-create-project-cmd script
        $composerFile = $this->rootDir . '/composer.json';
        if (file_exists($composerFile)) {
            $composer = json_decode(file_get_contents($composerFile), true);
            unset($composer['scripts']['post-create-project-cmd']);
            // Remove symfony/console from require-dev as it's no longer needed
            unset($composer['require-dev']['symfony/console']);
            if (empty($composer['require-dev'])) {
                unset($composer['require-dev']);
            }
            file_put_contents($composerFile, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->removeDirectory($path) : unlink($path);
        }
        return rmdir($dir);
    }

    private function sanitizeFileName(string $name): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9-]/', '-', $name));
    }
}

// Run the customization
$application = new Application();
$application->add(new CustomizePluginCommand(dirname(__DIR__)));
$application->setDefaultCommand('customize', true);
$application->run();