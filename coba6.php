<?php
$image = imagecreatefrompng('bga.png');
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
	} 
	$colors[] = $y_array ;
}

set_time_limit(0);
$obj_gambar = imageCreateTrueColor($width, $height);

foreach ($colors as $key1 => $value1) {
	foreach ($value1 as $key2 => $value2) {
		$zzz_r = $value2[0];
		$zzz_g = $value2[1];
		$zzz_b = $value2[2];

		$warna = imageColorAllocate($obj_gambar, $zzz_r, $zzz_g, $zzz_b);
		imagesetpixel($obj_gambar, $key2, $key1, $warna);
	}
}


header("Content-Type: image/png");
// header("Content-Disposition: attachment; filename=".date('Ymd_His').".png");
imagepng($obj_gambar);
imagedestroy($obj_gambar);
?>