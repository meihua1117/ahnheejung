import OPi.GPIO as GPIO
import time
import subprocess
import atexit

def power_call():
    time.sleep(5)
    GPIO.output(pled, False)

pled = 14
input = 15

GPIO.setmode(GPIO.BCM)
GPIO.setup(input, GPIO.IN)
GPIO.setup(pled, GPIO.OUT)
GPIO.output(pled, True)
GPIO.setwarnings(False)

while True:
    time.sleep(2)
    if not GPIO.input(input):
        power_call()
    continue
