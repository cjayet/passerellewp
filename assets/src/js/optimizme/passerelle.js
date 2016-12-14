$(document).ready(function(){

    /**
     * PUSH DATA - Générique
     *
     * pousse l'ensemble des données du formulaire en ajax
     *  - chaque field doit avoir un champ data-id de spécifié (key)
     *  - chaque field doit avoir un champ value de spécifié (value)
     */
    $(document).on('click', '.push_cms', function(){

        var btnClick = $(this);
        var form = $(this).closest('form');

        //var urlArticleCible = $('#easycontent-url').val();        // where to push data

        // où envoyer les data (racine du site)
        var dataUrl = btnClick.attr('data-url');
        if (dataUrl !== undefined && dataUrl != ''){
            var urlArticleCible = dataUrl;
        }
        else {
            var urlArticleCible = $('#url_cible').val();
        }

        console.log('push_cms TO '+ urlArticleCible);


        if (urlArticleCible != '')
        {
            // add loading to form
            form.loading();

            // get inputs in form
            form.each(function(){
                var elements = $(this).find(':input');

                // tableau des données à envoyer
                var tabData = {url_cible: urlArticleCible};
                if ( $('#select_list_posts').length )                       tabData['id_post'] = $('#select_list_posts').val();
                else if ( $('#shopify_select_list_products').length )       tabData['id_post'] = $('#shopify_select_list_products').val();

                // valeurs présentes dans le formulaire
                elements.each(function(){
                    if ( $(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox' ){
                        if ($(this).prop('checked')){
                            tabData[$(this).attr('data-id')] = $(this).val();
                        }
                    }
                    else if ($(this).attr('type') == 'select'){
                        if ($(this).prop('selected')){
                            tabData[$(this).attr('data-id')] = $(this).find(":selected").val();
                        }
                    }
                    else {
                        tabData[$(this).attr('data-id')] = $(this).val();

                        // cas particuliers
                        if ( $(this).attr('data-id') == 'action' && $(this).val() == 'set_post_content'){
                            // contenu : on rajoute le contenu de grid editor
                            tabData['new_content'] = $('#easycontent-grid').gridEditor('getHtml');
                        }
                        else if ( $(this).attr('data-id') == 'action' && $(this).val() == 'set_post_shortdescription'){
                            var newContent = getTinymceContent('easycontent-short_description');
                            tabData['new_short_description'] = newContent;
                        }
                        else if ( $(this).attr('data-id') == 'action' && $(this).val() == 'set_shopify_product_update'){
                            tabData['shop_name'] = $('#url_cible').val();
                            tabData['new_description'] = getTinymceContent('product_description');
                        }
                    }
                });


                // to JSON
                var json_data = JSON.stringify(tabData, null, 2);

                // exécution ajax
                getAjaxResponse(urlArticleCible, json_data, function(msg){

                    // stop loading
                    form.loading('stop');

                    // lance une fonction supplémentaire si nécessaire : définie dans data-after
                    var traitementSupp = btnClick.attr('data-after');
                    if (traitementSupp !== undefined && traitementSupp != ''){
                        window[traitementSupp](msg);
                    }

                    // cas particulier : envoi contenu easycontent
                    if (tabData['action'] == 'set_post_content'){
                        if (msg.result == 'success'){
                            // réactive les modales
                            setBoolContentUpdatedAndNotSaved(false);

                            // réinject le contenu de wordpress dans le grid editor
                            easycontentGridInit(msg.content, false);

                        }
                    }

                    // add message under form
                    form.append('<div class="form-group result_push_cms"><div class="alert alert-'+ msg.result +'">'+ msg.message +'</div></div>');
                })
            });
        }
        else {
            // error
            sweetAlert("Oops...", "No URL to perform ajax!", "error");
        }

    });

})
