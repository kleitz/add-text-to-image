{{font_content}}
<link rel="stylesheet" href="{{base_url}}css/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<link rel="stylesheet" href="{{base_url}}css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<link rel="stylesheet" href="{{base_url}}css/fancybox/jquery.fancybox-buttons.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{base_url}}css/fancybox/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{{base_url}}css/style.css" type="text/css" media="screen" />

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="{{base_url}}js/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="{{base_url}}js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="{{base_url}}js/fancybox/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="{{base_url}}js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="{{base_url}}js/fancybox/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="{{base_url}}js/jquery.textfill.min.js"></script>
<script type="text/javascript" src="{{base_url}}js/jquery.arctext.js"></script>
<script type="text/javascript" src="{{base_url}}js/previewimage.js"></script>

<div class="fancybox"  id="img_preview_fancybox" rel="group" style="display:none;">
    <div style="position: relative;" >
        <img src="{{image}}" alt="" style="width:100%;" id="preview_image_img"/>
        <div class="" id="img_preview_text_container" style="width:{{w}}px; height:{{h}}px; position: absolute; top:{{x}}px; left:{{y}}px">
            <div id="img_preview_text" style="color: {{color}};"></div>        
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#preview_btn").click(function(event) {
            url = '{{base_url}}generate_image_new.php?';
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
    <input type='hidden' name='id' value="{{datetimeid}}" id="template_id">
    <input type='hidden' value="" id="img_name">
    <select id="font_select" name="font">
        {{font_option}}
    </select>

    <button id="preview_btn">preview</button>
</div>