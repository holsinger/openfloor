<?php

/* 
 * usage: <img src="shrink.php?img=images/test.jpg&w=20&h=20">
 */


$img=$_GET['img']; $w=$_GET['w']; $h=$_GET['h'];
if(!defined('DIR_CACHE'))
define('DIR_CACHE', './image_cache/');

if (!Is_Dir(DIR_CACHE))
mkdir(DIR_CACHE, 0777);

#IMAGE RESIZE AND SAVE TO FIT IN $new_width x $new_height
if (file_exists($img))
{
$thumb=strtolower(preg_replace('/\W/is', "_", "$img $w $h"));
$changed=0;

if(!is_file($img))
$img = "image01.jpg";

if (file_exists($img) && file_exists(DIR_CACHE.$thumb))
{
$mtime1=filemtime(DIR_CACHE.$thumb);
$mtime2=filemtime($img);
if ($mtime2 > $mtime1)
$changed=1;
}
elseif (!file_exists(DIR_CACHE.$thumb))
$changed=1;

if ($changed)
{
$filename=$img;
$new_width=(int)@$w;
$new_height=(int)@$h;
$lst=GetImageSize($filename);
$image_width=$lst[0];
$image_height=$lst[1];
$image_format=$lst[2];

if ($image_format==1)
$old_image=imagecreatefromgif($filename);
elseif ($image_format==2)
$old_image=imagecreatefromjpeg($filename);
elseif ($image_format==3)
$old_image=imagecreatefrompng($filename);
else
exit;

if (($new_width!=0) && ($new_width < $image_width))
{
$image_height=(int)($image_height*($new_width/$image_width));
$image_width=$new_width;
}

if (($new_height!=0) && ($new_height < $image_height))
{
$image_width=(int)($image_width*($new_height/$image_height));
$image_height=$new_height;
}

$new_image=ImageCreateTrueColor($image_width, $image_height);
$white = ImageCopyResampled($new_image, $old_image, 0, 0, 0, 0, $image_width, $image_height, imageSX($old_image), imageSY($old_image));
#ImageFill($new_image, 0, 0, $white);
imageJpeg($new_image, DIR_CACHE.$thumb);
}

header("Content-type:image/jpeg");
readfile(DIR_CACHE.$thumb);
}

/*$imgp = $_GET["imgpath"];
$quality = $_GET["qt"];
$newWidth = $_GET["width"];
$newHeight = $_GET["height"];

list($width, $height) = getimagesize($imgp);
$source = imagecreatefromjpeg($imgp);
$ratio_orig = $width/$height;

if ($newWidth/$newWidth > $ratio_orig) {
   $newWidth = $newWidth*$ratio_orig;
} else {
   $newHeight = $newWidth/$ratio_orig;
}
$thumb = imagecreatetruecolor($newWidth, $newHeight);
imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

header ("Content-type: image/jpeg");                   
imagejpeg($thumb, null, $quality);
imagedestroy($thumb);*/

?>