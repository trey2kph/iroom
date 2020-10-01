<?php

    $part = $_GET['part'];
    $from = $_GET['from'];
    $to = $_GET['to'];

    if ($part == 'summary') {
        $rescount_dept = $main->get_rescount_dept(($from ? $from : date('Y-m-d', strtotime('last month'))), ($to ? $to : date('Y-m-d')));
        $rescount_room = $main->get_rescount_room(($from ? $from : date('Y-m-d', strtotime('last month'))), ($to ? $to : date('Y-m-d')));
    } else {    
        $reservation = $main->get_reservations(0, 0, 0, 0, 0, 0, $searchres, 0, 0, ($from ? $from : date('Y-m-d', strtotime('last month'))), ($to ? $to : date('Y-m-d')));
    }
    // get the HTML
    ob_start();

    include(TEMP.'/reservation_report.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once(DOCUMENT.'/lib/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF($part == 'summary' ? 'P' : 'L', 'Letter', 'en');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('reservation_report.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>