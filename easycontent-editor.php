<?php session_start() ?>
<?php $_SESSION['id_optimizme_user'] = 3; ?>
<!DOCTYPE html>
<html>
<head>
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

    <script>
        $(function() {
            // Initialize grid editor
            $('#myGrid').gridEditor({
                new_row_layouts: [[12], [6,6], [9,3]],
                content_types: ['tinymce'],

                tinymce: {
                    config: {
                        inline: true,
                        plugins: [
                            "advlist autolink lists link image charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu responsivefilemanager paste"
                        ],
                        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link responsivefilemanager image insertfile",

                        image_advtab: true ,

                        external_filemanager_path: "filemanager/",
                        filemanager_title: "Filemanager" ,
                        external_plugins: { "filemanager" : "http://localhost/tests/easycontent-editor/filemanager/plugin.min.js"},
                        relative_urls:false
                    }
                },
            });

            // Get resulting html
            var html = $('#myGrid').gridEditor('getHtml');
            console.log(html);
        });
    </script>

    <title>Easycontent editor</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-9">

            <?php include('blocs/head_push.php') ?>

            <h2 id="bloc_content">PUSH content</h2>
            <form action="" method="POST">

                <div class="form-group">
                    <div id="myGrid"></div>
                </div>

                <button type="button" data-id="action" value="set_content" class="btn btn-default push_wp">Envoyer</button>
            </form>

            <div class="form-group">
                <div class=""></div>
            </div>
            <br /><hr /><br />

        </div>
    </div>

</div> <!-- /.container -->

</body>
</html>