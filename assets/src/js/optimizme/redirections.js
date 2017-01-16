/**
 * Load redirections
 */
function loadRedirectionsFromSite(){

    // suppression des lignes de redirection
    removeNodeEverywhere('.ligne_table_redirection');

    /**
     *  Affichage des redirections présentes en base dans la page "Redirections"
     */
    if ($('#page-redirections').length > 0){

        var urlArticleCible = $('#url_cible').val();        // site where to push data
        $('body').loading();

        // préparation requête ajax
        var tabData = {url_cible: urlArticleCible};
        tabData['action'] = 'load_redirections';

        // exécution ajax
        getAjaxResponse(urlArticleCible, tabData, function(msg){
            $('body').loading('stop');
            if (msg.result == 'success'){
                if (msg.redirections.length > 0)
                {
                    // ajout de la liste des redirections
                    $("#redirection-table-ligne").tmpl(msg).appendTo("#table-redirections tbody");
                }
            }
            else {
                sweetAlert("Oops...", "Error loading redirections", "error");
            }
        })

    }
}


/**
 * Load all redirections for online CMS
 * @param cms : shopify/weebly
 */
function loadAllRedirectionsApi(cms){
    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        action: 'get_redirections'
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax='+ cms, tabData, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){

            // remove all lines
            removeNodeEverywhere('.ligne_table_redirection');

            if (msg.redirections.length > 0)
            {
                // ajout de la liste des redirections
                $("#redirection-table-ligne").tmpl(msg).appendTo("#table-redirections tbody");
            }
        }
        else {
            sweetAlert("Oops...", "Error loading redirections", "error");
        }
    })
}


/**
 *  Redirections table: actions (active/désacrive/supprime)
 */
$(document).on('click', '.confirmAction', function(){

    var btnClick = $(this);

    // popup confirmation
    swal({
            title: "Are you sure?",
            text: "Do you really want to do this?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, just do it!",
            closeOnConfirm: true
        },
        function(){

            var dataUrl = btnClick.attr('data-url');
            if (dataUrl !== undefined && dataUrl != '')     var urlArticleCible = dataUrl;
            else                                            var urlArticleCible = $('#url_cible').val();

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = btnClick.attr('data-action');
            tabData['id_redirection'] = btnClick.attr('data-id');

            // specifique
            var cms = btnClick.attr('data-cms');
            if (cms !== undefined && cms == ''){
                tabData['shop_name'] = $('#url_cible').val();
            }

            // exécution ajax
            getAjaxResponse(urlArticleCible, tabData, function(msg){

                if (msg.result == 'success'){
                    // additionnal action to do
                    var rowTr = $('#table-redirections #redirection-'+ tabData['id_redirection']);

                    if (tabData['action'] == 'redirection_enable')      rowTr.removeClass('danger').addClass('success');
                    if (tabData['action'] == 'redirection_disable')     rowTr.removeClass('success').addClass('danger');
                    if (tabData['action'] == 'redirection_delete')      rowTr.remove();
                }
                else {
                    sweetAlert("Oops...", "Error ajax: " + msg.message, "error");
                }

            })
        });

});