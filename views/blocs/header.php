<?php
/**
 * Head - load all scripts
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Easycontent editor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- CSS dependencies -->
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="bower_components/font-awesome/css/font-awesome.min.css" />

    <!-- Javascript dependencies -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/tinymce/tinymce.min.js"></script>
    <script src="bower_components/tinymce/jquery.tinymce.min.js"></script>

    <!-- Ajax Loader -->
    <script src="bower_components/AjaxLoader/jquery.ajaxloader.1.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bower_components/AjaxLoader/ajaxloader/ajaxloader.css" />

    <!-- Grid editor -->
    <script src="bower_components/grid-editor/dist/jquery.grideditor.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bower_components/grid-editor/dist/grideditor.css" />

    <!-- jquery tmpl -->
    <script src="bower_components/jquery-tmpl/jquery.tmpl.min.js"></script>

    <!-- optimiz.me -->
    <link rel="stylesheet" type="text/css" href="css/optimizme.css" />
    <script src="js/optimizme/utils.js" ></script>
    <script src="js/optimizme/passerelle.js" ></script>
    <script src="js/optimizme/editor.js" ></script>

</head>
<body>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php OptimizmeUtils::LinkToPage('home') ?>">Passerelle</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php OptimizmeUtils::LinkToPage('easycontent_editor') ?>">Easycontent Editor</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('install_config') ?>">Install WP plugin</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('push_content') ?>">Push</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('redirections') ?>">Redirections</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('create_post') ?>">Create post/page</a></li>

                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li> -->
                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>
