<?php

namespace App\Command;

use App\Service\Batch\Batch;
use App\Service\Batch\BatchInputArguments;
use App\Service\Batch\Component\ArrayCommissionWriter;
use App\ValueObject\CommissionFee;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:commission', description: 'Get commission fee')]
class CalcCommissionFeeCommand extends Command
{
    public function __construct(
        private readonly Batch $sampleConverter,
        private readonly BatchInputArguments $args,
        private readonly ArrayCommissionWriter $results,
    ) {
        parent::__construct();
    }

    #[\Override]
    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Transactions file');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $this->args->setArgument('file', $file);

        $this->sampleConverter->run();

        $output->write(array_map(static fn (CommissionFee $fee): string => $fee->getValueInString(), $this->results->getCommissions()), true);

        return Command::SUCCESS;
    }
}
