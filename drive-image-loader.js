const $ = jQuery;

const get_data_safe = (element, key, default_data) => {
    let data = $(element).data(key);
    return (data === undefined) ? default_data : data;
}

const resize_item = (element, width, height) => {
    $(element).attr("style", "width: "+width+"; height: "+height+";")
}

const get_size_data = (element, key, default_size) => {
    return Number.parseInt(get_data_safe(element, key, default_size).split('px')[0])
}

$(document).ready(() => {
    $(".drive-img").each((_, item) => {
        let url = $(item).data('src')
        resize_item(item, get_data_safe(item, "width", "444px"), get_data_safe(item, "height", "250px"))
        $(item).append('<img class="act-img"/><div class="loader-holder"><div class="loader"></div></div>')
        let loader_size = Math.min(get_size_data(item, "width", "200")*0.64, get_size_data(item, "height", "200")*0.64,200)
            + "px !important"
        resize_item($(item).children(".loader-holder").eq(0).children(".loader") , loader_size, loader_size)
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