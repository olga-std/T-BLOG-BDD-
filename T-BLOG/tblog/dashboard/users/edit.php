<?php include("../../path.php");
    include(ROOT_PATH . "/app/controllers/users.php");
    adminsOnly();
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/ico" sizes="16x16" href="../../assets/imgtblog/icon.ico">
        
            <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

            <!-- Custom Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">

            <!--JQuery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
        
        <title>Editor_users  &#31; T&#8210;BLOG</title>
    </head>
    <body>        
        <?php include(ROOT_PATH . "/app/includes/dashboard_header.php");?>

            <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            <?php include(ROOT_PATH . "/app/includes/left_sidebar.php");?>
            
                <!-- Admin Content -->
            <div class="admin-content">
            <div class="button-group">
                <a href="create.php" class="btn btn-big">Inserire Utente</a>
                <a href="index.php" class="btn btn-big">Gestire Utenti</a>
            </div>

            <div class="content">
                <h2 class="page-title">Modifica Profilo</h2>
                <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                <?php if ($_SESSION['id'] == $id): ?>
                    <form action="edit.php?id=<?php echo $user['id']; ?>" method="post">
                            <!--id non si cambia nella modifica -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                            <?php if (isset($admin_users) && $admin == 1): ?>
                                <label>
                                    <input type="hidden" name="admin"  checked>Admin
                                </label>
                            <?php endif; ?>
                        </div>
                        <div>
                            <button type="submit" name="update-user" class="btn btn-big">Modifica Profilo</button>
                        </div>
                    </form>
                <?php endif; ?>
                <?php if(empty($errors) && ($_SESSION['id'] != $id)): ?>
                    <div class="main-content article">
                        <p>Puoi:</p> 
                        <ul>
                            <li>modificare <b id="blue"> SOLO IL TUO</b> profilo</li>
                        </ul>
                    </div>
                <?php endif; ?>                
            </div>
        </div>
    </body>
</html>