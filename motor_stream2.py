#Data Generator  for motor dashboard2

# Dave Robinson 4/10/20
# Tweaked random number generator. Still crude
# but enough to make  the limits trigger on the dashboard.
# Also added a loop of 20 and reduced timing to 1 second.
import time
import datetime


# generate random integer values
from random import seed
from random import randint
# seed random number generator
seed(1)
# generate some integers

i = 0
while  i < 1000:
	
	for _ in range(10):
        	value = randint(0, 10)
#        	print(value)
	if value != 0:	
		x = datetime.datetime.now()
		for _ in range(10):
                	rev_value = randint(0, 10)
		rev = 10000 - (rev_value * 30 * x.second)
		if  rev < 0 :	
			rev= rev * -1 
		for _ in range(10):
                	temp_value = randint(0, 10)
			temp = temp_value * 32 + x.minute
		msn = value 
		entry0 =  str(temp) + "," + str(temp) + "," + str(temp) + "," + str(temp) + "," + str(msn) + "," + str(msn) + "," + str(msn) +  "," 
		entry1 =  str(temp) + "," + str(temp) + "," + str(temp) + "," + str(temp) + "," + str(msn) + "," + str(msn) + "," + str(msn) + "," 
		entry2 =  str(rev)  + "," + str(rev)  + "," + str(rev)  + "," + str(temp) + "," + "0 "      + "," + "0 " + "\n" 
		entry3 =  str(rev)  + "," + str(rev)  + ",0" + ",0"       + ",0" + "\n" 
		entry4 =  str(rev)  + "," + str(rev)  + "," + str(rev)  + "," + str(temp) + "," + str(rev)  + "," + str(temp)+  "," 
		entry5 =  ",0,0,0,0,0,0,0,0,0,0,0,0"
		entry = entry0 + entry1 + entry2
#		print(entry)
		file_object = open('motor2.csv', 'w')
		file_object.write(entry)
		file_object.close()
		entry = entry0 + entry3
		file_object = open('motor3.csv', 'w')
                file_object.write(entry)
                file_object.close()
#		entry = entry0 + entry0  + entry4 + entry5 + str(rev)  + "," + str(rev)  + "," + str(msn) + "\n"  
#		file_object = open('motor4.csv', 'w')
#                file_object.write(entry)
#                file_object.close()


	time.sleep(.1)
	i += 1


