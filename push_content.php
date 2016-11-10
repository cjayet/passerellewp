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
    <script src="js/optimizme.js" ></script>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="col-md-9">

                <div class="page-header">
                    <h1>Envoi de données <small>vers wordpress</small></h1>
                </div>

                <div class="form-group">
                    <label for="new_title">URL article cible</label>
                    <input type="text" class="form-control" id="url_cible" placeholder="URL" value="http://localhost/wordpress/article-de-test/" />
                </div>

                <div class="form-group">
                    <label for="new_title">URL wordpress</label>
                    <input type="text" class="form-control" id="url_wordpress" placeholder="URL" value="http://localhost/wordpress/" />
                </div>
                <br /><hr /><br />

                <?php include('blocs/title.php') ?>
                <?php include('blocs/content.php') ?>
                <?php include('blocs/image_alt.php') ?>
                <?php include('blocs/meta_description.php') ?>
            </div>


            <div class="col-md-3" role="complementary">
                 <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix">
                     <h3>Menu</h3>
                     <ul class="nav bs-docs-sidenav">
                         <li class=""><a href="#bloc_title">Title</a></li>
                         <li class=""><a href="#bloc_content">Content</a></li>
                         <li class=""><a href="#bloc_image">Image alt</a></li>
                         <li class=""><a href="#bloc_meta_description">Meta description</a></li>
                     </ul>
                 </nav>
            </div>


        </div>
    </div>

</body>
</html>
