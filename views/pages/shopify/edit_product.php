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
            <?php
            // update alt image
            // TODO alt à faire marcher
            //$dataImage = array('image' => array('position' => 1 , 'metafields' => array("namespace"=> "tags",  "key" => "alt", "value" => "basket of kittens", "value_type" => "string")));
            //$dataImage = array('image' => array('position' => 1 , 'metafields' => array("key" => "alt", "value" => "basket of kittens", "value_type" => "string")));

            //$dataImage = array('image' => array('position' => 1 ));
            //$image = $shopify('PUT', '/admin/products/8590696909/images/19866381965.json', $dataImage);
            ?>

            <form method="post" action="">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="product_name" data-id="name" class="form-control" value="" required="" />

                        <label for="metatitle">Slug</label>
                        <input type="text" name="handle" id="product_handle" data-id="handle" class="form-control" value="" required="" />
                        <input type="hidden" name="current_handle" id="product_current_handle" data-id="current_handle" class="form-control" value="<?php echo $produit['handle'] ?>" />

                        <label for="metatitle">Meta title</label>
                        <input type="text" name="metatitle" id="product_metatitle" data-id="metatitle" class="form-control" value="" />

                        <label for="metadescription">Meta Description</label>
                        <input type="text" name="metadescription" id="product_metadescription" data-id="metadescription" class="form-control" value="" />

                        <label for="description">Description</label>
                        <textarea name="description" id="product_description" class="form-control"></textarea>

                    </div>
                    <div class="col-md-12">
                        <button type="button" data-id="action" value="set_shopify_product_update" class="btn btn-primary push_cms" data-url="index.php?ajax=shopifySaveProduct">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>

</body>
</html>