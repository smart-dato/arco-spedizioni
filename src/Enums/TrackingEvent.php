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

        return match (mb_strtolower($label)) {
            'consegnata' => self::DELIVERED,
            'giacenza aperta' => self::STORAGE_OPENED,
            'giacenza chiusa' => self::STORAGE_CLOSED,
            'messa in consegna' => self::OUT_FOR_DELIVERY,
            'messa in transito', 'merce in transito' => self::IN_TRANSIT,
            default => throw new InvalidArgumentException("Unknown event label: '$label'"),
        };
    }

    public function label(): string
    {
        return $this->value;
    }
}
