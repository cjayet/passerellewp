(function($){
    $(document).ready(function(){

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
                    $('#easycontent-permalink').val(msg.permalink);
                    $('#easycontent-meta-description').val(msg.meta_description);
                    $('#easycontent-canonical-url').val(msg.url_canonical);

                    if (msg.noindex == 1)           $('#easycontent-noindex').prop('checked', true);
                    else                            $('#easycontent-noindex').prop('checked', false);

                    if (msg.nofollow == 1)          $('#easycontent-nofollow').prop('checked', true);
                    else                            $('#easycontent-nofollow').prop('checked', false);

                    if (msg.publish == 'publish')   $('#easycontent-publish').prop('checked', true);
                    else                            $('#easycontent-publish').prop('checked', false);

                    // initialisation de la grille de l'éditeur
                    //alert(msg.content)
                    //easycontentGridInit( '<h1>Essai !</h1>', false);
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



            // load images in post
            refreshImagesListInPost();

            // load links in post
            refreshLiensListInPost();

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
        });


        /**
         * Init gridEditor for easycontent
         */
        function easycontentGridInit(newContentGrid, keepContent){

            // keep previous content in editor?
            if (keepContent == true)        var contenuInitial = $('#easycontent-grid').gridEditor('getHtml');
            else                            var contenuInitial = '';

            // vide le contenu affichant la grid
            $('#content-grid').html('<div id="easycontent-grid">'+contenuInitial+newContentGrid+'</div>');

            // init droppable
            initDraggableDroppable();

            // grid editor
            $('#easycontent-grid').gridEditor({
                //new_row_layouts: [[12], [6,6], [9,3], [3,9], [8,4], [4,8]],
                new_row_layouts: [],

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
                }

            });

            // maj des listes d'images / liens
            refreshImagesListInPost();
            refreshLiensListInPost();
        }

        /**
         * Insert content in grid editor
         * @param element
         * @param action
         */
        function dropAction(element, action, url){

            element.removeClass('placeholderdrop');

            var generateContent = '';
            if (action == 'h1'){
                generateContent = '<h1>Title h1</h1>';
                injectDropContent(element, generateContent);
            }
            if (action == 'h2'){
                generateContent = '<h2>Title h2</h2>';
                injectDropContent(element, generateContent);
            }
            if (action == 'h3'){
                generateContent = '<h3>Title h3</h3>';
                injectDropContent(element, generateContent);
            }
            if (action == 'image'){
                if (url != '' && url !== undefined)     var urlImage = url;
                else                                    var urlImage  = 'http://placehold.it/550x150';
                generateContent = '<img src="'+ urlImage +'" alt="" style="max-width:100%; height:auto;" />';
                injectDropContent(element, generateContent);
            }
            if (action == 'content'){
                generateContent = '';
                getAjaxResponse('index.php?ajax=getLoremIpsum', $(this).attr('data-select'), function(msg) {
                    if(msg.result == 'success'){
                        generateContent = msg.lorem;
                        injectDropContent(element, generateContent);
                    }
                })
            }
        }


        /**
         * @param element
         * @param generateContent
         */
        function injectDropContent(element, generateContent){

            // inject content in the current row
            element.html('<div class="col-md-12 col-sm-12 col-xs-12 column addRow">'+ generateContent +'</div>')

            // supprime les row qui traineraient
            removeRowsPlaceholder();

            // remet l'éditeur
            easycontentGridInit('', true);

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

                $.get("views/blocs/js-tmpl/toolbar.html", function(data){

                    // random id for toolbar
                    var rand = Math.floor(Math.random() * (Math.pow(10,7))) + 1;
                    data =  $.tmpl( data, {
                        'toolbarid' : 'toolbar-easycontent-'+rand,
                        'suggestid' : 'toolbar-suggest-'+rand
                    }).html()

                    $('body').append(data);
                    $('#toolbar-easycontent-'+rand).css({ 'left': posX, 'top': posY });
                    $('#toolbar-easycontent-'+rand).find('.glyphicon-search').attr('data-select', selection.toString())
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

                getAjaxResponse('index.php?ajax=getLoremIpsum', $(this).attr('data-select'), function(msg) {
                    if(msg.result == 'success'){
                        alert(msg.lorem)
                        // TODO ajouter le contenu en dessous et pouvoir l'injecter dans le grid editor
                        //$('#toolbar-easycontent-')
                    }
                })
            }
        });





        /**
         * Initialisation draggable & droppable
         */
        function initDraggableDroppable(){

            /**
             * DRAGGABLE BUTTONS
             */
            $( ".ui-draggable" ).draggable({
                helper:"clone",
                cursor:"move",
                revertDuration:0,
                revert: true,
                refreshPositions: false,

                start: function(event, ui) {
                    ui.helper.data('dropped', false);
                    removeClassEverywhere('addRow');
                    var htmlRowPlaceholder = '<div class="row placeholderdrop"><div class="col-md-12 col-sm-12 col-xs-12 column">&nbsp;</div></div>';

                    // disable editor but keep content
                    var contenuInitial = $('#easycontent-grid').gridEditor('getHtml');

                    // vide le contenu affichant la grid
                    $('#content-grid').html('<div id="easycontent-grid">'+contenuInitial+'</div>');

                    // ajout des rows placeholder pour insérer du contenu
                    if ($('.ui-droppable').length == 0)
                    {
                        // editeur vide: ajoute une première ligne
                        $('#easycontent-grid').append(htmlRowPlaceholder);
                    }
                    else
                    {
                        $('.ui-droppable').each(function(i){
                            // ajoute une row au tout début
                            if (i == 0)         $(this).before(htmlRowPlaceholder);
                            $(this).after(htmlRowPlaceholder);
                        });
                    }

                    // reinit droppable car rows ajoutées juste avant
                    initDroppablePlaceholder();
                },

                stop: function(event, ui){
                    if (ui.helper.data('dropped') == false){
                        // drop dans une zone non acceptée : nettoie les rows placeholder ajoutées dynamiquement
                        removeRowsPlaceholder();
                    }
                }
            });
        };


        /**
         * Droppable sur les rows placeholder temporaires
         */
        function initDroppablePlaceholder(){
            $( '.placeholderdrop' ).droppable({
                accept: ".ui-draggable",
                hoverClass: "placeholderdropHover",
                drop: function (event, ui) {
                    ui.helper.data('dropped', true);
                    var action = $(ui.draggable).attr('data-action');
                    var url = $(ui.draggable).attr('src');
                    dropAction($(this), action, url);
                }
            })
        };


        /**
         * Nettoie le code en supprimant les rows temporaires
         */
        function removeRowsPlaceholder(){
            $('.placeholderdrop').each(function(){
                $(this).remove();
            })
        }

        /**
         *
         */
        function refreshImagesListInPost(){

            // préparation requête ajax pour les images
            var contenuEditor = $('#easycontent-grid').gridEditor('getHtml');
            var tabData = {grideditor_content: contenuEditor};
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse('index.php?ajax=getImagesInGridEditor', json_data, function(msg) {
                $('#image-list').empty();
                if (msg.result == 'success')
                {
                    if (msg.images.length > 0){

                        $.each(msg.images, function(idx, objImage) {
                            $.get("views/blocs/js-tmpl/image_detail_contenu.html", function(data){
                                data =  $.tmpl( data, {
                                    'url_image' : objImage.src,
                                    'alt_image' : objImage.alt,
                                    'title_image' : objImage.title
                                }).html()

                                $('#image-list').append(data);
                            });
                        })
                    }
                    else{
                        $('#image-list').append('<li>Aucune image trouvée.</li>');
                    }
                }
            })
        }


        /**
         *
         */
        function refreshLiensListInPost(){

            // préparation requête ajax pour les images
            var contenuEditor = $('#easycontent-grid').gridEditor('getHtml');
            var tabData = {grideditor_content: contenuEditor};
            var json_data = JSON.stringify(tabData, null, 2);

            // exécution ajax
            getAjaxResponse('index.php?ajax=getLiensInGridEditor', json_data, function(msg) {
                $('#href-list').empty();
                if (msg.result == 'success')
                {
                    if (msg.liens.length > 0){
                        $.each(msg.liens, function(idx, objLien) {
                            $.get("views/blocs/js-tmpl/href_detail_contenu.html", function(data){
                                data =  $.tmpl( data, {
                                    'href_lien' : objLien.href,
                                    'rel_lien' : objLien.rel,
                                    'target_lien' : objLien.target
                                }).html()

                                $('#href-list').append(data);
                            });
                        })
                    }
                    else{
                        $('#href-list').append('<li>Aucun lien trouvé.</li>');
                    }
                }
            })
        }

        /**
         * Refresh image list
         */
        $(document).on('click', '.refresh_images', function(){
            refreshImagesListInPost();
        })

        /**
         * Refresh links list
         */
        $(document).on('click', '.refresh_links', function(){
            refreshLiensListInPost();
        })


        /**
         * Load random dummy image
         */
        $(document).on('click', '.load_random_images', function(){
            //getAjaxResponse('includes/ajax/getRandomDummyImage.php', $(this).attr('data-select'), function(msg) {
            getAjaxResponse('index.php?ajax=getRandomDummyImage', $(this).attr('data-select'), function(msg) {
                if (msg.result == 'success'){

                    $('#draggable-random-images').empty();
                    if (msg.images.length > 0){
                        $.each(msg.images, function(idx, urlImage){
                            $('#draggable-random-images').append('<img src="'+ urlImage +'"  data-action="image" width="100%" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable" />')
                        })

                        // reinit draggable car nouveau éléments
                        initDraggableDroppable();
                    }
                }
            })
        })

    });
})(jQuery)