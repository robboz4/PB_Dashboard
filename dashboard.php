<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

<meta http-equiv="refresh" content="10">

</head>
<body>
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.2.0)</h1>

Press Button  to start simluated updating of csv file. It will run a 10x loop to add new data. <br>
The data is serial number, revs and temperature. Numbers are simply generated via python random code generator 1-10.<br>
Wait about 10 seconds after pressing the run button, refresh the page to see the data. The page  will refresh every 10 seconds after that.<br>

<form action="dashboard.php" method="POST">
<button name="submit"  value="start" class="green">Start demo run.</button>
</form>

<?php
/* Test of parsing csv file and  displaying results.


Dave Robinson 4/4/2020

*/

function   check_entry($motor, $dashboard)

{
	$data = FALSE;
	$arrlength = count($dashboard);
	for($x = 0; $x < $arrlength; $x++){
                foreach($dashboard[$x] as $value){
//
			if ($value == $motor[0]) {
				$dashboard[$x] = $motor;
				$data =  TRUE;
			}
                }

	 }
	if ( $data == FALSE) {
		
		
		$new_array = array_push($dashboard, $motor);

	}



	return($dashboard);


} 


if(isset($_POST['submit'])){


          $cmd= "/usr/bin/python /var/www/html/test/CSV/motor_stream.py";
         exec($cmd, $output, $error);
//	 echo $output . $error;
	}

else {
         $stream =  fopen("motor.csv",  "r");
//	 echo " Dashboard is: ";
/*	 $dashboard = array(
				array( 'serial'=>"", 'rev'=>"", 'temp'=>"")
			   );

*/
	$dashboard = array();
//	 print_r($dashboard);
//	 echo "      <br>";
         echo  "<table>";
         echo "<caption>Motor data </caption>";
         echo "<tr> <th> Motor S/N </th><th> Revs </th><th>  Temperature </th> <th> Timestamp </th></tr>";

         while (($motor = fgetcsv($stream)) !== false) {
	
	        $dashboard = check_entry($motor, $dashboard);
//		echo "entries " . count($dashboard) . "<br>";
//		var_dump($dashboard);
//		echo '<pre>' . var_export($dashboard, true) . '</pre>';
		}
//	  echo "Main loop <br>";

	fclose($stream);
/*	echo count($dashboard) . "= Number in array<br>";
	foreach ($dashboard as $c) {
		while (list($k, $v) = each($c)){
			echo  $v . "<br>"; 
		}
		"<br>";
	}
*/
	$arrlength = count($dashboard);
	for($x = 0; $x < $arrlength; $x++) {
        echo "<tr>";   
	foreach($dashboard[$x] as $value){
		echo "<td>" . $value . "</td>";
		}
           echo "</tr>";
        }
	echo "</table>";
}

?>


</html>
