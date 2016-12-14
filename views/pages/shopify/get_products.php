<?php
// Set variables for our request
$shop = "optimiz-me-dev.myshopify.com";
$token = "81dbd9fd6d0d2a31f27286724461ef65";
$query = array(
	"Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);


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


    <div class="row" >
        <div class="col-md-12">

            <table class="table table-striped table-hover" id="table-products">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Title</th>
                </tr>
                </thead>
                <tbody>
                    <?php OptimizmeUtils::LoadBloc('js-tmpl/shopify_produit_boucle', 'html') ?>
                </tbody>
            </table>

            <?php
            // get all products
            $shopObj = new ShopifyEasycontent();
            $shopify = $shopObj->loadShopConnection($shop);
            $products = ShopifyEasycontent::getAllProducts($shopify);

            //echo '<h3>'. count($products) . ' produits au total<h3>';
            OptimizmeUtils::nice($products);

            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>

</body>
</html>