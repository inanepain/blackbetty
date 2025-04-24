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

use Dev\App\DefaultConfigTrait;
use Inane\Stdlib\Options;
use Inane\Cli\{
    Pencil\Colour,
    Pencil\Style,
    Cli,
    Colors,
    Pencil
};
use Inane\File\{
    File,
    Path
};

use function basename;
use function count;
use function end;
use function explode;
use function str_pad;
use function strlen;
use function strval;
use function uniqid;

use const STR_PAD_LEFT;

/**
 * ImageStripper
 *
 * Strips images from a given URL and downloads them to a specified directory.
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
        ];
    }

    /**
     * Constructor for the Stripper class.
     *
     * @param array|Options|null $config Configuration options for the Stripper instance.
     */
    public function __construct(array|Options|null $config = null) {
        $this->configure($config);

        $this->config->format->title->line('Image Stripper ' . $this->config->format->white . '(' . $this->config->format->blue . static::VERSION . $this->config->format->white . ')');
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
        if (!$dir) $dir = uniqid(date('Y-m-d_H-i-s_'), true);
        $path = new Path($this->config->path->download)->getChildPath($dir);

        if (!$path->isDir()) $path->makePath(permissions: 0777);

        Cli::line("Downloading images to: $path");

        $total = count($links);
        $notify = new \Inane\Cli\Progress\Bar("Downloading $total images... ", $total);
        $notify->display();

        $files = [];
        $fileObjects = [];

        foreach ($links as $index => $link) {
            $file_name = end(explode('/', $link));
            $current = str_pad(strval($index + 1), strlen("$total"), '0', STR_PAD_LEFT);

            $msg = $this->config->format->file . $file_name . $this->config->format->reset . " [" . $this->config->format->progress . "$current{$this->config->format->reset} of $total]:";

            $file = $path->getFile($file_name);
            $file->write(contents: file_get_contents($link), cacheContents: false);

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
        /**
         * Embeds a JavaScript block into the PHP code using the heredoc syntax.
         *
         * This block of code initializes a JavaScript variable or script content
         * within the PHP file. Ensure that the JavaScript code is properly formatted
         * and escaped if necessary to avoid syntax errors.
         */
        $js = <<<JS
links = [];
for (let name of Array.from(document.querySelectorAll('img'))) {
    if (name.src.includes('large')) {
        links.push(name.src);
    }
}
console.log("['" + links.join("', '") + "']");
JS;

        $links = [];
        $links = ['https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-1.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-2.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-3.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-4.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-5.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-6.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-7.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-8.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-9.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-10.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-11.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-12.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-13.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-14.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-15.jpg', 'https://i1.fuskator.com/large/aMqKNCdjGma/Shaved-Teen-Babe-Anastasia-Petrova-from-Met-Art-Wearing-White-Lingerie-16.jpg'];

        if (empty($links)) $this->showError("No images found.", 5);

        if (!$dir) $dir = basename(end(explode('/', $links[0])), '.jpg');
        return $this->downloadImages($links, $dir);
    }
}
