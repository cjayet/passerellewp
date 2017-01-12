<?php /** COMMUN  **/ ?>
<form>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="noindex">Publish</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox" data-id="product_is_publish" id="easycontent-publish" name="is_publish" value="1"> Publié
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" data-id="action" value="set_product_publish" data-url="index.php?ajax=weebly" class="btn btn-default t25 push_cms">Envoyer</button>
        </div>
    </div>
</form>