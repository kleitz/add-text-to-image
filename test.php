<style type="text/css">
  @font-face {
    font-family: 'Impact';
    src: url('http://103.9.77.27/demo/generateimage/font.php?f=impact&t=ttf') format('truetype');
  }

@font-face {
  font-family: 'Edwardian';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=edwardian&t=ttf') format('truetype');
}

@font-face {
  font-family: 'Fetteunzfraktur';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=fetteunzfraktur&t=ttf') format('truetype');
}

@font-face {
  font-family: 'H74rbl';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=h74rbl&t=ttf') format('truetype');
}

@font-face {
  font-family: 'Kiss Me';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=kgkissmeslowly&t=ttf') format('truetype');
}

@font-face {
  font-family: 'Boston';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=lhfbostontruckstylec&t=ttf') format('truetype');
}

@font-face {
  font-family: 'Lintsec';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=lintsec&t=ttf') format('truetype');
}


@font-face {
  font-family: 'Oklahoma';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=oklahoma&t=ttf') format('truetype');
}


@font-face {
  font-family: 'Old English';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=oldeenglish&t=ttf') format('truetype');
}

@font-face {
  font-family: 'Sanchez';
  src: url('http://103.9.77.27/demo/generateimage/font.php?f=sanchezregular&t=ttf') format('truetype');
}
</style>
<link rel="stylesheet" href="http://103.9.77.27/demo/generateimage/css/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/generateimage/css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/generateimage/css/fancybox/jquery.fancybox-buttons.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/generateimage/css/fancybox/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/generateimage/css/style.css" type="text/css" media="screen" />

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/fancybox/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/fancybox/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/jquery.textfill.min.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/jquery.arctext.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/generateimage/js/previewimage.js"></script>

<div class="fancybox"  id="img_preview_fancybox" rel="group" style="display:none;">
    <div style="position: relative;" >
        <img src="http://103.9.77.27/demo/generateimage/img/1443892037CH-Profile.jpg" alt="" style="width:100%;" id="preview_image_img"/>
        <div class="" id="img_preview_text_container" style="width:198px; height:196px; position: absolute; top:375px; left:201px">
            <div id="img_preview_text" style="color: #ffffff;">hello world</div>        
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#preview_btn").click(function(event) {
            url = 'http://103.9.77.27/demo/generateimage/generate_image_new.php?';
            url += 'font='+ $("#font_select option:selected").val();
            url += '&id='+ $("#template_id").val();
            var selected_font = $("#font_select option:selected").val();
            $.ajax({
                url: url,
                dataType: 'jsonp',
                jsonpCallback: 'callback',
                type: 'GET',
                success: function (jsonp) {
                    // $("#image_preview_image").attr('src', jsonp.img);
                    $("#img_preview_text").css('color', jsonp.color);
                    $("#img_preview_text_container").css('top', jsonp.top);
                    $("#img_preview_text_container").css('left', jsonp.left);
                    $("#img_preview_text_container").css('width', jsonp.width);
                    $("#img_preview_text_container").css('height', jsonp.height);

                    $("#img_preview_fancybox").click();
                    $("#img_preview_text").remove();
                     textforshow  = $("#user_input").val().substring(0, jsonp.length);
                    $('#img_preview_text_container').html('<span id="img_preview_text" style="color:'+jsonp.color+'; position: absolute; top:0px;">'+textforshow+'</span>');

                    $('#img_preview_text_container').textfill({ 
                                                widthOnly: true, 
                                                maxFontPixels:0
                                            });
                    
                    $('#img_preview_text').arctext({radius: parseInt(jsonp.radius), dir: parseInt(jsonp.dir)});
                    $('#img_preview_text').css('font-family', selected_font);
                    
                    $('#img_preview_text').hide();

                    autoResize();
                    shrink();
                    setTimeout(function(){
                      shrink();
                      $('#img_preview_text').show();
                    }, 300);     
                }
            });

        });

        $("#img_preview_fancybox").fancybox({
              closeBtn    : true,
              closeClick  : false, // prevents closing when clicking the background 
              openEffect  : 'elastic',
              closeEffect : 'elastic',
              scrolling   : 'no',
              autoSize    : true,
              fitToView   : true,
              overlayShow: false
          });  
    });
</script>

<div class="impact_image_section">
    <input name='text' value="" id="user_input">
    <input type='hidden' name='id' value="1443892044" id="template_id">
    <input type='hidden' value="" id="img_name">
    <select id="font_select" name="font">
        <option value="Angil">Angil</option><option value="Impact">Impact</option><option value="Edwardian">Edwardian</option><option value="Fetteunzfraktur">Fetteunzfraktur</option><option value="H74rbl">H74rbl</option><option value="Kiss Me">Kiss Me</option><option value="Boston">Boston</option><option value="Lintsec">Lintsec</option><option value="Oklahoma">Oklahoma</option><option value="Old English">Old English</option><option value="Sanchez">Sanchez</option>
    </select>

    <button id="preview_btn">preview</button>
</div>