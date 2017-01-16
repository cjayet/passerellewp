/**
 * Load products lists
 */
function weeblyLoadProducts(){

    $('#container-weebly').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        action: 'get_products'
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=weebly', tabData, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            $('#weebly_select_list_elements').empty();

            if (msg.products.length > 0){

                var dataPosts = '<optgroup label="Products">'
                $.each(msg.products, function(idx, post){
                    dataPosts += '<option value="'+ post.product_id +'">'+ post.name +'</option>';
                })
                dataPosts += '</optgroup>';
                $('#weebly_select_list_elements').append(dataPosts);


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
 *  Load product detail
 */
function weeblyLoadProduct(){

    $('#container-weebly').css('display', 'none');

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product: $('#weebly_select_list_elements').val(),
        action: 'get_product'
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=weebly', tabData, function(msg) {
        if (msg.result == 'success'){

            // set values
            $('#product_name').val(msg.product.name);
            $('#product_url').val(msg.product.url);
            $('#product_description').val(msg.product.short_description);

            if (msg.product.published == true)          $('#easycontent-publish').prop('checked', true);
            else                                        $('#easycontent-publish').prop('checked', false);

            // set tinymce for description
            if (msg.product.short_description == null)      msg.product.short_description = '';
            changeTinymceContent('product_description',     msg.product.short_description);

            $('body').loading('stop');

            // déplie le contenu
            $('#container-weebly').slideDown();

            weeblyRefreshProductImages();

        }
    })
}


/**
 * Add image to weebly
 * @param type : url/computer
 */
function weeblyUploadImage(type){

    if (type == 'url')          var typeSendImage = 'add_product_image_url';
    else                        var typeSendImage = 'add_product_image_computer';

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product: $('#weebly_select_list_elements').val(),
        action: typeSendImage
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=weebly', tabData, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            weeblyRefreshProductImages();
        }
        else {
            sweetAlert("Oops...", "Error Adding product image", "error");
        }
    })

}


/**
 *  Get image list
 */
function weeblyRefreshProductImages(){

    // préparation requête ajax pour les images
    var id_product = $('#weebly_select_list_elements').val();

    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product: id_product,
        action: 'get_product_images'
    };

    $('#image-list').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=weebly', tabData, function(msg) {
        if (msg.result == 'success'){

            // load la liste des images
            $('#image-list').empty();
            if (msg.product_images.length > 0){
                $.each(msg.product_images, function(idx, objImage) {
                    $.get("views/blocs/js-tmpl/weebly_image_detail_contenu.html", function(data){
                        data =  $.tmpl( data, {
                            'id_product': id_product,
                            'id_product_image' : objImage.product_image_id,
                            'url_image' : objImage.url
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
function weeblyDeleteProductImage(idProductImage){

    // préparation requête ajax pour les images
    var tabData = {
        shop_name: $('#url_cible').val(),
        id_product_image: idProductImage,
        action: 'delete_product_image'
    };

    $('body').loading();

    // exécution ajax
    getAjaxResponse('index.php?ajax=weebly', tabData, function(msg) {
        $('body').loading('stop');

        if (msg.result == 'success'){
            weeblyRefreshProductImages();
        }
        else {
            sweetAlert("Oops...", "Error deleting product image", "error");
        }
    })
}

/**
 * @param msg
 */
function afterCheckProductCreateWeebly(msg){
    if (msg.canAddProduct){
        $('#page_easycontenteditor_loadpage').slideDown();
    }
    else {
        $('#page_easycontenteditor_loadpage').css('display', 'none');
    }
}


$(document).ready(function(){

    /**
     * Installation de l'application, depuis la page d'installation de la passerelle
     */
    $(document).on('click', '#form_install_weebly #send', function(){
        var urlBO = $('#url_backoffice').val();
        $('#form_install_weebly').attr('action', urlBO +'/api/auth');
        $('#form_install_weebly').submit();
    })

    /** trigger : load all products on click **/
    $(document).on('click', '#weebly_load_products', function () {
        weeblyLoadProducts();
    })

    /** trigger : load a single product, with details **/
    $(document).on('click', '#btn-load-weebly-product', function () {
        weeblyLoadProduct();
    })

    $(document).on('change', '#weebly_select_list_elements', function () {
        weeblyLoadProduct();
    })

    $(document).on('click', '#weebly_load_redirections', function(){
        loadAllRedirectionsApi('weebly');
    })

    $(document).on('click', '#btn_weebly_add_image_url', function(){
        weeblyUploadImage('url');
    })

    $(document).on('click', '#btn_weebly_add_image_computer', function(){
        weeblyUploadImage('computer');
    })

    $(document).on('click', '.btn_weebly_delete_product_image', function(){
        var idProductImage = $(this).attr('data-id-product-image');
        weeblyDeleteProductImage(idProductImage);
    })
})