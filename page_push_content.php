<?php
// header: scripts + navigation bar
include('includes/blocs/header.php');
?>

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
