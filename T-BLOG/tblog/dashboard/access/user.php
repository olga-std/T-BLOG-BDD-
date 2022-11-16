<?php include("../../path.php");
    include(ROOT_PATH . "/app/controllers/posts.php");
    usersOnly();
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
        
        <title>User_dashboard  &#31; T&#8210;BLOG</title>
    </head>
    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboard_header.php"); ?>

        <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/left_sidebar_user.php"); ?>
            <!-- Admin Content -->
        <div class="admin-content">
            <div class="content">
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <h1 class="page-title">Regolamento</h1>
                <div class="main-content article">
                    <p>Puoi:</p> 
                    <ul>
                        <li>scrivere, modificare, eliminare,<br>
                            &nbsp;pubblicare o nascondere dalla pubblicazione <b id="blue">SOLO I TUOI</b> articoli</li><br>
                        <li>modificare o cancelare <b id="blue">IL TUO</b> profilo</li><br>
                        <li>mettere o rimuovere <i>&#171;mi piace&#187;</i>,<br>
                            &nbsp;lasciare o eliminare <b id="blue">SOLO I TUOI</b> commenti sotto gli articoli scelti</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
            <!--JQuery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
    </body>
</html>