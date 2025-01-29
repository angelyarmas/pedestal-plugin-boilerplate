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
        $sanitizedName = $this->sanitizeFileName($pluginName);

        $pluginNamespace = $io->ask('What is your plugin namespace?', 'MyAwesomePlugin');
        $pluginPrefix = $io->ask('What is your plugin prefix?', 'map');
        $pluginDescription = $io->ask('What is your plugin description?', '');
        $authorName = $io->ask('What is your name?', '');
        $authorEmail = $io->ask('What is your email?', '');

        // Get API namespace and text domain with defaults
        $apiNamespace = $io->ask(
            'What is your REST API route namespace? (Press enter to use "' . $sanitizedName . '")',
            $sanitizedName
        );

        $textDomain = $io->ask(
            'What is your text domain? (Press enter to use "' . $sanitizedName . '")',
            $sanitizedName
        );

        // Replace in all PHP files
        $this->processDirectory($this->rootDir, [
            'PedestalNamespace' => $pluginNamespace,
            'my-plugin-boilerplate' => $sanitizedName,
            'mpb_' => $pluginPrefix . '_',
            'Pedestal Plugin Name' => $pluginName,
            'Pedestal Plugin description' => $pluginDescription,
            'Author Name' => $authorName,
            'author@email.com' => $authorEmail,
            "'mpb-api'" => "'" . $apiNamespace . "'", // For API namespace in register_rest_route
            "'my-plugin-boilerplate'" => "'" . $textDomain . "'", // For text domain
            'mpb-api/v1' => $apiNamespace . '/v1', // For API routes
        ]);

        // Update main plugin file
        $oldMainFile = $this->rootDir . '/my-plugin-boilerplate.php';
        $newMainFile = $this->rootDir . '/' . $sanitizedName . '.php';
        if (file_exists($oldMainFile)) {
            $content = file_get_contents($oldMainFile);

            // Update plugin header
            $pluginHeader = <<<EOT
/**
 * Plugin Name: {$pluginName}
 * Plugin URI:
 * Description: {$pluginDescription}
 * Version: 1.0.0
 * Author: {$authorName}
 * Author URI:
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: {$textDomain}
 * Domain Path: /languages
 */
EOT;
            $content = preg_replace('/\/\*\*[\s\S]+?\*\//', $pluginHeader, $content, 1);
            file_put_contents($newMainFile, $content);

            if ($oldMainFile !== $newMainFile) {
                unlink($oldMainFile);
            }
        }

        // Clean up unnecessary files and directories
        $this->cleanup();

        $io->success([
            'Plugin has been customized successfully!',
            'API Namespace: ' . $apiNamespace . '/v1',
            'Text Domain: ' . $textDomain
        ]);

        return Command::SUCCESS;
    }

    private function processDirectory(string $dir, array $replacements)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && ($file->getExtension() === 'php' || $file->getExtension() === 'pot')) {
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
            $this->rootDir . '/.git',
            $this->rootDir . '/composer.lock',
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