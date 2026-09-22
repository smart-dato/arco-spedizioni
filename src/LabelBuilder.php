<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni;

use Dompdf\Dompdf;

final class LabelBuilder
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function zpl(array $data): string
    {
        return view('arco-spedizioni-sdk::zpl', $data)->render();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function pdf(array $data): string
    {
        // Load HTML
        $html = view('arco-spedizioni-sdk::pdf', $data)->render();

        $dompdf = new Dompdf();

        // Define custom paper size in points.
        // 1 cm ≈ 28.3465 points
        // 10 cm = 283.465 points, 9.5 cm = 269.292 points
        $width = 283.465;  // 10 cm in points
        $height = 269.292;  // 9.5 cm in points
        $dompdf->setPaper([0, 0, $width, $height]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }
}
