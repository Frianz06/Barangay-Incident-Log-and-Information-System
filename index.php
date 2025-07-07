<?php include 'includes/headers/header.php'?>
<?php include 'includes/welcome_modal.php'?>

<style>
  body{
        background-image: url("../images/brgy.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover; 

    }

    .card{
      background: rgba( 255, 255, 255, 0.2 );
      box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
      backdrop-filter: blur( 4px );
      -webkit-backdrop-filter: blur( 4px );
      border-radius: 10px;
      border: 1px solid rgba( 255, 255, 255, 0.18 );
    }
</style>


<div class="container-md mt-5"> 
<link rel="stylesheet" href="../css/design.css">
  

  <div class="row justify-content-center">

    <!-- 1st Card -->
    <div class="col-md-3 mx-3">

      <div class="card" style="width: 18rem;">

        <img src="../images/user-pic.jpg" class="card-img-top pic" alt="Profile Photo">

        <div class="card-body" >

          <h5 class="card-title">Residential</h5>
          <p class="card-text fw-bold">Access the platform to report incidents within your barangay.</p>

          <a href="user_log.php" class="btn btn-primary">Residential Login</a>

        </div>

      </div>

    </div>

    <!-- 2nd Card -->
    <div class="col-md-3 mx-3">

      <div class="card" style="width: 18rem;">

        <img src="../images/admin-pic.jpg" class="card-img-top" alt="Profile Photo">

        <div class="card-body">

          <h5 class="card-title"> Barangay Admin</h5>
          <p class="card-text fw-bold">Oversee and manage incident reports with ease</p>

          <a href="admin_log.php" class="btn btn-danger">Admin Login</a>
          
        </div>

      </div>

    </div>

  </div> 

</div> 


</body>
</html>