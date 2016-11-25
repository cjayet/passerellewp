<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('head_push'); ?>

            <form action="" method="POST">
                <button id="btn-load-grideditor" type="button" data-id="action" value="load_post_content" class="btn btn-primary load_grid_editor" data-target="#easycontent-grid">Load content</button>
            </form>
            <div class="form-group">
                <div class=""></div>
            </div>
            <br /><hr /><br />
        </div>
    </div>


    <div id="container-easycontent" style="display: none">
        <div class="row" >

            <div class="col-md-12">

                <?php
                // TITRE
                OptimizmeUtils::LoadBloc('form-push/title');

                // PERMALINK
                OptimizmeUtils::LoadBloc('form-push/permalink');

                // URL CANONIQUE
                OptimizmeUtils::LoadBloc('form-push/url_canonique');

                // META DESCRIPTION
                OptimizmeUtils::LoadBloc('form-push/meta_description');

                // META ROBOTS
                OptimizmeUtils::LoadBloc('form-push/meta_robots');

                // PUBLISH
                OptimizmeUtils::LoadBloc('form-push/publish');

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
                    <div data-action="h1" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H1</div>
                    <div data-action="h2" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H2</div>
                    <div data-action="h3" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H3</div>
                    <div data-action="content" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG Content</div>
                    <div data-action="image" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG Image</div>
                    <div id="draggable-random-images"></div>
                    <div class="btn btn-default load_random_images">Load random images</div>
                </aside>
            </div>

            <div class="col-md-10">

                <div class="page-header">CONTENT</div><br />

                <form target="_blank" action="" method="POST">
                    <input type="hidden" id="preview_content" name="preview_content" value=""/>
                    <button type="button" class="btn btn-default preview_content" >Preview in Wordpress</button>
                </form>

                <form>
                    <div id="content-grid" class="form-group">
                        <div id="easycontent-grid"></div>
                    </div>

                    <button type="button" data-id="action" value="set_content" class="btn btn-primary push_cms">Envoyer</button>
                    <div class="form-group result_push_cms"><div class=""></div></div>
                </form>

                <div class="form-group">
                    <div class=""></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 h200">&nbsp;</div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <h2>Optimisation des images présentes dans le contenu</h2>
                <div id="image-list"></div>
                <div class="btn btn-primary refresh_images">Rafraichir</div>
                <br /><hr /><br />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Optimisation des liens présents dans le contenu</h2>
                <div id="href-list"></div>
                <div class="btn btn-primary refresh_links">Rafraichir</div>
                <br /><hr /><br />
            </div>
        </div>

    </div>
</div> <!-- /.container -->

<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            // load au chargement de la page
            $('.load_grid_editor').trigger('click');
            $('.load_random_images').trigger('click');
        })
    })(jQuery)
</script>


</body>
</html>