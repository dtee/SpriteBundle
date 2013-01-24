<?php
namespace Dtc\SpriteBundle\Command;

use Asc\PlatformBundle\Documents\Profile\UserProfile;
use Asc\PlatformBundle\Documents\UserAuth;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateImageCommand
    extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dtc:sprite:generate_image')
            ->addArgument('destination', InputArgument::REQUIRED, 'Destination Folder', null)
            //->addArgument('type', InputArgument::OPTIONAL, 'Image type - defaults (png)', 'png')
            ->setDescription('Generate Sprite image files: {name}-{timestamp}.png')
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

        foreach ($spriteImages as $filename => $spriteImage) {
            $sprite =  $spriteImage->getSprite();
            $time = $spriteImage->getMaxModifiedTime();
            $filename = "{$path}/{$filename}-{$time}.png";
            $sprite->writeImage($filename);
            $output->writeln("{$filename}");
        }

        $output->writeln("Finished!");
    }
}
