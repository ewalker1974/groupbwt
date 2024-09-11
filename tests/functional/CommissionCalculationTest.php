<?php

namespace App\Tests\Functional;

use App\Service\Batch\Batch;
use App\Service\Batch\Component\ArrayCommissionWriter;
use App\Service\Batch\Reader;
use App\Service\CardService;
use App\Service\CurrencyRate;
use App\Tests\Trait\TransactionTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class CommissionCalculationTest extends KernelTestCase
{
    use TransactionTrait;
    private Container $container;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = self::getContainer();
    }

    /**
     * @dataProvider transactions
     */
    public function testFeeCalculation(string $country, float $amount, float $expectedFee): void
    {
        $cardService = $this->createStub(CardService::class);
        $cardService->method('getCardCountry')->willReturn($country);
        $this->container->set(CardService::class, $cardService);

        $currencyRate = $this->createStub(CurrencyRate::class);
        $currencyRate->method('getRate')->willReturn(0.5);
        $this->container->set(CurrencyRate::class, $currencyRate);

        $transaction = $this->createTransaction('123', 'TEST', $amount);
        $reader = $this->createStub(Reader::class);
        $reader->method('hasMoreItems')->willReturnOnConsecutiveCalls(true, false);
        $reader->method('readNext')->willReturn($transaction);
        $this->container->set(Reader::class, $reader);

        /** @var Batch $batch */
        $batch = $this->container->get('app.calculator.commission_processor');
        $batch->run();

        /** @var ArrayCommissionWriter $writer */
        $writer = $this->container->get(ArrayCommissionWriter::class);
        $this->assertCount(1, $writer->getCommissions());
        $this->assertEquals($expectedFee, $writer->getCommissions()[0]->getValue());
    }

    private function transactions(): array
    {
        return [
            'EU country' => ['AT', 1000, 5],
            'Non EU country' => ['US', 1000, 10],
        ];
    }
}
