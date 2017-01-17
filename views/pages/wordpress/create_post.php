<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?php OptimizmeUtils::LoadBloc('wordpress/head_push'); ?>
            <form>
                <!-- <button type="button" data-id="action" id="btn_createpostpage_loadarborescence" class="btn btn-primary">Reload pages</button> -->
                <button type="button" data-id="action" id="btn_createpostpage_loadarborescence" class="btn btn-primary push_cms" data-after="after">Reload pages</button>
                <div id="easycontent-url" value="" />
            </form>
            <hr /><br />
        </div>

        <div class="col-md-9">
            <form>
                <h2 id="bloc_title">Saisie du nouveau contenu </h2>

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" class="form-control" name="title" data-id="title" placeholder="Titre" value="" />
                </div>

                <label for="post_type">Type de contenu</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" data-id="post_type" name="post_type" class="createpostpage_post_type" value="post"> Article
                    </label>
                    <label>
                        <input type="radio" data-id="post_type" name="post_type" class="createpostpage_post_type" value="page"> Page
                    </label>
                </div>

                <div id="liste-pages" class="form-group" style="display: none">
                    <label for="title">Page parente</label>
                    <select id="select_post_parent" data-id="parent" name="parent" class="form-control"></select>
                </div>

                <label for="post_type">État</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" data-id="post_status" name="post_status" value="publish"> Publié
                    </label>
                    <label>
                        <input type="radio" data-id="post_status" name="post_status" value="draft"> Brouillon
                    </label>
                </div>


                <button type="button" data-id="action" value="set_create_post" class="btn btn-primary push_cms">Ajouter</button>
                <div id="easycontent-url" value="" />
            </form>
        </div>

        <br /><hr /><br />
    </div>
</div>

<script type="text/javascript">
    (function($){
        $(document).ready(function(){

            // on  load
            $('#btn_createpostpage_loadarborescence').trigger('click');

            // on change
            $(document).on('change', '#url_cible', function(){
                $('#btn_createpostpage_loadarborescence').trigger('click');
            })

        })
    })(jQuery)
</script>

</body>
</html>
