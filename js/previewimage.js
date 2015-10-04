 function shrink()
{
    while($("#img_preview_text").width() < $("#img_preview_text_container").width()){
        // console.log($("#img_preview_text").width(), $("#img_preview_text_container").width());
        fontsize = $("#img_preview_text").css('font-size');
        fontsize = parseInt(fontsize.replace("px", ""));
        fontsize = fontsize + 1;
        $("#img_preview_text").css('font-size', fontsize + 'px');
        if($("#img_preview_text").width() > $("#img_preview_text_container").width()){
            fontsize = $("#img_preview_text").css('font-size');
            fontsize = parseInt(fontsize.replace("px", ""));
            fontsize = fontsize - 1;
             $("#img_preview_text").css('font-size', fontsize + 'px');
             break;
        }
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
    $("#img_preview_text").css('top', delta + 'px');

    bwidth= $("#img_preview_text_container").width();
    textwidth =  $("#img_preview_text").width();
    delta = (bwidth - textwidth)/2 ;
    if(delta >0){
        $("#img_preview_text").css('left', Math.ceil(delta) + 'px');    
    }
    
}