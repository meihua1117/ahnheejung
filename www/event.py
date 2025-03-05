# -*- coding: utf-8 -*
# encoding=utf8

import OPi.GPIO as GPIO
import time
import os
import subprocess
import atexit
import commands
import threading
import os.path

input = 27
read_data = '0'

GPIO.setmode(GPIO.BCM)
GPIO.setup(input, GPIO.IN)
GPIO.setwarnings(False)

def cvlc_off():
    os.system('pkill -9 -f answer.py')
    time.sleep(1)
    os.system('mpg321 /home/chime.mp3')

def event_play():
    os.system('pkill -9 -f vlc')
    time.sleep(0.1)
    os.system("mpg321 /var/www/html/sound/1653128424-03_이_지역은_관리자외에_출입을_할_수_없습니다.mp3")

def cvlc_on(aa):
    os.system('python /home/answer.py')

while True:
    time.sleep(1)
    if not GPIO.input(input):
        cvlc_off()
        time.sleep(2)
        event_play()
    else:
        ss1 = os.popen('ps -ef | grep mpg*').read()
        if 'mpg321' in ss1:
            print ('incoming')
        else:
            ss2 = os.popen('ps -ef | grep python').read()
            if 'answer.py' in ss2:
                print ('===> answer run ')
            else:
                sun_run = threading.Thread(target=cvlc_on, args=(1,))
                sun_run.start()
