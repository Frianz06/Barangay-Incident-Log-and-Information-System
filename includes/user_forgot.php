<?php include '../includes/headers/header_user_main1.php';

if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
  echo '
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
      <div class="text-center">
          <h1 class="text-danger">Error: Admin is not logged in.</h1>
          <p class="text-secondary">You will be redirected to the login page shortly.</p>
      </div>
  </div>
  <meta http-equiv="refresh" content="4;url=../admin_log.php">';
  exit;
}

?>
<link rel="stylesheet" href="../includes/log_style.css">


<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card my-5">
        
        <form class="card-body cardbody-color p-lg-5" style="background-color: #ebf2fa;" method="POST">

        <h2 class="text-center text-dark">User Reset Password</h2>

        <?php include 'user_forgot_form.php'?>
           
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-fill"></i></span>
            <input type="text" class="form-control" name="user_email" placeholder="Email" aria-label="Email" aria-describedby="Email" required>
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" name="user_password" placeholder="Password" aria-label="Password" aria-describedby="Password" required>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" name="user_repassword" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="Confirm Password" required>
          </div>
          
          <div class="text-center">
            <button type="submit" class="btn btn-danger px-5 mb-5 w-100">Reset Password</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>


</body>
</html>