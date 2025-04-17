<?php

declare(strict_types=1);

use SmartDato\ArcoSpedizioni\LabelBuilder;

it('can creat pdf label', function () {

    $output = (new LabelBuilder())
        ->pdf(
            data: [
                'barcode' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALsAAAAyCAYAAAAEL6p6AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA80lEQVR4nO3SMY4CMRAAQfv+/2cTrWStLFgCkuuqCNgZY1DPtdYaD8w5xxhjrLXGnHNca/vr++w1v39+7e9n7U7n3veezt539pnT/n329H2nu78799ezT3Y//Zb9/bf/2f7s2zvtTm3sz97d82HC4+/RFPwDYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZL6jpjmDZ4E69AAAAAElFTkSuQmCC',
                'client' => 'CLIENT',
                'warhouse' => 'XXX',
                'waybill' => '2025xxx000000010000001MZ1',
                'route' => 'LB / MZ / MONZA',
                'gate' => '002',
                'details' => 'xxX/00000001/1',
                'reference' => '123456789',

                'receiver' => 'Destinatario',
                'receiverStreet' => 'Indirizzo',
                'receiverAddress' => 'CAP - Località - Provincia',

                'shipper' => 'Rag. Sociale',

                'date' => 'gg/mm/aa',
                'weight' => 'xxxxxx,x',
                'volume' => 'xxx,xx',
                'shipmentNumber' => '00000001',
                'parcelNumber' => '1',
                'totalParcels' => '2',
            ]
        );
    $file = 'storages/labels/'.now()->format('YmdHis').'_label.pdf';
    file_put_contents($file, $output);
});

it('can creat zpl label', function () {

    $output = (new LabelBuilder())
        ->zpl(
            data: [
                'barcode' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALsAAAAyCAYAAAAEL6p6AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA80lEQVR4nO3SMY4CMRAAQfv+/2cTrWStLFgCkuuqCNgZY1DPtdYaD8w5xxhjrLXGnHNca/vr++w1v39+7e9n7U7n3veezt539pnT/n329H2nu78799ezT3Y//Zb9/bf/2f7s2zvtTm3sz97d82HC4+/RFPwDYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZYidD7GSInQyxkyF2MsROhtjJEDsZL6jpjmDZ4E69AAAAAElFTkSuQmCC',
                'client' => 'CLIENT',
                'warhouse' => 'XXX',
                'waybill' => '2025xxx000000010000001MZ1',
                'route' => 'LB / MZ / MONZA',
                'gate' => '002',
                'details' => 'xxX/00000001/1',
                'reference' => '123456789',

                'receiver' => 'Destinatario',
                'receiverStreet' => 'Indirizzo',
                'receiverAddress' => 'CAP - Località - Provincia',

                'shipper' => 'Rag. Sociale',

                'date' => 'gg/mm/aa',
                'weight' => 'xxxxxx,x',
                'volume' => 'xxx,xx',
                'shipmentNumber' => '00000001',
                'parcelNumber' => '1',
                'totalParcels' => '2',
            ]
        );
    $file = 'storages/labels/'.now()->format('YmdHis').'_label.zpl';
    file_put_contents($file, $output);
});
