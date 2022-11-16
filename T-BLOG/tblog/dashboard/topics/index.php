<?php include("../../path.php");
    include(ROOT_PATH . "app/controllers/topics.php");
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
        
        <title>Manage_topics  &#31; T&#8210;BLOG</title>
    </head>
    <body>        
        <?php include(ROOT_PATH . "app/includes/dashboard_header.php");?>

            <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            <?php include(ROOT_PATH . "app/includes/left_sidebar.php");?>            

                <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Inserire Tema</a>
                    <a href="index.php" class="btn btn-big">Gestire Temi</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Gestisci Temi</h2>
                    <?php include(ROOT_PATH . "app/includes/messages.php")?>

                    <table>
                        <thead>
                            <th>&#8470;</th>
                            <th>Nome</th>
                            <th colspan="2">Azione</th>
                        </thead>
                        <tbody>
                            <?php foreach ($topics as $key =>$topic): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $topic['name']; ?></td>
                                    <td><a href="edit.php?id=<?php echo $topic['id']; ?>" class="edit">modifica</a></td>
                                    <td><a href="index.php?del_id=<?php echo $topic['id']; ?>" class="delete">elimina</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>