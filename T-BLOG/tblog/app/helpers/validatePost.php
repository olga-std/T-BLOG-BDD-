<?php
function validatePost($post)
{
        //evitare la creazieone degli post vuoti
    $errors = array();
    $table = 'posts';
    
    if (empty($post['title'])) {
        array_push($errors, 'Titolo &egrave; richiesto');
    } else {
        $term = esclude($_POST['title']); //ricevo in input la stringa e la controllo
        if (preg_match('/[\^£$&*}{@#~><>|=_+]/', $term)) {
            array_push($errors, "Titolo: uno o pi&#249; caratteri non validi");
        } else {
                //controlare se titolo è già presete nel DB
            $existingPost = selectOne($table, ['title' => $post['title']]);
                // per la modifica del'articolo dare il permesso di utilizare il titolo senza cambiamenti
            if ($existingPost) {
                if (isset($post['update-post']) && $existingPost['id'] != $post['id']) {
                    array_push($errors, 'Articolo con questo titolo esiste gi&#224;');
                }
                if (isset($post['add-post'])) {
                    array_push($errors, 'Articolo con questo titolo esiste gi&#224;');
                }
            }
        }
    }    
    if (empty($post['body'])) {
        array_push($errors, 'Testo &egrave; richiesto');
    }
    if (empty($post['topic_id'])) {
        array_push($errors, 'Seleziona tema');
    }
    if (isset($post['add-post']) && empty($_FILES['image']['name'])) {
        array_push($errors, 'Immagine &egrave; richiesto');
    }
    if ((isset($post['add-post']) || isset($post['update-post'])) && (!empty($_FILES['image']['name']))) { 
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/imgtblog/images/" . $image_name;
        $imageFileType = strtolower(pathinfo($destination,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check == false) {
            array_push($errors, "Il file non &egrave; immagine");
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		        array_push($errors, "Solo JPG, JPEG, PNG e GIF sono ammessi");
            }
        }
            // controlla la grandezza
        if ($_FILES['image']["size"] > 500000 ) {
            array_push($errors,  "Immaggine &egrave; troppo grande");            
        }
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Impossibile caricare l'immagine");
        }
    }
    return $errors;
}
?>