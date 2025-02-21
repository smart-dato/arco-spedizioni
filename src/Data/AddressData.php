<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Data;

use SmartDato\ArcoSpedizioni\Contracts\Data;

final readonly class AddressData implements Data
{
    public function __construct(
        private string $name,
        private string $street,
        private string $city,
        private string|int $zip,
        private string $province,
    ) {}

    /**
     * @return array<string, string|float|int>
     */
    public function build(): array
    {
        return [
            'RagSocDes' => $this->name,
            'Localita' => $this->city,
            'Cap' => $this->zip,
            'Provincia' => $this->province,
            'Indirizzo' => $this->street,
        ];
    }
}
