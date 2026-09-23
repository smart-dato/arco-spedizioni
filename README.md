# Arco Spedizioni SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/arco-spedizioni.svg?style=flat-square)](https://packagist.org/packages/smart-dato/arco-spedizioni)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/arco-spedizioni/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/arco-spedizioni/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/arco-spedizioni/code-style.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/arco-spedizioni/actions?query=workflow%3A%22Code+style%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/arco-spedizioni.svg?style=flat-square)](https://packagist.org/packages/smart-dato/arco-spedizioni)

A Laravel package for the Italian carrier Arco Spedizioni. It talks to Arco's web services (waybill numbers and routing), generates the fixed-width DDT and TXT files Arco exchanges with clients, parses Arco's delivery-outcome (*esiti*) files, and renders PDF and ZPL shipping labels.

## Requirements

- PHP 8.2+
- Laravel 10 – 13

## Installation

```bash
composer require smart-dato/arco-spedizioni
```

Publish the config file:

```bash
php artisan vendor:publish --tag="arco-spedizioni-sdk-config"
```

## Configuration

```dotenv
ARCO_SPEDIZIONI_USERNAME=your-username
ARCO_SPEDIZIONI_PASSWORD=your-password
```

The config also defines `ARCO_SPEDIZIONI_CLIENT_CODE`, which the package does not currently read.

## Web services

The `ArcoSpedizioni` facade is bound to a client built from the configured credentials. It logs in lazily on the first call and reuses the token.

```php
use SmartDato\ArcoSpedizioni\Facades\ArcoSpedizioni;

$waybillNumber = ArcoSpedizioni::nextWaybillNumber();
```

Or construct it yourself:

```php
use SmartDato\ArcoSpedizioni\ArcoSpedizioni;

$arco = new ArcoSpedizioni(username: 'your-username', password: 'your-password');
```

### Routing

Ask Arco how a shipment will be routed (`instradamento`):

```php
use SmartDato\ArcoSpedizioni\Data\AddressData;
use SmartDato\ArcoSpedizioni\Data\ShipmentData;

$routing = ArcoSpedizioni::routing(new ShipmentData(
    recipient: new AddressData(
        name: 'Mario Rossi',
        street: 'Via Roma 1',
        city: 'Milano',
        zip: '20121',
        province: 'MI',
    ),
    weight: 12.5,
    volume: 0.1,
    cashOnDelivery: 0.0,
    isAdrGoods: false,
));
```

### Errors

- `ArcoSpedizioniConnectionException` — the request could not be sent
- `ArcoSpedizioniRequestException` — Arco returned an error response
- `ArcoSpedizioniInvalidWaybillNumberException` — `nextWaybillNumber()` got an empty number back

## DDT and TXT files

`DdtFileGenerator` and `TxtFileGenerator` build Arco's fixed-width record files. Set each field by name, close the record, and repeat for as many records as you need:

```php
use SmartDato\ArcoSpedizioni\Generators\DdtFileGenerator;

$content = (new DdtFileGenerator())
    ->setField('arco_sender_client_code', '053696')
    ->setField('sender_company_name', 'ACME')
    ->setField('recipient_company_name', 'Mario Rossi')
    ->setField('recipient_zip_code', '20121')
    // … the remaining fields of the record
    ->setField('end_of_record_flag', 'E')
    ->addRecord()
    ->content();          // or ->store('/path/to/file.txt')
```

Each field is padded to its defined width — numeric fields with leading zeros, text fields with trailing spaces — and every record ends with a newline. The field names and their positions are defined in the `$structure` of each generator.

## Delivery outcomes

Parse the *esiti* files Arco sends back:

```php
use SmartDato\ArcoSpedizioni\Parsers\DdtEsitiParser;

$records = (new DdtEsitiParser())->parseFile('/path/to/esiti.txt');

// or a single line
$record = (new DdtEsitiParser())->parseLine($line);
```

Statuses map to the `TrackingEvent` enum: `DELIVERED`, `OUT_FOR_DELIVERY`, `IN_TRANSIT`, `STORAGE_OPENED` and `STORAGE_CLOSED`. `parseFile()` throws if the file cannot be read.

## Labels

Render a label as PDF or ZPL from the package's Blade templates:

```php
use SmartDato\ArcoSpedizioni\LabelBuilder;

$data = [
    'barcode' => 'data:image/png;base64,…',
    'client' => 'CLIENT',
    'waybill' => '2025xxx000000010000001MZ1',
    'route' => 'LB / MZ / MONZA',
    'gate' => '002',
    'details' => 'xxX/00000001/1',
    'reference' => '123456789',
    'receiver' => 'Mario Rossi',
    'receiverStreet' => 'Via Roma 1',
    'receiverAddress' => '20121 - Milano - MI',
    'shipper' => 'ACME',
    'date' => '01/01/26',
    'weight' => '12,5',
    'volume' => '0,10',
    'parcelNumber' => '1',
    'totalParcels' => '1',
];

$pdf = (new LabelBuilder())->pdf($data);  // PDF bytes, 10 × 9.5 cm
$zpl = (new LabelBuilder())->zpl($data);  // ZPL string
```

These are the variables the `pdf` and `zpl` templates read.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
