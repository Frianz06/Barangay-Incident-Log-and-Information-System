<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $gender = $_POST['gender'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_repassword = $_POST['user_repassword'];
    $user_address = $_POST['user_address'];

    $errors = [];

    // Validate form fields
    if (empty($user_name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($gender)) {
        $errors[] = 'Gender is required.';
    }

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

    if (empty($user_repassword)) {
        $errors[] = 'Re-type password is required.';
    }

    if (empty($user_address)) {
        $errors[] = 'Home Address is required.';
    }

    // Check if there are errors
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } else {
        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM user_table WHERE user_email = ?";
        $stmt = $db->prepare($checkEmailQuery);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="alert alert-danger mb-3">Email already exists. Please use a different email address.</div>';
        } else {
            // Check if password has been used before
            $checkPasswordQuery = "SELECT user_password FROM user_table";
            $stmt = $db->prepare($checkPasswordQuery);
            $stmt->execute();
            $result = $stmt->get_result();

            $passwordUsed = false;
            while ($row = $result->fetch_assoc()) {
                if (password_verify($user_password, $row['user_password'])) {
                    $passwordUsed = true;
                    break;
                }
            }

            if ($passwordUsed) {
                echo '<div class="alert alert-danger mb-3">This password has already been used. Please choose a different password.</div>';
            } else {
                // Check if passwords match
                if ($user_password !== $user_repassword) {
                    echo '<div class="alert alert-danger mb-3">Passwords do not match. Please ensure both entries are the same.</div>';
                    echo '<meta http-equiv="refresh" content="4">';
                } else {
                    // Secure password hashing
                    $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);

                    // Insert user data into the database
                    $stmt = $db->prepare("INSERT INTO user_table (user_name, gender, user_email, user_password, home_address) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $user_name, $gender, $user_email, $hashedPassword, $user_address);

                    if ($stmt->execute()) {
                        echo '<script>alert("You have successfully created an account!");</script>';
                        echo '<script>window.location.href = "../admin_dashboard.php";</script>';
                    } else {
                        echo '<script>alert("Error: Failed to create an account. Please try again.");</script>';
                        echo '<script>window.location.reload();</script>';
                    }
                }
            }
        }
    }
}

?>
