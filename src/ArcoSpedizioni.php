<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni;

use Exception;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use SmartDato\ArcoSpedizioni\Connectors\ArcoSpedizioniConnector;
use SmartDato\ArcoSpedizioni\Data\ShipmentData;
use SmartDato\ArcoSpedizioni\Exceptions\ArcoSpedizioniConnectionException;
use SmartDato\ArcoSpedizioni\Exceptions\ArcoSpedizioniInvalidWaybillNumberException;
use SmartDato\ArcoSpedizioni\Exceptions\ArcoSpedizioniRequestException;
use SmartDato\ArcoSpedizioni\Requests\InstradamentoRequest;
use SmartDato\ArcoSpedizioni\Requests\LoginRequest;
use SmartDato\ArcoSpedizioni\Requests\NumeratoriBolleRequest;

final class ArcoSpedizioni
{
    private ?ArcoSpedizioniConnector $connector = null;

    public function __construct(
        private readonly ?string $username = null,
        private readonly ?string $password = null,
    ) {}

    /**
     * @throws ArcoSpedizioniConnectionException
     * @throws ArcoSpedizioniRequestException
     */
    public static function token(?string $username = null, ?string $password = null): string
    {
        try {
            $response = (new LoginRequest($username, $password))->send();
        } catch (Exception $e) {
            throw new ArcoSpedizioniConnectionException();
        }

        if ($response->failed()) {
            throw new ArcoSpedizioniRequestException();
        }

        return $response->body();
    }

    /**
     * @throws ArcoSpedizioniRequestException
     * @throws JsonException
     * @throws ArcoSpedizioniInvalidWaybillNumberException
     * @throws ArcoSpedizioniConnectionException
     */
    public function nextWaybillNumber(): mixed
    {
        try {
            $response = $this->connector()->send(
                new NumeratoriBolleRequest()
            );
        } catch (RequestException|FatalRequestException $e) {
            throw new ArcoSpedizioniConnectionException();
        }

        if ($response->failed()) {
            throw new ArcoSpedizioniRequestException();
        }

        $waybillNumber = $response->json('numero_spedizione');
        if ($waybillNumber === null || $waybillNumber === '') {
            throw new ArcoSpedizioniInvalidWaybillNumberException();
        }

        return $waybillNumber;
    }

    /**
     * @return array<mixed>
     *
     * @throws ArcoSpedizioniConnectionException
     * @throws ArcoSpedizioniRequestException
     * @throws FatalRequestException
     * @throws JsonException
     * @throws RequestException
     */
    public function routing(ShipmentData $route): array
    {
        try {
            $response = $this->connector()->send(
                new InstradamentoRequest($route)
            );
        } catch (RequestException|FatalRequestException $e) {
            throw new ArcoSpedizioniConnectionException();
        }

        if ($response->failed()) {
            throw new ArcoSpedizioniRequestException();
        }

        return $response->json();
    }

    /**
     * @throws ArcoSpedizioniRequestException
     * @throws ArcoSpedizioniConnectionException
     */
    private function connector(): ArcoSpedizioniConnector
    {
        return $this->connector ??= new ArcoSpedizioniConnector(
            token: self::token($this->username, $this->password)
        );
    }
}
