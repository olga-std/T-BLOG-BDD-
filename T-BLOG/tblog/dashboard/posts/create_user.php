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
        <link rel="stylesheet" href="../../assets/css/style.css">
            <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        
            <!--JQuery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Ckeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
            <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
        
        <title>Add_post  &#31; T&#8210;BLOG</title>
    </head>
    <body>        
        <?php include(ROOT_PATH . "/app/includes/dashboard_header.php"); ?>

            <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            <?php include(ROOT_PATH . "/app/includes/left_sidebar_user.php"); ?> 

                <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create_user.php" class="btn btn-big">Inserire Articolo</a>
                    <a href="index_user.php" class="btn btn-big">Gestire Articoli</a>
                </div>

                <div class="content">
                    <h2 class="page-title">Inserisci Articolo</h2>
                    
                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?> 
                    <form action="create_user.php" method="post" enctype="multipart/form-data">
                        <div>
                            <label>Titolo</label>
                            <input type="text" name="title" value="<?php echo $title ?>" class="text-input">
                        </div>
                        <div>
                            <label>Testo</label>
                            <textarea name="body" id="body"><?php echo $body ?></textarea>
                        </div>
                        <div>
                            <label>Immagine</label>
                            <input type="file" name="image" class="text-input">
                        </div>
                        <div>
                            <label>Tema</label>
                            <select name="topic_id" class="text-input">
                                <option value=""></option>
                                <?php foreach($topics as $key => $topic): ?>
                                    <?php if(!empty($topic_id) && $topic_id == $topic['id']): ?>
                                        <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                    <?php endif; ?>                                    
                                <?php endforeach; ?>                                
                            </select>
                        </div>
                        <div>
                            <?php if(empty($published)): ?>
                                <label>
                                    <input type="checkbox" name="published"> Pubblica
                                </label>
                            <?php else: ?>
                                <label>
                                    <input type="checkbox" name="published" checked> Pubblica
                                </label>
                            <?php endif; ?>                            
                        </div>
                        <div>
                            <button type="submit" name="add-post" class="btn btn-big">Inserisci Articolo</button>
                        </div>
                    </form>            
                </div>
            </div>
        </div>
        <script>
            ClassicEditor
                .create( document.querySelector( '#body' ), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    }
            } )
            .catch( error => {
                console.log( error );
            } );
        </script>
    </body>
</html>