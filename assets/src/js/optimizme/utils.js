/**
 * load ajax - generic
 * @param urlArticleCible : where to post ajax
 * @param json_data : parameters
 * @param callback
 */
function getAjaxResponse(urlArticleCible, json_data, callback){

    // remove all notice blocks
    removeNodeEverywhere('.result_push_cms');

    // ajax request
    $.ajax({
        method: "POST",
        url: urlArticleCible,
        cache: false,
        dataType: "json",
        data: { data_optme: json_data },
        success:    function(data) {
            callback(data);
        },
        error: function(xhr, status, error) {
            if(xhr.status == 404) {
                alert('error 404');
            }
            else {
                var err = eval("(" + xhr.responseText + ")");

                var data = new Array();
                data['result'] = 'error';
                data['message'] = 'Ajax error --- ' + err;
                callback(data);
            }
        }
    });
}


/**
 * Remove class everywhere
 * @param classParam
 */
function removeClassEverywhere(classParam){
    $('.'+ classParam).each(function(){
        $(this).removeClass(classParam);
    })
};


/**
 * Remove all elements in DOM
 * @param idOrClass
 */
function removeNodeEverywhere(idOrClass){
    $(idOrClass).each(function(){
        $(this).remove();
    })
}


/**
 * If search engines no allowed:  noindex
 */
function setMetaRobotsIfSearchEngineDisabled( isBlogPublic ){
    if (isBlogPublic == 0){
        // noindex
        $('#easycontent-noindex').prop('checked', true);
        $('#easycontent-noindex').attr("disabled", true);

        // follow
        $('#easycontent-nofollow').prop('checked', false);
        $('#easycontent-nofollow').attr("disabled", true);

        // message
        $('#alert_no_search_engines').css('display', '');
    }
}