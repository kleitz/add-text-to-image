var jcrop_api = null;
var is_image_change = false;
url =base_url + "admin/index.php";

function startUpload(){
	$('#select_picture').html('Processing...');
}

function stopUpload(success){
	if(success!=0 && success!="0"){
		$('#select_picture').html('Please select your product picture');		
		var newImage = base_url+'/img/'+success ;
		
		//store this image file name in cookie to delete it later
		currentListImage = $.cookie("tmp_uploadimage");
		if (typeof currentListImage == 'undefined')
		{
			currentListImage = [];
		}
		currentListImage  =  currentListImage+"@@@@"+success;	
		$.cookie("tmp_uploadimage", currentListImage);
		$.cookie("latest_image_name", success);
		
		//re-setup jcrop.
		jcrop_api.setImage(newImage); 

		$('#image_preview').attr('src', newImage);	
		$("#coordx1").val(0);
	    $("#coordy1").val(0);
		$("#coordx2").val(0);
	    $("#coordy2").val(0);
		$("#coordw").val(0);
	    $("#coordh").val(0);

	    $("#layout_name").focus();
	    is_image_change = true;
	}else{
		toastr.error('Upload image fail, please try again!');
		$('#select_picture').html('Please select your product picture');		
	}
}


jQuery(document).ready(function($) {
	$('#color').colorpicker();
	$('#edit_color').colorpicker();

	var interval = null;
	function createJcropArea(){
		jcrop_api  = $.Jcrop("#image_preview",{
			allowMove: 	true,
	        allowResize: false,
			onSelect: function(c){
				console.log(c);
				$("#coordx1").val(c.x);
			    $("#coordy1").val(c.y);
				$("#coordx2").val(c.x2);
			    $("#coordy2").val(c.y2);
				$("#coordw").val(c.w);
			    $("#coordh").val(c.h);
			},
		    // onChange: showCoords,
	        setSelect: [$("#coordx1").val(), $("#coordy1").val(), $("#coordx2").val(), $("#coordy2").val()],// you have set proper proper x and y coordinates here
	        // minSize:[$("#coordw").val(),$("#coordh").val()],
	        bgColor: 'white'
	        // aspectRatio: 10 / 3
	    });
	    clearInterval(interval);
	}		
	// createJcropArea();

	// $("#image_preview").on('load', function() { 
		interval = setInterval(createJcropArea, 2000);
		// setTimeout(function());
	// });
// 


	$("#save_change").click(function(event) {
		if(!$("#layout_name").is(":visible") && !$("#select_picture").is(":visible") && !iseditmode){
			return false;
		}

		//detect this is the edit or create
		if(!$("#layout_name").is(":visible") && !$("#select_picture").is(":visible") && iseditmode){
			//this is edit
			var data = {
					type: "edit layout",
					datetime: $( "#change_layout option:selected" ).val(),
					layout_name: $( "#edit_layout_name" ).val(),
					color: $( "#edit_color" ).val(),
					d: $( "#edit_direction option:selected" ).val(),
					r: $( "#edit_radius" ).val(),
					l: $( "#edit_characters_length" ).val(),
					x1:$("#coordx1").val(),
					y1:$("#coordy1").val(),
					x2:$("#coordx2").val(),
					y2:$("#coordy2").val(),
					w:$("#coordw").val(),
					h:$("#coordh").val()
				};
			$.post(url, data , function(data, textStatus, xhr) {
				//delete old post 
				if(data.err==0 ){
					toastr.success("The layout is edited successful!");
					setTimeout(function(){
						window.location.reload();	
					},1000);
				}
				//set current layout
			}, 'json');
			return true;
		}

		if($("#layout_name").val()==""){
			$("#layout_name").focus();
			toastr.error("Please input the layout's name");	
			return false;
		}

		if($("#coordw").val()==0 || $("#coordh").val()==0){
			toastr.error("Please select the text's area");	
			return false;
		}

		if($("#characters_length").val()==0 || $("#characters_length").val()==0){
			toastr.error("Please input the length of character");	
			$("#characters_length").focus();
			return false;
		}

		if(is_image_change){
			var data = {
					type: "save layout",
					image_name : $.cookie("latest_image_name"),
					layout_name: $("#layout_name").val(),
					
					color: $( "#color" ).val(),
					d: $( "#direction option:selected" ).val(),
					r: $( "#radius" ).val(),

					l: $("#characters_length").val(),
					x1:$("#coordx1").val(),
					y1:$("#coordy1").val(),
					x2:$("#coordx2").val(),
					y2:$("#coordy2").val(),
					w:$("#coordw").val(),
					h:$("#coordh").val()
				};
			$.post(url, data , function(data, textStatus, xhr) {
				//delete old post 
				if(data.err==0 ){
					var deleteData  = {
						exceptfile: $.cookie("latest_image_name"),
						listfile: $.cookie("tmp_uploadimage"),
						type: 'delete tmp file'
					};

					$.post(url, deleteData, function(data, textStatus, xhr) {
						$.cookie("tmp_uploadimage", '');
						$.cookie("latest_image_name", '');
						toastr.success("The new layout is created successful!");
						setTimeout(function(){
							window.location.reload();	
						},1000);
						
					});
				}
				//set current layout
			}, 'json');
		}
		
	});

	$("#delete_layout").click(function(event) {
		bootbox.confirm("Are you sure to delete this layout?", function(result) {
			var data = {
					type: "delete layout",
					datetime: $( "#change_layout option:selected" ).val()
				};

			$.post(url, data , function(data, textStatus, xhr) {
				if(data.err==0 ){
					toastr.success("Delete layout successful!");
					setTimeout(function(){
						window.location.reload();	
					},1000);
				}
				//set current layout
			}, 'json');
		}); 
	});

	$("#generate_code").click(function(event) {
		var data = {
			type: "generate code",
			datetime : $( "#change_layout option:selected" ).val()
		};
 		$.post(url,data, function(resp, textStatus, xhr) {
 				bootbox.dialog({
					  message: '<pre class="htmlCode clipboard">'+resp+'</pre>',
					  title: "Generated code",
					  buttons: {}
					});

 				// $('.snippet-copy').zclip({
     //           		path:"../js/ZeroClipboard.swf",
     //           		copy:$('pre.htmlCode').text()
     //       		});

				$("pre.htmlCode").snippet("javascript", {style:"", /*clipboard:"../js/ZeroClipboard.swf", */ transparent:true,showNum:false});
				// $("pre.htmlCode").snippet("html",{style:"bright",transparent:true,showNum:false});
 				// $('pre.htmlCode').zclip({
     //           		path:'../js/ZeroClipboard.swf',
     //           		copy:$('pre.htmlCode').text()
     //       		});
 		});

		// toastr.success('generate_code');
	});

	var isnewlayoutinputopen = false;
	$("#new_layout").click(function(event) {
		// toastr.success('generate_code');
		if(isnewlayoutinputopen){
			$(".new_layout").hide();	
			isnewlayoutinputopen = false;
		}else{
			$(".new_layout").show();	
			isnewlayoutinputopen = true;
		}
		
	});

	var iseditmode = false;
	$("#edit_this_layout").click(function(event) {
		if(iseditmode){
			$("#row_edit_layout_name").hide();
			$("#row_edit_color").hide();
			$("#row_edit_direction").hide();
			$("#row_edit_character").hide();
			$("#row_edit_radius").hide();
			$("#edit_characters_length").prop('disabled', true);	
			iseditmode = false;
		}else{
			$("#row_edit_layout_name").show();
			$("#row_edit_color").show();
			$("#row_edit_direction").show();
			$("#row_edit_character").show();
			$("#row_edit_radius").show();
			$("#edit_layout_name").focus().val($( "#change_layout option:selected" ).text());
			$("#edit_characters_length").prop('disabled', false);
			iseditmode = true;
		}
	});

	$("#file").change(function(rp){
        //submit the form here
     	$("#form_upload_file").submit();
   	});

 	$("#select_picture").click(function(rp){
         //submit the form here
         $("#file").click();
         // toastr.success('upload file');
 	});

 	$("#change_layout").change(function(event) {
 		
		var data = {
				type: "change layout",
				datetime : $( "#change_layout option:selected" ).val()
			};
 		$.post(url,data, function(data, textStatus, xhr) {
			window.location.reload();
 		},'json');
 	});
});