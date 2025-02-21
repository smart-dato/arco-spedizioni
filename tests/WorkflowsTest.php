<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\ArcoSpedizioni\ArcoSpedizioni;
use SmartDato\ArcoSpedizioni\Data\AddressData;
use SmartDato\ArcoSpedizioni\Data\ShipmentData;
use SmartDato\ArcoSpedizioni\Requests\InstradamentoRequest;
use SmartDato\ArcoSpedizioni\Requests\LoginRequest;
use SmartDato\ArcoSpedizioni\Requests\NumeratoriBolleRequest;

beforeEach(function () {
    MockClient::global([
        LoginRequest::class => MockResponse::fixture('LoginRequest'),
        NumeratoriBolleRequest::class => MockResponse::fixture('NumeratoriBolleRequest'),
        InstradamentoRequest::class => MockResponse::fixture('InstradamentoRequest'),
    ]);
});

it('can get auth token', function () {
    $token = ArcoSpedizioni::token();

    $this->assertNotNull($token);
});

it('can get next waybill number', function () {
    $waybill = (new ArcoSpedizioni())->nextWaybillNumber();

    expect($waybill)
        ->toHaveLength(15);
});

it('can create a shipment', function () {
    $data = new ShipmentData(
        recipient: new AddressData(
            name: 'Mario Rossi',
            street: 'STRADA SETTIMIO TORINESE',
            city: 'SAN MAURO TORINESE',
            zip: '10099',
            province: 'TO'
        ),
        clientCode: '000000'
    );

    $route = (new ArcoSpedizioni())
        ->routing(
            route: $data
        );

    expect($route)
        ->toBeArray();
});
