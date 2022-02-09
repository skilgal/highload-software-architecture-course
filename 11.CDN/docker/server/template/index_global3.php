<?php
header('Content-type: image/png');

$your_text = 'Global Server #3';
$newImage = imagecreate( 250, 80 );
$background = imagecolorallocate($newImage, 0,0,255);
$text_color = imagecolorallocate($newImage, 255,255,0);
$line_color = imagecolorallocate($newImage, 128,255,0);
imagestring( $newImage, 10, 1, 25, $your_text,  $text_color );
imagesetthickness ( $newImage, 5 );
imageline( $newImage, 30, 45, 165, 45, $line_color );
imagepng($newImage);
imagecolordeallocate($newImage, $line_color );
imagecolordeallocate($newImage, $text_color );
imagecolordeallocate($newImage, $background );
imagedestroy($newImage);
exit;