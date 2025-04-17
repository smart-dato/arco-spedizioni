^XA

^PW800
^LL760

^CF0,25
^FO30,30^FDArco Spedizioni - {{$client}}^FS

^FO30,70^BY2
^BCN,100,Y,N,N
^FD{{$waybill}}^FS

^CF0,40
^FO30,240^FD{{$route}}^FS

^CF0,30
^FO30,290^FD{{$details}}^FS

^CF0,30
^FO550,240^FDRif. {{$reference}}^FS
^FO550,280^FD{{$gate}}^FS

^FO30,340^GB740,2,2,B^FS

^CF0,35
^FO30,360^FD{{$receiver}}^FS

^CF0,28
^FO30,400^FD{{$receiverStreet}}^FS
^FO30,440^FD{{$receiverAddress}}^FS
^FO30,480^FDMitt: {{$shipper}}^FS

^CF0,25
^FO550,360^FDDt. {{$date}}^FS
^FO550,395^FDKG. {{$weight}}^FS
^FO550,430^FDVol. {{$volume}}^FS
^FO550,465^FDPr.Cl {{$parcelNumber}}/{{$totalParcels}}^FS
^FO550,500^FDCL. {{$totalParcels}}^FS

^FO520,340^GB2,210,2,B^FS

^XZ
