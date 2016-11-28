<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?php OptimizmeUtils::LoadBloc('head_push'); ?>
          <hr />
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
                        <input type="radio" data-id="post_type" name="post_type" class="post_type" value="post"> Article
                    </label>
                    <label>
                        <input type="radio" data-id="post_type" name="post_type" class="post_type" value="page"> Page
                    </label>
                </div>

                <div id="liste-pages" class="form-group" style="display: none">
                    <label for="title">Page parente</label>
                    <select id="select_post_parent" data-id="parent" name="parent" class="form-control">
                        <option value="0">No parent</option>
                        <option value="1">Test1</option>
                        <option value="1">Test2</option>
                    </select>
                </div>

                <button type="button" data-id="action" value="set_create_post" class="btn btn-primary push_cms">Ajouter</button>
            </form>
        </div>

        <br /><hr /><br />
    </div>
</div>

<script type="text/javascript">
    (function($){
        $(document).ready(function(){

            var urlArticleCible = $('#url_cible').val();        // site where to push data

            ////////////////////////////////////////
            // RECUPERATION LISTE DES PAGES
            ////////////////////////////////////////

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_posts_pages';
            var json_data = JSON.stringify(tabData, null, 2);

            getAjaxResponse(urlArticleCible, json_data, function(msg){
                if (msg.result == 'success'){
                    $('#select_post_parent').empty();
                    $('#select_post_parent').append('<option value="0">-- No parent --</option>');
                    if (msg.arborescence.pages.length > 0){
                        $.each(msg.arborescence.pages, function(idx, page){
                            $('#select_post_parent').append('<option value="'+ page.ID +'">'+ page.post_title +'</option>');
                        })
                    }
                }
            })


            // affiche ou non l'arborescence des pages (non pour post, oui pour page)
            $(document).on('change', '.post_type', function(){
                var type = ( $('input[name=post_type]:checked').val());
                if (type == 'page')     $('#liste-pages').slideDown();
                else                    $('#liste-pages').slideUp();
            })

        })
    })(jQuery)
</script>

</body>
</html>
