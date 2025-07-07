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
    $pdf->Cell(0, 10, 'Archived Incident Cases Report Summary', 0, 1, 'C');
    $pdf->Ln(10);

    // Set column widths and headers
    $widths = [20, 40, 40, 50, 70, 70]; // Adjusted for the remaining columns
    $headers = [
        'Incident ID', 'Reporter Name', 'Incident Type', 
        'Incident Location', 'Incident Description', 'Archived Description'
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
        $pdf->Cell($widths[0], 10, $row[0], 1, 0, 'C'); // Incident ID
        $pdf->Cell($widths[1], 10, $row[1], 1, 0, 'C'); // Reporter Name
        $pdf->Cell($widths[2], 10, $row[2], 1, 0, 'C'); // Incident Type
        $pdf->Cell($widths[3], 10, $row[3], 1, 0, 'C'); // Incident Location

        // Wrap long text for Incident Description
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell($widths[4], 10, $row[4], 1, 'L');
        $pdf->SetXY($x + $widths[4], $y);

        // Wrap long text for Archived Description
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell($widths[5], 10, $row[7], 1, 'L');
        $pdf->SetXY($x + $widths[5], $y);

        $pdf->Ln();
    }

    // Save the PDF file with a readable timestamp
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/reports_pdf/archive_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output('F', $filePath);

    // Return the file URL to the client
    $fileUrl = '/reports_pdf/archive_incidents/report_' . date('Y-m-d_H-i-s') . '.pdf';
    echo $fileUrl;
}
?>
