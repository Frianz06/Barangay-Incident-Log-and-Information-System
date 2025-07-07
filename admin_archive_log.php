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

// Start the base query
$statement = "SELECT * FROM archive_table WHERE 1=1";
$query = $db->query($statement);

?>

<div class="container py-5 mt-5 bg-dark text-white">

    <h3 class="text-center text-white">Archived Incident Case Table</h3>

        <!-- Generate PDF Button -->
        <div class="text-end mb-4">
        <button id="generatePdf" class="btn btn-danger">Generate PDF Report</button>
        </div>

    <!-- Archived Incident Log Table -->
    <div class="table-responsive">
        <table class="table table-light table-striped mt-4" id="archive_table">
            <thead class="table-dark">
                <tr>
                    <th>Incident_ID</th>
                    <th>Reporter Name</th>
                    <th>Incident Type</th>
                    <th>Incident Location</th>
                    <th>Incident Description</th>
                    <th>Date of Incident</th>
                    <th>Time of Incident</th>
                    <th>Time Reported</th>
                    <th class="text-center" style="width: 15%;">Archived Description</th>
                    <th>Time of Archived</th>
                </tr>
            </thead>
        
            <tbody>
        
            <?php 
            // Display the results in the table
            while ($row = $query->fetch_object()) {
                echo '<tr>
                <td>'.$row->incident_ID.'</td>
                <td>'.$row->user_name.'</td>
                <td>'.$row->incident_type.'</td>
                <td>'.$row->incident_location.'</td>
                <td>'.$row->incident_description.'</td>
                <td>'.$row->incident_date.'</td>
                <td>'.$row->incident_time.'</td>
                <td>'.$row->report_timestamp.'</td>
                <td>'.$row->archive_description.'</td>
                <td>'.$row->archive_time.'</td>
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
    $('#archive_table').DataTable();

    // Add click event for the "Generate PDF" button
    $('#generatePdf').on('click', function () {
        // Get filtered data from DataTable
        const tableData = $('#archive_table').DataTable().rows({ filter: 'applied' }).data().toArray();

        // Send the data to the server for PDF generation
        $.ajax({
            url: 'includes/report_gen_archive.php', // The PHP file handling the PDF generation
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
