<?php
require 'user_config.php'; // Includes session_start()

// Destroy the session on the server
session_unset(); 
session_destroy(); 

// Redirect to the user login page
header('Location: ../user_log.php');
exit();
?>
