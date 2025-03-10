<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <title>Shipment label</title>
</head>

<style>

    @page {
        margin: 0;
        size: A4 portrait;
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
    }

    .shipment-label {
        margin: 0 auto;
        max-width: 440px;
        width: 100%;
        padding: 20px;
        page-break-inside: avoid;
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
        text-align: center;
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
        margin-bottom: 15px;
    }

    .route-info td {
        vertical-align: bottom;
    }

    .route-info .route-decoding {
        font-size: 24px;
        line-height: 26px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .route-info .shipping {
        font-size: 18px;
        line-height: 24px;
        font-weight: 600;
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


    .personal-info .date {
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
        <div class="shipment-label-title">Arco Spedizioni - cliente</div>
        <div class="barcode-container">
            <img alt="barcode"
                 src="data:image/gif;base64,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"/>
        </div>

        <table class="route-info" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="route-decoding">LB / MZ / MONZA</div>
                    <div class="shipping">xxx/<span>000000001</span>/1</div>
                </td>
                <td>
                    <div class="gate">002</div>
                    <div class="reference">Rif.123456789</div>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="personal-info">
            <tbody>
            <tr>
                <td>
                    <div class="company-name">Rag. soc. Destinatario</div>
                    <div class="address">Indirizzo</div>
                    <div class="zip-code">CAP - Località - Provincia</div>
                    <div class="info">Mitt: Rag. Sociale</div>
                </td>
                <td>
                    <div class="date">Dt. gg/mm/aa</div>
                    <div class="weight">KG. xxxxx,x</div>
                    <div class="vol">Vol. xx,x</div>
                    <div class="pr-total">Pr.Cl 1/2</div>
                    <div class="total">CL. 2</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
