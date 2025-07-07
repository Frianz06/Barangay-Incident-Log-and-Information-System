<?php
// Include FPDF library
require_once('../fpdf/fpdf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decode the JSON data sent from the frontend
    $data = json_decode($_POST['data'], true);

    // Initialize FPDF
    $pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Add a title to the PDF
    $pdf->Cell(0, 10, 'Pending Incidents Report Summary', 0, 1, 'C');
    $pdf->Ln(10);

    // Set column widths and headers
    $widths = [20, 40, 40, 60, 30, 30, 30];
    $headers = [
        'ID', 'Reporter Name', 'Incident Type', 'Location', 
        'Date', 'Time', 'Status'
    ];

    // Add table headers
    $pdf->SetFont('Arial', 'B', 10);
    foreach ($headers as $index => $header) {
        $pdf->Cell($widths[$index], 10, $header, 1);
    }
    $pdf->Ln();

    // Add table rows
    $pdf->SetFont('Arial', '', 10);
    foreach ($data as $row) {
        $pdf->Cell($widths[0], 10, $row[0], 1); // Incident ID
        $pdf->Cell($widths[1], 10, $row[1], 1); // Reporter Name
        $pdf->Cell($widths[2], 10, $row[2], 1); // Incident Type
        $pdf->Cell($widths[3], 10, $row[3], 1); // Location
        $pdf->Cell($widths[4], 10, $row[5], 1); // Date of Incident
        $pdf->Cell($widths[5], 10, $row[6], 1); // Time of Incident
        $pdf->Cell($widths[6], 10, $row[8], 1); // Status
        $pdf->Ln();
    }

    // Save the PDF file with a readable timestamp
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/reports_pdf/pending_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output('F', $filePath);

    // Return the file URL to the client
    $fileUrl = '/reports_pdf/pending_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    echo $fileUrl;

}
?>
