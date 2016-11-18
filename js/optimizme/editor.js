(function($){
    $(document).ready(function(){

        var grid;

        // draggable
        $( ".ui-draggable" ).draggable();

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

                    // set content
                    $('#easycontent-title').val(msg.title);
                    $('#easycontent-permalink').val('Permal');
                    $('#easycontent-meta-description').val('Metadesc');

                    // initialisation de la grille de l'éditeur
                    easycontentGridInit( msg.content, false);
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
                    var newContent = '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 column">'+msg.content+'</div></div>';

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

            grid = $('#easycontent-grid').gridEditor({
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

                        external_filemanager_path: "includes/filemanager/",
                        filemanager_title: "Filemanager" ,
                        external_plugins: { "filemanager" : "http://localhost/passerelle/includes/filemanager/plugin.min.js"},   // TODO configuration en dur
                        relative_urls:false
                    }
                },
            });


        }





        /**
         *  Selection du texte + positionnement toolbar d'action
         */
        $(document).on('mouseup', '.ge-content.active', function(e){
            var elem= $(this);
            var selection;

            if (window.getSelection) {
                selection = window.getSelection();
            } else if (document.selection) {
                selection = document.selection.createRange();
            }

            //selection.toString() !== '' && alert('"' + selection.toString() + '" was selected at ' + e.pageX + '/' + e.pageY);
            if (selection.toString() !== ''){

                // text selected
                var posX = parseInt(e.pageX +30);
                var posY = parseInt(e.pageY -15);

                $.get("includes/blocs/easycontent_editor/toolbar.html", function(data){

                    // random id for toolbar
                    var rand = Math.floor(Math.random() * (Math.pow(10,7))) + 1;
                    data =  $.tmpl( data, {
                        'toolbarid' : 'toolbar-easycontent-'+rand,
                        'suggestid' : 'toolbar-suggest-'+rand
                    }).html()

                    $('body').append(data);
                    $('#toolbar-easycontent'+rand).css({ 'left': posX, 'top': posY });
                    $('#toolbar-easycontent'+rand).find('.glyphicon-search').attr('data-select', selection.toString())
                });
            }
        });


        /**
         * Search results for selected text
         */
        $(document).on('click', '.toolbar-menu-action span', function(){
            var buttonClick = $(this);
            var action = buttonClick.attr('data-action');
            if (action == 'close'){
                buttonClick.closest('.toolbar-editor').remove();
            }
            else if (action == 'search'){
                // get content and inject in suggest

                getAjaxResponse('includes/ajax/getLoremIpsum.php', $(this).attr('data-select'), function(msg) {
                    if(msg.result == 'success'){
                        alert(msg.lorem)
                        //$('#toolbar-easycontent-')
                    }

                })
            }
        })

    })
})(jQuery)