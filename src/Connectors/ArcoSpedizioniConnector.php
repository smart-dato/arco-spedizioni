<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Connectors;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

final class ArcoSpedizioniConnector extends Connector
{
    use AcceptsJson;

    public function __construct(protected readonly string $token) {}

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://webservices.arcospedizioni.it';
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator(
            $this->token
        );
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
