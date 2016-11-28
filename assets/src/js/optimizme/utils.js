/**
 * load ajax - generic
 * @param urlArticleCible : where to post ajax
 * @param json_data : parameters
 * @param callback
 */
function getAjaxResponse(urlArticleCible, json_data, callback){

    // remove all blocks
    removeClassEverywhere('result_push_cms');

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
        error: function() {
            var data = new Array();
            data['result'] = 'error';
            data['message'] = 'Ajax error ---';
            callback(data);
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
