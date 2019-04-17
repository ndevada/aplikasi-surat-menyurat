<?php
/*$today = date("my");
$nama = "Peternak Lele";
$arr = explode(" ", $nama);
$singkatan = "";
foreach($arr as $kata){
$singkatan .= substr($kata, 0, 1);
}
echo "MM".$today.$singkatan;*/
 /*  $name = "Peternal Lele";
   $parts = explode(' ',$name);
   $initials = '';
   foreach($parts as $part) {
      $initials .= $part[0];
   }
   echo $initials; */
   $today = date("Y");
   $nama = "Kamera CCTV";
   $arr = explode(" ", $nama);
   $singkatan = "";
   foreach($arr as $kata){
   $singkatan .= substr($kata, 0, 1);
   }
   echo $singkatan;

   

$now = strtotime(date('Y-m-d')); // or your date as well
$your_date = strtotime("2018-01-01");
$datediff = $now - $your_date;

$aaa= round($datediff / (60 * 60 * 24));

$apa = $aaa - 3;

echo $apa;


?>