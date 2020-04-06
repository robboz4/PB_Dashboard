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
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.2.1)</h1>

Press Button  to start simluated updating of table from a csv file/stream. It will run a 10x loop to add new or updated  data. <br>
The data is serial number, revs and temperature. Numbers are simply generated via python random code generator 1-10.<br>
The page  will refresh every 10 seconds after that.<br>

<form action="dashboard.php" method="POST">
<button name="submit"  value="start" class="green">Start demo run.</button>
</form>

<?php
/* Test of parsing csv file and  displaying results.


Dave Robinson 4/4/2020

A.0.0 Simple reading a csv file an dupdating the screen
A.2.0 Updates table with new or updated data of eeiting entries. (4/5/2020)
A.2.1 Removed the need to refresh page to get data after pressing the start button (4/6/2020)



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
          shell_exec("/usr/bin/nohup " . $cmd . ">/dev/null 2>&1 &"); 
// Asynchronously runs command. No waiting...

	}

else {
         $stream =  fopen("motor.csv",  "r");
	$dashboard = array();
         echo  "<table>";
         echo "<caption>Motor data </caption>";
         echo "<tr> <th> Motor S/N </th><th> Revs </th><th>  Temperature </th> <th> Timestamp </th></tr>";

         while (($motor = fgetcsv($stream)) !== false) {
	
	        $dashboard = check_entry($motor, $dashboard);
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
