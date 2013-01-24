<?php
namespace Dtc\SpriteBundle\Image\Pack;

use Imagick;

class ImageRectangle
    extends Rectangle
{
    protected $image;
    protected $path;
    protected $key;
    protected $imageWidth;
    protected $imageHeight;

    public function __construct(Imagick $image, $path, $gutter = 5) {
        $this->image = $image;
        $this->path = $path;

        $this->imageWidth = $image->getImageWidth();
        $this->imageHeight = $image->getImageHeight();

        $width = $image->getImageWidth() + $gutter;
        $height = $image->getImageHeight() + $gutter;

        parent::__construct($width, $height);
    }

    public function getPath() {
        return $this->path;
    }

    public function getImageWidth() {
        return $this->imageWidth;
    }

    public function getImageHeight() {
        return $this->imageHeight;
    }

    /**
     * Convert to a valid css name
     */
    public function getKey() {
        if (!$this->key) {
            $pathInfo = pathinfo($this->path);
            $this->key = $pathInfo['filename'];
        }

        return $this->key;
    }

    public function getImage() {
        return $this->image;
    }
}
