<?php

namespace App\Service\Impl;

use App\Exception\RatesException;
use App\Service\CurrencyRate;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyRateImpl implements CurrencyRate
{
    private const string REQUEST_URL = 'https://api.apilayer.com/exchangerates_data/latest?symbols=%s&base=%s';

    private array $rates = [];

    public function __construct(private readonly HttpClientInterface $httpClient, private readonly ParameterBagInterface $params)
    {
    }

    /**
     * @throws RatesException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[\Override]
    public function getRate(string $from, string $to): float
    {
        if (!isset($this->rates[$from.$to])) {
            $this->rates[$from.$to] = $this->loadRates($from, $to);
        }

        return $this->rates[$from.$to];
    }

    /**
     * @throws RatesException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function loadRates(string $from, string $to): float
    {
        if ($from === $to) {
            return 1;
        }

        $response = $this->httpClient->request(
            'GET',
            sprintf(self::REQUEST_URL, $to, $from),
            ['headers' => ['Content-Type: text/plain', 'apikey: '.$this->params->get('exchange_rates_key')]]
        );

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $response->toArray();
            if (isset($response->toArray()['rates'][$to])) {
                return (float) $response->toArray()['rates'][$to];
            }
        }

        throw new RatesException();
    }
}
