<?php

 $filename = $file.".csv";
 
$titlaData = explode("+", $title);
 $countT = count($titlaData);
 for($j=0;$j<$countT;$j++){
	  echo ltrim($titlaData[$j])."\n";
	 
 }
 echo "".$headding."\n";

 $data = explode("<", $data_total);
 $count = count($data);
 for($j=0;$j<$count;$j++){
	  echo $data[$j]."\n";
	 
 }
 
 $dataT = explode("<", $csv_data_total);
 $countT = count($dataT);
 for($n=0;$n<$countT;$n++){
	  echo $dataT[$n]."\n";
	  
 }

 $csv_file = fopen('php://output', 'w');
 header('Content-Type: text/csv; charset=utf-8');
 header( 'Content-Type: text/csv' );
 header( 'Content-Disposition: attachment;filename='.$filename);
 
//fputcsv($csv_file,$dataCSV);
?>