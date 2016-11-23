<?php
// header: scripts + navigation bar
include('includes/blocs/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?php include('includes/blocs/head_push.php') ?>
          <hr />
        </div>

        <div class="col-md-9">
            <form>

                <h2 id="bloc_title">Saisie du nouveau contenu </h2>
                <label for="post_type">Type de contenu</label>
                <div class="checkbox">
                    <label>
                        <input type="radio" data-id="post_type" name="post_type" value="post"> Article
                    </label>
                    <label>
                        <input type="radio" data-id="post_type" name="post_type" value="page"> Page
                    </label>
                </div>

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" class="form-control" name="title" data-id="title" placeholder="Titre" value="" />
                </div>

                <button type="button" data-id="action" value="set_create_post" class="btn btn-primary push_wp">Ajouter</button>

            </form>
            <div class="form-group">
                <div class=""></div>
            </div>
        </div>

        <br /><hr /><br />
    </div>
</div>

<script type="text/javascript">
    (function($){
        $(document).ready(function(){

            var urlArticleCible = $('#url_cible').val();        // site where to push data

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_posts_pages';
            var json_data = JSON.stringify(tabData, null, 2);

            getAjaxResponse(urlArticleCible, json_data, function(msg){
                // todo
                alert(msg.result)
            })

        })
    })(jQuery)
</script>

</body>
</html>
