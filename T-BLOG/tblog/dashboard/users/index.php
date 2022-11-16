<?php include("../../path.php");
include(ROOT_PATH . "/app/controllers/users.php");
adminsOnly();
$searchResult = "";
if (isset($_POST['search-term']) && (!empty($_POST['search-term']))){
    $admin_users = array();
    $author_users = array();
    $term = esclude($_POST['search-term']); //ricevo in input la stringa e la controllo
    if (preg_match('/[\^£$&*}{@#~><>|=+]/', $term)) {
            array_push($errors, "Uno o pi&#249; caratteri non validi"); 
    } 
    if (count($errors) == 0)  {
        $admin_users = searchAdmins($_POST['search-term']);
        $author_users = searchUsers($_POST['search-term']);
        if (empty($admin_users) && empty($author_users)){
            $searchResult = "<i>Utente con nome</i> &#171;". $_POST['search-term'] . "&#187; <i>non &egrave; registrato</i>";
        }
    }
}
if(isset($_POST['search-term']) && empty ($_POST['search-term'])) {
        array_push($errors, 'compila i dati per la ricerca');
}
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
        
        <title>Manage_users  &#31; T&#8210;BLOG</title>
    </head>
    <body>        
        <?php include(ROOT_PATH . "/app/includes/dashboard_header.php");?>

            <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            <?php include(ROOT_PATH . "/app/includes/left_sidebar.php");?>            

                <!-- Admin Content -->
            <div class="admin-content">
                <div class="btn_item_d">
                    <div class="button-group">
                        <a href="create.php" class="btn btn-big">Inserire Utente</a>
                        <a href="index.php" class="btn btn-big">Gestire Utenti</a>
                    </div>
                    <div class="section search">
                        <form action="index.php" method="post">
                            <div class="search_btn" id="dash_search">                        
                                <input type="text" name="search-term" class="text-input" minlength="3" maxlength="12" placeholder="Cerca username...">
                                <button  type="submit" class="btn main btn"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>                
                </div>
              
                <div class="content">
                    <h2 class="page-title" id="dashboard_admin">Gestisci Utenti</h2>
                    <p id="searc-result"><b><?php echo $searchResult; ?></b></p>
                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                    <?php include(ROOT_PATH . "app/helpers/formErrors.php"); ?>
                    <table>
                        <thead>
                            <th>&#8470;</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th colspan="2">Azione</th>
                        </thead>
                        <th class="tb_colspan" colspan="5"><h4><i>Amministratori</i></h4></th>
                        <tbody>                        
                            <?php foreach ($admin_users as $key =>$user): ?>                                
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <?php if ($_SESSION['id']==$user['id']): ?>
                                        <td><a href="edit.php?id=<?php echo $user['id']; ?>" class="edit">modifica profilo</a></td>
                                    <?php else: ?>
                                        <td><a href="edit.php?admin=0&m_id=<?php echo $user['id']; ?>" class="user">rimuovi priveleggi</a></td>
                                    <?php endif; ?>
                                    <td><a href="index.php?delete_id=<?php echo $user['id']; ?>" class="delete">elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <th class="tb_colspan" colspan="5"><h4><i>Utenti</i></h4></th>
                        <tbody>                    
                            <?php foreach ($author_users as $key =>$user): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><a href="edit.php?admin=1&m_id=<?php echo $user['id']; ?>" class="admin">aggiungi priveleggi</a></td>
                                    <td><a href="index.php?delete_id=<?php echo $user['id']; ?>" class="delete">elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>  
        </div>
    </body>
</html>