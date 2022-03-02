<?php
// DATA KRITERIA
$kriteria = array(
	array('idk'=>1, 'nkriteria'=>'Red'),
	array('idk'=>2, 'nkriteria'=>'Green'),
	array('idk'=>3, 'nkriteria'=>'Blue')
);
foreach ($kriteria as $key => $value) {
	$detail_kriteria[$value['idk']] = $value;
}
// DATA HIMPUNAN
$himpunan = array(
	array('idh'=>1, 'idk'=>1, 'nhimpunan'=>'Dark', 'nminimal'=>0, 'ntengah'=>63, 'nmaksimal'=>127),
	array('idh'=>2, 'idk'=>1, 'nhimpunan'=>'Pure', 'nminimal'=>63, 'ntengah'=>127, 'nmaksimal'=>191),
	array('idh'=>3, 'idk'=>1, 'nhimpunan'=>'Light', 'nminimal'=>127, 'ntengah'=>191, 'nmaksimal'=>255),
	array('idh'=>4, 'idk'=>2, 'nhimpunan'=>'Dark', 'nminimal'=>0, 'ntengah'=>63, 'nmaksimal'=>127),
	array('idh'=>5, 'idk'=>2, 'nhimpunan'=>'Pure', 'nminimal'=>63, 'ntengah'=>127, 'nmaksimal'=>191),
	array('idh'=>6, 'idk'=>2, 'nhimpunan'=>'Light', 'nminimal'=>127, 'ntengah'=>191, 'nmaksimal'=>255),
	array('idh'=>7, 'idk'=>3, 'nhimpunan'=>'Dark', 'nminimal'=>0, 'ntengah'=>63, 'nmaksimal'=>127),
	array('idh'=>8, 'idk'=>3, 'nhimpunan'=>'Pure', 'nminimal'=>63, 'ntengah'=>127, 'nmaksimal'=>191),
	array('idh'=>9, 'idk'=>3, 'nhimpunan'=>'Light', 'nminimal'=>127, 'ntengah'=>191, 'nmaksimal'=>255)
);
foreach ($himpunan as $key => $value) {
	$detail_himpunan[$value['idk']][] = $value;
}
// DATA ATURAN
$aturan = array(
	array('ida'=>1, 'idh'=>1, 'naturan'=>0, 'nhimpunan'=>'Dark',),
	array('ida'=>2, 'idh'=>2, 'naturan'=>127, 'nhimpunan'=>'Pure',),
	array('ida'=>3, 'idh'=>3, 'naturan'=>255, 'nhimpunan'=>'Light',),
	array('ida'=>4, 'idh'=>4, 'naturan'=>0, 'nhimpunan'=>'Dark',),
	array('ida'=>5, 'idh'=>5, 'naturan'=>127, 'nhimpunan'=>'Pure',),
	array('ida'=>6, 'idh'=>6, 'naturan'=>255, 'nhimpunan'=>'Light',),
	array('ida'=>7, 'idh'=>7, 'naturan'=>0, 'nhimpunan'=>'Dark',),
	array('ida'=>8, 'idh'=>8, 'naturan'=>127, 'nhimpunan'=>'Pure',),
	array('ida'=>9, 'idh'=>9, 'naturan'=>255, 'nhimpunan'=>'Light',)
);
foreach ($aturan as $key => $value) {
	$detail_aturan[$value['nhimpunan']] = $value;
}
// INPUTAN
$rgb[1][1][0] = 6; 		$rgb[1][1][1] = 40; 	$rgb[1][1][2] = 7;
$rgb[1][2][0] = 255; 	$rgb[1][2][1] = 10; 	$rgb[1][2][2] = 120;
$rgb[1][3][0] = 50; 	$rgb[1][3][1] = 20; 	$rgb[1][3][2] = 100;
$rgb[2][1][0] = 100;	$rgb[2][1][1] = 35;		$rgb[2][1][2] = 50;
$rgb[2][2][0] = 46;		$rgb[2][2][1] = 105;	$rgb[2][2][2] = 55;
$rgb[2][3][0] = 75;		$rgb[2][3][1] = 85;		$rgb[2][3][2] = 105;
$rgb[3][1][0] = 105;	$rgb[3][1][1] = 205;	$rgb[3][1][2] = 125;
$rgb[3][2][0] = 70;		$rgb[3][2][1] = 30;		$rgb[3][2][2] = 20;
$rgb[3][3][0] = 250;	$rgb[3][3][1] = 43;		$rgb[3][3][2] = 180;

// PERHITUNGAN FUZZY
foreach ($rgb as $x => $valuex) {
	foreach ($valuex as $y => $valuey) {
		foreach ($valuey as $warna => $nilai) {
			if ($warna==0) {
				$idk = 1;
			} elseif ($warna==1) {
				$idk = 2;
			} elseif ($warna==2) {
				$idk = 3;
			}
			// Mengambil himpunan yang mempunyai kriteria $idk
			$dt_him = $detail_himpunan[$idk];
			$dt_him = $detail_himpunan[$idk];
			$dt_him = $detail_himpunan[$idk];
			foreach ($dt_him as $key_h => $value_h) {
				$nh = $value_h['nhimpunan'];
				$min = $value_h['nminimal'];
				$ten = $value_h['ntengah'];
				$mak = $value_h['nmaksimal'];
				// Mencari dark
				if ($min==0) {
					if ($nilai <= $ten) {
						$fuzzifikasi[$nh] = 1;
					} elseif ($nilai > $min AND $nilai <= $mak) {
						$fuzzifikasi[$nh] = ($mak - $nilai) / ($mak - $ten);
					} else {
						$fuzzifikasi[$nh] = 0;
					}
				}elseif ($min!==0 AND $mak!==255) {
					if ($nilai <= $min OR $nilai > $mak) {
						$fuzzifikasi[$nh] = 0;
					} elseif ($nilai > $min AND $nilai <= $ten) {
						$fuzzifikasi[$nh] = ($nilai - $min) / ($ten - $min);
					} else {
						$fuzzifikasi[$nh] = ($mak - $nilai) / ($mak - $ten);
					}
				}else {
					if ($nilai <= $min) {
						$fuzzifikasi[$nh] = 0;
					} elseif ($nilai > $min AND $nilai <= $ten) {
						$fuzzifikasi[$nh] = ($nilai - $min) / ($ten - $min);
					} else {
						$fuzzifikasi[$nh] = 1;
					}
				}
				$nilai_aturan = $detail_aturan[$nh]['naturan'];
				$perkalian[$nh] = $fuzzifikasi[$nh] * $nilai_aturan;
			}
			$defuzzifikasi[$x][$y][$idk] = array_sum($perkalian) / array_sum($fuzzifikasi);
		}
	}
}

echo "<pre>";
print_r ($defuzzifikasi);
echo "</pre>";
?>