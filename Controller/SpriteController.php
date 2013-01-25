<?php
namespace Dtc\SpriteBundle\Controller;

use Dtc\SpriteBundle\Image\ImageSprite;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Useful for debugging - do not use for production
 */
class SpriteController
    extends Controller
{
    /**
     * Summary stats
     *
     * @Route("/")
     * @Route("/{name}", name="dtc_sprite_sprite_view")
     * @Template()
     */
    public function indexAction($name = null) {
        $params = array();
        $spriteManager = $this->get('dtc_sprite.manager');
        $keys = $spriteManager->getSpriteKeys();

        if (!$name) {
            $name = current($keys);
        }

        $spriteImage = $spriteManager->get($name);

        $hash = array();
        foreach ($spriteImage->getImages() as $image)
        {
            $key = $image->getKey();
            $hash[$key] = $image->toArray();
        }

        $params['sprites'] = $keys;
        $params['name'] = $name;
        $params['sprite_hash'] = $hash;

        return $params;
    }

    /**
     * Summary stats
     *
     * @Route("/image/{name}.png")
     */
    public function imageAction($name) {
        $spriteManager = $this->get('dtc_sprite.manager');
        $spriteImage = $spriteManager->get($name);
        $sprite = $spriteImage->getSprite();
        $headers = array('Content-Type' => 'image/png');
        return new Response($sprite->getImageBlob(), 200, $headers);
    }

    /**
     * Generate the css
     *
     * @Route("/css/{name}")
     */
    public function cssAction($name) {
        $css = array();
        $spriteManager = $this->get('dtc_sprite.manager');
        $spriteImage = $spriteManager->get($name);

        foreach ($spriteImage->getImages() as $className => $image) {
            $css[] = ".{$name}.{$className} {
            display: inline-block;
            width: {$image->getImageWidth()}px;
            height: {$image->getImageHeight()}px;
            background-position:-{$image->x}px -{$image->y}px;
            }";
        }

        return new Response(implode("\n", $css));
    }
}
