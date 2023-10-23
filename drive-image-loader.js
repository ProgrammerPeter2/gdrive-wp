const $ = jQuery;

$(document).ready(() => {
    $(".drive-img").each((_, item) => {
        let url = $(item).data('src')
        $(item).append('<img class="act-img"/><div class="loading-ring">Loading... <span></span></divc>')
        let img = $(item).children(".act-img")
        $.ajax({
            url : url,
            cache: true,
            processData : false,
        }).always(function(){
            $(img).attr("src", url).fadeIn();
        }).success(() => {
            $(item).children(".loading-ring").hide()
        });
    })
})