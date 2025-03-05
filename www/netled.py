import OPi.GPIO as GPIO
import urllib2
import time
import subprocess
netled = 17
GPIO.setmode(GPIO.BCM)
GPIO.setup(netled, GPIO.OUT)
GPIO.setwarnings(False)
def internet_on():
    try:
        response=urllib2.urlopen('http://192.168.0.100')
        return True
    except urllib2.URLError as err: pass
    return False
while 1:
    time.sleep(2)
    if internet_on() == 1:
            GPIO.output(netled, True)
            time.sleep(0.2)
            GPIO.output(netled, False)
    else:
        while True:
            GPIO.output(netled, False)
    time.sleep(1)
    pass
try:
    main()
except KeyboardInterrupt:
    GPIO.Cleanup()
