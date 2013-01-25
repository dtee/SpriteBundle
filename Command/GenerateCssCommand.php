<?php
namespace Dtc\SpriteBundle\Command;

use Dtc\SpriteBundle\View\Css;
use Dtc\SpriteBundle\Image\ImageSprite;

use Asc\PlatformBundle\Documents\Profile\UserProfile;
use Asc\PlatformBundle\Documents\UserAuth;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCssCommand
    extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dtc:sprite:generate_css')
            ->addArgument('destination', InputArgument::REQUIRED, 'Destination Folder', null)
            ->setDescription('Generate Sprite css files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spriteManager = $this->getContainer()->get('dtc_sprite.manager');
        $spriteImages = $spriteManager->getAll();

        $path = $input->getArgument('destination');

        if (!is_dir($path)) {
            throw new \Exception("Directory `{$path}` doesn't exists");
        }

        foreach ($spriteImages as $name => $spriteImage) {
            $filename = "{$path}/{$name}.css";
            $css = Css::GetCss($name, $sprite);
            file_put_contents($filename, $css);
            $output->writeln("{$filename}");
        }

        $output->writeln("Finished!");
    }
}
