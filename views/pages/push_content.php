<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

    <div class="container">
        <div class="row">

            <div class="col-md-9">

                <?php OptimizmeUtils::LoadBloc('head_push'); ?>
                <br /><hr /><br />

                <?php OptimizmeUtils::LoadBloc('form-push/title'); ?>
                <?php OptimizmeUtils::LoadBloc('deprecated/content'); ?>
                <?php OptimizmeUtils::LoadBloc('deprecated/image_alt'); ?>
                <?php OptimizmeUtils::LoadBloc('form-push/meta_description'); ?>
                <?php OptimizmeUtils::LoadBloc('form-push/permalink'); ?>
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
