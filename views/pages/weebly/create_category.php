<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('weebly/head_push'); ?>
            <form>
                <button type="button" data-id="action" value="get_categories_products" id="btn_load_arbo" class="btn btn-primary push_cms" data-url="index.php?ajax=weebly" data-after="afterLoadCategories">Load categories</button>
            </form>
        </div>
    </div>
    <hr /><br />

    <div id="page_easycontenteditor_loadpage" style="display: none">
        <div class="row" >
            <div class="col-md-12">
                <form>
                    <h2 id="bloc_title">new category </h2>

                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" name="name" data-id="name" placeholder="Name" value="" />
                    </div>

                    <div class="form-group">
                        <label for="category_metatitle">Meta title</label>
                        <input type="text" name="category_metatitle" id="category_metatitle" data-id="meta_title" class="form-control" placeholder="Meta title (Optionnal)" />
                    </div>

                    <div class="form-group">
                        <label for="category_metatitle">Meta description</label>
                        <input type="text" name="category_metadescription" id="category_metadescription" data-id="meta_description" class="form-control" placeholder="Meta description (Optionnal)" />
                    </div>

                    <div class="form-group">
                        <label for="checkbox_products">Products associated</label>
                        <div id="checkbox_products"></div>
                    </div>

                    <button type="button" data-id="action" value="add_category" data-url="index.php?ajax=weebly" class="btn btn-primary push_cms">Add category</button>
                </form>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>