<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $gender = $_POST['gender'];
    $incident_location = $_POST['incident_location'];
    $incident_types = $_POST['incident_types'];
    $incident_description = $_POST['incident_description'];
    $incident_date = $_POST['incident_date'];
    $incident_time = $_POST['incident_time'];

    // Check for "Other" option
    if ($incident_types === 'Other') {
        $incident_types = $_POST['other']; // Use the "Other" input value
    }

    // Get the username from the session
    if (isset($_SESSION['user_name'])) {
        $user_name = $_SESSION['user_name'];
    }

    $errors = [];

    // Validate form fields
    if (empty($gender)) {
        $errors[] = 'Gender is required.';
    }

    if (empty($incident_location)) {
        $errors[] = 'Location of incident is required.';
    }

    if (empty($incident_types)) {
        $errors[] = 'Incident type is required.';
    }

    if (empty($incident_description)) {
        $errors[] = 'Description of the incident is required.';
    } elseif (strlen($incident_description) < 10) {
        $errors[] = 'Description must be at least 10 characters long.';
    }

    if (empty($incident_date)) {
        $errors[] = 'Date of incident is required.';
    }

    if (empty($incident_time)) {
        $errors[] = 'Time of incident is required.';
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } else { 
        // Use prepared statements to prevent SQL Injection
        $stmt = $db->prepare("INSERT INTO incident_table (user_name, `status`, gender, incident_location, incident_type, incident_description, incident_date, incident_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("ssssssss", $user_name, $status, $gender, $incident_location, $incident_types, $incident_description, $incident_date, $incident_time); 

        // Execute the query
        if ($stmt->execute()) {
            echo '<div class="alert alert-warning">'.$user_name.' has successfully filed an incident!</div>';
            echo '<meta http-equiv="refresh" content="3;url=user_dashboard.php">';
        } else {
            echo '<script>alert("Error: Failed to file a report. Please try again.");</script>';
            echo '<script>window.location.reload();</script>'; 
        }

        // Close the statement
        $stmt->close();
    }
}
?>
