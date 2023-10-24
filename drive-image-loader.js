const $ = jQuery;

$(document).ready(() => {
    $(".drive-img").each((_, item) => {
        let url = $(item).data('src')
        $(item).append('<img class="act-img"/><div class="loader"></div>')
        let img = $(item).children(".act-img")
        $.ajax({
            url : url,
            cache: true,
            processData : false,
        }).always(function(){
            $(img).attr("src", url)
            $(img).css("width", $(item).data('width'))
            $(img).css("height", $(item).data('height'))
            $(img).fadeIn()
        }).success(() => {
            $(item).children(".loader").hide()
        });
    })
})