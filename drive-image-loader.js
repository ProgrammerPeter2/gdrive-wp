const $ = jQuery;

const get_data_safe = (element, key, default_data) => {
    let data = $(element).data(key);
    return (data === undefined) ? default_data : data;
}

const resize_item = (element, width, height) => {
    $(element).css("width", width)
    $(element).css("height", height)
}

$(document).ready(() => {
    $(".drive-img").each((_, item) => {
        let url = $(item).data('src')
        resize_item(item, get_data_safe(item, "width", "444px"), get_data_safe(item, "height", "250px"))
        $(item).append('<img class="act-img"/><div class="loader-holder"><div class="loader"></div></div>')
        let img = $(item).children(".act-img")
        $.ajax({
            url : url,
            cache: true,
            processData : false,
        }).always(function(){
            $(img).attr("src", url)
            $(img).hide()
        }).success(() => {
            $(item).children(".loader-holder").hide()
            $(img).show()
        });
    })
})