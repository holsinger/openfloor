<?php

/* 
 * usage: <img src="shrink.php?imgpath=images/test.jpg&qt=70">
 */


$imgp = $_GET["imgpath"];
$quality = $_GET["qt"];
$newWidth = $_GET["width"];
$newHeight = $_GET["height"];

list($width, $height) = getimagesize($imgp);
$source = imagecreatefromjpeg($imgp);
$thumb = imagecreatetruecolor($newWidth, $newHeight);

$ratio_orig = $width/$height;

if ($newWidth/$newWidth > $ratio_orig) {
   $newWidth = $newWidth*$ratio_orig;
} else {
   $newHeight = $newWidth/$ratio_orig;
}
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

header ("Content-type: image/jpeg");                   
imagejpeg($thumb, null, $quality);
imagedestroy($thumb);

?>