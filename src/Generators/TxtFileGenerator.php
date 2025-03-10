<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Generators;

final class TxtFileGenerator
{
    private array $data = [];

    private array $currentRecord = [];

    private array $structure = [
        // 1
        [
            'field' => 'client_code',
            'it' => 'CODICE CLIENTE',
            'description' => 'Client Code',
            'type' => 'A',
            'length' => 6,
            'start' => 1,
            'end' => 6,
            'note' => 'Chiave per il caricamento',
        ],
        // 2
        [
            'field' => 'authorization_code',
            'it' => 'CODICE AUTORIZZAZIONE',
            'description' => 'Authorization Code',
            'type' => 'A',
            'length' => 10,
            'start' => 7,
            'end' => 16,
            'note' => 'Chiave per il caricamento',
        ],
        // 3
        [
            'field' => 'recipient_name',
            'it' => 'RAGIONE SOCIALE DESTINATARIO',
            'description' => 'Recipient Name',
            'type' => 'A',
            'length' => 40,
            'start' => 17,
            'end' => 56,
            'note' => 'Alfanumerico da max 40 caratteri',
        ],
        // 4
        [
            'field' => 'address',
            'it' => 'INDIRIZZO',
            'description' => 'Address',
            'type' => 'A',
            'length' => 40,
            'start' => 57,
            'end' => 96,
            'note' => 'Alfanumerico da max 40 caratteri',
        ],
        // 5
        [
            'field' => 'city',
            'it' => 'LOCALITA',
            'description' => 'City',
            'type' => 'A',
            'length' => 40,
            'start' => 97,
            'end' => 136,
            'note' => 'Alfanumerico da max 30 caratteri',
        ],
        // 6
        [
            'field' => 'postal_code',
            'it' => 'CAP',
            'description' => 'Postal Code',
            'type' => 'A',
            'length' => 5,
            'start' => 137,
            'end' => 141,
            'note' => 'Alfanumerico da 5 caratteri',
        ],
        // 7
        [
            'field' => 'ddt_client_reference_number',
            'it' => 'NUMERO DDT/RIFERIMENTO CLIENTE',
            'description' => 'DDT/Client Reference Number',
            'type' => 'A',
            'length' => 15,
            'start' => 142,
            'end' => 156,
            'note' => 'Alfanumerico da max 15 caratteri',
        ],
        // 8
        [
            'field' => 'pre_call',
            'it' => 'PREAVV TEL',
            'description' => 'Pre-Call',
            'type' => 'A',
            'length' => 1,
            'start' => 157,
            'end' => 157,
            'note' => 'campo da 1 carattere, “S” se si vuole il preavviso',
        ],
        // 9
        [
            'field' => 'recipient_phone',
            'it' => 'TELEFONO DESTINATARIO',
            'description' => 'Recipient Phone',
            'type' => 'A',
            'length' => 15,
            'start' => 158,
            'end' => 172,
            'note' => 'Se la colonna F è vuota, lasciare vuoto, Compilare obbligatoriamente se la colonna F è compilata',
        ],
        // 10
        [
            'field' => 'packages',
            'it' => 'COLLI',
            'description' => 'Packages',
            'type' => 'S',
            'length' => 5,
            'start' => 173,
            'end' => 177,
            'note' => 'Numerico da 5',
        ],
        // 11
        [
            'field' => 'weight_kg',
            'it' => 'KG',
            'description' => 'Weight (kg)',
            'type' => 'S',
            'length' => 7,
            'start' => 178,
            'end' => 184,
            'note' => 'Numerico da 7, ultimo campo decimale',
        ],
        // 12
        [
            'field' => 'volume_m3',
            'it' => 'VOLUME M3',
            'description' => 'Volume (m³)',
            'type' => 'S',
            'length' => 5,
            'start' => 185,
            'end' => 189,
            'note' => 'Numerico da 5, ultimi 2 decimali',
        ],
        // 13
        [
            'field' => 'length_over_200',
            'it' => 'LUNGHEZZA > 200',
            'description' => 'Length > 200cm',
            'type' => 'S',
            'length' => 3,
            'start' => 190,
            'end' => 192,
            'note' => 'Necessario quando superiore a 200 cm, campo numerico da 3, in centimetri',
        ],
        // 14
        [
            'field' => 'cash_on_delivery',
            'it' => 'CONTRASSEGNO',
            'description' => 'Cash on Delivery',
            'type' => 'S',
            'length' => 11,
            'start' => 193,
            'end' => 203,
            'note' => "Inserire quando c'è vincolo di contrassegno, campo numerico da 11, ultimi 2 decimali",
        ],
        // 15
        [
            'field' => 'collection_type',
            'it' => 'TIPO INCASSO',
            'description' => 'Collection Type',
            'type' => 'A',
            'length' => 1,
            'start' => 204,
            'end' => 204,
            'note' => "Campo da 1, obbligatorio solo quando c'è il contrassegno, diversamente lasciare vuoto. Per utilizzo con contrassegno, vedi tab 1 sotto.",
        ],
        // 16
        [
            'field' => 'goods_value',
            'it' => 'VALORE MERCE',
            'description' => 'Goods Value',
            'type' => 'S',
            'length' => 11,
            'start' => 205,
            'end' => 215,
            'note' => 'Utilizzare solo se stipulato contratto ALL RISKS con ARCO. Ultimi 2 decimali',
        ],
        // 17
        [
            'field' => 'disposition_2',
            'it' => 'DISPOSIZIONI 2',
            'description' => 'Disposition 2',
            'type' => 'A',
            'length' => 1,
            'start' => 216,
            'end' => 216,
            'note' => 'Campo da 1, vedi tabella 2 sotto',
        ],
        // 18
        [
            'field' => 'notes',
            'it' => 'NOTE',
            'description' => 'Notes',
            'type' => 'A',
            'length' => 60,
            'start' => 217,
            'end' => 276,
            'note' => 'Campo alfanumerico da max 60 caratteri',
        ],
        // 19
        [
            'field' => 'agreed_delivery',
            'it' => 'CONSEGNA CONCORDATA',
            'description' => 'Agreed Delivery',
            'type' => 'A',
            'length' => 1,
            'start' => 277,
            'end' => 277,
            'note' => 'Campo da 1, obbligatorio quando si vuole definire una data di consegna tassativa, diversamente lasciare vuoto. Per utilizzo vedi tab. 3 sotto.',
        ],
        // 20
        [
            'field' => 'delivery_date',
            'it' => 'DATA CONSEGNA',
            'description' => 'Delivery Date',
            'type' => 'S',
            'length' => 8,
            'start' => 278,
            'end' => 285,
            'note' => 'Campo data, da compilare solo quando si è scelta una tipologia di consegna tassativa. SSAAMMGG (Secolo anno mese giorno)',
        ],
        // 21
        [
            'field' => 'monday_closure',
            'it' => 'CHIUSURA LUNEDI',
            'description' => 'Monday Closure',
            'type' => 'A',
            'length' => 1,
            'start' => 286,
            'end' => 286,
            'note' => 'Campo da 1, definisce le chiusure del cliente destinatario nel giorno indicato T=tutto il giorno M=Mattino P=Pomeriggio',
        ],
        // 22
        [
            'field' => 'tuesday_closure',
            'it' => 'CHIUSURA MARTEDI',
            'description' => 'Tuesday Closure',
            'type' => 'A',
            'length' => 1,
            'start' => 287,
            'end' => 287,
            'note' => 'Campo da 1, definisce le chiusure del cliente destinatario nel giorno indicato T=tutto il giorno M=Mattino P=Pomeriggio',
        ],
        // 23
        [
            'field' => 'wednesday_closure',
            'it' => 'CHIUSURA MERCOLEDI',
            'description' => 'Wednesday Closure',
            'type' => 'A',
            'length' => 1,
            'start' => 288,
            'end' => 288,
            'note' => 'Campo da 1, definisce le chiusure del cliente destinatario nel giorno indicato T=tutto il giorno M=Mattino P=Pomeriggio',
        ],
        // 24
        [
            'field' => 'thursday_closure',
            'it' => 'CHIUSURA GIOVEDI',
            'description' => 'Thursday Closure',
            'type' => 'A',
            'length' => 1,
            'start' => 289,
            'end' => 289,
            'note' => 'Campo da 1, definisce le chiusure del cliente destinatario nel giorno indicato T=tutto il giorno M=Mattino P=Pomeriggio',
        ],
        // 25
        [
            'field' => 'friday_closure',
            'it' => 'CHIUSURA VENERDI',
            'description' => 'Friday Closure',
            'type' => 'A',
            'length' => 1,
            'start' => 290,
            'end' => 290,
            'note' => 'Campo da 1, definisce le chiusure del cliente destinatario nel giorno indicato T=tutto il giorno M=Mattino P=Pomeriggio',
        ],
        // 26
        [
            'field' => 'returnable_pallets',
            'it' => 'BANCALI A RENDERE',
            'description' => 'Returnable Pallets',
            'type' => 'S',
            'length' => 2,
            'start' => 291,
            'end' => 292,
            'note' => 'Campo numerico, inserire solo se si ha contratto stipulato di resa bancali, e inserire solo n° bancali EPAL',
        ],
        // 27
        [
            'field' => 'email',
            'it' => 'EMAIL',
            'description' => 'Email',
            'type' => 'A',
            'length' => 200,
            'start' => 293,
            'end' => 492,
            'note' => 'alfanumerico da 200, inserire gli indirizzi mail per invio automatico e-mail traking ( separatore interno “;” (punto e virgola)',
        ],
        // 28
        [
            'field' => 'original_sender_name',
            'it' => 'RAG SOCIALE MITTENTE ORIGINALE',
            'description' => 'Original Sender Name',
            'type' => 'A',
            'length' => 40,
            'start' => 493,
            'end' => 532,
            'note' => 'Obbligatorio per clienti CORRIERI o Logistiche - Alfanumerico 40',
        ],
        // 29
        [
            'field' => 'original_sender_address',
            'it' => 'INDIRIZZO MITTENTE ORIGINALE',
            'description' => 'Original Sender Address',
            'type' => 'A',
            'length' => 40,
            'start' => 533,
            'end' => 572,
            'note' => 'Obbligatorio per clienti CORRIERI o Logistiche - Alfanumerico 40',
        ],
        // 30
        [
            'field' => 'original_sender_city',
            'it' => 'LOCALITA MITTENTE ORIGINALE',
            'description' => 'Original Sender City',
            'type' => 'A',
            'length' => 30,
            'start' => 573,
            'end' => 602,
            'note' => 'Obbligatorio per clienti CORRIERI o Logistiche - Alfanumerico 30',
        ],
        // 31
        [
            'field' => 'original_sender_postal_code',
            'it' => 'CAP MITTENTE ORIGINALE',
            'description' => 'Original Sender Postal Code',
            'type' => 'A',
            'length' => 5,
            'start' => 603,
            'end' => 607,
            'note' => 'Obbligatorio per clienti CORRIERI o Logistiche - Alfanumerico 5',
        ],
        // 32
        [
            'field' => 'un_number_1',
            'it' => '1° NUMERO ONU',
            'description' => '1st UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 608,
            'end' => 611,
            'note' => 'Obbligatorio se Merce ADR - Alfanumerico da 4',
        ],
        // 33
        [
            'field' => 'un_number_2',
            'it' => '2° NUMERO ONU',
            'description' => '2nd UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 612,
            'end' => 615,
            'note' => 'Se merce ADR, se presente, secondo numero ONU - Alfanumerico da 4',
        ],
        // 34
        [
            'field' => 'un_number_3',
            'it' => '3° NUMERO ONU',
            'description' => '3rd UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 616,
            'end' => 619,
            'note' => 'Se merce ADR, se presente, terzo numero ONU - Alfanumerico da 4',
        ],
        // 35
        [
            'field' => 'un_number_4',
            'it' => '4° NUMERO ONU',
            'description' => '4th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 620,
            'end' => 623,
            'note' => 'Se merce ADR, se presente, quarto numero ONU - Alfanumerico da 4',
        ],
        // 36
        [
            'field' => 'un_number_5',
            'it' => '5° NUMERO ONU',
            'description' => '5th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 624,
            'end' => 627,
            'note' => 'Se merce ARD, se presente, quinto numero ONU - Alfanumerico da 4',
        ],
        // 37
        [
            'field' => 'un_number_6',
            'it' => '6° NUMERO ONU',
            'description' => '6th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 628,
            'end' => 631,
            'note' => 'Se merce ADR, se presente, sesto numero ONU - Alfanumerico da 4',
        ],
        // 38
        [
            'field' => 'un_number_7',
            'it' => '7° NUMERO ONU',
            'description' => '7th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 632,
            'end' => 635,
            'note' => 'Se merce ADR, se presente, settimo numero ONU - Alfanumerico da 4',
        ],
        // 39
        [
            'field' => 'un_number_8',
            'it' => '8° NUMERO ONU',
            'description' => '8th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 636,
            'end' => 639,
            'note' => 'Se merce ADR, se presente, ottavo numero ONU - Alfanumerico da 4',
        ],
        // 40
        [
            'field' => 'un_number_9',
            'it' => '9° NUMERO ONU',
            'description' => '9th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 640,
            'end' => 643,
            'note' => 'Se merce ADR, se presente, nono numero ONU - Alfanumerico da 4',
        ],
        // 41
        [
            'field' => 'un_number_10',
            'it' => '10° NUMERO ONU',
            'description' => '10th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 644,
            'end' => 647,
            'note' => 'Se merce ADR, se presente, decimo numero ONU - Alfanumerico da 4',
        ],
        // 42
        [
            'field' => 'un_number_11',
            'it' => '11° NUMERO ONU',
            'description' => '11th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 648,
            'end' => 651,
            'note' => 'Se merce ADR, se presente, undicesimo numero ONU - Alfanumerico da 4',
        ],
        // 43
        [
            'field' => 'un_number_12',
            'it' => '12° NUMERO ONU',
            'description' => '12th UN Number',
            'type' => 'A',
            'length' => 4,
            'start' => 652,
            'end' => 655,
            'note' => 'Se merce ADR, se presente, dodicesimo numero ONU - Alfanumerico da 4',
        ],
        // 44
        [
            'field' => 'morning_opening_time',
            'it' => 'ORARIO APERTURA MATTINO',
            'description' => 'Morning Opening Time',
            'type' => 'N',
            'length' => 4,
            'start' => 656,
            'end' => 659,
            'note' => 'Numerico (oreminuti allineato a DX)',
        ],
        // 45
        [
            'field' => 'morning_closing_time',
            'it' => 'ORARIO CHIUSURA MATTINO',
            'description' => 'Morning Closing Time',
            'type' => 'N',
            'length' => 4,
            'start' => 660,
            'end' => 663,
            'note' => 'Numerico (oreminuti allineato a DX)',
        ],
        // 46
        [
            'field' => 'afternoon_opening_time',
            'it' => 'ORARIO APERTURA POMERIGGIO',
            'description' => 'Afternoon Opening Time',
            'type' => 'N',
            'length' => 4,
            'start' => 664,
            'end' => 667,
            'note' => 'Numerico (oreminuti allineato a DX)',
        ],
        // 47
        [
            'field' => 'afternoon_closing_time',
            'it' => 'ORARIO CHIUSURA POMERIGGIO',
            'description' => 'Afternoon Closing Time',
            'type' => 'N',
            'length' => 4,
            'start' => 668,
            'end' => 671,
            'note' => 'Numerico (oreminuti allineato a DX)',
        ],
        // 48
        [
            'field' => 'historic_center',
            'it' => 'CEBTRO STORICO',
            'description' => 'Historic Center',
            'type' => 'A',
            'length' => 1,
            'start' => 672,
            'end' => 672,
            'note' => '1=SI / BLANK=NO',
        ],
        // 49
        [
            'field' => 'additional_services',
            'it' => 'SERVIZI ACCESSORI',
            'description' => 'Additional Services',
            'type' => 'A',
            'length' => 2,
            'start' => 673,
            'end' => 674,
            'note' => 'VEDI TABELLA 4',
        ],
        // 50
        [
            'field' => 'delivery_floor',
            'it' => 'PIANO CONSEGNA',
            'description' => 'Delivery Floor',
            'type' => 'N',
            'length' => 1,
            'start' => 675,
            'end' => 675,
            'note' => 'NR.PIANO DI CONSEGNA (IN QUESTO CASO IMPOSTARE LA DISPOSIZIONE 1/2 CON RELATIVO SERVIZIO "CONSEGNA AL PIANO")',
        ],
    ];

    public function setField(string $field, string $value): self
    {
        $this->currentRecord[$field] = $value;

        return $this;
    }

    public function addRecord(): self
    {
        $this->data[] = $this->currentRecord;
        $this->currentRecord = [];

        return $this;
    }

    public function store(string $filename): self
    {
        $fileContent = $this->formatData();
        file_put_contents($filename, $fileContent);

        return $this;
    }

    public function content(): string
    {
        return $this->formatData();
    }

    private function formatData(): string
    {
        $formattedLines = [];
        // Find the max "end" position to know how long each line should be
        $maxEnd = max(array_column($this->structure, 'end'));

        foreach ($this->data as $record) {
            // Create a blank line of the appropriate length
            $line = str_repeat(' ', $maxEnd);

            // Fill each field at the correct position
            foreach ($this->structure as $fieldInfo) {
                $value = $record[$fieldInfo['field']] ?? '';
                // Pad or truncate to the exact field length
                $value = mb_str_pad($value, $fieldInfo['length'], ' ', STR_PAD_RIGHT);
                // Replace the substring in the line
                $line = substr_replace($line, $value, $fieldInfo['start'] - 1, $fieldInfo['length']);
            }

            $formattedLines[] = $line;
        }

        // Join lines with a newline character
        return implode("\n", $formattedLines)."\n";
    }
}
