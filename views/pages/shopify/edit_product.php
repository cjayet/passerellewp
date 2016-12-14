<?php
require 'vendor/autoload.php';
use sandeepshetty\shopify_api;

// Set variables for our request
$shop = "optimiz-me-dev.myshopify.com";
$token = "81dbd9fd6d0d2a31f27286724461ef65";
$query = array(
    "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);

$shopify = shopify_api\client(
    $shop, '81dbd9fd6d0d2a31f27286724461ef65', '2cba3b567d19031ae9e4900cafed2e96', '824b1bd54e591972deb0ed99ef724327'
);

// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('shopify/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="load_site_options" class="btn btn-primary">Load products</button>
                <div id="easycontent-url" value="" />
            </form>
            <hr /><br />
        </div>
    </div>


    <div class="row" >
        <div class="col-md-12">

            <h3>Produit (id : 8590696909) : </h3>

            <?php
            // update post
            //OptimizmeUtils::nice($_POST); die;
            if (isset($_POST['name']) && $_POST['name'] != ''){


                // update post name
                $data = array(
                        'product' => array(
                            'id' => '8590696909',
                            'title' => $_POST['name'],
                            'metafields_global_title_tag' => $_POST['metatitle'],
                            'metafields_global_description_tag' => $_POST['metadescription'],
                            'body_html' => addslashes($_POST['description']),
                            'handle' => $_POST['handle']
                        ),
                        'images' => array('metafields' => array("namespace"=> "tags",  "key" => "alt", "value" => "basket of kittens", "value_type" => "string"))
                );
                $products = $shopify('PUT', '/admin/products/8590696909.json', $data);


                // creation d'une redirection (si nouvelle saisie)
                if ( isset($_POST['handle']) && $_POST['handle'] != '' && isset($_POST['current_handle']) && $_POST['current_handle'] != $_POST['handle']){
                    // new handle: ajour d'une redirection
                    $dataRedirect = array('redirect' => array('path' => '/products/'. $_POST['current_handle'], 'target' => '/products/'. $_POST['handle']));
                    $redirection = $shopify('POST', '/admin/redirects.json', $dataRedirect);
                    OptimizmeUtils::nice($redirection);
                }

            }

            // récupération du produit
            $produit = $shopify('GET', '/admin/products/8590696909.json');

            // récupération des meta (meta title / meta description)
            $metaProduct = $shopify('GET', '/admin/products/8590696909/metafields.json');

            // update alt image
            // TODO alt à faire marcher
            //$dataImage = array('image' => array('position' => 1 , 'metafields' => array("namespace"=> "tags",  "key" => "alt", "value" => "basket of kittens", "value_type" => "string")));
            //$dataImage = array('image' => array('position' => 1 , 'metafields' => array("key" => "alt", "value" => "basket of kittens", "value_type" => "string")));
            $dataImage = array('image' => array('position' => 1 ));
            $image = $shopify('PUT', '/admin/products/8590696909/images/19866381965.json', $dataImage);
            ?>

            <form method="post" action="">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="name">Title</label>
                        <input type="text" name="name" id="name" data-id="name" class="form-control" value="<?php echo $produit['title'] ?>" required="" />

                        <label for="metatitle">Slug</label>
                        <input type="text" name="handle" id="handle" data-id="handle" class="form-control" value="<?php echo $produit['handle'] ?>" required="" />
                        <input type="hidden" name="current_handle" id="current_handle" data-id="current_handle" class="form-control" value="<?php echo $produit['handle'] ?>" />

                        <label for="metatitle">Meta title</label>
                        <input type="text" name="metatitle" id="metatitle" data-id="metatitle" class="form-control" value="<?php echo $metaProduct[1]['value'] ?>" />

                        <label for="metadescription">Meta Description</label>
                        <input type="text" name="metadescription" id="metadescription" data-id="metadescription" class="form-control" value="<?php echo $metaProduct[0]['value'] ?>" />

                        <label for="easycontent_short_description">Description</label>
                        <textarea name="description" id="description" class="form-control"><?php echo $produit['body_html'] ?></textarea>

                    </div>
                    <div class="col-md-4">
                        <input type="submit" class="btn btn-primary t25" />
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
    $(document).ready(function(){

        if ( $('#description').length ){
            loadTinyMCE('#description');
        }

    })
</script>

</body>
</html>