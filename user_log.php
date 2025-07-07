<?php include 'includes/headers/header_user_log.php'?>


<style>
  body{
        background-image: url("../images/green.jpg");
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


<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card my-5">
        
        <form class="card-body p-lg-5 " method="POST">

        <h2 class="text-center text-dark">User Login Form</h2>

        <?php include 'includes/user_log_form.php'?>
          
          <div class="text-center">
            <img src="../images/user-pic.jpg" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px" alt="profile">
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-fill"></i></span>
            <input type="text" class="form-control" name="user_email" placeholder="Email" aria-label="Email" aria-describedby="Email">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" name="user_password" placeholder="Password" aria-label="Password" aria-describedby="Password">
          </div>
          
          <div class="text-center">
            <button type="submit" class="btn btn-primary px-5 mb-5 w-100">Login</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>


</body>
</html>