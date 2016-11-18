/**
 * load ajax - generic
 * @param urlArticleCible : where to post ajax
 * @param json_data : parameters
 * @param callback
 */
function getAjaxResponse(urlArticleCible, json_data, callback){

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


/*
$.fn.tmpl = function(obj) {
    var _this = this,
        el = $(this);

    return (function() {
        var original = el.html();

        el.html(el.html().replace(/{{([^}}]+)}}/g, function(wholeMatch, key) {
            var substitution = obj[$.trim(key)];

            return typeof substitution == 'undefined' ? wholeMatch : substitution;
        }));

        return el.html() == original ? _this : $(el).tmpl(obj);
    })();
};
    */