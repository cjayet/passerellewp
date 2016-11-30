var boolContentUpdatedAndNotSaved = false;

/**
 * load "GridEditor"
 */
function loadGridEditor(){

    // remove all blocks
    removeNodeEverywhere('.result_push_cms');

    var form = $('#form_load_grideditor');
    var containerMsg = form.next();
    containerMsg.removeClass().html('');
    var urlArticleCible = $('#url_cible').val();

    if (urlArticleCible !== null)
    {
        // préparation requête ajax
        var tabData = {url_cible: urlArticleCible};
        tabData['action'] = 'load_post_content';
        tabData['id_post'] = $('#select_arborescence').val();
        var json_data = JSON.stringify(tabData, null, 2);

        $('#container-easycontent').css('display', 'none');

        if (tabData['id_post'] != ''){

            $('body').loading();

            // exécution ajax
            getAjaxResponse(urlArticleCible, json_data, function(msg){

                $('body').loading('stop');

                if (msg.result == 'success'){

                    $('#container-easycontent').slideDown();

                    // set content
                    $('#easycontent-title').val(msg.title);
                    $('#easycontent-slug').val(msg.slug);
                    $('#easycontent-meta-description').val(msg.meta_description);
                    $('#easycontent-canonical-url').val(msg.url_canonical);
                    $('#easycontent-url').val(msg.url);
                    $('#easycontent-cms-link').attr('href', msg.url);

                    if (msg.blog_public == 0){
                        // moteurs de recherche bloquées dans les réglages de Wordpress
                        setMetaRobotsIfSearchEngineDisabled(0);
                    }
                    else {
                        // moteurs de recherche autorisés : choix possible
                        $('#alert_no_search_engines').css('display', 'none');

                        if (msg.noindex == 1)           $('#easycontent-noindex').prop('checked', true);
                        else                            $('#easycontent-noindex').prop('checked', false);

                        if (msg.nofollow == 1)          $('#easycontent-nofollow').prop('checked', true);
                        else                            $('#easycontent-nofollow').prop('checked', false);
                    }

                    if (msg.publish == 'publish')   $('#easycontent-publish').prop('checked', true);
                    else                            $('#easycontent-publish').prop('checked', false);

                    // initialisation de la grille de l'éditeur
                    //easycontentGridInit( '<h1>Essai !</h1>', false);
                    easycontentGridInit( msg.content, false);
                }
                else {
                    // show error
                    form.append('<div class="form-group result_push_cms"><div class="alert alert-danger">'+ msg.message +'</div></div>');
                }
            })
        }
        else {
            // add message under form
            form.append('<div class="form-group result_push_cms"><div class="alert alert-danger">Veuillez choisir un contenu</div></div>');
        }

    }
    else {
        containerMsg.removeClass().addClass('alert alert-info');
        containerMsg.html('Veuillez choisir une page/article');
    }
}


/**
 * easycontent editor: append de contenu
 */
function injectEasycontentContent(){

    setBoolContentUpdatedAndNotSaved(true);
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
};


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

    setBoolContentUpdatedAndNotSaved(true);

    // inject content in the current row
    element.html('<div class="col-md-12 col-sm-12 col-xs-12 column easyContentAddRow">'+ generateContent +'</div>')

    // supprime les row qui traineraient
    removeRowsPlaceholder();

    // remet l'éditeur
    easycontentGridInit('', true);

}



/**
 *  Selection du texte + positionnement toolbar d'action
 */
function addEasycontentToolbarFromText(){
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
};


/**
 * Search results for selected text
 */
function easycontentToolbarAction(){
    var buttonClick = $(this);
    var action = buttonClick.attr('data-action');
    if (action == 'close'){
        buttonClick.closest('.toolbar-editor').remove();
    }
    else if (action == 'search'){
        // get content and inject in suggest

        getAjaxResponse('index.php?ajax=getLoremIpsum', $(this).attr('data-select'), function(msg) {
            if(msg.result == 'success'){
                sweetAlert("Res", msg.lorem);
                // TODO ajouter le contenu en dessous et pouvoir l'injecter dans le grid editor
                //$('#toolbar-easycontent-')
            }
        })
    }
}



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
            removeClassEverywhere('easyContentAddRow');

            // template d'une ligne permettant d'ajouter du contenu
            var htmlRowPlaceholder = '<div class="row placeholderdrop"><div class="col-md-12 col-sm-12 col-xs-12 column">&nbsp;</div></div>';

            // disable editor but keep content
            var contenuInitial = $('#easycontent-grid').gridEditor('getHtml');

            // vide le contenu affichant la grid
            $('#content-grid').html('<div id="easycontent-grid">'+contenuInitial+'</div>');

            // ajout des rows placeholder pour insérer du contenu
            if ($('#easycontent-grid .row').length == 0)
            {
                // editeur vide: ajoute une première ligne
                $('#easycontent-grid').append(htmlRowPlaceholder);
            }
            else
            {
                $('#easycontent-grid .row').each(function(i){
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
        tolerance: "pointer",
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
 *  Affiche la liste des images présentes dans le post
 */
function refreshImagesListInPost(){

    if (boolContentUpdatedAndNotSaved == true){
        sweetAlert("Res", "NO REFRESH");
    }
    else {
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
}


/**
 *  Affiche la liste des liens présents dans le post
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
                        }).html();

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
 * Load random dummy image
 */
function loadRandomDummyImage(){
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
}


/**
 *
 */
function loadAllPostsPages(){

    ////////////////////////////////////////
    // RECUPERATION LISTE DES PAGES
    ////////////////////////////////////////

    var urlWordpressCible = $('#url_cible').val();
    $('#container-easycontent').css('display', 'none');

    // add loading to form
    $('body').loading();

    // préparation requête ajax
    var tabData = {url_cible: urlWordpressCible};
    tabData['action'] = 'load_posts_pages';
    var json_data = JSON.stringify(tabData, null, 2);

    // vide le selecteur
    $('#select_arborescence').empty();

    getAjaxResponse(urlWordpressCible, json_data, function(msg){

        $('body').loading('stop');

        if (msg.result == 'success'){

            $('#select_arborescence').append('<option value="">-- Veuillez choisir un contenu --</option>')

            if (msg.arborescence.posts.length > 0){
                var dataPosts = '<optgroup label="Posts">'
                $.each(msg.arborescence.posts, function(idx, post){
                    dataPosts += '<option value="'+ post.ID +'">'+ post.post_title +'</option>';
                })
                dataPosts += '</optgroup>';
                $('#select_arborescence').append(dataPosts);
            }

            if (msg.arborescence.pages.length > 0){
                var dataPosts = '<optgroup label="Pages">'
                $.each(msg.arborescence.pages, function(idx, page){
                    dataPosts += '<option value="'+ page.ID +'">'+ page.post_title +'</option>';
                })
                dataPosts += '</optgroup>';
                $('#select_arborescence').append(dataPosts);
            }

            $('#page_easycontenteditor_loadpage').slideDown();
        }
        else {
            sweetAlert("Oops...", "Error in loadAllPostsPages", "error");
        }

    })


    // affiche ou non l'arborescence des pages (non pour post, oui pour page)
    $(document).on('change', '.post_type', function(){
        var type = ( $('input[name=post_type]:checked').val());
        if (type == 'page')     $('#liste-pages').slideDown();
        else                    $('#liste-pages').slideUp();
    })

}


/**
 * Update slug: update url post
 * @param msg
 */
function updateUrlField(msg){
    if (msg.url != ''  && msg.url !== undefined){
        $('#easycontent-url').val(msg.url);
    }
    else {
        // error changing URL, reload
        //loadGridEditor();
    }
}

/**
 * easycontent editor: affichage du preview du post (article/page) dans wordpress
 */
function previewContentInCMS(btn){
    var urlCible = $('#easycontent-url').val();     // article to preview

    var form = btn.closest('form');

    var contenuEditeur = $('#easycontent-grid').gridEditor('getHtml');
    $('#preview_content').attr('value', contenuEditeur);
    form.attr('action', urlCible );
    form.submit();
}


/**
 * Active / désactive modal d'édition de contenu
 * @param val
 */
function setBoolContentUpdatedAndNotSaved(boolVal){
    if (boolVal == true)        var dataModal = 'no-modal';
    else                        var dataModal = 'modal'

    $('#btn_easycontent_optimiz_images').attr('data-toggle', dataModal);
    $('#btn_easycontent_optimiz_hrefs').attr('data-toggle', dataModal);
}
