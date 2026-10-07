<?php

declare(strict_types=1);

use SmartDato\ArcoSpedizioni\Enums\TrackingEvent;
use SmartDato\ArcoSpedizioni\Parsers\DdtEsitiParser;

it('maps italian and english labels to the same event', function (string $label, TrackingEvent $event) {
    expect(TrackingEvent::fromLabel($label))->toBe($event);
})->with([
    ['Consegnata', TrackingEvent::DELIVERED],
    ['DELIVERED', TrackingEvent::DELIVERED],
    ['Messa in Consegna', TrackingEvent::OUT_FOR_DELIVERY],
    ['OUT FOR DELIVERY', TrackingEvent::OUT_FOR_DELIVERY],
    ['Messa in Transito', TrackingEvent::IN_TRANSIT],
    ['Merce in Transito', TrackingEvent::IN_TRANSIT],
    ['IN TRANSIT FROM PI', TrackingEvent::IN_TRANSIT],
    ['Giacenza Aperta', TrackingEvent::STORAGE_OPENED],
    ['Giacenza Chiusa', TrackingEvent::STORAGE_CLOSED],
    ['RECEIVED', TrackingEvent::RECEIVED],
    ['LOADED', TrackingEvent::LOADED],
    ['DEPARTED FROM VR', TrackingEvent::DEPARTED],
    ['DEPARTED FROM', TrackingEvent::DEPARTED],
    ['ARRIVED AT RM', TrackingEvent::ARRIVED],
    ['  arrived at mi  ', TrackingEvent::ARRIVED],
]);

it('does not match a label that only shares a prefix with a hub event', function () {
    expect(TrackingEvent::tryFromLabel('DEPARTED FROMAGE'))->toBeNull();
});

it('throws on an unknown label', function () {
    TrackingEvent::fromLabel('SOMETHING NEW');
})->throws(InvalidArgumentException::class, "Unknown event label: 'SOMETHING NEW'");

it('returns the hub of an english hub event', function (string $label, ?string $hub) {
    expect(TrackingEvent::hubFromLabel($label))->toBe($hub);
})->with([
    ['DEPARTED FROM VR', 'VR'],
    ['IN TRANSIT FROM PI', 'PI'],
    ['ARRIVED AT RM', 'RM'],
    ['DEPARTED FROM', null],
    ['DELIVERED', null],
    ['Messa in Transito', null],
]);

it('parses an english esiti file without failing on an unknown label', function () {
    $records = (new DdtEsitiParser)->parseFile(__DIR__.'/Fixtures/Esiti/ESITI_ENGLISH.TXT');

    expect(array_column($records, 'R29EVE'))->toBe([
        TrackingEvent::RECEIVED,
        TrackingEvent::LOADED,
        TrackingEvent::DEPARTED,
        TrackingEvent::IN_TRANSIT,
        TrackingEvent::ARRIVED,
        TrackingEvent::OUT_FOR_DELIVERY,
        TrackingEvent::DELIVERED,
        null,
    ])
        ->and($records[2]['R29EVE_LABEL'])->toBe('DEPARTED FROM VR')
        ->and($records[2]['R29RFM'])->toBe('OLS202600773845')
        ->and($records[2]['R29DCE'])->toBe(20261006.0)
        ->and($records[7]['R29EVE_LABEL'])->toBe('SOMETHING NEW');
});
