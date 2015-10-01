<link rel="stylesheet" href="http://103.9.77.27/demo/hahaha1//css/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/hahaha1//css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/hahaha1//css/fancybox/jquery.fancybox-buttons.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://103.9.77.27/demo/hahaha1//css/fancybox/jquery.fancybox-thumbs.css" type="text/css" media="screen" />

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/hahaha1//js/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/hahaha1//js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/hahaha1//js/fancybox/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/hahaha1//js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="http://103.9.77.27/demo/hahaha1//js/fancybox/jquery.fancybox-media.js"></script>

<a class="fancybox" style="display:none;" id="image_fancybox" rel="group" href="">
<img src="" alt="" />
</a>

<script type="text/javascript">
    $(document).ready(function() {
        $("#preview_btn").click(function(event) {
            url = 'http://103.9.77.27/demo/hahaha1//generate_image.php?';
            url += 'text='+ $("#user_input").val();
            url += '&font='+ $("#font_select option:selected").val();
            url += '&id='+ $("#template_id").val();
        
            $.ajax({
                url: url,
                dataType: 'jsonp',
                jsonpCallback: 'callback',
                type: 'GET',
                success: function (jsonp) {
                    data = jsonp.img;
                    $("#image_fancybox").attr('href', data.trim());
                    $("#img_name").val(jsonp.img_name);
                    $("#image_fancybox img").attr('src', data.trim());
                    $("#image_fancybox img").click();
                }
            });
        });
        $(".fancybox").fancybox({
            afterClose: function() {              
                url = 'http://103.9.77.27/demo/hahaha1//delete_image.php?';
                url += 'name='+ $("#img_name").val();
                $.ajax({
                    url: url,
                    dataType: 'jsonp',
                    jsonpCallback: 'callback',
                    type: 'GET',
                    success: function (jsonp) {
                    }
                });
            }
        });
    });
</script>

<div class="impact_image_section">
    <input name='text' value="" id="user_input">
    <input type='hidden' name='id' value="1442995808" id="template_id">
    <input type='hidden' value="" id="img_name">
    <select id="font_select" name="font">
        <option value="Angil">Angil</option><option value="Impact">Impact</option><option value="Edwardian">Edwardian</option><option value="Fetteunzfraktur">Fetteunzfraktur</option><option value="H74rbl">H74rbl</option><option value="Kiss Me">Kiss Me</option><option value="Boston">Boston</option><option value="Lintsec">Lintsec</option><option value="Oklahoma">Oklahoma</option><option value="Old English">Old English</option><option value="Sanchez">Sanchez</option>
    </select>
    <button id="preview_btn">preview</button>
</div>