<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('magento/head_push'); ?>

            <form>
                <button type="button" data-id="action" value="load_categories" id="btn_load_arbo" class="btn btn-primary push_cms" data-after="afterLoadCategories">Load categories</button>
            </form>
        </div>
    </div>


    <div class="row" id="page_easycontenteditor_loadpage">

        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('easycontent/select_categories'); ?>
            <form id="form_load_grideditor">

                <button id="btn-load-category" type="button" data-id="action" value="load_category_content" class="btn btn-primary push_cms" data-after="afterLoadCategory">
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
                 // TITRE
                OptimizmeUtils::LoadBloc('form-push/category/name');

                // DESCRIPTION
                OptimizmeUtils::LoadBloc('form-push/category/description');
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>