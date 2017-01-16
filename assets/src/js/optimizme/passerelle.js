$(document).ready(function () {

    /**
     * PUSH DATA - Générique
     *
     * pousse l'ensemble des données du formulaire en ajax
     *  - chaque field doit avoir un champ data-id de spécifié (key)
     *  - chaque field doit avoir un champ value de spécifié (value)
     */
    $(document).on('click', '.push_cms', function () {

        var btnClick = $(this);
        var form = $(this).closest('form');
        var allInputProcessed = false;
        var nbFilesUploadProcessing = 0;
        var shopname = '';

        // où envoyer les data (racine du cms cible, ou fichier ajax de la passerelle ?)
        var dataUrl = btnClick.attr('data-url');
        if (dataUrl !== undefined && dataUrl != ''){
            // ajax passerelle
            var urlArticleCible = dataUrl;v
            shopname = $('#url_cible').val();
        }
        else {
            // cms
            var urlArticleCible = $('#url_cible').val();
        }

        console.log('push_cms TO ' + urlArticleCible);

        if (urlArticleCible != ''){
            // add loading to form
            form.loading();

            // get inputs in form
            form.each(function () {
                var elements = $(this).find(':input');

                // tableau des données à envoyer
                var tabData = {url_cible: urlArticleCible};
                if ($('#select_list_elements').length)                      tabData['id_post'] = $('#select_list_elements').val();
                else if ($('#select_list_categories').length)               tabData['id_post'] = $('#select_list_categories').val();
                else if ($('#shopify_select_list_elements').length)         tabData['id_post'] = $('#shopify_select_list_elements').val();
                else if ($('#weebly_select_list_elements').length)          tabData['id_post'] = $('#weebly_select_list_elements').val();

                // shopname: pour les cms qu'on requête via api (shopify, weebly...)
                if (shopname != '')                                         tabData['shop_name'] = shopname;

                // langue (prestashop)
                if ($('#select_cms_lang').length)                           tabData['id_lang'] = $('#select_cms_lang').val();


                // valeurs présentes dans le formulaire
                elements.each(function (){

                    //console.log('ELEMENT: ' + $(this).attr('type') +' - '+ $(this).attr('name'));
                    if ($(this).attr('type') == 'radio') {
                        if ($(this).prop('checked')) {
                            tabData[$(this).attr('data-id')] = $(this).val();
                        }
                    }
                    else if ($(this).attr('type') == 'checkbox') {
                        if ($(this).prop('checked')) {
                            var ind = $(this).attr('data-id');

                            if (! Array.isArray( tabData[ind] )){
                                tabData[ind] = [];
                            }
                            tabData[ind].push($(this).val());
                        }
                    }
                    else if ($(this).attr('type') == 'select') {
                        if ($(this).prop('selected')) {
                            tabData[$(this).attr('data-id')] = $(this).find(":selected").val();
                        }
                    }
                    else if ($(this).attr('data-tinymce') == 1){
                        var tinyMceField = getTinymceContent( $(this).attr('id') );
                        tabData[$(this).attr('data-id')] = tinyMceField;
                    }
                    else if ($(this).attr('type') == 'file') {

                        // file upload
                        var fileUpload = this.files[0];

                        // create files array if not exists
                        if (! Array.isArray(tabData['files']) )     tabData['files'] = [];

                        if (fileUpload) {
                            var filereader = new FileReader();

                            filereader.onloadstart = function (e){
                                nbFilesUploadProcessing += 1;
                            }
                            filereader.onload = function (e) {
                                nbFilesUploadProcessing -= 1;
                                var contents = e.target.result;

                                var fileInfos = {
                                    name: fileUpload.name,
                                    size: fileUpload.size,
                                    content: contents
                                };
                                // file name
                                tabData['files'].push(fileInfos);

                                // trigger ajax ?
                                triggerSendAjax(allInputProcessed, nbFilesUploadProcessing, tabData);
                            }

                            // launch file reader
                            filereader.readAsDataURL(fileUpload);
                        }
                    }
                    else {
                        // autres input
                        tabData[$(this).attr('data-id')] = $(this).val();
                        //console.log( 'log action: ' + $(this).attr('data-id') + ' => ' + $(this).val());

                        // cas particuliers
                        if ($(this).attr('data-id') == 'action' && $(this).val() == 'set_post_content') {
                            // contenu : on rajoute le contenu de grid editor
                            tabData['new_content'] = $('#easycontent-grid').gridEditor('getHtml');
                        }
                        else if ($(this).attr('data-id') == 'action' && $(this).val() == 'set_post_shortdescription') {
                            var newContent = getTinymceContent('easycontent-short_description');
                            tabData['new_short_description'] = newContent;
                        }
                        else if ($(this).attr('data-id') == 'action' && $(this).val() == 'set_shopify_product_update') {
                            tabData['shop_name'] = $('#url_cible').val();
                            tabData['product_description'] = getTinymceContent('product_description');
                        }
                        else if ($(this).attr('data-id') == 'action' && $(this).val() == 'update_product') {
                            tabData['shop_name'] = $('#url_cible').val();
                            tabData['product_description'] = getTinymceContent('product_description');
                        }
                    }

                    allInputProcessed = true;
                });


                // trigger ajax ?
                triggerSendAjax(allInputProcessed, nbFilesUploadProcessing, tabData);



                //////////////////////////////////////
                // trigger ajax if all is computed
                ///////////////////////////////////////

                /**
                 * Trigger ajax request only if everything
                 * @param allInputProcessed
                 * @param nbFilesUploadProcessing
                 * @param tabData
                 */
                function triggerSendAjax(allInputProcessed, nbFilesUploadProcessing, tabData){
                    if (allInputProcessed == true && nbFilesUploadProcessing == 0){

                        // all is ok : data to JSON and send ajax
                        //var json_data = JSON.stringify(tabData, null, 2);
                        sendAjax(tabData);
                    }
                }



                //////////////////////////
                // execute ajax when ok
                //////////////////////////

                function sendAjax(json_data){
                    console.log('Now fire ajax!')

                    ///////////////////
                    // execute ajax
                    ///////////////////

                    getAjaxResponse(urlArticleCible, json_data, function (msg) {

                        // stop loading
                        form.loading('stop');

                        // lance une fonction supplémentaire si nécessaire : définie dans data-after
                        var traitementSupp = btnClick.attr('data-after');
                        if (traitementSupp !== undefined && traitementSupp != '') {
                            window[traitementSupp](msg);
                        }

                        // cas particulier : envoi contenu easycontent
                        if (tabData['action'] == 'set_post_content') {
                            if (msg.result == 'success') {
                                // réactive les modales
                                setBoolContentUpdatedAndNotSaved(false);

                                // réinject le contenu de wordpress dans le grid editor
                                easycontentGridInit(msg.content, false);
                            }
                        }

                        // add message under form
                        if ( typeof msg.message !== 'undefined'){
                            form.append('<div class="form-group result_push_cms"><div class="alert alert-' + msg.result + '">' + msg.message + '</div></div>');
                        }
                    })
                }
            });
        }
        else {
            // error
            sweetAlert("Oops...", "No URL to perform ajax!", "error");
        }
    });
})
