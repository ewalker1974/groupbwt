<?php

namespace App\Service\Batch\Component;

use App\Exception\BadParamException;
use App\Exception\BadTransactionFormat;
use App\Service\Batch\Reader;
use App\ValueObject\InputArgument;
use App\ValueObject\SampleTransactionBuilder;
use App\ValueObject\Transaction;

class FileTransactionReader implements Reader
{
    private const string FILE_ARG = 'file';

    private mixed $fileHandler;

    #[\Override]
    public function hasMoreItems(): bool
    {
        return null !== $this->fileHandler && !feof($this->fileHandler);
    }

    /**
     * @throws BadTransactionFormat
     * @throws \JsonException
     */
    #[\Override]
    public function readNext(): Transaction
    {
        $data = fgets($this->fileHandler);
        $rawTransaction = json_decode(trim($data), true, 512, JSON_THROW_ON_ERROR);

        $bin = $rawTransaction['bin'] ?? throw new BadTransactionFormat('Missing bin');
        $amount = (float) $rawTransaction['amount'] ?? throw new BadTransactionFormat('Missing amount');
        $currency = $rawTransaction['currency'] ?? throw new BadTransactionFormat('Missing currency');

        return (new SampleTransactionBuilder())
                ->setCard($bin)
                ->setAmount($amount)
                ->setCurrency($currency)
                ->build();
    }

    /**
     * @throws BadParamException
     */
    #[\Override]
    public function open(InputArgument ...$inputArguments): void
    {
        $fileName = $this->getFileName($inputArguments);
        $this->fileHandler = fopen($fileName, 'r');
    }

    #[\Override]
    public function close(): void
    {
        if (null !== $this->fileHandler) {
            fclose($this->fileHandler);
        }
    }

    /**
     * @throws BadParamException
     */
    private function getFileName(array $inputArguments): string
    {
        $args = array_filter($inputArguments, static fn (InputArgument $arg): bool => self::FILE_ARG === $arg->getName());
        if ([] === $args) {
            throw new BadParamException(BadParamException::PARAM_NOT_FOUND, self::FILE_ARG);
        }

        return (string) $inputArguments[array_key_first($inputArguments)]->getValue();
    }
}
