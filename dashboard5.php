<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  font-size: 13px;
}
td.hot{
 color:red;
</style>

<meta http-equiv="refresh" content="10">

</head>
<body>
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.03.03)</h1>


Press the "Start demo run" button  to start a simluate run. It will run a program  to  generate  random data  and switch to a dashbaord<br>
showing an animated REV counter. The program runs for about 1000 cycles.

<form action="dashboard2.php" method="POST">
<button name="submit"  value="start" class="green">Start demo run.</button>
</form>

<?php
/* Test of parsing csv file and  displaying results.


Dave Robinson 4/28/2020

A.0.0 Simple reading a csv file an dupdating the screen
A.2.0 Updates table with new or updated data of existing entries.
A.2.1 Removed the need to refresh page to get data after pressing the start button
A.3.0 New dashboard with real example fo actual data stream.
A.3.1 Added a PHP line graph as a test. 
A.3.2 Added update function for first 3  fields and write out updates to csv file

A.3.2 Launches motor_strea3.py to generate numbers for scripted.html which has an animated Rev Counter.

*/


if(isset($_POST['submit'])){

	          $cmd= "/usr/bin/python /var/www/html/test/CSV/motor_stream3.py";
        	  shell_exec("/usr/bin/nohup " . $cmd . ">/dev/null 2>&1 &"); 
		  //Asynchronously runs command. No waiting...
	          header("Location: ./scripted2.html");	
	}
?>

</html>
