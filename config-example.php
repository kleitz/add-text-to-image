<?php 

// error_reporting(E_ALL);
ini_set('display_errors', 0);

$config= array();
$config['image_path'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;

$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$isexit = strpos($root, 'local');
if($isexit != false){
	$config['base_path'] = "C:/xampp/htdocs/www/test/previewimage/add-text-to-image/";
	$config['base_url'] = 'http://test.local/previewimage/add-text-to-image/';
}else{
	//HINT: config here when deploy to server.
	$config['base_path'] = '/var/www/html/demo/generateimage/';
	$config['base_url'] = 'http://103.9.77.27/demo/generateimage/';
}

//init default values 
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
						);?>


