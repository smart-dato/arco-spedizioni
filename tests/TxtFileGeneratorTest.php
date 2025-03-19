<?php

declare(strict_types=1);

use SmartDato\ArcoSpedizioni\Generators\TxtFileGenerator;

it('can create a shipment file', function () {
    $content = (new TxtFileGenerator())
        ->setField('client_code', '053696')
        ->addRecord()
        ->content();

    expect($content)
        ->toBeString()
        ->toHaveLength(676)
        ->toStartWith('053696');
});
