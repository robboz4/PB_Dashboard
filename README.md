# PB_Dashboard
 Sample code for PB motor test rig

dashboard.php is main display web page.

motor.csv is data file. This is updated via the following python script

motor_stream.py generates 20 new entries, one every 1 second.

RPM cell turn red if number exceeds 7000.

TEMP cell turns red if number exeeds 300


Set up on a Raspberyy Pi in the following directory structure:

/var/www/html/test/CSV

