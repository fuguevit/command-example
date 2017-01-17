<?php

namespace Fuguevit\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CodeLineCounter extends Command
{
    protected function configure()
    {
        $this->setName('count-line')
            ->setDescription('Count code lines.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = exec("find . -type f -execdir cat {} \;| wc -l ");
        
        $output->writeln($result);
    }

}