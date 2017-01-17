<?php

namespace Fuguevit\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CodeLineCounter extends Command
{
    protected function configure()
    {
        $this->setName('count-line')
            ->setDescription('Count code lines.')
            ->addOption('suffix', null, InputOption::VALUE_REQUIRED, 'Specify file suffix.')
            ->addOption('exclude', null, InputOption::VALUE_REQUIRED, 'Specify exclude directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileFoundCommand = "find . -type f -execdir cat {} \;";
        $wordCountCommand = 'wc -l';

        // Add -name for find.
        if ($suffix = $input->getOption('suffix')) {
            $nameOption = "-name '*.$suffix'";
            $fileFoundCommand = $this->str_replace_first('.', '. '.$nameOption, $fileFoundCommand);
        }

        // Add -exclude for filter directory.
        if ($exclude = $input->getOption('exclude')) {
            $excludeOption = "-path './$exclude' -prune -o";
            $fileFoundCommand = $this->str_replace_first('.', '. '.$excludeOption, $fileFoundCommand);
        }

        $command = $fileFoundCommand.' | '.$wordCountCommand;
        $result = exec($command);

        $output->writeln($result);
    }

    protected function str_replace_first($from, $to, $subject)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $subject, 1);
    }
}
