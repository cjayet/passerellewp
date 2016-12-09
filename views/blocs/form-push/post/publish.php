<?php /** COMMUN  **/ ?>
<form>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="noindex">Contenu publié</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox" data-id="is_publish" id="easycontent-publish" name="is_publish" value="1"> Publier le contenu
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" data-id="action" value="set_post_status" class="btn btn-default t25 push_cms">Envoyer</button>
        </div>
    </div>
</form>