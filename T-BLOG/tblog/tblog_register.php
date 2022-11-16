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

    <title>Register  &#31; T&#8210;BLOG</title>
  </head>
  <body>
    <?php include(ROOT_PATH . "/app/includes/tblog_header.php")?>

    <div class="auth-content">
      <form action="tblog_register.php" method="post">
        <h2 class="form-title">Registrati su T-BLOG</h2>
        <p>Crea un profilo, pubblica i tuoi articoli, metti &#128153; ai post preferiti e altro ancora.</p>
        
        <?php include(ROOT_PATH . "/app/helpers/formErrors.php")?>
        
        <div>
          <label>Username</label>
          <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
        </div>
        <div>
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>" class="text-input">
        </div>
        <div>
          <label>Telefono</label>
          <input type="text" name="phone" value="<?php echo $phone; ?>" class="text-input">
        </div>
        <div>
          <label>Password</label>
          <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
        </div>
        <div>
          <label>Conferma Password</label>
          <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
        </div>
        <div>
          <button type="submit" name="register-btn" class="btn btn-big">Registrati</button>
        </div>
        <p>Oppure <a href="<?php echo BASE_URL . '/tblog_login.php' ?>">Entra nel tuo profilo</a></p>
      </form>
    </div>
    <?php include(ROOT_PATH . "/app/includes/tblog_footer.php") ?>
  </body>
</html>