<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Enums;

use InvalidArgumentException;

/**
 * Arco sends the event label in Italian or English depending on the client
 * account. Both languages resolve to the same case, so the case value is the
 * stable code a consumer maps against.
 */
enum TrackingEvent: string
{
    case DELIVERED = 'Consegnata';
    case STORAGE_OPENED = 'Giacenza Aperta';
    case STORAGE_CLOSED = 'Giacenza Chiusa';
    case OUT_FOR_DELIVERY = 'Messa in Consegna';
    case IN_TRANSIT = 'Messa in Transito';
    case RECEIVED = 'Received';
    case LOADED = 'Loaded';
    case DEPARTED = 'Departed';
    case ARRIVED = 'Arrived';

    public static function fromLabel(string $label): self
    {
        return self::tryFromLabel($label)
            ?? throw new InvalidArgumentException('Unknown event label: \''.mb_trim($label).'\'');
    }

    /**
     * English hub events carry the hub's province code ("DEPARTED FROM VR",
     * "ARRIVED AT RM"), so those match on their prefix.
     */
    public static function tryFromLabel(string $label): ?self
    {
        $label = mb_strtolower(mb_trim($label));

        return match (true) {
            $label === 'consegnata',
            $label === 'delivered' => self::DELIVERED,
            $label === 'giacenza aperta' => self::STORAGE_OPENED,
            $label === 'giacenza chiusa' => self::STORAGE_CLOSED,
            $label === 'messa in consegna',
            $label === 'out for delivery' => self::OUT_FOR_DELIVERY,
            $label === 'messa in transito',
            $label === 'merce in transito',
            self::matchesHubEvent($label, 'in transit from') => self::IN_TRANSIT,
            $label === 'received' => self::RECEIVED,
            $label === 'loaded' => self::LOADED,
            self::matchesHubEvent($label, 'departed from') => self::DEPARTED,
            self::matchesHubEvent($label, 'arrived at') => self::ARRIVED,
            default => null,
        };
    }

    /**
     * Returns the hub's province code of an English hub event, e.g. "VR" for "DEPARTED FROM VR".
     */
    public static function hubFromLabel(string $label): ?string
    {
        $label = mb_trim($label);

        foreach (['in transit from', 'departed from', 'arrived at'] as $prefix) {
            if (! self::matchesHubEvent(mb_strtolower($label), $prefix)) {
                continue;
            }

            $hub = mb_trim(mb_substr($label, mb_strlen($prefix)));

            return $hub === '' ? null : $hub;
        }

        return null;
    }

    public function label(): string
    {
        return $this->value;
    }

    private static function matchesHubEvent(string $label, string $prefix): bool
    {
        return $label === $prefix || str_starts_with($label, "{$prefix} ");
    }
}
