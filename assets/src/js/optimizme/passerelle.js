(function($){
    $(document).ready(function(){

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

            var urlArticleCible = $('#url_cible').val();        // where to push data

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

                    // stop loading
                    form.loading('stop');

                    // add message under form
                    form.append('<div class="form-group result_push_cms"><div class="alert alert-'+ msg.result +'">'+ msg.message +'</div></div>');
                })

            });
        });


        /**
         *  Affichage des redirections présentes en base dans la page "Redirections"
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
         *  Redirections table: actions (active/désacrive/supprime)
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
         * easycontent editor: affichage du preview du post (article/page) dans wordpress
         */
        $(document).on('click', '.preview_content', function(){

            var urlArticleCible = $('#url_cible').val();        // site where to push data
            var form = $(this).closest('form');

            var contenuEditeur = $('#easycontent-grid').gridEditor('getHtml');
            $('#preview_content').attr('value', contenuEditeur);
            form.attr('action', urlArticleCible );
            form.submit();
        })


    })
})(jQuery);