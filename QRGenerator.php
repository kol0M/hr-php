<?php
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRGenerator {
    public static function generateQRCode($url, $filename): string
    {
        $qr = QrCode::create($url);
        $writer = new PngWriter();
        $result = $writer->write($qr);
        $outputFile = __DIR__ . '/temp/' . $filename;
        file_put_contents($outputFile, $result->getString());
        return $outputFile;
    }
}