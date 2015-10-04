<?php
require_once('../config.php');
require_once('../utility.php');
require_once('../lib/json.db.php');
require_once('../lib/layout.db.php');

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$dbHandler = new JsonDB("database.json");
$databasefilename = dirname($_SERVER["SCRIPT_FILENAME"]) . "/database.json" ;
chmod($databasefilename, 0777);

$currentlayoutObj = new Layout();

//check request
//this code block works like a controller
if(is_ajax() || isset($_POST['type'])){
	$type=$_POST['type'];
	switch ($type) {
		case 'save layout':
			$new_layout = new Layout();
			$new_layout->set_name($_POST['layout_name']);
			$new_layout->set_background_image($_POST['image_name']);
			$new_layout->set_datetime(time());
			$new_layout->set_x1($_POST['x1']);
			$new_layout->set_y1($_POST['y1']);
			$new_layout->set_x2($_POST['x2']);
			$new_layout->set_y2($_POST['y2']);
			$new_layout->set_w($_POST['w']);
			$new_layout->set_h($_POST['h']);
			$new_layout->set_l($_POST['l']);
			$new_layout->set_color($_POST['color']);
			$new_layout->set_r($_POST['r']);
			$new_layout->set_d($_POST['d']);
			
			$currentListLayout = $dbHandler->read('layout');	
			if($currentListLayout!=null){
				if(is_array($currentListLayout)){
					$tmparr = $currentListLayout;
				} else {
					$tmparr = get_object_vars($currentListLayout);
				}	
				array_push($tmparr, (object) $new_layout->getAllData()); 
			}else{
				$tmparr= array((object) $new_layout->getAllData());
			}
			

			// $tmparr[]= (object) $new_layout->getAllData();
			
			$currentListLayout = $tmparr;
			$rs = $dbHandler->set("layout", $currentListLayout)->save();
		

			if($rs){
				$tmpdata = ($new_layout->getAllData());
				$dbHandler->set("current_layout", $tmpdata)->save();
				echo json_encode(array('err'=>0));
			}else{
				echo json_encode(array('err'=>1));
			}
			break;
		case 'delete tmp file':
			$tmpFile = $_POST['listfile'];
			$exceptFile = $_POST['exceptfile'];

			$tmpFileArr = explode('@@@@', $tmpFile);
			foreach ($tmpFileArr as $key => $value) {
				if($value != $exceptFile){
					unlink($config['image_path'].$value);
				}
			}
		
			echo json_encode(array('err'=>0));
			break;
		case 'change layout':
			$datetime = $_POST['datetime'];
			$alllayoutJson = $dbHandler->read('layout');

			foreach ($alllayoutJson as $key => $value) {
				if($value->datetime == $datetime){
					$tmp = (array) $value;
					$currentlayoutObj->set_name($tmp['name']);
					$currentlayoutObj->set_background_image($tmp['background_image']);
					$currentlayoutObj->set_datetime($tmp['datetime']);
					$currentlayoutObj->set_x1($tmp['x1']);
					$currentlayoutObj->set_y1($tmp['y1']);
					$currentlayoutObj->set_x2($tmp['x2']);
					$currentlayoutObj->set_y2($tmp['y2']);
					$currentlayoutObj->set_w($tmp['w']);
					$currentlayoutObj->set_h($tmp['h']);
					$currentlayoutObj->set_l($tmp['l']);
					$currentlayoutObj->set_color($tmp['color']);
					$currentlayoutObj->set_d($tmp['d']);
					$currentlayoutObj->set_r($tmp['r']);

					$tmpdata = $currentlayoutObj->getAllData();
					$dbHandler->set("current_layout", ($tmpdata))->save();
				}
			}
			echo json_encode(array('err'=>0));
			break;
		case 'edit layout':
			$datetime = $_POST['datetime'];
			$layout_name = $_POST['layout_name'];
			$alllayoutJson = $dbHandler->read('layout');

			$newdata = $alllayoutJson;
			if(is_object($alllayoutJson)){
				$tmpdata = array();
				foreach ($alllayoutJson as $key => $value) {
					$tmpdata[] =(array) $value;
				}
				$newdata= $tmpdata;
			}
			$alllayoutJson = $newdata;

			foreach ($alllayoutJson as $key => $value) {
				if($value->datetime == $datetime){
					$tmp = (array) $value;
					$currentlayoutObj->set_name($layout_name);
					$currentlayoutObj->set_background_image($tmp['background_image']);
					$currentlayoutObj->set_datetime($tmp['datetime']);
					$currentlayoutObj->set_x1($_POST['x1']);
					$currentlayoutObj->set_y1($_POST['y1']);
					$currentlayoutObj->set_x2($_POST['x2']);
					$currentlayoutObj->set_y2($_POST['y2']);
					$currentlayoutObj->set_w($_POST['w']);
					$currentlayoutObj->set_h($_POST['h']);
					$currentlayoutObj->set_l($_POST['l']);
					$currentlayoutObj->set_color($_POST['color']);
					$currentlayoutObj->set_r($_POST['r']);
					$currentlayoutObj->set_d($_POST['d']);


					$tmpdata = $currentlayoutObj->getAllData();
					// var_dump($tmpdata); exit;
					$dbHandler->set("current_layout", ($tmpdata))->save();

					$tmpvalue = $value;
					$tmpvalue->x1 = $_POST['x1'];
					$tmpvalue->y1 = $_POST['y1'];
					$tmpvalue->x2 = $_POST['x2'];
					$tmpvalue->y2 = $_POST['y2'];
					$tmpvalue->w = $_POST['w'];
					$tmpvalue->h = $_POST['h'];
					$tmpvalue->l = $_POST['l'];
					$tmpvalue->color = $_POST['color'];
					$tmpvalue->r = $_POST['r'];
					$tmpvalue->d = $_POST['d'];
					$tmpvalue->name = $_POST['layout_name'];
					$alllayoutJson[$key] = $tmpvalue;
				}
			}
		
			$dbHandler->set("layout", $alllayoutJson)->save();
			echo json_encode(array('err'=>0));
			break;

		case 'delete layout':
			$datetime = $_POST['datetime'];
			$alllayoutJson = $dbHandler->read('layout');
			foreach ($alllayoutJson as $key => $value) {
				if($value->datetime == $datetime){
					unlink($config['image_path'].$value->background_image);
					if(is_array($alllayoutJson)){
						unset($alllayoutJson[$key]);
					} else {
					    unset($alllayoutJson->$key);
					}
					
				}
			}

			$dbHandler->set("layout", $alllayoutJson)->save();
			$tmp = (array) $alllayoutJson;
			if(!empty($tmp)){
				foreach ($alllayoutJson as $key => $value) {
					$tmp = (array) $value;
					$currentlayoutObj->set_name($tmp['name']);
					$currentlayoutObj->set_background_image($tmp['background_image']);
					$currentlayoutObj->set_datetime($tmp['datetime']);
					$currentlayoutObj->set_x1($tmp['x1']);
					$currentlayoutObj->set_y1($tmp['y1']);
					$currentlayoutObj->set_x2($tmp['x2']);
					$currentlayoutObj->set_y2($tmp['y2']);
					$currentlayoutObj->set_w($tmp['w']);
					$currentlayoutObj->set_h($tmp['h']);
					$currentlayoutObj->set_l($tmp['l']);
					$currentlayoutObj->set_color($tmp['color']);
					$currentlayoutObj->set_d($tmp['d']);
					$currentlayoutObj->set_r($tmp['r']);

					$tmpdata = $currentlayoutObj->getAllData();
					$dbHandler->set("current_layout", ($tmpdata))->save();
					break;
				}
			}else{
				$tmpdata = $currentlayoutObj->getAllData();
				$dbHandler->set("current_layout", ($tmpdata))->save();
			}
			
			echo json_encode(array('err'=>0));
			break;
		
		case 'generate code':
			$datetime = $_POST['datetime'];
			$image = "";
			$x = "";
			$y = "";
			$w = "";
			$h = "";
			$color = "";
			$r = "";
			$d = "";

			$alllayoutJson = $dbHandler->read('layout');
			foreach ($alllayoutJson as $key => $value) {
				if($value->datetime == $datetime){
					$image = $config['base_url'].'img/'.$value->background_image;
					$x  = $value->x1;
					$y  = $value->y1;
					$w  = $value->w;
					$h  = $value->h;
					$color  = $value->color;
					$r  = $value->r;
					$d  = $value->d;
					break;
				}
			}

			$fontcontent = file_get_contents('code_font.tpl');
			$fontcontent = str_replace('{{base_url}}', $config['base_url'] , $fontcontent);

			$codecontent = file_get_contents('code_generate.tpl');
			$codecontent = str_replace('{{base_url}}', $config['base_url'] , $codecontent);
			$codecontent = str_replace('{{font_content}}', $fontcontent , $codecontent);
			$codecontent = str_replace('{{datetimeid}}', $datetime , $codecontent);
			$codecontent = str_replace('{{image}}', $image , $codecontent);
			$codecontent = str_replace('{{x}}', $y , $codecontent);
			$codecontent = str_replace('{{y}}', $x , $codecontent);
			$codecontent = str_replace('{{w}}', $w , $codecontent);
			$codecontent = str_replace('{{h}}', $h , $codecontent);
			$codecontent = str_replace('{{color}}', $color , $codecontent);

			$list_font = $config['list_font'];
			$font_option = '';
			foreach ($list_font as $key => $value) {
				$font_option .='<option value="'.$key.'">'.$key.'</option>';
			}
			$codecontent = str_replace('{{font_option}}', $font_option , $codecontent);
			
			echo htmlspecialchars($codecontent);

			break;

		default:
			# code...
			break;
	}
	exit;
}else{
	$datalayoutJson = $dbHandler->read('current_layout');
	if($datalayoutJson==null){
		$tmpdata = $currentlayoutObj->getAllData();
		$dbHandler->set("current_layout", ($tmpdata))->save();
	}else{
		$tmp = (array)($datalayoutJson);
		$currentlayoutObj->set_name($tmp['name']);
		$currentlayoutObj->set_background_image($tmp['background_image']);
		$currentlayoutObj->set_datetime($tmp['datetime']);
		$currentlayoutObj->set_x1($tmp['x1']);
		$currentlayoutObj->set_y1($tmp['y1']);
		$currentlayoutObj->set_x2($tmp['x2']);
		$currentlayoutObj->set_y2($tmp['y2']);
		$currentlayoutObj->set_w($tmp['w']);
		$currentlayoutObj->set_h($tmp['h']);
		$currentlayoutObj->set_l($tmp['l']);
		$currentlayoutObj->set_color($tmp['color']);
		$currentlayoutObj->set_r($tmp['r']);
		$currentlayoutObj->set_d($tmp['d']);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin generation html code</title>

<link rel="stylesheet" href="../css/bootstrap.min.css" >
<link rel="stylesheet" href="../css/jquery.Jcrop.min.css"/>
<link rel="stylesheet" href="../css/toastr.css"/>
<link rel="stylesheet" href="../css/jquery.snippet.min.css"/>
<!-- <link rel="stylesheet" href="../css/docs.css"/> -->
<link rel="stylesheet" href="../css/bootstrap-colorpicker.min.css"/>

<script type="text/javascript">
	var base_url = '<?php echo $config["base_url"]; ?>';
</script>
</head>
<body>
	<div class="form-group"></div>
	<div class="container">
		<div class="span4 offset4">
			<div class="row">				
				<div class="col-md-2 col-md-offset-1 form-group">
					<button id="new_layout">Create New Layout</button>
				</div>

				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(1)<button id="select_picture" class="btn-info">Select your product picture</button>
						<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
						<form action="upload.php" method="post" enctype="multipart/form-data"id="form_upload_file" target="upload_target" onsubmit="startUpload();">
							<input type="file" name="file" id="file" style="display:none">	
						</form>
						
					</div>
				</div>

				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(2)<input type="text" name="layout_name" id="layout_name" placeholder="Please input layout's name">			
					</div>
				</div>

				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(3)<input type="number" name="number" id="characters_length" placeholder="Characters length">			
					</div>
				</div>

			</div>

			<div class="row">	
				<div class="col-md-2 col-md-offset-1 form-group">
				</div>			
				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(4)<input type="text" name="color" id="color" placeholder="Please input color" value="#FFFFFF">			
					</div>
				</div>

				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(5) Direction <select class="" id="direction" name="d">
								<option value="1" selected>1</option>							
								<option value="-1">-1</option>							
							</select>
					</div>
				</div>

				<div class="col-md-3 new_layout" style="display:none;">
					<div class="form-group">
						(6)<input type="number" name="r" id="radius" placeholder="radius">			
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-md-4 col-md-offset-1">
					<div class="form-group">
					    <select class="form-control" id="change_layout">
					    <?php 
					    $alllayoutJson = $dbHandler->read('layout');
					    if($alllayoutJson!=null){
					    	$currentlayoutObj= (object) $currentlayoutObj;
					    	foreach ($alllayoutJson as $key => $layout) {
					    		if($currentlayoutObj->datetime == $layout->datetime){
					    			echo '<option value="'.$layout->datetime.'" selected>'.$layout->name.'</option>';
						    	}else{
						    		echo '<option value="'.$layout->datetime.'" >'.$layout->name.'</option>';
						    	}
						    }	
					    }else{
				    		echo '<option value="'.$currentlayoutObj->name.'" seleted>'.$currentlayoutObj->name.'</option>';
					    }
					    
					    ?>
			
						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
					 	<button id="edit_this_layout" class="btn-info">Edit this layout</button>
					</div>
				</div>

			</div>

			<div class="row" style="display:none" id="row_edit_layout_name">
				<div class="preview_section col-md-12 col-md-offset-1 form-group">
					<div class="col-md-2"><label>Layout name</label></div>
					<div class="col-md-4"><input type="text" name="number" id="edit_layout_name" autocomplete="off"></div>
				</div>
			</div>

			<div class="row" style="display:none" id="row_edit_color">
				<div class="preview_section col-md-12 col-md-offset-1 form-group">
					<div class="col-md-2"><label>Color</label></div>
					<div class="col-md-4"><input type="text" name="color" value="<?php echo $currentlayoutObj->color; ?>" id="edit_color"></div>
				</div>
			</div>


			<div class="row" style="display:none" id="row_edit_character">
				<div class="col-md-12 col-md-offset-1 form-group">
					<div class="col-md-2"><label>Character length</label></div>
					<div class="col-md-4"><input type="number" name="number" id="edit_characters_length" value="<?php echo $currentlayoutObj->l; ?>" placeholder="Characters length" disabled></div>
				</div>
			</div>

			<div class="row" style="display:none" id="row_edit_direction">
				<div class="preview_section col-md-12 col-md-offset-1 form-group">
					<div class="col-md-2"><label>Direction</label></div>
					<div class="col-md-4">
						<select class="" id="edit_direction" name="d">
							<?php 
							if($currentlayoutObj->d == "1" || $currentlayoutObj->d == 1){
								?><option value="1" selected>1</option><option value="-1">-1</option><?php
							}else{
								?><option value="1">1</option><option value="-1" selected="">-1</option><?php 
							}
							?>
						</select>
					</div>
				</div>
			</div>

			<div class="row" style="display:none" id="row_edit_radius">
				<div class="col-md-12 col-md-offset-1 form-group" >
					<div class="col-md-2"><label>Radius</label></div>
					<div class="col-md-4"><input type="text" name="radius" id="edit_radius" value="<?php echo $currentlayoutObj->r; ?>"></div>
				</div>
			</div>

			<div class="row">
				<div class="preview_section col-md-12 col-md-offset-1 form-group">
					<img id="image_preview" src="<?php echo $config['base_url'].'/img/'.$currentlayoutObj->background_image; ?>" style="max-width:800px;"></img>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-md-offset-1">
					<button id="save_change">Save changes</button>
					<button id="delete_layout">Delete Layout</button>
					<button id="generate_code">Generate Code</button>
				</div>
			</div>

			<input type="hidden" value="<?php echo $currentlayoutObj->x1; ?>" id="coordx1" autocomplete="off" />
			<input type="hidden" value="<?php echo $currentlayoutObj->y1; ?>" id="coordy1" autocomplete="off" />
			<input type="hidden" value="<?php echo $currentlayoutObj->x2; ?>" id="coordx2" autocomplete="off" />
			<input type="hidden" value="<?php echo $currentlayoutObj->y2; ?>" id="coordy2" autocomplete="off" />
			<input type="hidden" value="<?php echo $currentlayoutObj->w; ?>" id="coordw" autocomplete="off" />
			<input type="hidden" value="<?php echo $currentlayoutObj->h; ?>" id="coordh" autocomplete="off" />

	<!-- 	<input type="hidden" value="<?php echo $currentlayoutObj->x1; ?>" id="coordx1" />
			<input type="hidden" value="<?php echo $currentlayoutObj->y1; ?>" id="coordy1" />
			<input type="hidden" value="<?php echo $currentlayoutObj->x2; ?>" id="coordx2" />
			<input type="hidden" value="<?php echo $currentlayoutObj->y2; ?>" id="coordy2" />
			<input type="hidden" value="<?php echo $currentlayoutObj->w; ?>" id="coordw" />
			<input type="hidden" value="<?php echo $currentlayoutObj->h; ?>" id="coordh" /> -->
		</div>
	</div>
<style>
    .header {
        color: #36A0FF;
        font-size: 27px;
        padding: 10px;
    }
	.bigicon {
        font-size: 35px;
        color: #36A0FF;
    }
    .modal-backdrop {
	  z-index: -1;
	}

</style>

<script src="../js/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
<script src="../js/js.cookie.js"></script>
<script src="../js/jquery.zclip.min.js"></script>
<script src="../js/jquery.color.js"></script>
<script src="../js/jquery.Jcrop.min.js"></script>
<script src="../js/toastr.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootbox.min.js"></script>

<script src="../js/jquery.snippet.min.js"></script>

<script src="../js/colorpicker-color.js"></script>
<script src="../js/colorpicker.js"></script>
<script src="../js/docs.js"></script>

<script src="../js/script.js"></script>
</body>

</html>