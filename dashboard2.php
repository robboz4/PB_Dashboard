<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
td.hot{
 color:red;
</style>

<meta http-equiv="refresh" content="1">

</head>
<body>
<h1 align=\"center\"> Mock up dashboard  for monitoring motors under test. (A.3.0)</h1>

These tables SIMPLY repesent  three data stream formats from a  controller/motor under test.

Press the "Start demo run" button  to start a simluate run. It will run a program  to  update the  tables with random data <br>
Numbers are simply generated via python random code generator. They will be fugded to more accurately resemble the data.<br>
The page  will refresh every 1 second after that.<br>
Some numbers may show up red. This will be numbers that have limits that are not to  be exceed. Currently it is not set up for these tables correctly.
Its a work in progress. <br>


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
*/

function   check_entry($motor, $dashboard)
/*
function to check if serial number is already reporting.

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


          $cmd= "/usr/bin/python /var/www/html/test/CSV/motor_stream2.py";
          shell_exec("/usr/bin/nohup " . $cmd . ">/dev/null 2>&1 &"); 
//Asynchronously runs command. No waiting...
	}

else {
         $stream =  fopen("motor2.csv",  "r");
	 $dashboard = array();
         echo  "<table>";
         echo "<caption>Motor data String format # 1</caption>";
         echo "<tr> <th> Motor Temp #1 </th><th> Motor Temp #2</th><th> Ctrl Temp #1 </th> <th> Ctrl Temp #2</th>
		    <th> Slow charge current</th> <th>Fast charger current</th> <th>DC current </th> <th> Quad current</th><th> DC feedback</th>
		    <th>Quad current feedback</th><th> DC Volts</th><th>Quad Volts</th><th>DC Bus voltage </th><th> DC Bus Current </th>
		    <th>RPM</th><th>Resolver Positon</th><th>Fault Bits High</th><th> Fault bits low </th><th> Unused #1</th><th> Unused #2 </th>
		   
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
         echo "<caption>Motor data  String Format #2</caption>";
         echo "<tr> <th> DC Command (IdRef)</th><th> Quad Current command (IqRef)</th><th> DC Feedback (Id)</th> <th> Quad Feedback (Iq)</th>
                    <th> DC Voltage (Vd)</th> <th>Quad Voltage (Vq)</th> <th>DC Bus Voltage (Vbus)</th> <th> DC Bus Current (Ibus)</th><th> RPM</th>
                    <th> Unused #1</th><th> Unused #2 </th> <th> Unused #3 </th>
                   
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
                                
                        }
                        echo "</tr>";
                }
        
        echo "</table>";

	 $stream =  fopen("motor4.csv",  "r");
         $dashboard = array();
         echo  "<table>";
         echo "<caption>Motor data  String Format #3</caption>";
         echo "<tr> <th> Max Battery Amps</th><th>Min Battery Amps</th><th> Max Current cmd</th> <th>Min Current cmd</th>
                    <th> Max RPM</th> <th>Ramp rate</th> <th>Pole Pairs</th> <th> Speed Command</th><th> Stream Period</th>
                    <th> PWM Freq</th><th> Use Spread Spectrum</th> <th> Motor Inertia</th><th> Resolver angle</th>
		    <th> Control Mode</th> <th>Magent D-axis Flux</th><th>Current USB cmd</th><th> Electrical revs/<br>Resolver Rev</th>
		    <th> D-axis Inductance</th><th>Q-axis inductance</th><th>Damping factor</th><th>Unused #0</th>
		    <th> Unused #1</th><th> Unused #2</th><th> Unused #3</th><th> Unused #4</th><th> Unused #5</th><th> Unused #6</th>
		    <th> Unused #7</th><th> Unused #8</th><th> Unused #9</th><th> Unused #10</th><th> Unused #11</th>
                    <th>Min Analog Pos</th><th>Max Anlog pos</th><th>Request all</th>
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
                                
                        }
                        echo "</tr>";
                }
        
        echo "</table>";



}

?>


</html>
