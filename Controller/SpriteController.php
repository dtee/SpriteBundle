<?php
namespace Dtc\SpriteBundle\Controller;

use Dtc\SpriteBundle\Image\ImageSprite;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SpriteController
    extends Controller
{
    /**
     * Summary stats
     *
     * @Route("/image/{name}.{type}")
     */
    public function imageAction($name, $type) {

    }

    /**
     * Generate the css
     *
     * @Route("/css/{name}")
     */
    public function cssAction($name) {
        $path = '/service/qvc/web/bundles/odlshop/img/sprites/base';
        $spriteImage = new ImageSprite($path);
        $files = $spriteImage->getFiles();
        ve($files);
    }
}
