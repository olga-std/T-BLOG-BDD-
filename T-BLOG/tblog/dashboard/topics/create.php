<?php include("../../path.php");
    include(ROOT_PATH . "/app/controllers/topics.php");
    adminsOnly();
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
        <!--JQuery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Ckeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
        
            <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
        
        <title>Add_topic  &#31; T&#8210;BLOG</title>
    </head>

    <body>        
        <?php include(ROOT_PATH . "/app/includes/dashboard_header.php");?>

            <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            <?php include(ROOT_PATH . "/app/includes/left_sidebar.php");?>

                <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Inserire Tema</a>
                    <a href="index.php" class="btn btn-big">Gestire Temi</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Inserisci Tema</h2>
                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php")?>

                    <form action="create.php" method="post">
                        <div>
                            <label>Nome</label>
                            <input type="text" name="name" value="<?php echo $name ?>" class="text-input">
                        </div>
                        <div>
                            <label>Descrizione</label>
                            <textarea name="description" id="body"><?php echo $description ?></textarea>
                        </div>

                        <div>
                            <button type="submit" name="add-topic" class="btn btn-big">Inserisci Tema</button>
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