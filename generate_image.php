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

//init db handler
$dbHandler = new JsonDB("./admin/database.json");
$currentListLayout = $dbHandler->read('layout');

$existFile = $config['image_path'].'CH-Profile.jpg';
foreach ($currentListLayout as $key => $value) {
	if($datetimeid == $value->datetime){
		$existFile = $config['image_path'].$value->background_image;
		$x1= $value->x1;
		$y1= $value->y1;
		$width= $value->w;
		$height= $value->h;
		$text = substr($text,0,$value->l);
		break;
	}
}

$newfile = time() .".png";
$savepath = "./img_preview/".$newfile;
$tmp_text_box = "./img_preview/tmp_text_box.png";
$tmp_resize_img = "./img_preview/tmp_resize_img.png";

create_text_image($tmp_text_box, $text, $font);
do_resize_image($tmp_text_box, $tmp_resize_img,$width,$height) ;

//get size of image and 
list($rs_width, $rs_height) = getimagesize($tmp_resize_img);
do_copy_image($tmp_resize_img, $existFile ,  $savepath , $x1 , $y1 + $rs_height/2 , $width, $height);
// unlink($tmp_text_box);
// unlink($tmp_resize_img);

//jsonp
header("Content-Type: application/json");
echo $_GET['callback']."(".json_encode(array('img'=>$config['base_url'].'/img_preview/'.$newfile, 'img_name' => $newfile)).")";

//-----------------------function------------------------//
function str_to_utf8 ($str) {
    $decoded = utf8_decode($str);
    if (mb_detect_encoding($decoded , 'UTF-8', true) === false)
        return $str;
    return $decoded;
}

function create_text_image($fileout, $text, $font ){
	$sizearray = imagettfbbox(20, 0, $font, $text);
	$width = $sizearray[4] - $sizearray[6]; // upper-right x minus upper-left x 
	$height = $sizearray[3] - $sizearray[5]; // lower-right y minus upper-right y
	$padingx = $width/4;
	$padingy = $height/4;
	
	$im = imagecreatetruecolor($width+ $padingx, $height+ $padingy);
	$white = imagecolorallocate($im, 255, 255, 255);
	$black = imagecolorallocate($im, 0, 0, 0);

	// imagefill($im, $width+ $padingx, $height + $padingy, $black);
	imagefill($im, $width, $height, $black);
	imagecolortransparent($im, $black);

	imagettftext($im, 20, 0, $padingx/2 , $height , -$white , $font, $text);
	// imagettftext($im, 80, 0, $padingx/2, $height , -$white , $font, $text);
	imagepng($im, $fileout);
	imagedestroy($im);
}

function do_resize_image($filename,$fileout, $newwidth, $newheight){
	$im = imagecreatetruecolor($newwidth, $newheight);
	$white = imagecolorallocate($im, 255, 255, 255);
	$black = imagecolorallocate($im, 0, 0, 0);

	imagefill($im, $newwidth, $newheight, $black);
	imagecolortransparent($im, $black);

	$source = imageCreateFromPng($filename);
	list($width, $height) = getimagesize($filename);

	// imagecopyresized($im, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagecopyresized($im, $source, 0, 0, 0, 0, $newwidth, $height, $width, $height);

	imagepng($im, $fileout);
	imagedestroy($im);
}

function do_copy_image($resize_filein, $origin_filein, $fileout, $x, $y, $w, $h){
	if(strpos(strtolower($origin_filein), '.jpg') != false || strpos(strtolower($origin_filein), '.jpeg') != false){
    	$dest = @imagecreatefromjpeg($origin_filein);	
    }elseif (strpos(strtolower($origin_filein), '.png') != false) {
    	$dest = @imagecreatefrompng($origin_filein);	
    }else{
    	$dest = @imagecreatefromwbmp($origin_filein);	
    }
	$src = imageCreateFromPng($resize_filein);

	list($rs_width, $rs_height) = getimagesize($resize_filein);

	imagecopymerge($dest, $src, $x, $y, 0, 0, $w, $h, 75);
	// imagecopymerge($dest, $src, $x, $y, 0, -$rs_height/4, $w, $h, 75);
	imagepng($dest, $fileout);
	imagedestroy($dest);
	imagedestroy($src);
}

?>