<?php
require_once('config.php');

//datetime
$imagename= $_GET['name'];
// unlink($config['image_review_path'].$imagename);

header("Content-Type: application/json");
echo $_GET['callback']."()";

?>