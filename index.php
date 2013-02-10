<?php
$_SERVER['HTTP_ROOT'] = "/color2image/";

if(preg_match("#^{$_SERVER['HTTP_ROOT']}([\d]*)x([\d]*)\/([a-fA-F\d]{6})\.(jpg|jpeg|png)#", $_SERVER['REQUEST_URI'], $match)
or preg_match("#^{$_SERVER['HTTP_ROOT']}([\d]*)x([\d]*)\/([\d]*,[\d]*,[\d]*)\.(jpg|jpeg|png)#", $_SERVER['REQUEST_URI'], $match))
{
	$width	= $match[1];
	$height	= $match[2];
	$code	= $match[3];
	$format	= $match[4];
	
	$rgb = explode(',', $code);
	
	$im = imagecreate($width, $height);

	isset($rgb[1]) ? ImageColorAllocate($im, $rgb[0], $rgb[1], $rgb[2]) : ImageColorAllocateFromHex($im, $code);
	
	header("Content-Type: image/$format");
	
	$format == "png" ? imagepng($im) : imagejpeg($im);
}
else echo "error the pattern is : width x height / hexa(6) . png";

function ImageColorAllocateFromHex ($img, $hexstr) 
{ 
  $int = hexdec($hexstr);
  return ImageColorAllocate ($img, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int); 
}
?>