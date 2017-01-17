<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('shopify/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="shopify_load_products" class="btn btn-primary">Load products</button>
            </form>
            <hr /><br />
        </div>
    </div>

    <div class="row" id="page_easycontenteditor_loadpage">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('shopify/select_products_arborescence'); ?>
            <form id="form_load_grideditor">
                <button id="btn-load-shopify-product" type="button" class="btn btn-primary shopify_load_product" data-target="#easycontent-grid">Load content</button>
            </form>
            <hr /><br />
        </div>
    </div>

    <div class="row" id="container-shopify">
        <div class="col-md-12">

            <h3>Produit : </h3>
            <form method="post" action="">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="product_name" data-id="name" class="form-control" value="" required="" />

                        <label for="metatitle">Slug</label>
                        <input type="text" name="handle" id="product_handle" data-id="handle" class="form-control" value="" required="" />
                        <input type="hidden" name="current_handle" id="product_current_handle" data-id="current_handle" class="form-control" value="" />

                        <label for="metatitle">Meta title</label>
                        <input type="text" name="metatitle" id="product_metatitle" data-id="metatitle" class="form-control" value="" />

                        <label for="metadescription">Meta Description</label>
                        <input type="text" name="metadescription" id="product_metadescription" data-id="metadescription" class="form-control" value="" />

                        <label for="description">Description</label>
                        <textarea name="product_description" id="product_description" data-id="product_description" data-tinymce="1" class="form-control loadTinyMCE"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="button" data-id="action" value="update_product" class="btn btn-primary push_cms" data-url="index.php?ajax=shopify">Envoyer</button>
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
                        <button type="button" data-id="action" value="add_product_image_url" class="btn btn-default t25 push_cms" data-url="index.php?ajax=shopify" data-after="shopifyRefreshProductImages">Envoyer</button>
                    </div>
                </div>
            </form>


            <form enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="url"> Upload image from computer</label>
                        <input type="file" name="image_computer" id="image_computer" data-id="computer" class="form-control" value="" required="" />
                        <input type="file" name="image_computer2" id="image_computer2" data-id="computer2" class="form-control" value="" required="" />
                    </div>
                    <div class="col-md-4">
                        <button type="button" data-id="action" value="add_product_image_computer" class="btn btn-default t25 push_cms" data-url="index.php?ajax=shopify" data-after="shopifyRefreshProductImages">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>

</div>



</body>
</html>