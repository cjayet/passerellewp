$(document).ready(function(){

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
                changeTinymceContent('product_description', msg.product.body_html);

                $('body').loading('stop');

                $('#container-shopify').slideDown();
            }
        })
    }






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


})