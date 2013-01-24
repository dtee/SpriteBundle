<?php
namespace Dtc\SpriteBundle\Image;

class ImageSpriteManager
{
    protected $configs;
    protected $imageSprites;

    public function __construct() {
        $this->configs = array();
        $this->imageSprites = array();
    }

    public function addSpriteConfig($key, $config) {
        $this->key = $config;
    }

    public function getImageSprite($key) {
        if (!isset($this->imageSprites[$key])) {
            $path = $this->configs['folder'];
            $this->imageSprites[$key] = new ImageSprite($path);
        }

        return $this->imageSprites[$key];
    }
}
