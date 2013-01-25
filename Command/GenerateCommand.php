<?php
namespace Dtc\SpriteBundle\Command;

use Dtc\SpriteBundle\Image\ImageSprite;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand
    extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dtc:sprite:generate')
            ->addArgument('destination', InputArgument::OPTIONAL, 'Destination Folder', null)
            ->setDescription('Generate Sprite css and images files to the destination folder')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = $this->getContainer()->get('dtc_sprite.generator');
        $spriteManager = $this->getContainer()->get('dtc_sprite.manager');
        $spriteImages = $spriteManager->getAll();

        $path = $input->getArgument('destination');
        if ($path) {
            $generator->setPath($path);
        }
        else {
            $path = $generator->getPath();
        }

        if (!is_dir($path)) {
            throw new \Exception("Directory doesn't exists");
        }

        foreach ($spriteImages as $name => $spriteImage) {
            $generator->setImageSprite($name, $spriteImage);
            $generator->generate();

            $output->writeln("created: {$generator->getCssFilename()}");
            $output->writeln("created: {$generator->getImageFilename()}");
        }

        $output->writeln("Finished!");
    }
}
