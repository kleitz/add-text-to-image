function autoResize(){
    var image = document.getElementById('preview_image_img');
    var width = image.naturalWidth;
    var height = image.naturalHeight;
    var cwidth = $("#preview_image_img").width();
    var cheight = $("#preview_image_img").height();

    getRatiowidth = cwidth/width;
    getRatioheight = cheight/height;
    newboxwidth = getRatiowidth*$("#img_preview_text_container").width();
    newboxheight = getRatioheight*$("#img_preview_text_container").height();
    newboxtop = getRatioheight*$("#img_preview_text_container").position().top;
    newboxleft = getRatiowidth*$("#img_preview_text_container").position().left;

    $("#img_preview_text_container").css('top', newboxtop + 'px');
    $("#img_preview_text_container").css('left', newboxleft + 'px');

    $("#img_preview_text_container").width(newboxwidth);
    $("#img_preview_text_container").height(newboxheight);
}

function shrink()
{
    while(parseInt($("#img_preview_text").width()) < parseInt($("#img_preview_text_container").width())){
        fontsize = $("#img_preview_text").css('font-size');
        fontsize = parseInt(fontsize.replace("px", ""));
        fontsize = fontsize + 1;
        $("#img_preview_text").css('font-size', fontsize + 'px');
        if(parseInt($("#img_preview_text").width()) > parseInt($("#img_preview_text_container").width())){
            fontsize = $("#img_preview_text").css('font-size');
            fontsize = parseInt(fontsize.replace("px", ""));
            fontsize = fontsize - 1;
             $("#img_preview_text").css('font-size', Math.ceil(fontsize) + 'px');
            // console.log('nho hon parent',$("#img_preview_text").width(), $("#img_preview_text_container").width(), $("#img_preview_text").css('font-size'));     
             break;
        }
        // console.log('nho hon parent',$("#img_preview_text").width(), $("#img_preview_text_container").width(), $("#img_preview_text").css('font-size'));
    }

    while(parseInt($("#img_preview_text").width()) > parseInt($("#img_preview_text_container").width())){
        // console.log($("#img_preview_text").width(), $("#img_preview_text_container").width());
        fontsize = $("#img_preview_text").css('font-size');
        fontsize = parseInt(fontsize.replace("px", ""));
        fontsize = fontsize - 1;
        $("#img_preview_text").css('font-size', fontsize + 'px');
    }

    bheight = $("#img_preview_text_container").height();
    textheight = $("#img_preview_text").height();
    delta = (bheight - textheight)/2 ;
    $("#img_preview_text").css('top', Math.ceil(delta) + 'px');

    bwidth= $("#img_preview_text_container").width();
    textwidth =  $("#img_preview_text").width();
    delta = (bwidth - textwidth)/2 ;
    if(delta >0){
        $("#img_preview_text").css('left', Math.ceil(delta) + 'px');    
    }
}