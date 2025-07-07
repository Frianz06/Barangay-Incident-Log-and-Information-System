<?php
    mysqli_report(MYSQLI_REPORT_OFF); // Disable default error reporting

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'brgy_san_francisco'; // Database Name

    // Create connection
    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if ($db->connect_errno) {
        echo 'Connection failed: ' . $db->connect_error;
    } 
    // leave it as a comment
    // else {
    //     echo 'Connection established';
    // }

    session_name("user_session");
    session_start();
?>
