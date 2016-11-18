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
    <link rel="stylesheet" type="text/css" href="css/optimizme.css" />

    <!-- Javascript dependencies -->
    <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script src="js/tinymce/tinymce.min.js"></script>
    <script src="js/tinymce/jquery.tinymce.min.js"></script>

    <!-- Grid editor javascript -->
    <script src="js/jquery.grideditor.js"></script>

    <!-- jquery tmpl -->
    <script src="js/jquery.tmpl.min.js"></script>

    <!-- push optimiz.me -->
    <script src="js/optimizme/utils.js" ></script>
    <script src="js/optimizme/passerelle.js" ></script>
    <script src="js/optimizme/editor.js" ></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php include('includes/blocs/head_push.php') ?>

            <form action="" method="POST">
                <button type="button" data-id="action" value="load_post_content" class="btn btn-primary load_grid_editor" data-target="#easycontent-grid">Load content</button>
            </form>
            <div class="form-group">
                <div class=""></div>
            </div>
            <br /><hr /><br />
        </div>
    </div>

    <div id="container-easycontent" style="display: none">
        <div class="row" >

            <div class="col-md-12">

                <div class="form-group">
                    <label for="easycontent-title">Title</label>
                    <input type="text" name="easycontent-title" id="easycontent-title" data-id="new_title" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="easycontent-permalink">Permalien</label>
                    <input type="text" name="easycontent-permalink" id="easycontent-permalink" data-id="new_permalink" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="easycontent-permalink">Meta description</label>
                    <input type="text" name="easycontent-meta-description" id="easycontent-meta-description" data-id="meta_description" class="form-control" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <aside id="page_builder">
                    <div id="list_block_page_builder" class="page-header">Blocks</div>

                    <button type="button" data-id="action" value="add_h1" class="btn btn-default inject_easycontent_h1 ui-sortable">Inject h1</button>
                    <button type="button" data-id="action" value="add_h2" class="btn btn-default inject_easycontent_h2 ui-sortable">Inject h2</button>
                    <button type="button" data-id="action" value="add_content" class="btn btn-default inject_easycontent_content ui-sortable">Inject content</button>

                    <div class="ui-draggable ui-draggable-handle ui-sortable">DRAGDROP</div>
                </aside>
            </div>

            <div class="col-md-10">
                <form action="" method="POST">

                    <div id="content-grid" class="form-group">
                        <div id="easycontent-grid"></div>
                    </div>

                    <button type="button" data-id="action" value="set_content" class="btn btn-primary push_wp">Envoyer</button>
                </form>

                <div class="form-group">
                    <div class=""></div>
                </div>
            </div>

        </div>
    </div>



</div> <!-- /.container -->


</body>
</html>