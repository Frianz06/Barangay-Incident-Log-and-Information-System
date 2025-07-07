<?php require_once '../includes/admin_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/admin_design.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<header class="p-3 mb-3 border-bottom bg-dark">
  <div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <!-- Logo -->
      <a href="admin_dashboard.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img src="../images/LOGO2.png" alt="SF-LOGO" width="110" height="100">
      </a>

      <!-- Navigation -->
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="../admin_dashboard.php" class="nav-link px-2 link-light">Overview</a></li>
        
        <!-- Dropdown for Incident Tables -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle link-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Incident Tables
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admin_incident_log.php">Incident Log</a></li>
            <li><a class="dropdown-item" href="admin_resolve_log.php">Resolved Log</a></li>
            <li><a class="dropdown-item" href="admin_archive_log.php">Archived Log</a></li>
          </ul>
        </li>
      </ul>

      <!-- Profile Dropdown -->
      <div class="dropdown text-end">
        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../images/admin-pic.jpg" alt="Admin" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small">
          <li><a class="dropdown-item" href="user_register.php">User Creation</a></li>
          <li><a class="dropdown-item" href="user_forgot.php">User Change Password</a></li>
          <li><a class="dropdown-item" href="admin_register.php">Admin Creation</a></li>
          <li><a class="dropdown-item" href="admin_forgot.php">Admin Change Password</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><div class="dropdown-item"><?php echo $_SESSION['admin_name']; ?></div></li>
          <li><a class="dropdown-item" href="../includes/admin_logout.php" id="adminSignOut">Sign out</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>

<!-- Sign-out Function -->
<script defer>
    $(document).ready(function() {
        $("#adminSignOut").on("click", function(event) {
            event.preventDefault(); 
            let userConfirmed = confirm("Are you sure you want to sign out?");
            if (userConfirmed) {
                window.location.href = $(this).attr("href");
            }
        });
    });
</script>
</body>
</html>
