<?php
namespace Dtc\SpriteBundle\Generator;

use Dtc\SpriteBundle\Image\ImageSprite;

class SpriteGenerator
{
    protected $spriteName;
    protected $imageSprite;
    protected $path;
    protected $algorithm;

    public function __construct($path = null) {
        $this->setPath($path);
        $this->algorithm = 'crc32';
    }

    /**
     * If algo is not set, it will use file size + file mod time
     *
     * @param unknown_type $algo algorithm for hash_file
     */
    public function getHash() {
        $hash = array();
        foreach ($this->imageSprite->getFiles() as $file) {
            $realPath = $file->getRealPath();

            if ($this->algorithm) {
                $hash[] = hash_file($this->algorithm, $realPath);
            }
            else {
                $hash[] = filemtime($realPath) . filesize($realPath);
            }
        }

        if ($this->algorithm) {
            return hash($this->algorithm, implode($hash));
        }

        return hash('crc32', implode($hash));
    }

    public function getImageFilename($includePath = true) {
        return $this->getFilename($includePath, 'png');
    }

    public function getCssFilename($includePath = true) {
        return $this->getFilename($includePath, 'css');
    }

    protected function getFilename($includePath, $type) {
        $filename = "{$this->spriteName}-{$this->getHash()}.{$type}";
        if ($includePath) {
            return "{$this->path}/{$filename}";
        }

        return $filename;
    }

    public function generate() {
        $this->generateSprite();
        $this->generateCss();
    }

    public function generateSprite() {
        $sprite =  $this->imageSprite->getSprite();
        $sprite->writeImage("{$this->getImageFilename()}");
    }

    public function generateCss() {
        file_put_contents($this->getCssFilename(), $this->getCss());
    }

    public function getCss() {
        $css = array();
        $css[] = ".{$this->spriteName} { background: transparent url('{$this->getImageFilename(false)}') no-repeat; }";
        foreach ($this->imageSprite->getImages() as $className => $image) {
            $css[] = ".{$this->spriteName}.{$className} {
                    width: {$image->getImageWidth()}px;
                    height: {$image->getImageHeight()}px;
                    background-position:-{$image->x}px -{$image->y}px;
                }";
        }

        return implode("\n", $css);
    }

    /**
     * set image sprite and the name of the sprite
     *
     * @param unknown_type $spriteName
     * @param unknown_type $imageSprite
     */
    public function setImageSprite($spriteName, ImageSprite $imageSprite) {
        $this->spriteName = $spriteName;
        $this->imageSprite = $imageSprite;
    }

    /**
     * which directory to generate the files
     *
     * @param unknown_type $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return the $algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param NULL $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }
}
