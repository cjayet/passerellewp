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

        //var urlArticleCible = $('#url_cible').val();          // where to push data
        var urlArticleCible = $('#easycontent-url').val();      // where to push data
        console.log('push_cms TO '+ urlArticleCible);

        // add loading to form
        form.loading();

        // get inputs in form
        form.each(function(){
            var elements = $(this).find(':input');

            // tableau des données à envoyer
            var tabData = {url_cible: urlArticleCible};
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

                    if ( $(this).attr('data-id') == 'action' && $(this).val() == 'set_post_content'){
                        // cas particulier : on rajoute le contenu de grid editor
                        tabData['new_content'] = $('#easycontent-grid').gridEditor('getHtml');
                    }
                }
            });

            // to JSON
            var json_data = JSON.stringify(tabData, null, 2);


            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){

                // lance une fonction supplémentaire si nécessaire : définie dans data-after
                var traitementSupp = btnClick.attr('data-after');
                if (traitementSupp !== undefined && traitementSupp != ''){
                    window[traitementSupp](msg);
                }

                // stop loading
                form.loading('stop');

                // add message under form
                form.append('<div class="form-group result_push_cms"><div class="alert alert-'+ msg.result +'">'+ msg.message +'</div></div>');

                // cas particulier : envoi contenu easycontent
                if (tabData['action'] == 'set_post_content'){
                    if (msg.result == 'success'){
                        // réactive les modales
                        setBoolContentUpdatedAndNotSaved(false);
                    }
                }
            })

        });
    });

})