<?php

declare(strict_types=1);

use SmartDato\ArcoSpedizioni\ArcoSpedizioni;
use SmartDato\ArcoSpedizioni\Facades\ArcoSpedizioni as ArcoSpedizioniFacade;

it('resolves from the container without performing a login request', function () {
    $instance = app(ArcoSpedizioni::class);

    expect($instance)->toBeInstanceOf(ArcoSpedizioni::class);
});

it('resolves the facade root without performing a login request', function () {
    $root = ArcoSpedizioniFacade::getFacadeRoot();

    expect($root)->toBeInstanceOf(ArcoSpedizioni::class);
});

it('binds the sdk as a singleton', function () {
    expect(app(ArcoSpedizioni::class))->toBe(app(ArcoSpedizioni::class));
});
