<?php 
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");
$posts = array();
$searchTitle  = "";

if (isset($_GET['t_id'])) {
	$posts = getPostsByTopicId($_GET['t_id']); 
    $searchTitle = "&nbsp;" . $_GET['name'];
} 
else if (isset($_GET['u_id'])) {
    $posts = getPostsByUserId($_GET['u_id']);
    if (empty($posts)) {
        $searchTitle = "&nbsp; Non hai ancora pubblicato un articolo ";
    } else {
    $searchTitle = "&nbsp; Blog di &nbsp;" . $_GET['name'];}
} 
else if (!empty($_POST['search-term'])) {
    $term = esclude($_POST['search-term']); //ricevo in input la stringa e la controllo
	if (preg_match('/[\^£$&*}{@#~><>|=+]/', $term)) {
        array_push($errors, "Uno o pi&#249; caratteri non validi"); 
	} if (count($errors) == 0) {
    $searchTitle = "&nbsp; risultati della ricerca per &nbsp;&#171;" . $_POST['search-term'] . "&#187;";
    $posts = searchPosts($_POST['search-term']);
        if (empty($posts)) {
            $searchTitle = "non sono disponibili risultati per &nbsp;&#171;" . $_POST['search-term'] . "&#187;";
        }
    }
}
else {
    array_push($errors, 'compila i dati per la ricerca');
    $searchTitle  = "";
}
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
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
        crossorigin="anonymous">
        
            <!--JQuery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Custom Script -->
        <script src="assets/js/scripts.js"></script>

        <title><?php echo $searchTitle; ?> &#31; T&#8210;BLOG</title>
    </head>
    <body>
        <?php include(ROOT_PATH . "/app/includes/tblog_header.php")?>
        <?php include(ROOT_PATH . "/app/includes/messages.php")?>
        <div class="page-wrapper">            
            <div class="content clearfix">
                <div class="block_grid">                    
                    <!-- Main Content -->
                    <div class="main-content">
                        <div class="search-list">
                        <?php include(ROOT_PATH . "app/helpers/formErrors.php")?>
                            <h1 class="recent-post-title"><?php echo $searchTitle; ?></h1>

                            <?php foreach ($posts as $post): ?>
                                <div class="post clearfix">
                                    <a href="tblog_article.php?id=<?php echo $post['id']; ?>">
                                        <img src="<?php echo BASE_URL . '/assets/imgtblog/images/' . $post['image']; ?>" alt="" class="post-image">
                                    </a>
                                    <div class="post-preview">
                                        <h2><a href="tblog_article.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
                                        <i class="far fa-user"> <?php echo $post['username']; ?> </i>
                                        &nbsp;
                                        <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
                                        <div class="preview-article">
                                            <p class="preview-text"><?php echo html_entity_decode(substr($post['body'], 0, 200)); ?>...</p>
                                        </div>
                                        <a href="tblog_article.php?id=<?php echo $post['id']; ?>" class="btn read-more">Leggi tutto</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>    
                    </div>                
                    <?php include(ROOT_PATH . "/app/includes/right_sidebar.php") ?>
                </div>
            </div>
        </div>
        <?php include(ROOT_PATH . "/app/includes/tblog_footer.php") ?>
    </body>
</html>