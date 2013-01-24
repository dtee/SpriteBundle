<?php
namespace Dtc\SpriteBundle\Command;

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
        ->addArgument('desination', InputArgument::OPTIONAL, 'Destination Folder', null)
        ->setDescription('Generate Sprite css files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Todo
    }
}
