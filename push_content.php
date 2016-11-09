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

                <div class="form-group">
                    <label for="new_title">URL cible</label>
                    <input type="text" class="form-control" id="url_cible" placeholder="URL" value="http://localhost/wordpress/article-de-test/" />
                </div>

                <?php include('blocs/push_title.php') ?>
                <?php include('blocs/push_content.php') ?>
                <?php include('blocs/push_image.php') ?>
            </div>


            <div class="col-md-3" role="complementary">
                 <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix">
                     <ul class="nav bs-docs-sidenav">
                         <li class=""><a href="#bloc_title">PUSH title</a></li>
                         <li class=""><a href="#bloc_content">PUSH content</a></li>
                         <li class=""><a href="#bloc_image">PUSH image alt</a></li>
                     </ul>
                 </nav>
            </div>


        </div>
    </div>

</body>
</html>
