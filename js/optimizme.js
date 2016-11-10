(function($){
    $(document).ready(function(){

        // site where to push data
        var urlArticleCible = $('#url_cible').val();

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

            form.each(function(){
                var elements = $(this).find(':input');

                // tableau des données à envoyer
                var tabData = {url_cible: urlArticleCible};
                elements.each(function(){
                    tabData[$(this).attr('data-id')] = $(this).val();
                });
                var json_data = JSON.stringify(tabData, null, 2);

                // cache les éventuels messages présents avant
                containerMsg.removeClass().html('');

                // appel ajax
                $.ajax({
                    method: "POST",
                    url: urlArticleCible,
                    cache: false,
                    dataType: "json",
                    data: { data_optme: json_data }
                })
                .done(function( msg ) {

                    containerMsg.removeClass().addClass('alert alert-'+msg.result);
                    containerMsg.html(msg.message);
                });

            });
        })


    })
})(jQuery);