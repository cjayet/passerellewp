(function($){
    $(document).ready(function(){

        $.prettyLoader();

        /**
         * PUSH DATA - Générique
         *
         * pousse l'ensemble des données du formulaire en ajax
         *  - chaque field doit avoir un champ data-id de spécifié (key)
         *  - chaque field doit avoir un champ value de spécifié (value)
         */
        $(document).on('click', '.push_cms', function(){

            // récupération des éléments input du form (input, select, textarea)
            var btnClick = $(this);
            var form = $(this).closest('form');
            var containerMsg = form.find('.result_push_cms').children(0);
            containerMsg.removeClass().html('');
            var urlArticleCible = $('#url_cible').val();        // site where to push data

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
                            // TODO à tester si bien ok
                            tabData[$(this).attr('data-id')] = $(this).find(":selected").val();
                        }
                    }
                    else {
                        tabData[$(this).attr('data-id')] = $(this).val();

                        if ( $(this).attr('data-id') == 'action' && $(this).val() == 'set_content'){
                            // cas particulier : on rajoute le contenu de grid editor
                            tabData['new_content'] = $('#easycontent-grid').gridEditor('getHtml');
                        }
                    }
                });

                // to JSON
                var json_data = JSON.stringify(tabData, null, 2);


                // exécution ajax
                getAjaxResponse(urlArticleCible, json_data, function(msg){
                    // show results below
                    containerMsg.addClass('alert alert-'+msg.result);
                    containerMsg.html(msg.message);
                })

            });
        });


        /**
         *
         */
        if ($('#page-redirections').length > 0){
            var urlArticleCible = $('#url_cible').val();        // site where to push data

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_redirections';
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){
                if (msg.result == 'success'){
                    if (msg.redirections.length > 0)
                    {
                        // ajout de la liste des redirections
                        $("#redirection-table-ligne").tmpl(msg).appendTo("#table-redirections tbody");
                    }

                }
                else {
                    alert('Error loading redirections')
                }
            })
        }


        /**
         *  Redirections table: actions
         */
        $(document).on('click', '.confirmAction', function(){
            if (confirm('Please confirm your action')){

                var urlArticleCible = $('#url_cible').val();        // site where to push data

                // préparation requête ajax
                var tabData = {url_cible: urlArticleCible};
                tabData['action'] = $(this).attr('data-action');
                tabData['id_redirection'] = $(this).attr('data-id');
                var json_data = JSON.stringify(tabData, null, 2);

                // exécution ajax
                getAjaxResponse(urlArticleCible, json_data, function(msg){

                    if (msg.result == 'success'){
                        // additionnal action to do
                        var rowTr = $('#table-redirections #redirection-'+ tabData['id_redirection']);

                        if (tabData['action'] == 'enable_redirection')      rowTr.removeClass().addClass('success');
                        if (tabData['action'] == 'disable_redirection')     rowTr.removeClass().addClass('danger');
                        if (tabData['action'] == 'delete_redirection')      rowTr.remove();
                    }
                    else {
                        alert('Error ajax');
                    }

                })
            }
        });






        /**
         * easycontent editor: append de contenu
         */
        $(document).on('click', '.preview_content', function(){


            var urlArticleCible = $('#url_cible').val();        // site where to push data

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_full_preview_post';
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){
                if (msg.result == 'success'){

                    // add content with simple bootstrap form
                    alert(msg.preview);

                }

            })

        })


    })
})(jQuery);