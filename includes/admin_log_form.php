<?php 

if(isset($_SESSION['admin_name'])){
  header("Location: admin_dashboard.php");
  exit();
}

?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = htmlspecialchars($_POST['admin_email'], ENT_QUOTES, 'UTF-8');
    $admin_password = $_POST['admin_password'];

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

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger mb-3">' . $error . '</div>';
        }
    } 

    else {
        // Check if the email exists and retrieve both the hashed password and the admin's name from the database
        // Prepare the SQL query to select both admin_password and admin_name based on the provided email.
        $stmt = $db->prepare("SELECT admin_password, admin_name FROM admin_table WHERE admin_email = ?");

        // Bind the admin email parameter to the query (type 's' for string).
        $stmt->bind_param("s", $admin_email);

        // Execute the prepared statement (run the query with the provided email).
        $stmt->execute();

        // Bind the result variables ($hashedPassword and $admin_name) to the corresponding columns in the result set.
        $stmt->bind_result($hashedPassword, $admin_name);

        // Fetch the result of the query (this will retrieve one row).
        $stmt->fetch();

        // Check if a hashed password was retrieved and also the admin's name (i.e., email exists)
        if ($hashedPassword) {

            // Verify the provided password against the hashed password from the database
            if (password_verify($admin_password, $hashedPassword)) {
                // Password is correct, log the user in

                $_SESSION['admin_name'] = $admin_name; // Set session variable

                echo '<div class="alert alert-warning">Welcome '.$admin_name.'!</div>';
                echo '<meta http-equiv="refresh" content="3;url=admin_dashboard.php">'; // Redirect to dashboard or appropriate page
            } 

            else {
                // Password is incorrect
                echo '<div class="alert alert-danger mb-3">Invalid password. Please try again.</div>';
                echo '<meta http-equiv="refresh" content="3">';
            }
        } 

        else {
            // If no password was found, the email doesn't exist in the database
            echo '<div class="alert alert-danger mb-3">No account found with this email.</div>';
            echo '<meta http-equiv="refresh" content="3">';
        }

        $stmt->close(); // Always close the prepared statement
    }
}
?>

