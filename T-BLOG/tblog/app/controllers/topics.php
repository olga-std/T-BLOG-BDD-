<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");
include(ROOT_PATH . "/app/helpers/middleware.php");

$table = 'topics';
$id = '';
$name = '';
$description = '';
$errors = array();
$topics = selectAll($table);


if(isset($_POST['add-topic'])) {
    adminsOnly();
    $errors = validateTopic($_POST);

    if (count($errors) === 0) {
            //cancelare ['add-topic'] dal'array
        unset($_POST['add-topic']);

        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Tema creato correttamente, complimenti  ';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/dashboard/topics/index.php');
        exit(); 
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
    }  
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

if(isset($_GET['del_id'])) {
    adminsOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Tema eliminato con successo, complimenti  ';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/dashboard/topics/index.php');
    exit();
}

if(isset($_POST['update-topic'])) {
    adminsOnly();
    $errors = validateTopic($_POST);
    if (count($errors) ===0) {
        $id = $_POST['id'];
        unset($_POST['update-topic'], $_POST['id']);
        $topic_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Tema aggiornato con successo, complimenti  ';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/dashboard/topics/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }   
}
?>