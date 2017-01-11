<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('weebly/head_push'); ?>

            <form>
                <button type="button" data-id="action" value="get_categories" id="btn_load_arbo" class="btn btn-primary push_cms" data-url="index.php?ajax=weebly" data-after="afterLoadCategories">Load categories</button>
            </form>
        </div>
    </div>


    <div class="row" id="page_easycontenteditor_loadpage">

        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('easycontent/select_categories'); ?>
            <form id="form_load_grideditor">

                <button id="btn-load-category" type="button" data-id="action" value="get_category" class="btn btn-primary push_cms" data-url="index.php?ajax=weebly" data-after="afterLoadCategory">
                    Load category
                </button>
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
                OptimizmeUtils::LoadBloc('weebly/name');

                // titre seo
                OptimizmeUtils::LoadBloc('weebly/category_meta_title');

                // DESCRIPTION
                OptimizmeUtils::LoadBloc('weebly/category_meta_description');

                // PRODUITS ASSOCIES
                OptimizmeUtils::LoadBloc('weebly/category_products_associated');
                ?>

            </div>
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
                        <input type="text" name="url" id="category_image_url" data-id="url" class="form-control" value="" required="" />
                    </div>
                    <div class="col-md-4">
                        <button type="button" data-id="action" value="add_category_image_url" class="btn btn-default t25 push_cms" data-url="index.php?ajax=weebly">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>