<?php

namespace App\Services;

use Mpdf\Mpdf;

class PdfService
{
    public function generate(
        string $view,
        array $data,
        string $filename,
        array $meta = []
    ) {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 30,
            'margin_bottom' => 20,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $mpdf->SetTitle($meta['title'] ?? 'Documento');
        $mpdf->SetAuthor($meta['author'] ?? config('app.name'));
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->simpleTables = true;
        $mpdf->packTableData = true;

        $now = now();

        $mpdf->SetHTMLHeader('
            <div style="border-bottom:2px solid #9ca3af; padding-bottom:5px;">
                <div style="text-align:center; font-weight:bold; font-size:14px;">
                    ' . config('app.name') . '
                </div>
                <div style="font-size:13px; font-weight:bold; margin-top:3px;">
                    ' . ($meta['title'] ?? 'Reporte') . '
                </div>
                <div style="font-size:11px; color:#6b7280;">
                    Fecha de emisión: ' . $now->format('d/m/Y H:i:s') . '
                </div>
            </div>
        ');

        $mpdf->SetHTMLFooter('
            <div style="text-align:center; font-size:11px; border-top:1px solid #9ca3af; padding-top:5px;">
                Página {PAGENO} de {nbpg}
            </div>
        ');

        $html = view($view, $data)->render();

        $mpdf->WriteHTML($html);

        return response()->streamDownload(
            fn () => print($mpdf->Output('', 'S')),
            $filename . '_' . $now->format('d-m-Y_H-i-s') . '.pdf'
        );
    }
}
