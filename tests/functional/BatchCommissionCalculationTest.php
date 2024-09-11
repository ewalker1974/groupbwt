<?php

namespace App\Tests\Functional;

use App\Service\Batch\Batch;
use App\Service\Batch\BatchInputArguments;
use App\Service\Batch\Component\ArrayCommissionWriter;
use App\Service\CardService;
use App\Service\CurrencyRate;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class BatchCommissionCalculationTest extends KernelTestCase
{
    private Container $container;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = self::getContainer();
    }

    public function testFeeCalculation(): void
    {
        $cardService = $this->createStub(CardService::class);
        $cardService->method('getCardCountry')->willReturnMap([
            ['45717360', 'DK'],
            ['516793', 'LT'],
            ['45417360', 'JP'],
            ['41417360', 'UNKNOWN'],
            ['4745030', 'LT'],
        ]);
        $this->container->set(CardService::class, $cardService);

        $currencyRate = $this->createStub(CurrencyRate::class);
        $currencyRate->method('getRate')->willReturnMap([
            ['EUR', 'EUR', 1],
            ['GBP', 'EUR', 2.185720687],
            ['JPY', 'EUR', 0.0082870639],
            ['USD', 'EUR', 0.923616884],
        ]);

        $this->container->set(CurrencyRate::class, $currencyRate);

        /** @var BatchInputArguments $inputArguments */
        $inputArguments = $this->container->get(BatchInputArguments::class);
        $inputArguments->setArgument('file', __DIR__.'/../data/input.txt');

        /** @var Batch $batch */
        $batch = $this->container->get('app.calculator.commission_processor');
        $batch->run();

        /** @var ArrayCommissionWriter $writer */
        $writer = $this->container->get(ArrayCommissionWriter::class);

        $commissions = $writer->getCommissions();

        $this->assertCount(5, $commissions);
        $expectations = [1, 0.47, 1.66, 2.41, 43.72];
        $counter = count($commissions);
        for ($i = 0; $i < $counter; ++$i) {
            $this->assertEquals($expectations[$i], $commissions[$i]->getValue());
        }
    }
}
