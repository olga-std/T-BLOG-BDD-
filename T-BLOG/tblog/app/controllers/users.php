<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");
include(ROOT_PATH . "/app/helpers/middleware.php");

$table = 'users';
$admin_users = selectAll($table, ['admin' => 1]);
$author_users = selectAll($table, ['admin' => 0]);

$errors = array();
$id = '';
$username = '';
$admin = '';
$email = '';
$phone = '';
$password = '';
$passwordConf = '';

function loginUser($user) {
    // log user in
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['message'] = 'Ciao ';
    $_SESSION['type'] = 'success';

    //divisione per user ed admin    
    if ($_SESSION['admin']) {
        header('location: ' . BASE_URL . '/dashboard/access/admin.php');
    } else {
        header('location: ' . BASE_URL . '/dashboard/access/user.php');
    }    
    exit(0);
}


if (isset($_POST['register-btn']) || isset($_POST['add-admin'])) {
    $errors = validateUser($_POST);

    if(count($errors) === 0) {
            //cancelare dall'array ['register-btn', 'passwordConf', 'add-admin'] perchcè non sono presenti nella tabella
        unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['add-admin']);
            //nascondere password
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);        

            if (isset($_POST['admin'])) {
                adminsOnly();
                    //aggiungere i dati 'admin'
                $_POST['admin'] = 1;
                    //creare admin    
                $user_id = create($table, $_POST);
                $_SESSION['message'] = "Profilo creato correttamente, complimenti  ";
                $_SESSION['type'] = "success";
                header('location: ' . BASE_URL . '/dashboard/users/index.php');
                exit(0);
            } else {
                    //aggiungere i dati 'user'
                $_POST['admin'] = 0;
                    //creare user    
                $user_id = create($table, $_POST);
                $user = selectOne($table, ['id' => $user_id]);
                loginUser($user);
            }
    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

if (isset($_POST['update-user'])) {
    usersOnly();
    $errors = validateUser($_POST);

    if(count($errors) === 0) {
        $id = $_POST['id'];
            //cancelare dall'array ['passwordConf', 'update-user', 'id'] perchcè non sono presenti nella tabella ed id non va modificato
        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);        

            //controlare i dati 'admin'
        $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
            //modificare i dati 'admin'  
        $count = update($table, $id, $_POST);
        $_SESSION['message'] = "Profilo aggiornato con successo, complimenti  ";
        $_SESSION['type'] = "success";
        if ($_SESSION['id'] == $id) {
           $_SESSION['username'] =$_POST['username'];
        }
        if ($_SESSION['admin']) {
            header("location: " . BASE_URL . "/dashboard/users/index.php");
        }
        else {
            header("location: " . BASE_URL . "/dashboard/access/user.php");
        }
        exit(0);      
    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}


if (isset($_GET['admin']) && isset($_GET['m_id'])) {
    adminsOnly();
    $admin = $_GET['admin'];                                            
    $m_id = $_GET['m_id'];
        
        // update admin    
    $count = update($table, $m_id, ['admin' => $admin]);
    $_SESSION['message'] = 'Profilo aggiornato con successo, complimenti ';
    $_SESSION['type'] = 'success';
    header("location: " . BASE_URL . "/dashboard/users/index.php");
    exit(0);
}


    //modifica utente 
if (isset($_GET['id'])) {
    usersOnly();
    $user = selectOne($table, ['id' => $_GET['id']]);
    $id = $user['id'];
    $username = $user['username'];
    $phone = $user['phone'];
    $admin = $user['admin'];
    $email = $user['email'];
}

if (isset($_POST['login-btn'])) {
    $errors = validateLogin($_POST);

    if (count($errors) === 0) {
        $user = selectOne($table, ['username' => $_POST['username']]);

       if ($user && password_verify($_POST['password'], $user['password'])) {
            // login, redirect 
        loginUser($user);
        
        } else {
           array_push($errors, 'Credenziali sbagliate');
        }
    }
    $username =$_POST['username'];
    $password = $_POST['password'];
}

if (isset($_GET['delete_id'])) {
    adminsOnly();
    $count = delete($table, $_GET['delete_id']);
    if ($_SESSION['id'] == $_GET['delete_id']) {
        session_destroy();
        header('location: ' . BASE_URL . '/index.php');
        exit(0);
    }
    $_SESSION['message'] = "Profilo eliminato con successo, complimenti  ";
    $_SESSION['type'] = "success";
    header('location: ' . BASE_URL . '/dashboard/users/index.php');
    exit(0);
}


if (isset($_POST['delete_id'])) {
    usersOnly();
    $count = delete($table, $_SESSION['id']);    
    session_destroy();
    header('location: ' . BASE_URL . '/index.php');
    exit(0);
}
?>