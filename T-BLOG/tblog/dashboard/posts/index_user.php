<?php include("../../path.php");
    include(ROOT_PATH . "/app/controllers/posts.php");
    usersOnly();
    $userPosts = getUserPosts($_SESSION['id']);
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
            <?php include(ROOT_PATH . "/app/includes/left_sidebar_user.php");?>            

                <!-- Admin Content -->
            <div class="admin-content">
            <div class="button-group">
                <a href="create_user.php" class="btn btn-big">Inserire Articolo</a>
                <a href="index_user.php" class="btn btn-big">Gestire Articoli</a>
            </div>

            <div class="content">
                <h2 class="page-title">Gestisci Articoli</h2>
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                
                <table>
                    <thead>
                        <th>&#8470;</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th colspan="3">Azione</th>
                    </thead>
                    <tbody>
                        <?php foreach ($userPosts as $key => $post): ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['username']; ?></td>
                                <td><a href="edit_user.php? id=<?php echo $post['id']; ?>" class="edit">modifica</a></td>
                                <td><a href="edit_user.php? delete_id=<?php echo $post['id']; ?>" class="delete">elimina</a></td>
                                
                                <?php if ($post['published']): ?>
                                    <td><a href="edit_user.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">nascondi</a></td>
                                <?php else: ?>
                                    <td><a href="edit_user.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">pubblica</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>