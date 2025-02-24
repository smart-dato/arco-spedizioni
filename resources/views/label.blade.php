<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            border: 1px solid black; /* Add a thin border */
        }
        .shipment-section {
            border: 1px solid black; /* Add a box around shipment-section */
            display: flex;
        }
        .address-section {
            flex: 3; /* 3/4 of the space */
            border-right: 1px solid black; /* Add a border between sections */
            padding: 10px;
        }
        .detail-section {
            flex: 1; /* 1/3 of the space */
            padding: 10px;
        }
    </style>
    <title>label</title>
</head>
<body>
<div class="container">
    <div class="header-section">
        <span>ARCO SPEDIZIONE {{ $client }}</span>
    </div>

    <div class="barcode-section">
        <img src="data:image/png;base64,{{ $waybill }}" alt="barcode" />
        <span>{{ $waybill }}</span>
    </div>

    <div class="routing-section">
        <span>{{ $route }}</span>
        <span>{{ $gate }}</span>
        <span>{{ $warhouse }}/{{ $shipmentNumber }}/{{ $parcelNumber }}/</span>
        <span>Rif. {{ $reference }}</span>
    </div>

    <div class="shipment-section">
        <div class="address-section">
            <span>{{ $receiver }}</span>
            <span>{{ $receiverStreet }}</span>
            <span>{{ $receiverAddress }}</span>

            <span>Mitt: {{ $shipper }}</span>
        </div>

        <div class="detail-section">
            <span>DT. {{ $date }}</span>
            <span>KG. {{ $weight }}</span>
            <span>Vol. {{ $volume }}</span>
            <span>Pr.Cl.  {{ $parcelNumber }}/{{ $toalParcels }}</span>
            <span>CL. {{ $toalParcels }}</span>
        </div>
    </div>
</div>
</body>
</html>
