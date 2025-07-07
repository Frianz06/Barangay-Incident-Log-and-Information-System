<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $incident_ID = $_POST['incident_ID'];
    $resolution_description = $_POST['resolution_description'];
    $incident_description = $_POST['incident_description'];
    $resolution_date = date('Y-m-d H:i:s'); // Current date and time
    

    // Get the username from the session
    if (isset($_SESSION['admin_name'])) {
        $admin_name = $_SESSION['admin_name'];
    }

    $errors = [];

    // Validate form fields
    if (empty($incident_ID)) {
        $errors[] = 'Incident ID is required.';
    }

    if (empty($resolution_description)) {
        $errors[] = 'Description of the resolution is required.';
    } elseif (strlen($resolution_description) < 10) {
        $errors[] = 'Description must be at least 10 characters long.';
    }

    if (empty($resolution_date)) {
        $errors[] = 'Date of resolution is required.';
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
        // // Step 1: Insert into archive_table
        $stmt1 = $db->prepare("
        INSERT INTO archive_table 
        (incident_ID, user_name, gender, incident_location, incident_type, 
        incident_description, incident_date, incident_time, report_timestamp, archive_description) 
        SELECT incident_ID, user_name, gender, incident_location, incident_type, 
        incident_description, incident_date, incident_time, report_timestamp, 'resolved'
        FROM incident_table WHERE incident_ID = ?
        ");
        $stmt1->bind_param("i", $incident_ID);
        $stmt1->execute();
        

        // Check if the insertion into archive_table was successful
        if ($stmt1->affected_rows === 0) {
            throw new Exception('Failed to archive the incident. Incident ID not found.');
        }

        // Savepoint after successfully archiving
        $db->commit(); 

        $stmt2 = $db->prepare("
        INSERT INTO resolve_table 
        (incident_ID, resolved_by_admin, incident_description, resolution_description, date_of_resolution) 
        VALUES (?, ?, ?, ?, ?)
        ");
        
        // Assign incident_description directly from the fetched data
        $incident_description = $incident['incident_description'];
        
        // Bind parameters and execute the query
        $stmt2->bind_param("issss", $incident_ID, $admin_name, $incident_description, $resolution_description, $resolution_date);
        if (!$stmt2->execute()) {
            throw new Exception("Failed to insert into resolve_table: " . $stmt2->error);
        }
        
        // Debugging: Check affected rows
        if ($stmt2->affected_rows === 0) {
            throw new Exception("No rows were inserted into resolve_table.");
        }
        

        // Savepoint after successfully inserting resolution
        $db->commit(); 

        // Step 3: Delete from incident_table
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
        echo '<div class="alert alert-success">Incident resolved and archived successfully!</div>';

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