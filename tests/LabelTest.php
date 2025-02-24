<?php

use SmartDato\ArcoSpedizioni\LabelBuilder;

it('can creat label', function () {
    $output = (new LabelBuilder())
        ->make(
            data: [
                'client' => 'CLIENT',
                'warhouse' => 'XXX',
                'waybill' => '2016xxx000000010000001MZ1',
                'route' => 'LB / MZ / MONZA',
                'gate' => '002',
                'details' => 'xxX/00000001/1',
                'reference' => '123456789',

                'receiver' => 'Rag. soc. Destinatario',
                'receiverStreet' => 'Indirizzo',
                'receiverAddress' => 'CAP - Località - Provincia',

                'shipper' => 'Rag. Sociale',

                'date' => 'gg/mm/aa',
                'weight' => 'xxxxxx,x',
                'volume' => 'xxx,xx',
                'shipmentNumber' => '00000001',
                'parcelNumber' => '1',
                'toalParcels' => '2',
            ]
        );
    $file = 'storages/labels/'.now()->format('YmdHis').'_label.pdf';
    file_put_contents($file, $output);
});
