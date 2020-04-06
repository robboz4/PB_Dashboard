#Data Generator  for motor dashboard

# Dave Robinson 4/4/20

import time
import datetime


# generate random integer values
from random import seed
from random import randint
# seed random number generator
seed(1)
# generate some integers

i = 0
while  i < 10:
	
	for _ in range(10):
        	value = randint(0, 10)
#        	print(value)
	if value != 0:	
		x = datetime.datetime.now()
		rev = value * 1000
		temp = value * 32 + x.minute
		msn = value 
		entry = "PBM00-" + str(msn) + "," + str(rev) + "," + str(temp) + "," + str(x) + "\n"

		file_object = open('motor.csv', 'a')
		file_object.write(entry)
		file_object.close()
	time.sleep(10)
	i += 1


