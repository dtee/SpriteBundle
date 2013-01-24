<?php
namespace Dtc\SpriteBundle\Image;

use Dtc\SpriteBundle\Image\Pack\ImageRectangle;
use Dtc\SpriteBundle\Image\Pack\Canvas;

use Symfony\Component\Finder\Finder;
use Imagick;

class ImageSprite
{
    protected $finder;
    protected $images = array();
    protected $gutter;
    protected $sprite;
    protected $width;
    protected $height;

    public function __construct($path, $gutter = 10) {
        $this->gutter = $gutter;

        // Set up finder based on path
        $finder = new Finder();
        $finder->files()->name('*.png');
        if (is_array($path))
        {
            foreach ($path as $p) {
                $finder->in($p);
            }
        }
        else
        {
            $finder->in($path);
        }

        $this->finder = $finder;
    }

    public function getFiles() {
        return $this->finder;
    }

    public function getImages($throwsException = false) {
        $totalWidth = 0;
        $totalHeight = 0;
        $maxWidth = 0;
        if (!$this->images) {
            foreach ($this->finder as $file) {
                $realPath = $file->getRealPath();
                $image = new Imagick();
                $image->readImage($realPath);

                $rectangle = new ImageRectangle($image, $realPath, $this->gutter);
                $totalWidth += $rectangle->width;
                $totalHeight += $rectangle->height;
                $maxWidth = max($maxWidth, $rectangle->width);

                $key = $rectangle->getKey();
                if (isset($this->images[$key])) {
                    $path1 = $this->images[$key]->getPath();
                    $path2 = $rectangle->getPath();

                    if ($throwsException)
                    {
                        throw new \Exception("Duplate key found: {$path1} {$path2}");
                    }
                    else
                    {
                        continue;
                    }
                }

                $this->images[$key] = $rectangle;
            }
        }

        $totalImages = count($this->images);
        $idealWidth = (int) (($totalWidth / $totalImages) * sqrt($totalImages));
        $this->width = max($idealWidth, $maxWidth);
        $this->height = $totalHeight;

        return $this->images;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getSprite() {
        $images = $this->getImages();
        $width = $this->getWidth();
        $height = $this->getHeight();

        $canvas = new Canvas($width, $height);
        $sprite = new Imagick();
        $sprite->newImage($width, $height, "none");

        $maxY = 0;
        foreach ($images as $path => $image) {
            $image = $canvas->insert($image);

            $maxY = max(($image->y + $image->height), $maxY);
            if (!$image) {
                throw new \Exception("Canvas can't fit {$path}");
            }
            else {
                $sprite->compositeImage(
                    $image->getImage(),
                    Imagick::COMPOSITE_DEFAULT,
                    $image->x,
                    $image->y);
            }
        }

        $sprite->cropImage($width, $maxY, 0, 0);
        $sprite->setImageFormat('png');

        return $sprite;
    }
}
