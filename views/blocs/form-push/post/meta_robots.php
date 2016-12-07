<?php /** COMMUN  **/ ?>
<form>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="noindex">Meta robots</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox" data-id="noindex" id="easycontent-noindex" name="noindex" value="1"> noindex
                </label>
                <label>
                    <input type="checkbox" data-id="nofollow" id="easycontent-nofollow" name="nofollow" value="1"> nofollow
                </label>
            </div>

            <div id="alert_no_search_engines" class="alert alert-info">
                <p>Le site n'autorise pas les moteurs de recherche, noindex+follow par défaut.</p>
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" data-id="action" value="set_post_metarobots" class="btn btn-default t25 push_cms">Envoyer</button>
        </div>
    </div>
</form>