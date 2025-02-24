<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni;

use Dompdf\Dompdf;
use RuntimeException;

final class LabelBuilder
{
    public function make(array $data): string
    {
        // Load HTML
        $html = view('arco-spedizioni-sdk::label', $data)->render();

        $dompdf = new Dompdf();

        // Define custom paper size in points.
        // 1 cm ≈ 28.3465 points
        // 10 cm = 283.465 points, 9.5 cm = 269.292 points
        $width = 283.465;  // 10 cm in points
        $height = 269.292;  // 9.5 cm in points
        $dompdf->setPaper([0, 0, $width, $height]);

        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdf = $dompdf->output();

        if ($pdf === null) {
            throw new RuntimeException('Error while generating PDF');
        }

        return $pdf;
    }
}
