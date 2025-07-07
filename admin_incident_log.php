<?php 
include 'includes/headers/header_admin_main.php';


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
// Query to retrieve incidents
$statement = "SELECT * FROM incident_table WHERE 1=1";
$query = $db->query($statement);
?>

<div class="container py-5 mt-5 bg-dark text-white">
    <h3 class="text-center text-white">Pending Incidents Case Table</h3>

    <!-- Generate PDF Button -->
    <div class="text-end mb-4">
        <button id="generatePdf" class="btn btn-danger">Generate PDF Report</button>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-light table-striped mt-4" id="incident_table">
            <thead class="table-dark">
                <tr>
                    <th>Incident_ID</th>
                    <th>Reporter Name</th>
                    <th>Incident Type</th>
                    <th class="text-center" style="width: 15%;">Incident Location</th>
                    <th>Incident Description</th>
                    <th>Date of Incident</th>
                    <th>Time of Incident</th>
                    <th>Time Reported</th>
                    <th class="text-center" style="width: 15%;">Status</th>
                    <th class="text-center" style="width: 15%;">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php 
            // Display the results in the table
            while ($row = $query->fetch_object()) {
                $statusClass = '';
                if ($row->status === 'Urgent') {
                    $statusClass = 'text-danger'; // Red for urgent
                } 

                if ($row->status === 'Non-urgent') {
                    $statusClass = 'text-warning'; // Yellow for non-urgent
                }

                echo '<tr>
                <td>'.$row->incident_ID.'</td>
                <td>'.$row->user_name.'</td>
                <td>'.$row->incident_type.'</td>
                <td>'.$row->incident_location.'</td>
                <td>'.$row->incident_description.'</td>
                <td>'.$row->incident_date.'</td>
                <td>'.$row->incident_time.'</td>
                <td>'.$row->report_timestamp.'</td>
                <td class="'.$statusClass.'"> '.$row->status.'</td>
                <td class="text-center">
                    <div class="d-flex gap-2 justify-content-center">
                        <form action="includes/admin_resolve.php" method="GET" style="display:inline;">
                            <input type="hidden" name="incident_ID" value="'.$row->incident_ID.'">
                            <button type="submit" class="btn btn-success btn-sm">Resolve</button>
                        </form>

                        <form action="includes/admin_archive.php" method="GET" style="display:inline;">
                            <input type="hidden" name="incident_ID" value="'.$row->incident_ID.'">
                            <button type="submit" class="btn btn-danger btn-sm">Archive</button>
                        </form>
                    </div>
                </td>
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
    $('#incident_table').DataTable({
        responsive: true
    });

    // Add click event for the "Generate PDF" button
    $('#generatePdf').on('click', function () {
        // Get filtered data from DataTable
        const tableData = $('#incident_table').DataTable().rows({ filter: 'applied' }).data().toArray();

        // Send the data to the server for PDF generation
        $.ajax({
            url: 'includes/report_gen_incident.php', // The PHP file handling the PDF generation
            type: 'POST',                         // HTTP method for sending the data
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
