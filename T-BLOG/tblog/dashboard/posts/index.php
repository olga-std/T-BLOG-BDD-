<?php include("../../path.php");
include(ROOT_PATH . "/app/controllers/posts.php");
adminsOnly();
$u_Id = $_SESSION['id'];
$userPosts = getUserPosts($u_Id);
$othersPosts = getOthersPosts($u_Id);
$searcResult = "";
if (isset($_POST['search-term']) && (!empty($_POST['search-term']))){
    $userPosts = array();
    $othersPosts = array();
    
    $term = esclude($_POST['search-term']); //ricevo in input la stringa e la controllo
    if (preg_match('/[\^£$&*}{@#~><>|=_+]/', $term)) {
            array_push($errors, "Uno o pi&#249;  caratteri non validi"); 
    } if (count($errors) == 0) {
        $userPosts = searchUserTitles($_POST['search-term'], $u_Id);
        $othersPosts = searchOthersTitles($_POST['search-term'], $u_Id);
        if (empty($userPosts) && empty($othersPosts)){
            $searcResult = "<i>non sono disponibili risultati per</i> &#171;". $_POST['search-term'] . "&#187;";
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
        
        <title>Manage_posts  &#31; T&#8210;BLOG</title>
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
                        <a href="create.php" class="btn btn-big">Inserire Articolo</a>
                        <a href="index.php" class="btn btn-big">Gestire Articoli</a>
                    </div>
                    <div class="section search">
                        <form action="index.php" method="post">
                            <div class="search_btn" id="dash_search">                        
                                <input type="text" name="search-term" class="text-input" minlength="3" maxlength="20"placeholder="Cerca titolo...">
                                <button  type="submit" class="btn main btn"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>           

            <div class="content">
                <h2 class="page-title" id="dashboard_admin">Gestisci Articoli</h2>
                <p id="searc-result"><b><?php echo $searcResult; ?></b></p>
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <?php include(ROOT_PATH . "app/helpers/formErrors.php"); ?>              
                <table>
                    <thead>
                        <th>&#8470;</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th colspan="3">Azione</th>
                    </thead>
                    <th class="tb_colspan" colspan="6"><h4><i>Miei Articoli</i></h4></th>
                    <tbody>
                        <?php foreach ($userPosts as $key => $post): ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['username']; ?></td>
                                <td><a href="edit.php? id=<?php echo $post['id']; ?>" class="edit">modifica</a></td>
                                <td><a href="edit.php? delete_id=<?php echo $post['id']; ?>" class="delete">elimina</a></td>                                
                                <?php if ($post['published']): ?>
                                    <td><a href="edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">nascondi</a></td>
                                <?php else: ?>
                                    <td><a href="edit.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">pubblica</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <th class="tb_colspan" colspan="6"><h4><i>Aricoli degli altri Autori</i></h4></th>
                    <tbody>
                        <?php foreach ($othersPosts as $key => $post): ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['username']; ?></td>
                                <td><a href="edit.php? id=<?php echo $post['id']; ?>" class="edit">modifica</a></td>
                                <td></td>                                
                                <?php if ($post['published']): ?>
                                    <td><a href="edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">nascondi</a></td>
                                <?php else: ?>
                                    <td><a href="edit.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">pubblica</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>