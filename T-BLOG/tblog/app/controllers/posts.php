<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");
include(ROOT_PATH . "/app/helpers/middleware.php");

$table = 'posts';
$topics = selectAll('topics');
$posts = getPostsWhithUsername();

$errors = array();
$id = "";
$title = "";
$body = "";
$image = "";
$topic_id = "";
$published = "";
$user_id = "";


if (isset($_GET['id'])) {
    $post = selectOne($table, ['id' => $_GET['id']]);
    
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $image = $post['image'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
    $user_id = $post['user_id'];
}

if (isset($_GET['delete_id'])) {
    usersOnly(); 
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = 'Articolo eliminato con successo, complimenti  ';
    $_SESSION['type'] = 'success';
    if ($_SESSION['admin']) {
        header("location: " . BASE_URL . "/dashboard/posts/index.php");
    }
    else {
        header("location: " . BASE_URL . "/dashboard/posts/index_user.php");
    }
    exit(0);
}

if (isset($_GET['published']) && isset($_GET['p_id'])) {
    usersOnly(); 
    $published = $_GET['published'];                                            
    $p_id = $_GET['p_id'];
        
        // update published    
    $count = update($table, $p_id, ['published' => $published]);
    $_SESSION['message'] = 'Stato della pubblicazione &egrave; cambiato, complimenti  ';
    $_SESSION['type'] = 'success';
    if ($_SESSION['admin']) {
        header("location: " . BASE_URL . "/dashboard/posts/index.php");
    }
    else {
        header("location: " . BASE_URL . "/dashboard/posts/index_user.php");
    }
    exit(0);
}

if (isset($_POST['add-post'])) {
    usersOnly();    
    $errors = validatePost($_POST);
    
    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
            //controlare se l'articolo è da pubblicare
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
            //cancelare i tag dentro la bd
        $_POST['body'] = htmlentities($_POST['body']);

        $post_id = create($table, $_POST);
        $_SESSION['message'] = 'Articolo creato correttamente, complimenti  ';
        $_SESSION['type'] = 'success';
        if ($_SESSION['admin']) {
            header("location: " . BASE_URL . "/dashboard/posts/index.php");
        }
        else {
            header("location: " . BASE_URL . "/dashboard/posts/index_user.php");
        }
        exit(0);       
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }  
}


if (isset($_POST['update-post'])) {
    usersOnly();
    $errors = validatePost($_POST);

    if (empty($_FILES['image']['name']))  {
        $_POST['image'] = $post['image'];
    }
    
    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id'], $_POST['user_id']);
            //controlare se l'articolo è da pubblicare
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
            //cancelare i tag dentro la bd
        $_POST['body'] = htmlentities($_POST['body']);
        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Articolo aggiornato con successo, complimenti  ';
        $_SESSION['type'] = 'success';
        if ($_SESSION['admin']) {
            header("location: " . BASE_URL . "/dashboard/posts/index.php");
        }
        else {
            header("location: " . BASE_URL . "/dashboard/posts/index_user.php");
        }
        exit(0);      
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}
?>