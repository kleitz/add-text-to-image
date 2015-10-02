<style type="text/css">
  @font-face {
    font-family: 'Impact';
    src: url('http://test.local/previewimage/add-text-to-image/fonts/impact.ttf') format('truetype');
  }

@font-face {
  font-family: 'Edwardian';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/edwardian.ttf') format('truetype');
}

@font-face {
  font-family: 'Fetteunzfraktur';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/fetteunzfraktur.ttf') format('truetype');
}

@font-face {
  font-family: 'H74rbl';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/h74rbl.ttf') format('truetype');
}

@font-face {
  font-family: 'Kiss Me';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/kgkissmeslowly.ttf') format('truetype');
}

@font-face {
  font-family: 'Boston';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/lhfbostontruckstylec.ttf') format('truetype');
}

@font-face {
  font-family: 'Lintsec';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/lintsec.ttf') format('truetype');
}


@font-face {
  font-family: 'Oklahoma';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/oklahoma.ttf') format('truetype');
}


@font-face {
  font-family: 'Old English';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/oldeenglish.ttf') format('truetype');
}

@font-face {
  font-family: 'Sanchez';
  src: url('http://test.local/previewimage/add-text-to-image/fonts/sanchezregular.ttf') format('truetype');
}

</style>
<link rel="stylesheet" href="http://test.local/previewimage/add-text-to-image/css/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<link rel="stylesheet" href="http://test.local/previewimage/add-text-to-image/css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<link rel="stylesheet" href="http://test.local/previewimage/add-text-to-image/css/fancybox/jquery.fancybox-buttons.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://test.local/previewimage/add-text-to-image/css/fancybox/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://test.local/previewimage/add-text-to-image/css/style.css" type="text/css" media="screen" />

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image//js/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image//js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image//js/fancybox/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image//js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image//js/fancybox/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image/js/jquery.textfill.min.js"></script>
<script type="text/javascript" src="http://test.local/previewimage/add-text-to-image/js/jquery.arctext.js"></script>

<div class="fancybox"  id="img_preview_fancybox" rel="group" style="display:none;">
    <div style="position: relative;" >
        <img src="http://test.local/previewimage/add-text-to-image/img/1443716081XT-Profile.jpg" alt="" style="width:100%;" />
        <div class="" id="img_preview_text_container" style="width:201px; height:87px; position: absolute; top:422px; left:196px">
            <div id="img_preview_text" style="color: #3426d4;">hello world</div>        
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        function shrink()
        {
            var fontsize = $("#img_preview_text").css('font-size');
            fontsize = parseInt(fontsize.replace("px", ""));

            while($("#img_preview_text").width() < $("#img_preview_text_container").width()){
                fontsize = fontsize + 1;
                $("#img_preview_text").css('font-size', fontsize + 'px');
            }

            btop= $("#img_preview_text_container").position().top;
            bheight = $("#img_preview_text_container").height();

            texttop =  $("#img_preview_text").position().top;
            textheight = $("#img_preview_text").height();
            delta = (bheight - textheight)/2 ;
            $("#img_preview_text").css('top', delta + 'px');
        }

        $("#preview_btn").click(function(event) {
            url = 'http://test.local/previewimage/add-text-to-image/generate_image_new.php?';
            url += 'font='+ $("#font_select option:selected").val();
            url += '&id='+ $("#template_id").val();

              var selected_font = $("#font_select option:selected").val();
        
            $.ajax({
                url: url,
                dataType: 'jsonp',
                jsonpCallback: 'callback',
                type: 'GET',
                success: function (jsonp) {
                    data = jsonp.img;
                    $("#img_preview_text").css('color', jsonp.color);
                    $("#img_preview_text_container").css('top', jsonp.top);
                    $("#img_preview_text_container").css('left', jsonp.left);
                    $("#img_preview_text_container").css('width', jsonp.width);
                    $("#img_preview_text_container").css('height', jsonp.height);

                    $("#img_preview_fancybox").click();
                    $("#img_preview_text").remove();
                     textforshow  = $("#user_input").val().substring(0, jsonp.length);
                    $('#img_preview_text_container').append('<span id="img_preview_text" style="color:'+jsonp.color+'; position: absolute; top:0px;">'+textforshow+'</span>');

                    $('#img_preview_text_container').textfill({ 
                                                widthOnly: true, 
                                                maxFontPixels:0
                                                // changeLineHeight: true, 
                                                // minFontPixels: 1
                                            });
                     shrink();
                    $('#img_preview_text').arctext({radius: parseInt(jsonp.radius), dir: parseInt(jsonp.dir)});
                    $('#img_preview_text').css('font-family', selected_font);
                    
                }
            });

        });
        $("#img_preview_fancybox").fancybox({});
    });
</script>

<div class="impact_image_section">
    <input name='text' value="" id="user_input">
    <input type='hidden' name='id' value="1443716091" id="template_id">
    <input type='hidden' value="" id="img_name">
    <select id="font_select" name="font">
        <option value="Angil">Angil</option><option value="Impact">Impact</option><option value="Edwardian">Edwardian</option><option value="Fetteunzfraktur">Fetteunzfraktur</option><option value="H74rbl">H74rbl</option><option value="Kiss Me">Kiss Me</option><option value="Boston">Boston</option><option value="Lintsec">Lintsec</option><option value="Oklahoma">Oklahoma</option><option value="Old English">Old English</option><option value="Sanchez">Sanchez</option>
    </select>

    <button id="preview_btn">preview</button>
</div>