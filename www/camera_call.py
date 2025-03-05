import OPi.GPIO as GPIO
import time
import subprocess
import atexit
import urllib2
import urllib
import cgi
import cgitb; cgitb.enable()
import os
from multiprocessing import Process

def camera_call():
    query_args = { 'RPI':'Active' }
    url = 'http://ddmdgm.iptime.org:81/cgi-bin/fwptzctr.cgi?FwModId=0&PortId=0&PtzCode=0x00000112&PtzParm=0x00000001&RcvData=NO&FwCgiVer=0x0001,;'
    data = urllib.urlencode(query_args)
    request = urllib2.Request(url, data)
    response = urllib2.urlopen(request).read()

def led_call():
    i = 1
    while (i <= 30):
        GPIO.output(led, True)
        time.sleep(0.5)
        GPIO.output(led, False)
        time.sleep(0.5)
        i += 1
def light_call():
    i = 1
    while (i <= 1):
        GPIO.output(light, True)
        time.sleep(30)
        GPIO.output(light, False)
        time.sleep(0.5)
        i += 1

def cctv_call():
    GPIO.output(cctv, True)
    time.sleep(1)
    GPIO.output(cctv, False)

input_pin = 18
led = 8
light = 9
cctv = 11
GPIO.setmode(GPIO.BCM)
GPIO.setup(input_pin, GPIO.IN)
GPIO.setup(led, GPIO.OUT)
GPIO.setup(light, GPIO.OUT)
GPIO.setup(cctv, GPIO.OUT)
GPIO.setwarnings(False)
while True:
    time.sleep(1)
    if not GPIO.input(input_pin):
        p1 = Process(target=camera_call)
        p1.start()
#        p2 = Process(target=led_call)
#        p2.start()
#        p3 = Process(target=light_call)
#        p3.start()
        p4 = Process(target=cctv_call)
        p4.start()
        p1.join()
#        p2.join()
#        p3.join()
        p4.join()
    continue
