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
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.0.1)</h1>

Press Button  to start simluated updating of csv file. It will run a 10x loop to add new data. <br>
The data is serial number, revs and temperature. Numbers are simply generated via python random code generator 1-10.
Hit refresh after pressing the run button to see the data. The page  will refresh every 10 seconds after that.<br>

<form action="dashboard.php" method="POST">
<button name="submit"  value="start" class="green">Start demo run.</button>
</form>

<?php
/* Test of parsing csv file and  displaying results.


Dave Robinson 4/4/2020

*/
if(isset($_POST['submit'])){


          $cmd= "/usr/bin/python /var/www/html/test/CSV/motor_stream.py";
         exec($cmd, $output, $error);
//	 echo $output . $error;
	}

else {
         $stream =  fopen("motor.csv",  "r");
         echo  "<table>";
         echo "<caption>Motor data </caption>";
         echo "<tr> <th> Motor S/N </th><th> Revs </th><th>  Temperature </th></tr>";
         while (($motor = fgetcsv($stream)) !== false) {

	  echo "<tr><td> " . $motor[0] . "</td>" ;
	  echo "<td>" . $motor[1] . "</td>" ;
	  echo "<td>" . $motor [2] . "</td></tr>";


         }
         echo "</table>";
	fclose($stream);

}

?>


</html>
