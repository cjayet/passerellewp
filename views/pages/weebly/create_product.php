<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div id="page-weebly-createproduct" class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('weebly/head_push'); ?>
            <form>
                <button type="button" data-id="action" value="check_product_create" id="btn_load_arbo" class="btn btn-primary push_cms" data-url="index.php?ajax=weebly" data-after="afterCheckProductCreateWeebly">Begin creation</button>
            </form>
        </div>
    </div>
    <hr /><br />

    <div id="page_easycontenteditor_loadpage" style="display: none">
        <div class="row" >
            <div class="col-md-12">
                <form>
                    <h2 id="bloc_title">New product </h2>

                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" name="name" data-id="name" placeholder="Name" value="" />
                    </div>

                    <div class="form-group">
                        <label for="product_price">Price *</label>
                        <input type="text" name="product_price" id="product_price" data-id="price" class="form-control" placeholder="Price" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="product_type">Product type *</label>
                        <select name="product_type" id="product_type" data-id="type" class="form-control">
                            <option value="physical">Physical</option>
                            <option value="digital">Digital</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_description">Description</label>
                        <textarea name="product_description" id="product_description" data-id="description" class="form-control"></textarea>
                    </div>

                    <button type="button" data-id="action" value="add_product" data-url="index.php?ajax=weebly" class="btn btn-primary push_cms">Add product</button>
                </form>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>