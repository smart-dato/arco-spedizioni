<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Data;

use SmartDato\ArcoSpedizioni\Contracts\Data;

final readonly class ShipmentData implements Data
{
    public function __construct(
        private AddressData $recipient,

        private float $cashOnDelivery = 0.0,
        private float $volume = 0.0,
        private float $weight = 0.0,

        private bool $isAdrGoods = false,
        private ?string $clientCode = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        return array_merge([
            'LunMax' => 0,
            'Peso' => $this->weight,
            'Volume' => $this->volume,
            'Contrassegno' => $this->cashOnDelivery,

            'MerceAdr' => $this->isAdrGoods ? 'S' : 'N',
            'CodCliente' => $this->clientCode ?? config('arco-spedizioni-sdk.client_code'),
        ], $this->recipient->build());
    }
}
