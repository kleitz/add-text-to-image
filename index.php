<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>

<body>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- start -->
<link rel="stylesheet" href="http://test.local/Site.ProductPreview/css/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="http://test.local/Site.ProductPreview/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="http://test.local/Site.ProductPreview/css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="http://test.local/Site.ProductPreview/js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<a class="fancybox" style="display:none;" id="image_fancybox" rel="group" href="http://103.9.77.27/demo/generateimage//img/essance-sonmoi-do-hong-cam-02.JPG">
<img src="http://103.9.77.27/demo/generateimage//img/essance-sonmoi-do-hong-cam-02.JPG" alt="" />
</a>

<!-- end -->
<script src="js/impact_color_sdk.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#preview_btn").click(function(event) {
			url = 'http://103.9.77.27/demo/generateimage/generate_image.php?callback=my_cb';
			url += '&text='+ $("#user_input").val();
			url += '&font='+ $("#font_select option:selected").val();
			url += '&id='+ $("#template_id").val();
		
			// $.post(url , , function(data, textStatus, xhr) {
			// 	$("#image_fancybox").attr('href', data.trim());
			// 	$("#image_fancybox img").attr('src', data.trim());
			// 	$("#image_fancybox img").click();
			// });

			$.ajax({
		        url: url,
		        dataType: 'jsonp',
		        success: function (data) {
				    $("#image_fancybox").attr('href', data.trim());
					$("#image_fancybox img").attr('src', data.trim());
					$("#image_fancybox img").click();
				}
			});


		});
		$(".fancybox").fancybox();
	});
</script>

<div class="impact_image_section">
	<input name='text' value="" id="user_input">
	<input type='hidden' name='id' value="1442480776" id="template_id">
	<select id="font_select" name="font">
		<option value="Angil">Angil</option>
		<option value="Old English">Old English</option>
		<option value="Frank">Frank</option>
		<option value="Impact">Impact</option>
		<option value="Stencil">Stencil</option>
		<option value="Kiss Me">Kiss Me</option>
		<option value="Oklahoma">Oklahoma</option>
		<option value="Boston">Boston</option>
		<option value="Razor">Razor</option>
		<option value="Sanchez">Sanchez</option>
		<option value="Script">Script</option>
	</select>
	<button id="preview_btn">preview</button>
</div>

</body>

</html>