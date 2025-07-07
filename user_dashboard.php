
<?php
include 'includes/headers/header_user_dashboard.php';

// Validate session
if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    echo '
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="text-center">
            <h1 class="text-danger">Error: User is not logged in.</h1>
            <p class="text-secondary">You will be redirected to the login page shortly.</p>
        </div>
    </div>
    <meta http-equiv="refresh" content="4;url=../user_log.php">';
    exit;
}

$id = $_SESSION['user_name'];

try {
    // Use prepared statements to filter incidents by user
    $stmt = $db->prepare("SELECT * FROM incident_table WHERE user_name = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    echo "Error fetching incidents: " . $e->getMessage();
    exit;
}
?>

<div class="container py-5 mt-5 bg-dark text-white">
    
    <h3 class="text-center text-white"><?php echo htmlspecialchars($_SESSION['user_name']); ?>'s Reported Incident Table</h3>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-light table-striped mt-4" id="incident_table">
            <thead class="table-dark">
                <tr>
                     <!--class=d-none lang dinagdag ko para matago ang ID at NAME-->
                    <th>Incident Type</th>
                    <th class="text-center" style="width: 15%;">Incident Location</th>
                    <th>Incident Description</th>
                    <th>Date of Incident</th>
                    <th>Time of Incident</th>
                    <th>Time Reported</th>
                    <th class="text-center" style="width: 15%;">Status</th>
                </tr>
            </thead>
            
            <tbody>
            <?php 
            // Display the results in the table
            while ($row = $result->fetch_object()) {

                $statusClass = '';
                if ($row->status === 'Urgent') {
                $statusClass = 'text-danger'; // Red for urgent
                } 

                elseif ($row->status === 'Non-urgent') {
                $statusClass = 'text-warning'; // Yellow for non-urgent
                }   

                //class=d-none lang dinagdag ko para matago ang ID at NAME
                echo '<tr>
                <td>'.htmlspecialchars($row->incident_type).'</td>
                <td>'.htmlspecialchars($row->incident_location).'</td>
                <td>'.htmlspecialchars($row->incident_description).'</td>
                <td>'.htmlspecialchars($row->incident_date).'</td>
                <td>'.htmlspecialchars($row->incident_time).'</td>
                <td>'.$row->report_timestamp.'</td>
                <td class="'.$statusClass.'">'.htmlspecialchars($row->status).'</td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#incident_table').DataTable(); // Initialize DataTable
});
</script>

</body>
</html>
