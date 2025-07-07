<?php
require 'admin_config.php'; // Includes session_start()

// Destroy the session on the server
session_unset(); 
session_destroy(); 

// Redirect to the admin login page
header('Location: ../admin_log.php');
exit();
?>
