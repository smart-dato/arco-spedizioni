<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Parsers;

use SmartDato\ArcoSpedizioni\Enums\TrackingEvent;

final class DdtEsitiParser
{
    private array $structure = [
        ['name' => 'R29NRB', 'type' => 'A', 'start' => 0, 'end' => 15, 'desc' => 'Numero Spedizione Arco'],
        ['name' => 'R29DTA', 'type' => 'S', 'start' => 15, 'end' => 23, 'desc' => 'Data Spedizione'],
        ['name' => 'R29CLI', 'type' => 'S', 'start' => 23, 'end' => 29, 'desc' => 'Codice Cliente'],
        ['name' => 'R29RFM', 'type' => 'A', 'start' => 29, 'end' => 44, 'desc' => 'Riferimento Mittente'],
        ['name' => 'R29RGD', 'type' => 'A', 'start' => 44, 'end' => 84, 'desc' => 'Ragione Sociale Destinatario'],
        ['name' => 'R29IND', 'type' => 'A', 'start' => 84, 'end' => 124, 'desc' => 'Indirizzo Destinatario'],
        ['name' => 'R29CAP', 'type' => 'A', 'start' => 124, 'end' => 129, 'desc' => 'CAP Destinatario'],
        ['name' => 'R29LCD', 'type' => 'A', 'start' => 129, 'end' => 169, 'desc' => 'Località Destinatario'],
        ['name' => 'R29PVD', 'type' => 'A', 'start' => 169, 'end' => 171, 'desc' => 'Provincia Destinatario'],
        ['name' => 'R29COL', 'type' => 'S', 'start' => 171, 'end' => 176, 'desc' => 'Numero Colli'],
        ['name' => 'R29PES', 'type' => 'S', 'start' => 176, 'end' => 183, 'decimals' => 1, 'desc' => 'Peso Spedizione'],
        [
            'name' => 'R29VOL', 'type' => 'S', 'start' => 183, 'end' => 188, 'decimals' => 2,
            'desc' => 'Volume Spedizione'
        ],
        ['name' => 'R29NGI', 'type' => 'A', 'start' => 188, 'end' => 201, 'desc' => 'Numero Giacenza'],
        ['name' => 'R29DGI', 'type' => 'A', 'start' => 201, 'end' => 381, 'desc' => 'Motivo Giacenza'],
        ['name' => 'R29DRG', 'type' => 'A', 'start' => 381, 'end' => 441, 'desc' => 'Descrizione Reso o Riconsegna'],
        [
            'name' => 'R29ROR', 'type' => 'A', 'start' => 441, 'end' => 456,
            'desc' => 'Riferimento Originale DDT Giacenza'
        ],
        ['name' => 'R29BOR', 'type' => 'A', 'start' => 456, 'end' => 471, 'desc' => 'Bolla Arco Originale Giacenza'],
        ['name' => 'R29DCE', 'type' => 'S', 'start' => 471, 'end' => 479, 'desc' => 'Data Evento'],
        ['name' => 'R29EVE', 'type' => 'A', 'start' => 479, 'end' => 499, 'desc' => 'Evento'],
        ['name' => 'R29POD', 'type' => 'S', 'start' => 499, 'end' => 507, 'desc' => 'Data Invio POD'],
        ['name' => 'R29FIL', 'type' => 'S', 'start' => 507, 'end' => 510, 'desc' => 'Codice Filiale Evento'],
        ['name' => 'R29NUC', 'type' => 'A', 'start' => 510, 'end' => 518, 'desc' => 'Numero Riferimento Cliente'],
        ['name' => 'R29LINK', 'type' => 'A', 'start' => 518, 'end' => 618, 'desc' => 'Link per Sito'],
    ];

    /**
     * @param  string  $line
     * @return array<string, TrackingEvent|string|float>
     */
    public function parseLine(string $line): array
    {
        $record = [];
        foreach ($this->structure as $field) {
            $value = mb_substr($line, $field['start'], $field['end'] - $field['start']);
            $rawValue = mb_trim($value);

            switch ($field['type']) {
                case 'S':
                    $numeric = mb_ltrim($rawValue, '0') ?: '0';
                    $decimals = $field['decimals'] ?? 0;
                    if ($decimals > 0) {
                        $numeric = mb_str_pad($numeric, $decimals + 1, '0', STR_PAD_LEFT);
                        $intPart = mb_substr($numeric, 0, -$decimals);
                        $decPart = mb_substr($numeric, -$decimals);
                        $record[$field['name']] = (float) ("{$intPart}.{$decPart}");
                    } else {
                        $record[$field['name']] = (float) $numeric;
                    }
                    break;

                case 'A':
                    $record[$field['name']] = $field['name'] === 'R29EVE'
                        ? TrackingEvent::fromLabel($rawValue)
                        : $rawValue;
                    break;

                default:
                    $record[$field['name']] = $rawValue;
            }
        }

        return $record;
    }

    /**
     * @param  string  $filePath
     * @return mixed
     */
    public function parseFile(string $filePath): array
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_map(fn($line) => $this->parseLine($line), $lines);
    }
}
