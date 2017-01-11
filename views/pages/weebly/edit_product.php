<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('weebly/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="weebly_load_products" class="btn btn-primary">Load products</button>
            </form>
            <hr /><br />
        </div>
    </div>

    <div class="row" id="page_easycontenteditor_loadpage">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('weebly/select_products_arborescence'); ?>
            <form id="form_load_grideditor">
                <button id="btn-load-weebly-product" type="button" class="btn btn-primary weebly_load_product" data-target="#easycontent-grid">Load content</button>
            </form>
            <hr /><br />
        </div>
    </div>

    <div class="row" id="container-weebly">
        <div class="col-md-12">

            <h3>Produit : </h3>
            <form method="post" action="">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="product_name" data-id="name" class="form-control" value="" required="" />

                        <label for="metatitle">URL</label>
                        <input type="text" name="handle" id="product_url" data-id="url" class="form-control" value="" disabled="" />

                        <label for="description">Description</label>
                        <textarea name="product_description" id="product_description" data-id="product_description" data-tinymce="1" class="form-control loadTinyMCE"></textarea>

                        <?php
                        // PUBLISH
                        OptimizmeUtils::LoadBloc('form-push/post/publish');
                        ?>

                    </div>
                    <div class="col-md-12">
                        <button type="button" data-id="action" value="update_product" class="btn btn-primary push_cms" data-url="index.php?ajax=weebly">Envoyer</button>
                    </div>
                </div>
            </form>

        </div>

        <div class="row">
            <div class="col-md-12 h200">&nbsp;</div>
        </div>

        <div class="row">
            <h3>IMG LIST :</h3>
            <div id="image-list"></div>
        </div>

        <div class="row">

            <h3>IMG ENVOI :</h3>
            <p>
                Exemples :
                <ul>
                    <li>http://www.azlegal.com/wp-content/uploads/sites/22/2014/09/corporate_law.jpg</li>
                    <li>http://files.globallc.webnode.com/200000017-c5bb9c6b5f/Corporate_Image.jpg</li>
                    <li>http://sncevent.com/wp-content/uploads/2016/10/Corporate-Training.jpg</li>
                </ul>
            </p>
            <form>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="url"> Upload image from URL</label>
                        <input type="text" name="url" id="image_url" data-id="url" class="form-control" value="" required="" />
                    </div>
                    <div class="col-md-4">
                        <button type="button" data-id="action" value="add_product_image_url" class="btn btn-default t25 push_cms" data-url="index.php?ajax=weebly" data-after="weeblyRefreshProductImages">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>



</div>


<script type="text/javascript">
    (function($){
        $(document).ready(function(){

            $(document).on('change', '#url_cible', function(){
                $('.load_arborescence').trigger('click');
            })

        })
    })(jQuery)
</script>

</body>
</html>