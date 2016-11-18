<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 07/11/2016
 * Time: 14:58
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example push</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="js/jquery-3.1.1.min.js" ></script>

    <script src="js/optimizme/utils.js" ></script>
    <script src="js/optimizme/passerelle.js" ></script>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="col-md-9">

                <?php include('includes/blocs/head_push.php') ?>
                <br /><hr /><br />

                <?php include('includes/blocs/title.php') ?>
                <?php include('includes/blocs/content.php') ?>
                <?php include('includes/blocs/image_alt.php') ?>
                <?php include('includes/blocs/meta_description.php') ?>
                <?php include('includes/blocs/permalink.php') ?>
            </div>


            <div class="col-md-3" role="complementary">
                 <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix">
                     <h3>Menu</h3>
                     <ul class="nav bs-docs-sidenav">
                         <li class=""><a href="#bloc_title">Title</a></li>
                         <li class=""><a href="#bloc_content">Content</a></li>
                         <li class=""><a href="#bloc_image">Image alt</a></li>
                         <li class=""><a href="#bloc_meta_description">Meta description</a></li>
                         <li class=""><a href="#bloc_permalink">Permalink</a></li>
                     </ul>
                 </nav>
            </div>


        </div>
    </div>

</body>
</html>
