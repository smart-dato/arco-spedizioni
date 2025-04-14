<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Enums;

use InvalidArgumentException;

enum TrackingEvent: string
{
    case DELIVERED = 'Consegnata';              // Consegnata
    case STORAGE_OPENED = 'Giacenza Aperta';    // Giacenza Aperta
    case STORAGE_CLOSED = 'Giacenza Chiusa';    // Giacenza Chiusa
    case OUT_FOR_DELIVERY = 'Messa in Consegna'; // Messa in Consegna
    case IN_TRANSIT = 'Messa in Transito';      // Messa in Transito

    public static function fromLabel(string $label): self
    {
        $label = mb_trim($label);

        return match ($label) {
            'Consegnata' => self::DELIVERED,
            'Giacenza Aperta' => self::STORAGE_OPENED,
            'Giacenza Chiusa' => self::STORAGE_CLOSED,
            'Messa in Consegna' => self::OUT_FOR_DELIVERY,
            'Messa in Transito' => self::IN_TRANSIT,
            default => throw new InvalidArgumentException("Unknown event label: '$label'"),
        };
    }

    public function label(): string
    {
        return $this->value;
    }
}
