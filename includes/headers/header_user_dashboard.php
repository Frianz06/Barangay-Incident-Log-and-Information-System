<?php require_once 'includes/user_config.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/user_design.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
</head>
<body>

<header class="p-3 mb-3 border-bottom bg-dark">
  <div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <!-- Logo as an image instead of SVG -->
      <a href="user_dashboard.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img src="../images/LOGO2.png" alt="SF-LOGO" width="110" height="100">
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="user_dashboard.php" class="nav-link px-2 link-light">Home</a></li>
        <li><a href="user_report.php" class="nav-link px-2 link-light">Report Form</a></li>
      </ul>

      <div class="dropdown text-end">
        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="images/user-pic.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 34px, 0px);" data-popper-placement="bottom-start">
        <li><div class="dropdown-item"><?php echo $_SESSION['user_name'] ?></div></li>
        <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../includes/user_logout.php" id="userSignOut">Sign out</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>


<script defer>
    $(document).ready(function() {
        // jQuery code for sign out 
        $("#userSignOut").on("click", function(event) {
            event.preventDefault(); // Prevent the default action (navigation)
            
            // Show confirmation dialog
            let userConfirmed = confirm("Are you sure you want to sign out?");
            
            // If the user confirms, redirect to the link
            if (userConfirmed) {
                window.location.href = $(this).attr("href"); // Proceed to the href (logout page)
            }
        });
    });
</script>
