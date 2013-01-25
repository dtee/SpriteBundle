<?php
namespace Dtc\SpriteBundle\View;

use Dtc\SpriteBundle\Image\ImageSprite;

class Css {
    public static function GetCss($name, ImageSprite $sprite) {
        $css = array();
        foreach ($sprite->getImages() as $className => $image) {
            $css[] = ".{$name}.{$className} {
                    width: {$image->getImageWidth()}px;
                    height: {$image->getImageHeight()}px;
                    background-position:-{$image->x}px -{$image->y}px;
                }";
        }

        return implode("\n", $css);
    }
}
