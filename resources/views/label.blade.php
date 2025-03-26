
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Shipment label</title>
</head>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
    }

    .shipment-label {
        margin: 20px auto;
        max-width: 400px;
        width: 100%;
    }

    .shipment-label-inner {
        background-color: #ffffff;
        border: 3px solid #000000;
        padding: 10px;
    }

    .shipment-label-title {
        font-size: 12px;
        line-height: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .barcode-container {
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 0 20px;
    }

    .barcode-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .route-info {
        width: 100%;
        border-collapse: collapse;
        border: none;
        margin-bottom: 10px;
    }

    .route-info td {
        vertical-align: bottom;
    }

    .route-info .route-decoding {
        font-size: 24px;
        line-height: 30px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .route-info .shipping {
        font-size: 18px;
        line-height: 24px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .route-info .shipping span {
        font-size: 20px;
    }

    .route-info .gate {
        text-align: right;
        font-size: 20px;
        line-height: 24px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .route-info .reference {
        text-align: right;
        padding-right: 40px;
        font-size: 12px;
        line-height: 18px;
        font-weight: bold;
    }

    .personal-info {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000000;
    }

    .personal-info td {
        padding: 5px 7px;
        border: 1px solid #000000;
    }

    .personal-info .company-name {
        font-size: 20px;
        line-height: 24px;
        font-weight: 600;
    }

    .personal-info .address,
    .personal-info .zip-code,
    .personal-info .info-name {
        font-size: 16px;
        line-height: 22px;
        font-weight: 400;
    }


    .personal-info .date  {
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
    }

    .personal-info .weight,
    .personal-info .vol,
    .personal-info .pr-total,
    .personal-info .total {
        font-size: 12px;
        line-height: 18px;
        font-weight: 400;
    }
</style>

<body>

<div class="shipment-label">

    <div class="shipment-label-inner">
        <div class="shipment-label-title">Arco Spedizioni - {{$client}}</div>
        <div class="barcode-container">
            <img alt="barcode" src="{{$barcode}}" />
            <span>{{$waybill}}</span>
        </div>

        <table class="route-info" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="route-decoding">{{$route}}</div>
                    <div class="shipping">{{$details}}</div>
                </td>
                <td>
                    <div class="gate">{{$gate}}</div>
                    <div class="reference">Rif.{{$reference}}</div>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="personal-info">
            <tbody>
            <tr>
                <td>
                    <div class="company-name">Rag. soc. {{$receiver}}</div>
                    <div class="address">{{$receiverStreet}}</div>
                    <div class="zip-code">{{$receiverAddress}}</div>
                    <div class="info">Mitt: {{$shipper}}</div>
                </td>
                <td>
                    <div class="date">Dt. {{$date}}</div>
                    <div class="weight">KG. {{$weight}}</div>
                    <div class="vol">Vol. {{$volume}}</div>
                    <div class="pr-total">Pr.Cl {{$parcelNumber}}/{{$totalParcels}}</div>
                    <div class="total">CL. {{$totalParcels}}</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
