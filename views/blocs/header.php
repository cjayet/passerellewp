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

    <!-- vendor scripts -->
    <link rel="stylesheet" type="text/css" href="./assets/dist/css/vendor.min.css" />
    <script src="./assets/dist/js/vendor-debug.min.js" ></script>

    <script src="./bower_components/tinymce/tinymce.min.js" ></script>
    <script src="./bower_components/tinymce/jquery.tinymce.min.js" ></script>

    <!-- optimiz.me -->
    <link rel="stylesheet" type="text/css" href="./assets/dist/css/optimizme.min.css" />
    <script src="./assets/dist/js/optimizme.min.js" ></script>
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Wordpress <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/easycontent_editor') ?>">Easycontent Editor</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/install_config') ?>">Install WP plugin</a></li>
                            <!-- <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/push_content') ?>">Push</a></li> -->
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/redirections') ?>">Redirections</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/create_post') ?>">Create post/page</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/site_options') ?>">Site options</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestashop <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('prestashop/easycontent_editor') ?>">Easycontent Editor</a></li>
                        </ul>
                    </li>

                    <!--
                    <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/easycontent_editor') ?>">Easycontent Editor</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/install_config') ?>">Install WP plugin</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/redirections') ?>">Redirections</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/create_post') ?>">Create post/page</a></li>
                    <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/site_options') ?>">Site options</a></li>
                    -->
                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>
