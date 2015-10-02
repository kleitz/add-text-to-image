<?php

require_once('config.php');
require_once('./lib/json.db.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//get request data.
$text =	isset($_GET['text'])? $_GET['text'] : "ok, sound good";
$font_name = isset($_GET['font'])? $_GET['font'] : 'impact.ttf';
$list_font = $config['list_font'];
foreach ($list_font as $key => $value) {
	if($_GET['font'] == $key){
		$font_name = $value;
		break;
	}
}
$font = dirname(__FILE__).DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.$font_name;
if(!file_exists($font)){
	$font = dirname(__FILE__).DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'impact.ttf';
}

//datetime
$datetimeid= $_GET['id'];

//set default data
$x1= 195;
$y1= 449;
$width= 195;
$height= 449;
$radius= 449;
$dir= -1;
$color= "#FFFFFF";
$length = 11;

//init db handler
$dbHandler = new JsonDB("./admin/database.json");
$currentListLayout = $dbHandler->read('layout');

$existFile = $config['image_path'].'CH-Profile.jpg';
$filename = "";
foreach ($currentListLayout as $key => $value) {
	if($datetimeid == $value->datetime){
		$existFile = $config['image_path'].$value->background_image;
		$filename = $value->background_image;
		$x1= $value->x1;
		$y1= $value->y1;
		$width= $value->w;
		$height= $value->h;
		$radius= $value->r;
		$color= $value->color;
		$dir= $value->d;
		$length= $value->l;
		$text = substr($text,0,$value->l);
		break;
	}
}

$newfile = time() .".png";
$savepath = "./img_preview/".$newfile;
$tmp_text_box = "./img_preview/tmp_text_box.png";
$tmp_resize_img = "./img_preview/tmp_resize_img.png";

//jsonp
header("Content-Type: application/json");
// echo $_GET['callback']."(".json_encode(array('img'=>$config['base_url'].'/img_preview/'.$newfile, 'img_name' => $newfile)).")";
echo $_GET['callback']."(".json_encode(
	array(
			'img'=>$config['base_url'].'/img/'.$filename, 'img_name' => $filename,
			'color'=>'#FFFFFF',
			'top'=>$y1,
			'left'=>$x1,
			'width'=>$width,
			'height'=>$height,
			'color'=>$color,
			'dir'=>$dir,
			'length'=>$length,
			'radius'=>$radius
	)).")";



?>