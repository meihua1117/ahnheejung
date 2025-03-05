import OPi.GPIO as GPIO  
import time  
import os  
import subprocess
import atexit
import socket

from time import sleep
 
'''def set_Default():
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    s.connect(('192.168.0.1', 80))
    ipAddress = s.getsockname()[0]
    print (s.getsockname()[0])
'''
def read_network():
    f = open('/var/www/html/network.txt', 'r')
    s = f.read()
    print (s)

def write_network():
    f = open('/var/www/html/network.txt', 'w')
    f.write('192.168.0.200,255.255.255.0,192.168.0.1')
    f.close()

def read_net():
    f = open('/etc/network/interfaces', 'r')
    s = f.read()
    print (s)

input = 15

GPIO.setmode(GPIO.BCM)
GPIO.setup(input, GPIO.IN)

while (True):
    sleep(3)
    if not GPIO.input(input):
        print ('Set IP Address Default')
        read_network()
        write_network()
        read_net()
    continue
