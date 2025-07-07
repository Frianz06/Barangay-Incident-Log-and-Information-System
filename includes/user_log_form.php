<?php 

if (isset($_SESSION['user_name'])) {
    header("Location: user_dashboard.php");
    exit();
}

?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Apply htmlspecialchars() to prevent XSS (Cross-Site Scripting)
    $user_email = htmlspecialchars($_POST['user_email'], ENT_QUOTES, 'UTF-8');
    $user_password = $_POST['user_password'];

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
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } else {
        // Check if email exists and fetch the corresponding hashed password and other user details
        $stmt = $db->prepare("SELECT user_ID, user_password, user_name, gender FROM user_table WHERE user_email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $stmt->bind_result($user_ID, $hashedPassword, $user_name, $gender);
        $stmt->fetch();

        // Check if a hashed password was retrieved (i.e., email exists)
        if ($hashedPassword) {

            // Verify the provided password against the hashed password from the database
            if (password_verify($user_password, $hashedPassword)) {
                // Password is correct, log the user in
                $_SESSION['user_ID'] = $user_ID; // Store user ID in session
                $_SESSION['user_name'] = $user_name;
                $_SESSION['gender'] = $gender;

                echo '<div class="alert alert-warning">Welcome ' . htmlspecialchars($user_name) . '!</div>';
                echo '<meta http-equiv="refresh" content="3;url=user_dashboard.php">';
            } else {
                // Password is incorrect
                echo '<div class="alert alert-danger mb-3">Invalid password. Please try again.</div>';
                echo '<meta http-equiv="refresh" content="3">';
            }
        } else {
            // If no password was found, the email doesn't exist in the database
            echo '<div class="alert alert-danger mb-3">No account found with this email.</div>';
        }

        $stmt->close(); // Always close the prepared statement
    }
}
?>
