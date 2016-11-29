$(document).ready(function(){

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

                    if (tabData['action'] == 'redirection_enable')      rowTr.removeClass().addClass('success');
                    if (tabData['action'] == 'redirection_disable')     rowTr.removeClass().addClass('danger');
                    if (tabData['action'] == 'redirection_delete')      rowTr.remove();
                }
                else {
                    alert('Error ajax');
                }

            })
        }
    });
})
