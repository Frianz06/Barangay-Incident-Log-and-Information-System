<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_repassword = $_POST['user_repassword'];

    $errors = [];

    // Validate form fields
    if (empty($user_email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (empty($user_password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($user_password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $user_password)) {
        $errors[] = 'Password must include at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $user_password)) {
        $errors[] = 'Password must include at least one lowercase letter.';
    }

    if ($user_password !== $user_repassword) {
        $errors[] = 'Passwords do not match.';
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } else {
        // Check if email exists in the database
        $stmt = $db->prepare("SELECT user_password FROM user_table WHERE user_email = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $db->error);
            echo '<div class="alert alert-danger mb-3">There was an error in the query.</div>';
            return;
        }

        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $stmt->bind_result($currentHashedPassword);
        $stmt->fetch();
        $stmt->close(); // Close the SELECT statement

        if ($currentHashedPassword) {
            // Check if the new password matches any previous password
            $passwordReuse = false;

            $checkPasswordQuery = "SELECT user_password FROM user_table";
            $checkStmt = $db->prepare($checkPasswordQuery);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            while ($row = $result->fetch_assoc()) {
                if (password_verify($user_password, $row['user_password'])) {
                    $passwordReuse = true;
                    break;
                }
            }

            if ($passwordReuse) {
                echo '<div class="alert alert-danger mb-3">This password has already been used. Please choose a different password.</div>';
            } else {
                // Hash the new password
                $newHashedPassword = password_hash($user_password, PASSWORD_DEFAULT);

                // Update the old password with the new one
                $update_stmt = $db->prepare("UPDATE user_table SET user_password = ? WHERE user_email = ?");
                if (!$update_stmt) {
                    error_log("Prepare failed for update: " . $db->error);
                    echo '<div class="alert alert-danger mb-3">There was an error updating your password.</div>';
                    return;
                }

                $update_stmt->bind_param("ss", $newHashedPassword, $user_email);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    echo '<script>alert("Your password has been successfully reset.");</script>';
                    echo '<script>window.location.href = "../admin_dashboard.php";</script>';
                } else {
                    echo '<div class="alert alert-danger mb-3">Error: Failed to reset your password. Please try again.</div>';
                }

                $update_stmt->close(); // Close the update statement
            }
        } else {
            echo '<div class="alert alert-danger mb-3">No account found with this email.</div>';
        }
    }
}
?>
