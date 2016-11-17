(function($){
    $(document).ready(function(){


        /**
         * load ajax - generic
         * @param urlArticleCible : where to post ajax
         * @param json_data : parameters
         * @param callback
         */
        function getAjaxResponse(urlArticleCible, json_data, callback)
        {
            $.ajax({
                method: "POST",
                url: urlArticleCible,
                cache: false,
                dataType: "json",
                data: { data_optme: json_data },
                success:    function(data) {
                    callback(data);
                },
                error: function() {
                    var data = new Array();
                    data['result'] = 'error';
                    data['message'] = 'Ajax error ---';
                    callback(data);
                }
            });
        }


        /**
         * PUSH DATA - Générique
         *
         * pousse l'ensemble des données du formulaire en ajax
         *  - chaque field doit avoir un champ data-id de spécifié (key)
         *  - chaque field doit avoir un champ value de spécifié (value)
         */
        $(document).on('click', '.push_wp', function(){

            // récupération des éléments input du form (input, select, textarea)
            var form = $(this).parent();
            var containerMsg = form.next();
            containerMsg.removeClass().html('');
            var urlArticleCible = $('#url_cible').val();        // site where to push data

            form.each(function(){
                var elements = $(this).find(':input');

                // tableau des données à envoyer
                var tabData = {url_cible: urlArticleCible};
                elements.each(function(){
                    tabData[$(this).attr('data-id')] = $(this).val();
                });

                // editor?
                if ($('#easycontent-grid').length){
                    tabData['new_content'] = $('#easycontent-grid').gridEditor('getHtml');
                }

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
         * load "GridEditor"
         */
        $(document).on('click', '.load_grid_editor', function(){

            var form = $(this).parent();
            var containerMsg = form.next();
            containerMsg.removeClass().html('');
            var urlArticleCible = $('#url_cible').val();

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_post_content';
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){
                if (msg.result == 'success'){

                    $('#container-easycontent').slideDown();

                    // initialisation de la grille de l'éditeur
                    easycontentGridInit( msg.message, false);
                }
                else {
                    // erreur lors de la requête ajax pour récupération de contenu
                    $('#container-easycontent').slideUp();

                    // show error
                    containerMsg.removeClass().addClass('alert alert-'+msg.result);
                    containerMsg.html(msg.message);

                }
            })
        })


        /**
         * easycontent editor: append de contenu
         */
        $(document).on('click', '.inject_easycontent_content', function(){

            var urlArticleCible = $('#url_cible').val();        // site where to push data

            // préparation requête ajax
            var tabData = {url_cible: urlArticleCible};
            tabData['action'] = 'load_lorem_ipsum';
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){
                if (msg.result == 'success'){
                    // add content with simple bootstrap form
                    var newContent = '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 column">'+msg.message+'</div></div>';

                    // initialisation de la grille de l'éditeur
                    easycontentGridInit(newContent, true);
                }

            })
        })





        /**
         * Init gridEditor for easycontent
         */
        function easycontentGridInit(newContentGrid, keepContent){

            // keep previous content in editor?
            if (keepContent == true)        var contenuInitial = $('#easycontent-grid').gridEditor('getHtml');
            else                            var contenuInitial = '';

            // vide le contenu affichant la grid
            $('#content-grid').html('<div id="easycontent-grid">'+contenuInitial+newContentGrid+'</div>');

            $('#easycontent-grid').gridEditor({
                new_row_layouts: [[12], [6,6], [9,3], [3,9], [8,4], [4,8]],
                content_types: ['tinymce'],

                tinymce: {
                    config: {
                        inline: true,
                        plugins: [
                            "advlist autolink lists link image charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu responsivefilemanager paste"
                        ],
                        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link responsivefilemanager image insertfile",

                        image_advtab: true ,

                        external_filemanager_path: "filemanager/",
                        filemanager_title: "Filemanager" ,
                        external_plugins: { "filemanager" : "http://localhost/passerelle/filemanager/plugin.min.js"},   // TODO configuration en dur
                        relative_urls:false
                    }
                },
            });
        }


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
                    $.each(JSON.parse(msg.message), function(idx, obj) {
                        $('#page-redirections tbody').append(
                            '<tr>' +
                                '<td>'+ obj.id +'</td>' +
                                '<td><a href="'+ obj.url_base +'" target="_blank">'+ obj.url_base +'</a></td>' +
                                '<td><a href="'+ obj.url_redirect +'" target="_blank">'+ obj.url_redirect +'</a></td>' +
                                '<td>' +
                                    '<span class="glyphicon glyphicon-ok confirmAction" data-action="enable_redirection" data-id="'+ obj.id +'" aria-hidden="true"></span> ' +
                                    '<span class="glyphicon glyphicon-remove confirmAction" data-action="disable_redirection" data-id="'+ obj.id +'" aria-hidden="true"></span> ' +
                                    '<span class="glyphicon glyphicon-trash confirmAction" data-action="active_redirection" data-id="'+ obj.id +'" aria-hidden="true"></span> ' +
                                '</td>' +
                            '</tr>'
                        );
                    });
                }
                else {
                    alert('Error loading redirections')
                }
            })
        }


        $(document).on('click', '.confirmAction', function(){
            if (confirm('Voulez-vous vraiment faire cela ?')){

                var urlArticleCible = $('#url_cible').val();        // site where to push data

                // préparation requête ajax
                var tabData = {url_cible: urlArticleCible};
                tabData['action'] = $(this).attr('data-action');
                tabData['id_redirection'] = $(this).attr('data-id');
                var json_data = JSON.stringify(tabData, null, 2);

                // exécution ajax
                getAjaxResponse(urlArticleCible, json_data, function(msg){
                    alert(msg.result)
                    alert(msg.message)
                })
            }
        })

    })
})(jQuery);