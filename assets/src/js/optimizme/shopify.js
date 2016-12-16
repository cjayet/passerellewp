/**
 *  Load all redirections
 */
function shopifyLoadAllRedirections(){

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val() };
    var json_data = JSON.stringify(tabData, null, 2);

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyGetRedirections', json_data, function(msg) {
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


/**
 * Load products lists
 */
function shopifyLoadProducts(){

    $('#container-shopify').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val() };
    var json_data = JSON.stringify(tabData, null, 2);

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyGetProducts', json_data, function(msg) {

        if (msg.result == 'success'){
            $('#shopify_select_list_products').empty();

            if (msg.products.length > 0){
                //$("#shopify-table-produit").tmpl(msg).appendTo("#table-products tbody");

                var dataPosts = '<optgroup label="Products">'
                $.each(msg.products, function(idx, post){
                    dataPosts += '<option value="'+ post.id +'">'+ post.title +'</option>';
                })
                dataPosts += '</optgroup>';
                $('#shopify_select_list_products').append(dataPosts);


                $('body').loading('stop');

                // show products list
                $('#page_easycontenteditor_loadpage').slideDown();

                // refresh selectpicker des pages
                $('.selectpicker').selectpicker('refresh');
            }
        }
        else {
            sweetAlert('Erreur ajax');
        }
    })
}

/**
 *
 */
function shopifyLoadProduct(){

    $('#container-shopify').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val(), id_product: $('#shopify_select_list_products').val() };
    var json_data = JSON.stringify(tabData, null, 2);

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyGetProduct', json_data, function(msg) {
        if (msg.result == 'success'){

            // set values
            $('#product_name').val(msg.product.title);
            $('#product_handle').val(msg.product.handle);
            $('#product_current_handle').val(msg.product.handle);
            $('#product_metatitle').val(msg.metas.meta_title);
            $('#product_metadescription').val(msg.metas.meta_description);
            $('#product_description').val(msg.product.body_html);

            // set tinymce for description
            if (msg.product.body_html == null)      msg.product.body_html = '';
            changeTinymceContent('product_description', msg.product.body_html);

            $('body').loading('stop');

            // déplie le contenu
            $('#container-shopify').slideDown();

            shopifyRefreshProductImages();

        }
    })
}


/**
 *
 */
function shopifyUploadImage(){

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val(), id_product: $('#shopify_select_list_products').val() };
    var json_data = JSON.stringify(tabData, null, 2);

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyAddProductImage', json_data, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            alert('avant refresh')
            shopifyRefreshProductImages();
            alert('refresh done')
        }
        else {
            sweetAlert("Oops...", "Error Adding product image", "error");
        }
    })
}


/**
 *
 */
function shopifyRefreshProductImages(){

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val(), id_product: $('#shopify_select_list_products').val() };
    var json_data = JSON.stringify(tabData, null, 2);

    $('#image-list').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyGetProduct', json_data, function(msg) {
        if (msg.result == 'success'){

            // load la liste des images
            $('#image-list').empty();
            if (msg.product.images.length > 0){
                $.each(msg.product.images, function(idx, objImage) {
                    $.get("views/blocs/js-tmpl/shopify_image_detail_contenu.html", function(data){
                        data =  $.tmpl( data, {
                            'id_image' : objImage.id,
                            'url_image' : objImage.src,
                            'alt_image' : objImage.metafield_alt,
                            'id_metafield_alt' : objImage.metafield_alt_id
                        }).html()

                        $('#image-list').append(data);
                    });
                })
            }
            else{
                $('#image-list').append('<div class="alert alert-info">Aucune image trouvée.</div>');
            }
        }

        $('#image-list').loading('stop');
    })
}


/**
 * @param idProductImage
 */
function shopifyDeleteProductImage(idProductImage){

    // préparation requête ajax pour les images
    var tabData = { shop_name: $('#url_cible').val(), id_product_image: idProductImage };
    var json_data = JSON.stringify(tabData, null, 2);

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopifyDeleteProductImage', json_data, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            shopifyRefreshProductImages();
        }
        else {
            sweetAlert("Oops...", "Error deleting product image", "error");
        }
    })
}




$(document).ready(function(){

    /**
     * Installation de l'application, depuis la page d'installation de la passerelle
     */
    $(document).on('click', '#form_install_shopify #send', function(){
        var urlBO = $('#url_backoffice').val();
        $('#form_install_shopify').attr('action', urlBO +'/api/auth');
        $('#form_install_shopify').submit();
    })



    // chargement des tinyMCE
    if ( $('#product_description').length ){
        loadTinyMCE('#product_description');
    }

    /** trigger : load all products on click **/
    $(document).on('click', '#shopify_load_products', function () {
        shopifyLoadProducts();
    })

    /** trigger : load a single product, with details **/
    $(document).on('click', '#btn-load-shopify-product', function () {
        shopifyLoadProduct();
    })

    $(document).on('change', '#shopify_select_list_products', function () {
        shopifyLoadProduct();
    })

    $(document).on('click', '#shopify_load_redirections', function(){
        shopifyLoadAllRedirections();
    })

    $(document).on('click', '#btn_shopify_add_image_url', function(){
        shopifyUploadImage();
    })

    $(document).on('click', '.btn_shopify_delete_product_image', function(){
        var idProductImage = $(this).attr('data-id-product-image');
        shopifyDeleteProductImage(idProductImage);
    })




})