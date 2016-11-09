(function($){
    $(document).ready(function(){

        // site where to push data
        var urlCible = 'http://localhost/wordpress/';

        /////////////////////////////////////////////////
        //  push title
        /////////////////////////////////////////////////

        $(document).on('click', '#push_title', function(){
            $.ajax({
                method: "POST",
                url: urlCible,
                cache: false,
                dataType: "json",
                data: { action: "set_title",
                        url: $('#url_cible').val(),
                        content: $('#new_title').val()
                }
            })
            .done(function( msg ) {
                $('#result_update_title').removeClass().addClass('alert alert-'+msg.result)
                $('#result_update_title').html(msg.message)
            });
        })


        /////////////////////////////////////////////////
        //  push title
        /////////////////////////////////////////////////


        $(document).on('click', '#push_content', function(){
            $.ajax({
                method: "POST",
                url: urlCible,
                cache: false,
                dataType: "json",
                data: { action: "set_content",
                    url: $('#url_cible').val(),
                    content: $('#new_content').val()
                }
            })
            .done(function( msg ) {
                $('#result_update_content').removeClass().addClass('alert alert-'+msg.result)
                $('#result_update_content').html(msg.message)
            });
        })




        /////////////////////////////////////////////////
        //  push image
        /////////////////////////////////////////////////


        $(document).on('click', '#push_img_alt', function(){
            $.ajax({
                method: "POST",
                url: urlCible,
                cache: false,
                dataType: "json",
                data: { action: "set_img_alt",
                        url: $('#url_cible').val(),
                        url_image: $('#url_image').val(),
                        content: $('#update_image').val()
                }
            })
            .done(function( msg ) {
                $('#result_update_img').removeClass().addClass('alert alert-'+msg.result)
                $('#result_update_img').html(msg.message)
            });
        })

    })
})(jQuery)