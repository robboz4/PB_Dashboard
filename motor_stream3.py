#Data Generator  for scripted.html

# Dave Robinson 4/28/20
# Tweaked random number generator. Still crude
# Also added a loop of 1000 and reduced timing to 1 second.
# Writes out a csv  file that the scripted2.html page can read.
import time
import datetime
import csv

# generate random integer values
from random import seed
from random import randint
# seed random number generator
seed(1)
# CSV file format
rows = [ '+00056','-00056','+00100','+00100','+00134','-00134','-00135','-03012','-00123',
           '+00345','-01234','+01234','+01234','-02200','+01600','+01234','+65535','+00001','+00000','+000000']

# print(len(rows))




i = 0
while  i < 1000:
	
	for _ in range(10):
        	value = randint(0, 10)
#        	print(value)
	if value != 0:	
		x = datetime.datetime.now()
		for _ in range(10):
                	rev_value = randint(0, 10)
		rev = 20000 - (rev_value * value * x.second)
		if  rev < 0 :	
			rev= rev * -1 
		for _ in range(10):
                	temp_value = randint(0, 10)
			temp = temp_value * 32 + x.minute
		msn = value 

#		with open('motor2.csv') as csvfile:
#    			readCSV = csv.reader(csvfile, delimiter=',')
#    			for row in readCSV:
#        			print(row[14])
#	add  extra randown updates to te csv values here  row[x] = random number.
		rows[14] = rev
		f_name =  "motor2.csv"
		with open(f_name, 'w') as csvfile:
			csvwriter = csv.writer(csvfile)
			csvwriter.writerow(rows)
	time.sleep(.1)
	i += 1




