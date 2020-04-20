<?php
require_once("./phpChart_Lite/conf.php");
?>
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
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.3.2)</h1>

These tables SIMPLY repesent  three data stream formats from a  controller/motor under test.

Press the "Start demo run" button  to start a simluate run. It will run a program  to  update the  tables with random data <br>
Numbers are simply generated via a python random code generator. They will be fugded to more accurately resemble the data. later<br>
The page  will refresh every 10 second after that. This gives time to update  values in the third table.<br>
Some numbers may show up red. This will be numbers that have limits that are not to  be exceeded. Currently it is not set up for these tables correctly.
It's a work in progress. <br>
The graph at the bottom is also a WIP. <br>


<form action="dashboard2.php" method="POST">
<button name="submit"  value="start" class="green">Start demo run.</button>
</form>

<?php
/* Test of parsing csv file and  displaying results.


Dave Robinson 4/4/2020

A.0.0 Simple reading a csv file an dupdating the screen
A.2.0 Updates table with new or updated data of existing entries.
A.2.1 Removed the need to refresh page to get data after pressing the start button
A.3.0 New dashboard with real example fo actual data stream.
A.3.1 Added a PHP line graph as a test. 
A.3.2 Added update function for first 3  fields and write out updates to csv file
*/

function   check_entry($motor, $dashboard)
/*
function to check if serial number is already reporting.
OBSOLETE NOT NEEDED

*/
{
	$data = FALSE;
	$arrlength = count($dashboard);
	for($x = 0; $x < $arrlength; $x++){
                foreach($dashboard[$x] as $value){
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

function check_range($cell_offset, $cell_value)


/*Function to see if rpm or temp go over set limits. Turn  text red to indicate vaule is over limit
Simple hack
*/
{
	if ($cell_offset == 2 ) {
		if ( $cell_value > 300) {
			$result =  "<td class=\"hot\"   >  <b>  " . $cell_value . "<b/> </td>";
		}
		else {
			$result = "<td>" . $cell_value . "</td>";
		}
	}
	if ($cell_offset == 1 ){
		if ( $cell_value >= 7000) {
                        $result =  "<td class=\"hot\" >  <b>  " . $cell_value . "<b/> </td>";
                }
                else {
                        $result = "<td>" . $cell_value . "</td>";
                }
	}
	
	
	
	return($result);
}

if(isset($_POST['submit'])){

	  if (($_POST['submit'])  == "update")
/* checks to see if the submit button is equal to update
or else just assumes it is the  demo button has been pressed

*/
		{
		$settings = array();
		if (($stream =  fopen("motor4.csv",  "r")) == FALSE) {
			echo "File Open error <br>";
		}
		// Opens  streeam file 3 to get parameters that will be changed.
		while (($motor = fgetcsv($stream)) !== false) {
              	  $settings = check_entry($motor, $settings);
		}
		fclose($stream);
		$change = FALSE;
		$arrlength = count($settings);
		// Only first three parameters set up to be modified. 
		// Demo only. Real world needs parameter padding to 4 characters with +/- sign
		// AA+1234 - demo deos AA+ and what was entered inthe form field.
		if ( $_POST['AA'] != "") {
			echo "Sending command AA" . $_POST['AA'] . " to controller<br>";
			$settings[0][0] = $_POST['AA'];
			$change = TRUE; 
		  }
		if ( $_POST['AB'] != "") {
                        echo "Sending command AB" . $_POST['AB'] . " to controller<br>";
			$settings[0][1] = $_POST['AB'];
			$change = TRUE;    
                  }
                if ( $_POST['AC'] != "") {
                        echo "Sending command AC" . $_POST['AC'] . " to controller<br>";   
                 	$settings[0][2] = $_POST['AC'];
			 $change = TRUE; 
		 }
		// Simulates writing to the stream of updated parameters.
                 if (($handle =  fopen("motor4.csv",  "w")) == FALSE) {
                        echo "File Open error for writing  <br>";
                }
		$str = implode(",", $settings[0]);
		if ( $change == TRUE ) {
			fwrite($handle, $str);
			fclose($handle);
		}
		else{
			fwrite($handle, $str);
			fclose($handle);
		}
//		fclose($handle);
		$change = FALSE;
                }


	  else {
	          $cmd= "/usr/bin/python /var/www/html/test/CSV/motor_stream2.py";
        	  shell_exec("/usr/bin/nohup " . $cmd . ">/dev/null 2>&1 &"); 
		  //Asynchronously runs command. No waiting...
		}
	}
//end of isset - tests for forms  being submitted Below is main  table drawing.
else {
         $stream =  fopen("motor2.csv",  "r");
	 $dashboard = array();
         echo  "<table>";
         echo "<caption> Motor data String format # 1</caption>";
         echo "<tr> <th> Motor Temp <br>#1 </th><th> Motor Temp <br> #2 </th><th> Ctrl Temp <br> #1 </th> <th> Ctrl Temp <br>  #2</th>
		    <th> Slow charge <br> current</th> <th>Fast charger <br> current</th> <th>DC current </th> <th> Quad current</th><th> DC feedback</th>
		    <th>Quad current <br> feedback</th><th> DC Volts</th><th>Quad Volts</th><th>DC Bus <br> voltage </th><th> DC Bus <br> Current </th>
		    <th>RPM</th><th>Resolver Positon</th><th>Fault Bits <br> High</th><th> Fault bits <br> low </th><th> Unused #1</th><th> Unused #2 </th>
		   
		    </tr>";

         while (($motor = fgetcsv($stream)) !== false) {
	
	        $dashboard = check_entry($motor, $dashboard);
		}
		fclose($stream);
		$arrlength = count($dashboard);
		for($x = 0; $x < $arrlength; $x++) {
			$y=0;
        		echo "<tr>";   
			foreach($dashboard[$x] as $value){
				if ( $y == 2) {
//					echo "<td> <b> " . $value . "</b></td>";
					$new_value=check_range($y, $value);
					echo $new_value;
					$y +=1;
				}

				elseif ( $y == 1) {
//                                      echo "<td> <b> " . $value . "</b></td>";
                                        $new_value=check_range($y, $value);
                                        echo $new_value;
                                        $y +=1;
                                }
				else {
					echo "<td>" . $value . "</td>";
					$y +=1;
				}
				
			}
           		echo "</tr>";
        	}
	
	echo "</table>";


	 $stream =  fopen("motor3.csv",  "r");
         $dashboard = array();
         echo  "<table>";
         echo "<caption> Motor data  String Format #2 </caption>";
         echo "<tr> <th> DC Command <br> (IdRef)</th><th> Quad Current <br>command (IqRef)</th><th> DC Feedback <br> (Id) </th> <th> Quad Feedback <br>  (Iq)</th>
                    <th> DC Voltage <br> (Vd)</th> <th>Quad Voltage <br> (Vq)</th> <th>DC Bus <br> Voltage (Vbus)</th> <th> DC Bus <br> Current (Ibus)</th><th> RPM</th>
                    <th> Unused #1</th><th> Unused #2 </th> <th> Unused #3 </th>
                   
                    </tr>";

         while (($motor = fgetcsv($stream)) !== false) {
        	$chart = array();
                $dashboard = check_entry($motor, $dashboard);
                }
                fclose($stream);
                $arrlength = count($dashboard);
                for($x = 0; $x < $arrlength; $x++) {
                        $y=0;
                        echo "<tr>";   
                        foreach($dashboard[$x] as $value){
                                if ( $y == 2) {
//                                      echo "<td> <b> " . $value . "</b></td>";
                                        $new_value=check_range($y, $value);
                                        echo $new_value;
                                        $y +=1;
                                }

                                elseif ( $y == 1) {
//                                      echo "<td> <b> " . $value . "</b></td>";
                                        $new_value=check_range($y, $value);
                                        echo $new_value;
                                        $y +=1;
                                }
                                else {
                                        echo "<td>" . $value . "</td>";
                                        $y +=1;
                                }
                          $chart = $chart + $dashboard[$x]; // adding variables to be plotted inthe chart.                              
                        }
                        echo "</tr>";
//			$chart = $chart + $dashboard[$x];
                }
        
        echo "</table>";

	 $stream =  fopen("motor4.csv",  "r");
         $dashboard = array();
//         echo "<form action=\"../echo.php\" method=\"POST\">";
	  echo "<form action=\"dashboard2.php\" method=\"POST\">";
	 echo  "<table>";
         echo "<caption>Motor data  String Format #3</caption>";
         echo "<tr> <th> Max Battery <br> Amps</th><th>Min Battery <br> Amps</th><th> Max Current <br> cmd</th> <th>Min Current <br> cmd</th>
                    <th> Max RPM</th> <th>Ramp rate</th> <th>Pole Pairs</th> <th> Speed Command</th><th> Stream Period</th>
                    <th> PWM Freq</th><th> Use Spread <br> Spectrum</th> <th> Motor Inertia</th><th> Resolver angle</th>
		    <th> Control Mode</th> <th>Magent D-axis <br> Flux</th><th>Current USB <br> cmd</th><th> Electrical revs/<br>Resolver Rev</th>
		    <th> D-axis Inductance</th><th>Q-axis inductance</th><th>Damping factor</th><th> #0</th>
		    <th>  #1</th><th>  #2</th><th>  #3</th><th>  #4</th><th>  #5</th><th>  #6</th>
		    <th>  #7</th><th>  #8</th><th>  #9</th><th>  #10</th><th>  #11</th>
                    <th>Min Analog <br> Pos</th><th>Max Analog <br> pos</th><th>Request <br> all</th>
                    </tr>";
	while (($motor = fgetcsv($stream)) !== false) {
        
                $dashboard = check_entry($motor, $dashboard);
                }
                fclose($stream);
//		$chart = array();
                $arrlength = count($dashboard);
                for($x = 0; $x < $arrlength; $x++) {
                        $y=0;
                        echo "<tr>";   
                        foreach($dashboard[$x] as $value){
                                if ( $y == 2) {
//                                      echo "<td> <b> " . $value . "</b></td>";
                                        $new_value=check_range($y, $value);
                                        echo $new_value;
                                        $y +=1;
                                }

                                elseif ( $y == 1) {
//                                      echo "<td> <b> " . $value . "</b></td>";
                                        $new_value=check_range($y, $value);
                                        echo $new_value;
                                        $y +=1;
                                }
                                else {
                                        echo "<td>" . $value . "</td>";
                                        $y +=1;
                                }
  //                              $chart = $chart + $dashboard[$x];
                        }
                        echo "</tr>";
			echo "<tr><td><input type=\"text\" name=\"AA\" id=\"AA\" value=\"\" > </td><td><input type=\"text\" name=\"AB\" id=\"AB\" value=\"\"</td><td><input type=\"text\" name=\"AC\" id=\"AC\" value=\"\"</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
			echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
			echo "<td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>0<td>0</td>";
			echo "<td>0</td><td>0</td><td></td><td></td><td></td></tr>";
                }
        
        echo "</table>";
	echo "<button name=\"submit\"  value=\"update\" class=\"green\">Update Values. (Only First 3 changeable).</button>";
	echo "</form>";
//	var_dump($chart);
	$pc = new C_PhpChartX(array($chart),'basic_chart');
	$pc->set_title(array('text'=>'Controller Output Chart of Stream #2 '));
	$pc->set_grid(array(
             'background'=>'lightyellow', 
             'borderWidth'=>0, 
             'borderColor'=>'#000000', 
             'shadow'=>true, 
             'shadowWidth'=>10, 
             'shadowOffset'=>3, 
             'shadowDepth'=>3, 
             'shadowColor'=>'rgba(230, 230, 230, 0.07)'
    ));
        $pc->draw();


}
?>



</html>
