<?php
// Include FPDF library
require_once('../fpdf/fpdf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decode the JSON data sent from the frontend
    $data = json_decode($_POST['data'], true);

    // Initialize FPDF
    $pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation
    $pdf->SetMargins(5, 5, 5); // Adjust margins
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Add a title to the PDF
    $pdf->Cell(0, 10, 'Resolved Incidents Report Summary', 0, 1, 'C');
    $pdf->Ln(10);

    // Set column widths and headers
    $widths = [20, 30, 40, 70, 70, 50]; // Adjusted widths for better fitting
    $headers = [
        'Resolve ID', 'Incident ID', 'Resolved By Admin', 'Incident Description', 
        'Resolution Description', 'Date of Resolution'
    ];

    // Add table headers
    $pdf->SetFont('Arial', 'B', 10);
    foreach ($headers as $index => $header) {
        $pdf->Cell($widths[$index], 10, $header, 1, 0, 'C');
    }
    $pdf->Ln();

    // Add table rows
    $pdf->SetFont('Arial', '', 9); // Reduced font size
    foreach ($data as $row) {
        $pdf->Cell($widths[0], 10, $row[0], 1, 0, 'C'); // Resolve ID
        $pdf->Cell($widths[1], 10, $row[1], 1, 0, 'C'); // Incident ID
        $pdf->Cell($widths[2], 10, $row[2], 1, 0, 'C'); // Resolved By Admin
        
        // Wrap long text for Incident Description
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell($widths[3], 10, $row[3], 1, 'L');
        $pdf->SetXY($x + $widths[3], $y);

        // Wrap long text for Resolution Description
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell($widths[4], 10, $row[4], 1, 'L');
        $pdf->SetXY($x + $widths[4], $y);

        $pdf->Cell($widths[5], 10, $row[5], 1, 0, 'C'); // Date of Resolution
        $pdf->Ln();
    }

    // Save the PDF file with a readable timestamp
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/reports_pdf/resolve_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output('F', $filePath);

    // Return the file URL to the client
    $fileUrl = '/reports_pdf/resolve_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    echo $fileUrl;
}
?>
