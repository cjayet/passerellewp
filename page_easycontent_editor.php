<?php
session_start();
$_SESSION['id_optimizme_user'] = 3; // TODO vraie gestion de session utilisateur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Easycontent editor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- CSS dependencies -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />

    <!-- Grid editor CSS -->
    <link rel="stylesheet" type="text/css" href="css/grideditor.css" />

    <!-- Javascript dependencies -->
    <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="js/tinymce/tinymce.min.js"></script>
    <script src="js/tinymce/jquery.tinymce.min.js"></script>

    <!-- Grid editor javascript -->
    <script src="js/jquery.grideditor.min.js"></script>

    <!-- push optimiz.me -->
    <script src="js/optimizme.js" ></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-9">

            <?php include('blocs/head_push.php') ?>

            <form action="" method="POST">
                <button type="button" data-id="action" value="load_post_content" class="btn btn-primary load_grid_editor" data-target="#easycontent-grid">Load content</button>
            </form>
            <div class="form-group">
                <div class=""></div>
            </div>
            <br /><hr /><br />

            <div id="container-easycontent" style="display: none">
                <h2 id="bloc_content">LOAD/PUSH content</h2>
                <form action="" method="POST">

                    <div id="content-grid" class="form-group">
                        <div id="easycontent-grid"></div>
                    </div>

                    <button type="button" data-id="action" value="add_content" class="btn btn-default inject_easycontent_content">Inject content</button>
                    <button type="button" data-id="action" value="set_content" class="btn btn-primary push_wp">Envoyer</button>
                </form>

                <div class="form-group">
                    <div class=""></div>
                </div>
                <br /><hr /><br />
            </div>


        </div>
    </div>

</div> <!-- /.container -->

</body>
</html>