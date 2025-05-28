<?php

/**
 * Develop
 *
 * Tinkering development environment. Used to play with or try out stuff.
 *
 * PHP version 8.4
 *
 * @author Philip Michael Raab<philip@cathedral.co.za>
 * @package Develop\Tinker
 *
 * @license UNLICENSE
 * @license https://unlicense.org/UNLICENSE UNLICENSE
 *
 * @version $Id$
 * $Date$
 */

declare(strict_types=1);

namespace Dev\Strip;

use Dev\Config\DefaultConfigTrait;
use Inane\Cache\RemoteFileCache;
use Inane\Dumper\Silence;
use Inane\Cli\{
    Pencil\Colour,
    Pencil\Style,
    Cli,
    Pencil
};
use Inane\File\{
    File,
    Path
};
use Inane\Stdlib\{
    Json,
    Options
};

use function basename;
use function count;
use function end;
use function explode;
use function md5;
use function str_pad;
use function str_replace;
use function str_starts_with;
use function strlen;
use function strval;
use function uniqid;

use const STR_PAD_LEFT;

/**
 * ImageStripper
 *
 * Strips images from a given URL and downloads them to a specified directory.
 *
 * write clipboard to config file:
 * `cb > config/autoload/image-stripper-data.local.php`
 *
 * run stripper:
 * `php public/index.php -m 5`
 *
 * @package ImageStripper
 */
class ImageStripper {
    use DefaultConfigTrait;

    /**
     * The current version of the application.
     *
     * @var string
     */
    public const string VERSION = '0.1.0';

    /**
     * The default configuration for the ImageStripper class.
     *
     * @var array $defaultConfig An associative array containing default settings.
     */
    protected array $defaultConfig {
        get => [
            'fileObjects' => false,
            'path' => [
                'baseDownload' => 'C:/',
                /**
                 * How to process the rather common `image-1` directory.
                 *
                 * - increment: `image-2`, `image-3`, etc.
                 * - md5: `image-1` is replaced with a hash of the links to try reduce duplicate downloads.
                 * - uniqid: `image-1` number is replaced with a unique ID.
                 */
                'image1Handler' => 'md5',
            ],
            'format' => [
                'file' => new Pencil(Colour::Blue, style: Style::Bold),
                'blue' => new Pencil(Colour::Blue),
                'progress' => new Pencil(Colour::Green),
                'title' => new Pencil(Colour::Purple),
                'error' => new Pencil(Colour::Red),
                'white' => new Pencil(Colour::White),
                'reset' => Pencil::reset(),
            ],
            'images' => [],
        ];
    }

    protected RemoteFileCache $rfc;

    /**
     * Constructor for the Stripper class.
     *
     * @param array|Options|null $config Configuration options for the Stripper instance.
     */
    #[Silence(true)]
    public function __construct(array|Options|null $config = null) {
        $this->configure($config);

        dd($this->config, 'Parsed Config');

        $this->config->format->title->line('Image Stripper ' . $this->config->format->white . '(' . $this->config->format->blue . static::VERSION . $this->config->format->white . ')');

        $this->bootstrap();
    }

    protected function bootstrap(): void {
        // 1 week = 604800
        // 4 week = 2419200
        // 52 week = 31449600
        $this->rfc = new RemoteFileCache('cache-storage', 31449600);
        $this->rfc;
    }

    /**
     * Displays an error message for a specific file.
     *
     * @param string $message The error message to be displayed.
     * @param int    $exit When greater than 0 it tells the application is ended.
     *
     * @return void
     */
    protected function showError(string $message, int $exit = 0): void {
        Cli::err("{$this->config->format->error}Error:{$this->config->format->reset} $message");
        if ($exit > 0) exit($exit);
    }

    /**
     * Verify links and download directories.
     *
     * Checks for links and tries half heartedly to keep from downloading duplicates.
     *
     * @param array|string[]    $links  An array of links to verify the directory structure against.
     * @param string|null       $dir    An optional directory path to use as the base for verification.
     *
     * @return Path Returns a Path object representing the verified directory.
     */
    protected function veryfyInAndOutputs(array $links, ?string $dir = null): Path {
        if (!$dir) $dir = uniqid(date('Y-m-d_H-i-s_'), true);

        // Here I fiddle the directory name a bit if it is `image-1` which pops up far to often
        $wasImage = false;
        if ($dir == 'image') {
            $wasImage = true;
            $img_dirs = new Path($this->config->path->download)->getDirectories('image-*');

            $dir = match ($this->config->path->image1Handler) {
                'increment' => 'image-' . (count($img_dirs) + 1),
                'md5' => md5(Json::encode($links)),
                'uniqid' => uniqid('images-'),
                default => $dir,
            };
        }

        $path = new Path($this->config->path->download)->getChildPath($dir);

        if ($path->isValid() && $wasImage) {
            $this->showError("Special MD5 Directory already exists which may indicate that the files have already been downloaded: $path", 10);
        } elseif ($path->isValid()) {
            $this->showError("Directory already exists which may indicate that the files have already been downloaded: $path", 10);
        }

        if (!$path->isDir()) $path->makePath(permissions: 0777);

        return $path;
    }

    /**
     * Downloads images from the provided list of links and saves them to the specified directory.
     *
     * $dir is created in the base download directory.
     *
     * @param array $links An array of image URLs to download.
     * @param string|null $dir The directory where the images will be saved.
     *                         If null, a default directory will be used.
     *
     * @return array|File[] downloaded files
     */
    protected function downloadImages(array $links, ?string $dir = null): array {
        $path = $this->veryfyInAndOutputs($links, $dir);

        Cli::line("Downloading images to: $path");

        $total = count($links);
        $msg = "{$this->config->format->file}Downloading{$this->config->format->reset} a gallary of {$this->config->format->progress}$total{$this->config->format->reset} images:";
        $notify = new \Inane\Cli\Progress\Bar($msg, $total);
        $notify->display();

        $files = [];
        $fileObjects = [];

        foreach ($links as $index => $link) {
            $file_name = end(explode('/', $link));

            // check if its one of those pescy `image-` files and replace it with the directory name
            if (str_starts_with($file_name, 'image-')) {
                $file_name = str_replace('image', $path->getBasename(), $file_name);
            }

            $current = str_pad(strval($index + 1), strlen("$total"), '0', STR_PAD_LEFT);

            $msg = $this->config->format->file . $file_name . $this->config->format->reset . " [" . $this->config->format->progress . "$current{$this->config->format->reset} of $total]:";

            $file = $path->getFile($file_name);
            try {
                $file->write(contents: $this->rfc->get($link), cacheContents: false);
            } catch (\Throwable $th) {
                echo $th->getMessage();
                exit;
            }

            $files[] = $file->getPathname();
            $fileObjects[] = $file;

            $notify->tick(1, $msg);
        }

        $notify->finish();

        return $this->config->fileObjects ? $fileObjects : $files;
    }

    /**
     * Strips imgages from the given URL.
     *
     * @param string $url The URL to be processed.
     * @param string|null $dir The directory where the images will be saved.
     *                         If null, a default directory will be used.
     *
     * @return array|File[] downloaded files
     */
    public function strip(string $url, ?string $dir = null): array {
        $links = [];

        if (!empty($this->config->images)) {
            $links = $this->config->images->toArray();
        }

        if (empty($links)) $this->showError("No images found.", 5);

        if (!$dir) {
            $parts = explode('/', $links[0]);
            $dir = str_replace('-1', '', basename(array_pop($parts), '.jpg'));
            $dir = array_pop($parts) . '-' . $dir;
        }

        // if (!$dir) $dir = str_replace('-1', '', basename(end(explode('/', $links[0])), '.jpg'));;
        return $this->downloadImages($links, $dir);
    }
}
