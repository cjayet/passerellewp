<?php /** COMMUN  **/ ?>
<form>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="easycontent-slug">Slug (Catégorie)</label>
            <input type="text" name="easycontent-slug" id="easycontent-slug" data-id="new_slug" class="form-control" />
        </div>
        <div class="col-md-4">
            <button type="button" data-id="action" value="set_category_slug" class="btn btn-default t25 push_cms" data-after="updateUrlField">Envoyer</button>
        </div>
    </div>
</form>