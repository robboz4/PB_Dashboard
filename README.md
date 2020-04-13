# PB_Dashboard
 Sample code for PB motor test rig

dashboard2.php is main display web page.

motor*.csv are data files. They are updated via the following python script

motor_stream2.py generates 100 new entries, one every 0.1 second.

The psuedo random data needs to be formated to more refect the actula value ranges. ( To Do!)

Set up on a Raspberyy Pi in the following directory structure:

/var/www/html/test/CSV

