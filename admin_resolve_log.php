<?php include 'includes/headers/header_admin_main.php'; 

if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
    echo '
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="text-center">
            <h1 class="text-danger">Error: Admin is not logged in.</h1>
            <p class="text-secondary">You will be redirected to the login page shortly.</p>
        </div>
    </div>
    <meta http-equiv="refresh" content="4;url=../admin_log.php">';
    exit;
}

// Query to retrieve resolved incidents
$statement = "SELECT * FROM resolve_table WHERE 1=1";
$query = $db->query($statement);
?>

<div class="container py-5 mt-5 bg-dark text-white">
    <h3 class="text-center text-white">Resolved Incidents Case Table</h3>

    <!-- Generate PDF Button -->
    <div class="text-end mb-4">
        <button id="generatePdf" class="btn btn-danger">Generate PDF Report</button>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-light table-striped mt-4" id="resolve_table">
            <thead class="table-dark">
                <tr>
                    <th>resolve_ID</th>
                    <th>Incident_ID</th>
                    <th>Resolved By Admin</th>
                    <th>Incident Description</th>
                    <th>Resolution Description</th>
                    <th>Date of Resolution</th>
                </tr>
            </thead>

            <tbody>
            <?php
            // Display the results in the table
            while ($row = $query->fetch_object()) {
                echo '<tr>
                <td>'.$row->resolve_ID.'</td>
                <td>'.$row->incident_ID.'</td>
                <td>'.$row->resolved_by_admin.'</td>
                <td>'.$row->incident_description.'</td>
                <td>'.$row->resolution_description.'</td>
                <td>'.$row->date_of_resolution.'</td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#resolve_table').DataTable();

    // Add click event for the "Generate PDF" button
    $('#generatePdf').on('click', function () {
        // Get filtered data from DataTable
        const tableData = $('#resolve_table').DataTable().rows({ filter: 'applied' }).data().toArray();

        // Send the data to the server for PDF generation
        $.ajax({
            url: 'includes/report_gen_resolve.php', // The PHP file handling the PDF generation
            type: 'POST',
            data: { 
                data: JSON.stringify(tableData)   // Send the table data as a JSON string
            },
            success: function (response) {
                // On success, open the PDF file in a new tab
                if (response) {
                    window.open(response, '_blank'); // Open the returned file URL
                } else {
                    alert('Failed to generate the PDF report. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                // Log errors to the console
                console.error('Error generating PDF:', error);
                alert('An error occurred while generating the PDF. Please check the console for details.');
            }
        });
    });
});
</script>

</body>
</html>
