<?php
$x = 200;
$y = 200;

$colors = imagecreatetruecolor($x, $y);
// imagecreatefromjpeg/png/
		$image = imagecreatefromjpeg('image.jpg');
		// $image = imagecreatefrompng("image.png");

		$width = imagesx($image);
		$height = imagesy($image);
		$colors = array();

		for ($y = 0; $y < $height; $y++) {
			$y_array = array() ;

			for ($x = 0; $x < $width; $x++) {
				$rgb = imagecolorat($image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				$x_array = array($r, $g, $b) ;
				$y_array[] = $x_array ; 
				if ($x==10) {
					break;
				}
			} 
			$colors[] = $y_array ;
		}
header('Content-Type: image/png');
imagepng($colors);

?>