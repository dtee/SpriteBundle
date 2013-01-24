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
        $this->configs[$key] = $config;
    }

    /**
     * @param string $key
     *
     * @return ImageSprite
     */
    public function getImageSprite($key) {
        if (!isset($this->imageSprites[$key])) {
            $config = $this->configs[$key];
            $path = $config['path'];
            $gutter = isset($config['gutter']) ? $config['gutter'] : null;
            $this->imageSprites[$key] = new ImageSprite($path, $gutter);
        }

        return $this->imageSprites[$key];
    }

    public function get($key) {
        return $this->getImageSprite($key);
    }

    public function getConfig($key) {
        if (isset($this->configs[$key])) {
            return $this->configs[$key];
        }
    }

    public function getAll() {
        $sprites = array();
        foreach (array_keys($this->configs) as $key) {
            $sprites[$key] = $this->getImageSprite($key);
        }

        return $sprites;
    }
}
