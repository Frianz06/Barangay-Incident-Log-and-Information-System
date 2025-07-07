<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];
    $admin_repassword = $_POST['admin_repassword'];

    $errors = [];

    // Validate form fields
    if (empty($admin_email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (empty($admin_password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($admin_password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($admin_password !== $admin_repassword) {
        $errors[] = 'Passwords do not match.';
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } 
    
    else {
        // Check if email exists and fetch the corresponding hashed password from the database
        $stmt = $db->prepare("SELECT admin_password FROM admin_table WHERE admin_email = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $db->error);
            echo '<div class="alert alert-danger mb-3">There was an error in the query.</div>';
            return;
        }

        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();  // Close the SELECT statement

        // Check if a hashed password was retrieved (i.e., email exists)
        if ($hashedPassword) {

            // Hash the new password
            $newHashedPassword = password_hash($admin_password, PASSWORD_DEFAULT);

            // Now update the old password with the new one in the database
            $update_stmt = $db->prepare("UPDATE admin_table SET admin_password = ? WHERE admin_email = ?");
            if (!$update_stmt) {
                error_log("Prepare failed for update: " . $db->error);
                echo '<div class="alert alert-danger mb-3">There was an error updating your password.</div>';
                return;
            }

            $update_stmt->bind_param("ss", $newHashedPassword, $admin_email);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                echo '<script>alert("Your password has been successfully reset.");</script>';
                echo '<script>window.location.href = "../admin_dashboard.php";</script>';
            } 
            
            else {
                echo '<div class="alert alert-danger mb-3">Error: Failed to reset your password. Please try again.</div>';
            }

            $update_stmt->close(); // Close the update statement
        }
        
        else {
            // If no password was found, the email doesn't exist in the database
            echo '<div class="alert alert-danger mb-3">No account found with this email.</div>';
        }
    }
}
?>