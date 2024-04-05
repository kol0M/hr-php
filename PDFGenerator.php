<?php
require 'vendor/autoload.php';

use TCPDF as TCPDF;

class PDFGenerator {
    public static function generatePDF($qrImagePath, $content, $filename): string
    {

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('mkolodziejski');
        $pdf->SetTitle('Hr QR PDF');
        $pdf->SetSubject('Hr PDF');
        $pdf->SetKeywords('PDF, HR');
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->Image($qrImagePath, 15, 15, 60, 0, 'PNG');

        // fix justifying on PDF
        $x = 15;
        $y = 80;

        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $pdf->SetXY($x, $y);
            $pdf->Cell(0, 10, $line, 0, 1, 'L', false);
            $y += 10;
        }
        // end of fix

        $outputFile = __DIR__ . '/public/' . $filename;
        $pdf->Output($outputFile, 'F');
        return $outputFile;
    }
}