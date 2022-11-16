<?php
function validateUser($user)
{
    //evitare la creazieone degli utenti vuoti
    $errors = array();
    $table = 'users';
    
    if (empty($user['username'])) {
        array_push($errors, 'Username &egrave; richiesto');
    }
    $term = esclude($_POST['username']); //ricevo in input la stringa e la controllo
    if ((!empty($user['username'])) && (!preg_match('/^[A-Za-z0-9_\-]{3,12}$/', $user['username']))) {
        array_push($errors, 
        "Username pu&ograve; contenere solo i caratteri alfabetici, numeri, simboli &#171;&#95;&#187; e &#171;&#45;&#187;" . "<br>" . 
        "e di lunghezza compresa tra 3 e 12 caratteri");
    }

    if (empty($user['email'])) {
        array_push($errors, 'Email &egrave; richiesta');
    }
    $term = esclude($_POST['email']); //ricevo in input la stringa e la controllo
    if ((!empty($user['email'])) && (!filter_var($user['email'], FILTER_VALIDATE_EMAIL))) {
	    array_push($errors, "Indirizzo email non &egrave; corretto");
	}

    if (empty($user['phone'])) {
        array_push($errors, 'Telefono &egrave; richiesto');
    }
    $term = esclude($_POST['phone']); //ricevo in input la stringa e la controllo
            /*            
                        (?:\+?(\d{1,3}))?   #GROUP 1: The country code. Optional.
                        [-. (]*             #Allow certain non numeric characters that may appear between the Country Code and the Area Code.
                        (\d{3})             #GROUP 2: The Area Code. Required.
                        [-. )]*             #Allow certain non numeric characters that may appear between the Area Code and the Exchange number.
                        (\d{3})             #GROUP 3: The Exchange number. Required.
                        [-. ]*              #Allow certain non numeric characters that may appear between the Exchange number and the Subscriber number.
                        (\d{4})             #Group 4: The Subscriber Number. Required.
                        (?: *x(\d+))?       #Group 5: The Extension number. Optional           
            */
    if ((!empty($user['phone'])) && (!preg_match('/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{2,4})[-. ]*(\d{2})?(?: *x(\d+))?$/', $user['phone']))) {
        array_push($errors, "Il numero di telefono non valido");
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password &egrave; richiesta');
    }
    $term = esclude($_POST['password']); //ricevo in input la stringa e la controllo
    if ((!empty($user['password'])) && (!preg_match('/^[a-zA-Z0-9_\-]{4,15}$/', $user['password']))) {
	    array_push($errors, 
        "Password pu&ograve; contenere solo i caratteri alfabetici, numeri, simboli &#171;&#95;&#187; e &#171;&#45;&#187;" . 
        "<br>" . 
        "e di lunghezza compresa tra 4 e 15 caratteri");
    }

    if (empty($user['passwordConf'])) {
        array_push($errors, 'Conferma Password &egrave; richiesta');
    }
    $term = esclude($_POST['passwordConf']); //ricevo in input la stringa e la controllo
    if ((!empty($user['passwordConf'])) && (!preg_match('/^[a-zA-Z0-9_\-]{4,15}$/', $user['passwordConf']))) {
        array_push($errors, 
        "Conferma Password pu&ograve; contenere solo i caratteri alfabetici, numeri, simboli &#171;&#95;&#187; e &#171;&#45;&#187;" . 
        "<br>" .
        "e di lunghezza compresa tra 4 e 15 caratteri");
    }
    if (($user['passwordConf'] != $user['password'])) {
        array_push($errors, 'Password non corrispondono');
    }
   

        //controlare se il nomeUtente è già presete nel DB
    $existingUserName = selectOne($table, ['username'=> $user['username']]);
        // per la modifica dare il permesso di utilizare username senza cambiamenti
    if ($existingUserName) {
        if (isset($user['update-user']) && $existingUserName['id'] != $user['id']) {
            array_push($errors, 'Username esiste gi&#224;');
        }
        if (isset($user['add-admin'])) {
            array_push($errors, 'Username esiste gi&#224;');
        }
        if (isset($user['register-btn'])) {
            array_push($errors, 'Username esiste gi&#224;');
        }
    }

        //controlare se email è già presete nel DB
    $existingUserEmail = selectOne($table, ['email'=> $user['email']]);
        // per la modifica dare il permesso di utilizare email senza cambiamenti
    if ($existingUserEmail) {
        if (isset($user['update-user']) && $existingUserEmail['id'] != $user['id']) {
            array_push($errors, 'Email esiste gi&#224;');
        }
        if (isset($user['add-admin'])) {
            array_push($errors, 'Email esiste gi&#224;');
        }
        if (isset($user['register-btn'])) {
            array_push($errors, 'Email esiste gi&#224;');
        }
    }    
    return $errors;
}


function validateLogin($user)
{
    //evitare gli utenti vuoti
    $errors = array();
    if (empty($user['username'])) {
        array_push($errors, 'Username &egrave; richiesto');
    }
    if (empty($user['password'])) {
        array_push($errors, 'Password &egrave; richiesta');
    }
    return $errors;
}
?>