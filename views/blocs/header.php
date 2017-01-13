<?php
/**
 * Head - load all scripts
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Easycontent editor</title>
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- vendor scripts -->
    <link rel="stylesheet" type="text/css" href="./assets/dist/css/vendor.min.css" />
    <script src="./assets/dist/js/vendor-debug.min.js" ></script>

    <script src="./bower_components/tinymce/tinymce.min.js" ></script>
    <script src="./bower_components/tinymce/jquery.tinymce.min.js" ></script>

    <!-- optimiz.me -->
    <link rel="stylesheet" type="text/css" href="./assets/dist/css/optimizme.min.css" />
    <script src="./assets/dist/js/optimizme-debug.min.js" ></script>
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
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/edit_category') ?>">Categories</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/install_config') ?>">Install WP plugin</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/redirections') ?>">Redirections</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/create_post') ?>">Create post/page</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/site_options') ?>">Site options</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestashop <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('prestashop/easycontent_editor') ?>">Easycontent Editor</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('prestashop/edit_category') ?>">Categories</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('prestashop/redirections') ?>">Redirections</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shopify <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/edit_product') ?>">Edit produit</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/redirections') ?>">Redirections</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/install_config') ?>">Installation</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Magento <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('magento/edit_product') ?>">Edit produit</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('magento/edit_category') ?>">Categories</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('magento/redirections') ?>">Redirections</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Weebly <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php OptimizmeUtils::LinkToPage('weebly/edit_product') ?>">Edit produit</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('weebly/create_product') ?>">New produit</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('weebly/edit_category') ?>">Categories</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('weebly/create_category') ?>">New Category</a></li>
                            <li><a href="<?php OptimizmeUtils::LinkToPage('weebly/install') ?>">Install</a></li>
                        </ul>
                    </li>

                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>