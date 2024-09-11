<?php

namespace App\Service\Batch;

use Psr\Log\LoggerInterface;

readonly class Batch
{
    public function __construct(
        private Reader $reader,
        private Processor $processor,
        private Writer $writer,
        private BatchInputArguments $args,
        private LoggerInterface $logger,
    ) {
    }

    public function run(): void
    {
        $this->reader->open(...$this->args->getArguments());
        $this->writer->open();
        while ($this->reader->hasMoreItems()) {
            try {
                $transaction = $this->reader->readNext();
                $fee = $this->processor->getCommission($transaction);
                $this->writer->write($fee);
            } catch (\Exception $e) {
                $this->logger->error('Cannot parse transaction: '.$e->getMessage(), $e->getTrace());
            }
        }

        $this->writer->close();
        $this->reader->close();
    }
}
