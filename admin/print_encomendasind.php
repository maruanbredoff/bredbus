<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
try {
    ob_start();
    include dirname(__FILE__).'/pdf_encomenda_ind.php';
    $content = ob_get_clean();
    $html2pdf = new Html2Pdf('P', 'A6', 'pt');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
ob_end_clean();
    $html2pdf->output('encomendas.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>