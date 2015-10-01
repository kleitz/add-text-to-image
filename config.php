<?php 

// error_reporting(E_ALL);
ini_set('display_errors', 0);

$config= [];
$config['image_path'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;
$config['image_review_path'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'img_preview'.DIRECTORY_SEPARATOR;


$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$isexit = strpos($root, 'local');
if($isexit != false){
	$config['base_url'] = 'http://test.local/Site.ProductPreview/';
}else{
	// $config['base_url'] = 'http://103.9.77.27/demo/abc/';
	$config['base_url'] = 'http://103.9.77.27/demo/abc/';
}

//default layout
$config['name'] = 'default';
$config['background_image']= 'CH-Profile.jpg';
$config['datetime']= time();
$config['x1']= 139;
$config['y1']= 330;
$config['x2']= 282;
$config['y2']= 372;
$config['w']= 143;
$config['h']= 43;
$config['id']= 1;
$config['l']= 100;//characters length

// <option value="Angil">Angil</option>
// <option value="Old English">Old English</option>
// <option value="Impact">Impact</option>
// <option value="Stencil">Stencil</option>
// <option value="Kiss Me">Kiss Me</option>
// <option value="Oklahoma">Oklahoma</option>
// <option value="Boston">Boston</option>
// <option value="Razor">Razor</option>
// <option value="Sanchez">Sanchez</option>
// <option value="Script">Script</option>


$config['list_font'] = array(
					'Angil'				=> 'angillatattoopersonaluseonly.ttf',
					'Impact'			=> 'impact.ttf',
					'Edwardian'			=> 'edwardian.ttf',
					'Fetteunzfraktur'	=> 'fetteunzfraktur.ttf',
					'H74rbl'			=> 'h74rbl.ttf',
					'Kiss Me'			=> 'kgkissmeslowly.ttf',
					'Boston'			=> 'lhfbostontruckstylec.ttf',
					'Lintsec'			=> 'lintsec.ttf',
					'Oklahoma'			=> 'oklahoma.ttf',
					'Old English'		=> 'oldeenglish.ttf',
					'Sanchez'			=> 'sanchezregular.ttf'
				);

?>


