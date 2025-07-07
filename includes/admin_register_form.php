<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];
    $admin_repassword = $_POST['admin_repassword'];
    $brgy_role = $_POST['brgy_role'];

    $errors = [];

    // Validate form fields
    if (empty($admin_name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($admin_email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($admin_password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($admin_password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if (empty($admin_repassword)) {
        $errors[] = 'Re-type password is required.';
    }

    if (empty($brgy_role)) {
        $errors[] = 'Barangay Role is required.';
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } 

    else {
        // Check if passwords match directly
        if ($admin_password !== $admin_repassword) {
            $errors[] = 'Passwords do not match. Please ensure both entries are the same.';

            foreach ($errors as $error) {
                echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
                echo '<meta http-equiv="refresh" content="4">';
                }
        } 

        else {
            // Secure password hashing
            $hashedPassword = password_hash($admin_password, PASSWORD_DEFAULT);
            
            // Use prepared statements to prevent SQL Injection
            $stmt = $db->prepare("INSERT INTO admin_table (admin_name, admin_email, admin_password, brgy_role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $admin_name, $admin_email, $hashedPassword, $brgy_role);
            
            if ($stmt->execute()) {
                echo '<script>alert("You have successfully created an account!");</script>';
                echo '<script>window.location.href = "../admin_dashboard.php";</script>';
            } 
            
            else {
                echo '<script>alert("Error: Failed to create an account. Please try again.");</script>';
                echo '<script>window.location.reload();</script>'; 
            }
        }
    }
}

?>