<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Console\Tests\Stub;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yiisoft\Yii\Console\Application;
use Yiisoft\Yii\Console\ExitCode;

#[AsCommand(
    name: 'stub',
    description: 'Stub command tests'
)]
final class StubCommand extends Command
{
    public function configure(): void
    {
        $this->addOption('styled', 's', InputOption::VALUE_OPTIONAL);
    }

    public function __construct(private Application $application)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->application->start();

        $exception = new ConsoleException();

        $this->application->renderThrowable(
            $exception,
            $input->getOption('styled') ? new SymfonyStyle($input, $output) : $output
        );

        $this->application->shutdown(ExitCode::OK);

        return ExitCode::OK;
    }
}
