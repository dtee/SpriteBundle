<?php
namespace Dtc\SpriteBundle\Controller;

use Dtc\SpriteBundle\View\Css;
use Dtc\SpriteBundle\Image\ImageSprite;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/view/{name}", name="dtc_sprite_sprite_view")
     * @Template()
     */
    public function indexAction($name = null) {
        $params = array();
        $generator = $this->get('dtc_sprite.generator');
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

        $generator->setImageSprite($name, $spriteImage);

        $params['sprites'] = $keys;
        $params['name'] = $name;
        $params['sprite_hash'] = $hash;

        return $params;
    }

    /**
     * Serve Sprite file
     *
     * @Route("/{name}-{hash}.{type}")
     */
    public function fileAction($name, $hash, $type) {
        $response = new Response();

//         $expireDate = new \DateTime();
//         $expireDate->add(new \DateInterval('P10Y'));
//         $response->setExpires($expireDate);

        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(600);
        $response->setETag("{$hash}-{$type}");

        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }

        $generator = $this->get('dtc_sprite.generator');
        $spriteManager = $this->get('dtc_sprite.manager');

        $spriteImage = $spriteManager->get($name);
        $generator->setImageSprite($name, $spriteImage);

        if ($type == 'css') {
            $css = $generator->getCss();
            $response->headers->set('Content-Type', 'text/css');
            $response->setContent($css);
        }
        else {
            $sprite = $spriteImage->getSprite();
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent($sprite->getImageBlob());
        }

        return $response;
    }

    /**
     * Generate Actual image url
     *
     * @Route("/image/{name}.png")
     */
    public function imageAction($name) {
        return $this->redirectSprite($name, 'png');
    }

    /**
     * Generate Actual css url
     *
     * @Route("/css/{name}.css")
     */
    public function cssAction($name) {
        return $this->redirectSprite($name, 'css');
    }

    protected function redirectSprite($name, $type) {
        $generator = $this->get('dtc_sprite.generator');
        $spriteManager = $this->get('dtc_sprite.manager');

        $spriteImage = $spriteManager->get($name);
        $generator->setImageSprite($name, $spriteImage);

        $params = array(
                'name' => $name,
                'hash' => $generator->getHash(),
                'type' => 'png'
        );

        $url = $this->generateUrl('dtc_sprite_sprite_file', $params);
        return $this->redirect($url);
    }
}
