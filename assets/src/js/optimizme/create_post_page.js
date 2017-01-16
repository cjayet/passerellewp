$(document).ready(function(){

    // affiche ou non l'arborescence des pages (non pour post, oui pour page)
    $(document).on('change', '.createpostpage_post_type', function(){
        var type = ( $('input[name=post_type]:checked').val());
        if (type == 'page')     $('#liste-pages').slideDown();
        else                    $('#liste-pages').slideUp();
    })


    // chargement des pages du site demandé
    $(document).on('click', '#btn_createpostpage_loadarborescence', function(){

        var urlArticleCible = $('#url_cible').val();        // site where to push data
        $('#easycontent-url').val(urlArticleCible);         // for push

        ////////////////////////////////////////
        // RECUPERATION LISTE DES PAGES
        ////////////////////////////////////////

        if (urlArticleCible != '')
        {
            $('body').loading();

            // préparation requête ajax
            var tabData = {url_cible: 'test'};
            tabData['action'] = 'load_posts_pages';

            getAjaxResponse(urlArticleCible, tabData, function(msg){
                $('body').loading('stop');

                if (msg.result == 'success'){
                    $('#select_post_parent').empty();
                    $('#select_post_parent').append('<option value="0">No parent</option>');
                    if (msg.arborescence.pages.length > 0){
                        $.each(msg.arborescence.pages, function(idx, page){
                            $('#select_post_parent').append('<option value="'+ page.ID +'">'+ page.post_title +' ['+ page.post_status +']</option>');
                        })
                    }
                }
                else {
                    sweetAlert("Oops...", "Error loading pages, please try again", "error");
                }
            })
        }

    })

})