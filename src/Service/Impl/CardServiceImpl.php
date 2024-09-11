<?php

namespace App\Service\Impl;

use App\Exception\BadCardResponseException;
use App\Service\CardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardServiceImpl implements CardService
{
    private const string REQUEST_URL = 'https://lookup.binlist.net/%s';

    /** @var string[] */
    private array $binCountries = [];

    public function __construct(private readonly HttpClientInterface $httpClient)
    {
    }

    /**
     * @throws BadCardResponseException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[\Override]
    public function getCardCountry(string $bin): string
    {
        if (!isset($this->binCountries[$bin])) {
            $data = $this->loadBinData($bin);
            $this->binCountries[$bin] = $data['country']['alpha2'] ?? 'UNKNOWN';
        }

        return $this->binCountries[$bin];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws BadCardResponseException
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function loadBinData(string $bin): array
    {
        $response = $this->httpClient->request('GET', sprintf(self::REQUEST_URL, $bin));

        if (Response::HTTP_OK === $response->getStatusCode()) {
            return $response->toArray();
        }

        throw new BadCardResponseException();
    }
}
