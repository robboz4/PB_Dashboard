# PB_Dashboard
 Sample code for PB motor test rig

dashboard2.php is main display web page.

motor*.csv are data files. They are updated via the following python script

motor_stream2.py generates 100 new entries, one every 0.1 second.

The psuedo random data needs to be formated to more refect the actual value ranges. ( To Do!)
Table 3 allows you to modify the first three parameter and simulates sending that out to the controller  (file motor4.csv). 

There is a test of phpchartlite  (https://phpchart.com) to draw a graph of the incoming data stream. It would need more work plus upgrading  to the full version to make a descent dashboard of the incoming stream.


Project is moving to node.js so no further upates to this php demo or POC.

Set up on a Raspberry Pi in the following directory structure:

/var/www/html/test/CSV

