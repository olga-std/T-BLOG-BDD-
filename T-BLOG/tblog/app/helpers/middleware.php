<?php
function usersOnly($redirect = '/index.php')
{       if (empty($_SESSION['id'])){
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function adminsOnly($redirect = '/dashboard/access/user.php')
{
    if (empty($_SESSION['admin'])){
        $_SESSION['message'] = 'Accesso negato &nbsp;  ';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}
?>