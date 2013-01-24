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
        ->addArgument('desination', InputArgument::OPTIONAL, 'Destination Folder', null)
        ->addArgument('type', InputArgument::OPTIONAL, 'Image type - defaults (png)', 'png')
        ->setDescription('Generate Sprite image files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Todo
    }
}
