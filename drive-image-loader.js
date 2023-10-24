const $ = jQuery;

$(document).ready(() => {
    $(".drive-img").each((_, item) => {
        let url = $(item).data('src')
        $(item).append('<img class="act-img"/><div class="loader"></divc>')
        let img = $(item).children(".act-img")
        $.ajax({
            url : url,
            cache: true,
            processData : false,
        }).always(function(){
            $(img).attr("src", url)
            $(img).attr("width", $(item).data('width'))
            $(img).attr("height", $(item).data('height'))
            $(img).fadeIn()
        }).success(() => {
            $(item).children(".loader").hide()
        });
    })
})