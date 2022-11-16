<?php
function validateTopic($topic)
{
    //evitare la creazieone dei temi vuoti
    $errors = array();
    $table = 'topics';
    
    if (empty($topic['name'])) {
        array_push($errors, 'Nome &egrave; richiesto');
    }
    $term = esclude($_POST['name']); //ricevo in input la stringa e la controllo
    if (preg_match('/[\^£$&*}{@#~><>|=_+]/', $term)) {
        array_push($errors, "Nome: uno o pi&#249; caratteri non validi");
    }    
        //controlare se titolo è già presete nel DB
    $existingTopic = selectOne($table, ['name'=> $topic['name']]);
        // per la modifica del tema dare il permesso di utilizare il titolo senza cambiamenti
    if ($existingTopic) {
        if (isset($topic['update-topic']) && $existingTopic['id'] != $topic['id']) {
            array_push($errors, 'Tema esiste gi&#224;');
        }
        if (isset($topic['add-topic'])) {
            array_push($errors, 'Tema esiste gi&#224;');
        }
    }
    return $errors;
}
?>