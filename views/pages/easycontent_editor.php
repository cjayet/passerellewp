<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('head_push'); ?>

            <form>
                <button type="button" data-id="action" class="btn btn-primary load_arborescence">Load arbo</button>
            </form>
        </div>
    </div>

    <div class="row" id="page_easycontenteditor_loadpage">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('easycontent/select_page_arborescence'); ?>
            <form id="form_load_grideditor">
                <button id="btn-load-grideditor" type="button" data-id="action" value="load_post_content" class="btn btn-primary load_grid_editor" data-target="#easycontent-grid">Load content</button>
            </form>
        </div>
    </div>
    <hr /><br />


    <div id="container-easycontent" style="display: none">
        <div class="row" >

            <div class="col-md-12">

                <?php
                // PERMALINK
                OptimizmeUtils::LoadBloc('form-push/post/permalink');

                // TITRE
                OptimizmeUtils::LoadBloc('form-push/post/title');

                // SLUG
                OptimizmeUtils::LoadBloc('form-push/post/slug');

                // URL CANONIQUE
                OptimizmeUtils::LoadBloc('form-push/post/url_canonique');

                // META DESCRIPTION
                OptimizmeUtils::LoadBloc('form-push/post/meta_description');

                // META ROBOTS
                OptimizmeUtils::LoadBloc('form-push/post/meta_robots');

                // PUBLISH
                OptimizmeUtils::LoadBloc('form-push/post/publish');

                ?>
                <br /><hr /><br />
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <h2>Editor</h2>
            </div>
            <div class="col-md-2">
                <aside id="page_builder">
                    <div id="list_block_page_builder" class="page-header">BLOCKS</div>
                    <div data-action="h1" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">H1</div>
                    <div data-action="h2" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">H2</div>
                    <div data-action="h3" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">H3</div>
                    <div data-action="content" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">Content</div>
                    <div data-action="image" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">Image</div>
                    <div class="btn btn-default load_random_images">Load random images</div>
                    <div id="draggable-random-images"></div>
                </aside>
            </div>

            <div class="col-md-10">

                <div class="page-header">CONTENT</div><br />

                <form target="_blank" action="" method="POST">
                    <input type="hidden" id="preview_content" name="preview_content" value=""/>
                    <button type="button" class="btn btn-default preview_content">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        Preview in Wordpress
                    </button>

                    <button type="button" id="btn_easycontent_optimiz_images" class="btn btn-default refresh_images" data-toggle="modal" data-target="#modalImgOptimiz">
                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                        Optimiz IMG
                    </button>

                    <button type="button" id="btn_easycontent_optimiz_hrefs" class="btn btn-default refresh_links" data-toggle="modal" data-target="#modalHrefOptimiz">
                        <i class="fa fa-link" aria-hidden="true"></i>
                        Optimiz Href
                    </button>
                </form>

                <form>
                    <div id="content-grid" class="form-group">
                        <div id="easycontent-grid"></div>
                    </div>

                    <button type="button" data-id="action" value="set_post_content" class="btn btn-primary push_cms">Envoyer</button>
                </form>

                <div class="form-group">
                    <div class=""></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 h200">&nbsp;</div>
        </div>

        <?php
        // modal for images
        OptimizmeUtils::LoadBloc('easycontent/modal_image_optimisation');

        // modal for hrefs
        OptimizmeUtils::LoadBloc('easycontent/modal_href_optimisation');
        ?>

    </div>
</div> <!-- /.container -->

<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            // load au chargement de la page

            $(document).on('change', '#url_cible', function(){
                $('.load_arborescence').trigger('click');
            })

        })
    })(jQuery)
</script>


</body>
</html>