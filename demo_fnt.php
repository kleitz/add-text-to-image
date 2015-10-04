<?php
/** Téléchargement de la police 
 * 
 * @author Damien Cuvillier <damien.cuvillier@gmail.com>
 * @since April 2011
 * 
 * @licence Apache 2.0
 */
if(!isset($_GET["f"])){
	die("No font specified");
}

$fontDir = dirname($_SERVER["SCRIPT_FILENAME"]) . "/fonts/" ;

$file = $_GET["f"];
$font = $fontDir . $file;

$extensiontfile= end(explode('.', $file));

if(!is_file($font)){
	die("$font not exists");
}
header('Content-Description: Font File');
switch($extensiontfile){
	case "eot":
		header('Content-Description: Extended OpenType Font File');
		header('Content-Type: application/font');
		break;
	case "ttf":
		header('Content-Description: TTF Font File');
		header('Content-Type: application/x-font-TrueType');
		break;
	case "woff":
		header('Content-Description: Web Font File');
		header('Content-Type: application/x-font-TrueType');
		break;
	case "otf":
		header('Content-Description: OpenType Font File');
		header('Content-Type: application/x-font-woff');
		
		break;
	default:
		die("Invalid type : " . $_GET["t"]);
}
header('Content-Length: ' . filesize($font));
header('Content-Disposition: attachment; filename="' . $file . '"');
readfile($font);
?>