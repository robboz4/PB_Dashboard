#Data Generator  for motor dashboard

# Dave Robinson 4/4/20
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
while  i < 20:
	
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
		entry = "PBM00-" + str(msn) + "," + str(rev) + "," + str(temp) + "," + str(x) + "\n"
#		print(entry)
		file_object = open('motor.csv', 'a')
		file_object.write(entry)
		file_object.close()
	time.sleep(1)
	i += 1


