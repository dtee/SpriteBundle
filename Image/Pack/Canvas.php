<?php
namespace Dtc\SpriteBundle\Image\Pack;

class Canvas {
    protected $left;
    protected $right;
    public $rectangle;
    protected $isFilled = false;

    public function __construct($width = null, $height = null)
    {
        if ($width) {
            $this->rectangle = new Rectangle($width, $height);
        }
    }

    public function insert(Rectangle $rectangle) {
        $canvas = $this->insertRectange($rectangle);

        if ($canvas)
        {
            $position = $canvas->rectangle;
            $rectangle->x = $position->x;
            $rectangle->y = $position->y;

            return $rectangle;
        }
    }

    protected function insertRectange(Rectangle $rectangle) {
        if ($this->left) {
            if ($canvas = $this->left->insertRectange($rectangle))
                return $canvas;
            else
                return $this->right->insertRectange($rectangle);
        }

        if ($this->isFilled) {
            return null;
        }

        if (!$rectangle->isFitIn($this->rectangle)) {
            return null;
        }

        if ($rectangle->isSameSize($this->rectangle)) {
            $this->isFilled = true;
            return $this;
        }

        $this->left = new Canvas();
        $this->right = new Canvas();

        $widthDiff = $this->rectangle->width - $rectangle->width;
        $heighDiff = $this->rectangle->height - $rectangle->height;

        $me = $this->rectangle;
        if ($widthDiff > $heighDiff) {
            $this->left->rectangle = clone($me);
            $this->left->rectangle->width = $rectangle->width;

            $this->right->rectangle = clone($me);
            $this->right->rectangle->x = $me->x + $rectangle->width;
            $this->right->rectangle->width = $widthDiff;
        }
        else {
            $this->left->rectangle = clone($me);
            $this->left->rectangle->height = $rectangle->height;

            $this->right->rectangle = clone($me);
            $this->right->rectangle->y = $me->y + $rectangle->height;
            $this->right->rectangle->height = $heighDiff;
        }

        return $this->left->insertRectange($rectangle);
    }
}
