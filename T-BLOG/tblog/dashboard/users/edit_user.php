<?php include("../../path.php");
    include(ROOT_PATH . "/app/controllers/users.php");
    usersOnly();
    $user = getUserById($_SESSION['id']);
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
            <?php include(ROOT_PATH . "/app/includes/left_sidebar_user.php");?>
            
                <!-- Admin Content -->
            <div class="admin-content">

            <div class="content">

                <h2 class="page-title">Modifica Profilo</h2>

                <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                <?php if ($_SESSION['id'] == $user['id']): ?>
                    <form action="edit_user.php" method="post">
                            <!--id non si cambia nella modifica -->
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <div>
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo $user['username']; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Telefono</label>
                            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Nuova Password</label>
                            <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Conferma Nuova Password</label>
                            <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
                        </div>
                        <div class="button-group">
                            <button type="post" name="update-user" class="btn btn-big">Modifica Profilo</button>
                            <button type="post" name="delete_id" class="btn btn-big">Elimina Profilo</button>
                        </div>
                    </form>
                <?php elseif(empty($errors) && ($_SESSION['id'] != $user['id'])): ?>
                    <div class="main-content article">
                        <p>Puoi:</p> 
                        <ul>
                            <li>modificare o cancelare <b id="blue">SOLO IL TUO</b> profilo</li>
                        </ul>
                    </div>                                    
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>