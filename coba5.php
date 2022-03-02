<?php
set_time_limit(0);
$img = imageCreateTrueColor(510, 510);

for ($r=0; $r<256; $r++) {
  for ($koordinat_y_g=0; $koordinat_y_g<256; $koordinat_y_g++) {
    for ($koordinat_x_b=0; $koordinat_x_b<256; $koordinat_x_b++) {
      $zzz_r = $r;
      $zzz_g = $koordinat_y_g;
      $zzz_b = $koordinat_x_b;
      
      $warna = imageColorAllocate($img, $zzz_r, $zzz_g, $zzz_b);
      imagesetpixel($img, $koordinat_x_b, $koordinat_y_g, $warna);
      // if ($r < 255 && $koordinat_y_g > 0) break;
    }
  }
}
header("Content-Type: image/png");
imagepng($img);
imagedestroy($img);
?>