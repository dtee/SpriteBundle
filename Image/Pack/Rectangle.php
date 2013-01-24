<?php
namespace Dtc\SpriteBundle\Image\Pack;

class Rectangle {
    public $width;
    public $height;
    public $x;
    public $y;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
        $this->x = 0;
        $this->y = 0;
    }

    public function isFitIn(Rectangle $outer) {
        return $outer->width >= $this->width && $outer->height >= $this->height;
    }

    public function isSameSize(Rectangle $outer) {
        return $outer->width == $this->width && $outer->height == $this->height;
    }

    public function __toString() {
        return printf("({$this->x}, {$this->y}) - ({$this->width}, {$this->height})");
    }

    public function toArray() {
        return array(
                'height' => $this->height,
                'width' => $this->width,
                'offset_x' => $this->x,
                'offset_y' => $this->y
        );
    }
}
