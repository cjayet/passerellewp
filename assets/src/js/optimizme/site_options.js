$(document).ready(function(){

    $(document).on('click', '#load_site_options', function(){

        // load des informations du site au chargement de la page
        var urlArticleCible = $('#url_cible').val();        // site where to push data
        $('#easycontent-url').val(urlArticleCible);         // for push
        form = $(this).closest('form');

        // site selected?
        if (urlArticleCible != '')
        {
            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_site_options';
            var json_data = JSON.stringify(tabData, null, 2);

            $('body').loading();

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){

                if (msg.result == 'success'){
                    $('#easycontent_site_title').val(msg.site_title);
                    $('#easycontent_site_description').val(msg.site_description);

                    if (msg.site_is_public == "1")      $('#nosearchengine').prop('checked', false);
                    else                                $('#nosearchengine').prop('checked', true);
                }

                // stop loading
                $('body').loading('stop');
            })
        }

    })


})