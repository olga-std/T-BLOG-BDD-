<?php include("path.php"); 
  include(ROOT_PATH . "/app/controllers/users.php");
?>
<!DOCTYPE html>
<html lang="it">
  <head> 
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/ico" sizes="16x16" href="assets/imgtblog/icon.ico">
    <link rel="stylesheet" href="assets/css/style.css">

      <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

      <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <!-- Custom Script -->
    <script src="assets/js/scripts.js"></script>

    <title>Login  &#31; T&#8210;BLOG</title>
  </head>

  <body>
    <?php include(ROOT_PATH . "/app/includes/tblog_header.php"); ?>
    <div class="auth-content_item">
      <div class="auth-content">
        <form action="tblog_login.php" method="post">
          <h2 class="form-title">Login</h2>

          <?php include(ROOT_PATH . "/app/helpers/formErrors.php")?>
          
          <div>
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
          </div>
          <div>
            <label>Password</label>
            <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
          </div>
          <div>
            <button type="submit" name="login-btn" class="btn btn-big">Login</button>
          </div>
          <p>Oppure <a href="<?php echo BASE_URL . '/tblog_register.php' ?>">Registrati</a></p>
        </form>
      </div>
    </div>
    <?php include(ROOT_PATH . "/app/includes/tblog_footer.php") ?>
  </body>
</html>