/**
 * Load products lists
 */
function shopifyLoadProducts(){

    $('#container-shopify').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        action: "get_products"
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopify', tabData, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            $('#shopify_select_list_elements').empty();

            if (msg.products.length > 0){
                //$("#shopify-table-produit").tmpl(msg).appendTo("#table-products tbody");

                var dataPosts = '<optgroup label="Products">'
                $.each(msg.products, function(idx, post){
                    dataPosts += '<option value="'+ post.id +'">'+ post.title +'</option>';
                })
                dataPosts += '</optgroup>';
                $('#shopify_select_list_elements').append(dataPosts);


                // show products list
                $('#page_easycontenteditor_loadpage').slideDown();

                // refresh selectpicker des pages
                $('.selectpicker').selectpicker('refresh');
            }
        }
        else {
            sweetAlert('Erreur ajax : ' + msg.message);
        }
    })
}

/**
 *
 */
function shopifyLoadProduct(){

    $('#container-shopify').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product: $('#shopify_select_list_elements').val(),
        action: 'get_product'
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopify', tabData, function(msg) {
        if (msg.result == 'success'){

            // set values
            $('#product_name').val(msg.product.title);
            $('#product_handle').val(msg.product.handle);
            $('#product_current_handle').val(msg.product.handle);
            $('#product_metatitle').val(msg.metas.meta_title);
            $('#product_metadescription').val(msg.metas.meta_description);
            $('#product_description').val(msg.product.body_html);

            // set tinymce for description
            if (msg.product.body_html == null)          msg.product.body_html = '';
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
function shopifyRefreshProductImages(){

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product: $('#shopify_select_list_elements').val(),
        action: 'get_product'   // TODO à optimiser ?
    };

    $('#image-list').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=shopify', tabData, function(msg) {
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



$(document).ready(function(){

    /**
     * Installation de l'application, depuis la page d'installation de la passerelle
     */
    $(document).on('click', '#form_install_shopify #send', function(){
        var urlBO = $('#url_backoffice').val();
        $('#form_install_shopify').attr('action', urlBO +'/api/auth');
        $('#form_install_shopify').submit();
    })



    /** trigger : load all products on click **/
    $(document).on('click', '#shopify_load_products', function () {
        shopifyLoadProducts();
    })

    /** trigger : load a single product, with details **/
    $(document).on('click', '#btn-load-shopify-product', function () {
        shopifyLoadProduct();
    })

    $(document).on('change', '#shopify_select_list_elements', function () {
        shopifyLoadProduct();
    })

    $(document).on('click', '#shopify_load_redirections', function(){
        loadAllRedirectionsApi('shopify');
    })
})