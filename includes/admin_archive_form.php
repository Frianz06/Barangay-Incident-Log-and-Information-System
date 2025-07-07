<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $incident_ID = $_POST['incident_ID'];
    $archive_description = $_POST['archive_description'];
    $incident_description = $_POST['incident_description'];
    $archive_date = date('Y-m-d H:i:s'); // Current date and time
    

    // Get the username from the session
    if (isset($_SESSION['admin_name'])) {
        $admin_name = $_SESSION['admin_name'];
    }

    $errors = [];

    // Validate form fields
    if (empty($incident_ID)) {
        $errors[] = 'Incident ID is required.';
    }

    if (empty($archive_description)) {
        $errors[] = 'Reason of archive is required.';
    } elseif (strlen($archive_description) < 10) {
        $errors[] = 'Description must be at least 10 characters long.';
    }

    if (empty($archive_date)) {
        $errors[] = 'Date of archive is required.';
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } else { 

        // Start a transaction
        $db->autocommit(false);

        try {
            // Step 1: Insert into archive_table
            $stmt1 = $db->prepare("
            INSERT INTO archive_table 
            (incident_ID, user_name, gender, incident_location, incident_type, 
            incident_description, incident_date, incident_time, report_timestamp, archive_description) 
            SELECT incident_ID, user_name, gender, incident_location, incident_type, 
            incident_description, incident_date, incident_time, report_timestamp, ? 
            FROM incident_table WHERE incident_ID = ?
            ");
            $stmt1->bind_param("si", $archive_description, $incident_ID); // Bind both archive_description and incident_ID
            $stmt1->execute();


        // Check if the insertion into archive_table was successful
        if ($stmt1->affected_rows === 0) {
            throw new Exception('Failed to archive the incident. Incident ID not found.');
        }

        // Savepoint after successfully archiving
        $db->commit(); 

        // Step 2: Delete from incident_table
        $stmt3 = $db->prepare("DELETE FROM incident_table WHERE incident_ID = ?");
        $stmt3->bind_param("i", $incident_ID);
        $stmt3->execute();

        // Check if the deletion from incident_table was successful
        if ($stmt3->affected_rows === 0) {
            throw new Exception('Failed to delete the incident from the incident table.');
            }

        // Final commit after successfully deleting the incident
        $db->commit(); 

        // Success message
        echo '<div class="alert alert-success">Incident archived successfully!</div>';

        } 
        catch (Exception $e) {
        // Rollback the transaction if any step fails
        $db->rollback();
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        echo '<meta http-equiv="refresh" content="3">';

    } 
        finally {
        // Turn autocommit back on
        $db->autocommit(true);
         echo '<meta http-equiv="refresh" content="3;url=../admin_incident_log.php">';
        }

    }

}

?>