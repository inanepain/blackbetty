<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

use Inane\Cli\Cli;
use Inane\Stdlib\Options;
use \Inane\Cli\Pencil;
use \Inane\Cli\Pencil\Colour;
use \Inane\Cli\Pencil\Style;
use Inane\File\File;
use Inane\Stdlib\Json;

// use function is_null;
// use const null;

/**
 * Class VSCodiumPatcher
 *
 * This class is responsible for patching VSCodium configurations or files.
 * It provides methods to modify or update VSCodium settings to meet specific requirements.
 *
 * @package VSCodiumPatcher
 */
class VSCodiumPatcher {
    /**
     * The current version of the application.
     *
     * @var string
     */
    public const VERSION = '0.1.0';

    /**
     * @var Options $config Configuration options for the application.
     */
    private Options $config;

    /**
     * @var File $vscode An instance of the File class representing the VSCode file.
     */
    private File $vscode;

    /**
     * @var File $vscodium An instance of the File class representing the VSCodium file.
     */
    private File $vscodium;

    /**
     * Displays an error message for a specific file.
     *
     * @param string $file The path to the file where the error occurred.
     * @param string $message The error message to be displayed.
     * @param int    $exit When greater than 0 it tells the application is ended.
     *
     * @return void
     */
    protected function showError(string $file, string $message, int $exit = 0): void {
        Cli::line("{$this->config->message->red}Error:{$this->config->message->blue} $file:{$this->config->message->reset} $message");
        if ($exit > 0) exit($exit);
    }

    /**
     * Constructor method for initializing the class with configuration options.
     *
     * @param array|Options|null $config Configuration options for the class. It can be an array, an instance of the Options class, or null.
     */
    public function __construct(array|Options|null $config = null) {
        $this->config = new Options([
            'file' => [
                'vscode' => 'C:\Users\Philip\AppData\Local\Programs\Microsoft VS Code\resources\app\product.json',
                'vscodium' => 'C:\Program Files\VSCodium\resources\app\product.json',
            ],
            'gallery' => [
                'keyName' => 'extensionsGallery',
            ],
            'message' => [
                'blue' => new Pencil(Colour::Blue, style: Style::Bold),
                'green' => new Pencil(Colour::Green),
                'purple' => new Pencil(Colour::Purple),
                'red' => new Pencil(Colour::Red),
                'reset' => Pencil::reset(),
            ],
        ]);

        $this->config->message->purple->line('VSCodium Patcher (' . static::VERSION . ')');

        if (!is_null($config)) $this->config->merge($config);
        $this->config->lock();

        $this->init();
        $this->bootstrap();
    }

    /**
     * Initializes the necessary components or settings for the class.
     *
     * This method is protected and cannot be accessed outside of the class hierarchy.
     *
     * @return void
     */
    protected function init(): void {
        $this->vscode = new File($this->config->file->vscode);
        $this->vscodium = new File($this->config->file->vscodium);
    }

    /**
     * Initializes the application by setting up necessary configurations and services.
     *
     * This method is responsible for bootstrapping the application, ensuring that
     * all required components are properly configured and ready to be used.
     *
     * @return void
     */
    protected function bootstrap(): void {
        foreach($this->config->file as $fileName => $fileValue) {
            if (!$this->verifyFile($fileName, $fileName == 'vscodium')) {
                $this->showError($fileName, 'unusable...', 4);
            }
        }
    }

       /**
     * Verifies the existence and optionally the writability of a file based on the provided configuration key.
     *
     * @param string $configKey The key used to retrieve the file path from the configuration.
     * @param bool $isWritable Optional. If true, checks if the file is writable. Default is false.
     *
     * @return bool Returns true if the file exists (and is writable if $isWritable is true), otherwise false.
     */
    protected function verifyFile(string $configKey, bool $isWritable = false): bool {
        if (!$this->$configKey->isValid()) {
            $this->showError($configKey, 'not found...', 1);
            return false;
        }

        if (!$this->$configKey->isReadable()) {
            $this->showError($configKey, 'not readable...', 2);
            return false;
        }

        if ($isWritable && !$this->$configKey->isWritable()) {
            $this->showError($configKey, 'not writable...', 3);
            return false;
        }

        return true;
    }

    /**
     * Patches the VSCodium configuration or files.
     *
     * This method is responsible for applying necessary updates or modifications
     * to the VSCodium settings or files based on the provided configuration.
     *
     * @return void
     */
    public function patch(): void {
        $json = $this->config->file->vscode->read();
        $vscode = Json::decode($json);

        $json = $this->config->file->vscodium->read();
        $vscodium = Json::decode($json);

        if (count($vscodium[$this->config->gallery->keyName]) != count($vscode[$this->config->gallery->keyName])) {
            if (Cli::confirm('Do you want to update', true)) {
                $this->config->message->green->line('Updating...');

                $vscodium[$this->config->gallery->keyName] = $vscode[$this->config->gallery->keyName];
                $json = Json::encode($vscodium);
                $this->config->file->vscodium->write($json);
                $this->config->message->green->line('Update done.');
            }
        } else {
            Cli::line('No need to update...');
        }
    }
}

$vscodiumPatcher = new VSCodiumPatcher([
    'file' => [
        // 'vscode' => 'bob',
    ]
]);

$vscodiumPatcher->patch();

$red = new Pencil(Colour::Red);
$blue = new Pencil(Colour::Blue, style: Style::Bold);
$reset = Pencil::reset();

$config = new Options([
    'file' => [
        'vscode' => 'C:\Users\Philip\AppData\Local\Programs\Microsoft VS Code\resources\app\product.json',
        'vscodium' => 'C:\Program Files\VSCodium\resources\app\product.json',
    ],
    'gallery' => [
        'keyName' => 'extensionsGallery',
    ],
], false);

$vscode = new \Inane\File\File($config->file->vscode);
if (!$vscode->isValid()) {
    $red->line('Error:' . $$blue . ' VSCode' . $reset . ' not found...');
    exit;
}
if (!$vscode->isReadable()) {
    $red->line('Error:' . $$blue . ' VSCode' . $reset . ' not readable...');
    exit;
}

$json = $vscode->read();
$b = \Inane\Stdlib\Json::decode($json);

$vscodium = new \Inane\File\File($config->file->vscodium);
if (!$vscodium->isValid()) {
    $red->line('Error:' . $blue . ' VSCodium' . $reset . ' not found...');
    exit;
}
if (!$vscodium->isWritable()) {
    $red->line('Error:' . $reset . ' Update needed but ' . $blue . 'VSCodium' . $reset . ' not writable...');
    exit;
}
$json = $vscodium->read();
$p = \Inane\Stdlib\Json::decode($json);

if (count($p[$config->gallery->keyName]) != count($b[$config->gallery->keyName])) {
    if (!$vscodium->isWritable()) {
        $red->line('Error:' . $reset . ' Update needed but ' . $blue . 'VSCodium' . $reset . ' not writable...');
        exit;
    }
    if (Cli::confirm('Do you want to update', true)) {
        Cli::line('Updating...');
        $p[$config->gallery->keyName] = $b[$config->gallery->keyName];
        $json = \Inane\Stdlib\Json::encode($p);
        $vscodium->write($json);
    }
} else {
    Cli::line('No need to update...');
}
