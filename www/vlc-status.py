import time
import subprocess
import atexit
import os
import commands
import threading
import os.path

def answer():
    os.system('pkill -9 -f vlc')
    time.sleep(0.1)
    os.system('mpg321 /home/chime.mp3')
    time.sleep(0.1)
    os.system('pkill -9 -f cvlc.py')
    time.sleep(0.1)
    os.system('pkill -9 -f mpg321')
    time.sleep(1)
    os.system('linphonecsh generic answer')
    
def vlcon(aa):

    ss3 = os.popen("ps -ef | grep mpg*").read()
    if 'mpg321' in ss3:
        os.system('pkill -9 -f vlc')
        time.sleep(0.3)
        os.system('pkill -9 -f cvlc.py')
        time.sleep(0.3)
        os.system('pkill -9 -f mpg321')
    else:
        os.system('python /var/www/html/cvlc.py')

def emg():
    time.sleep(0.1)
    os.system('pkill -9 -f vlc')
    time.sleep(0.1)
    os.system('pkill -9 -f cvlc.py')
    time.sleep(0.1)
    os.system('pkill -9 -f mpg321')
    time.sleep(0.1)
               
while True:

    batcmd = 'vlc -vvv status'
    result = commands.getoutput(batcmd)
    
    print (result)
    time.sleep(1)

#    if 'hook=answered' in result:
    if 'Incoming call' in result:
#        time.sleep(1)
        answer()

    time.sleep(0.1)

    if 'hook=offhook' in result:
         if os.path.isfile('/var/www/html/bgm_setup.txt'):
             f = open('/var/www/html/bgm_setup.txt', mode='rt')
             read_data = str(f.readline())
             f.close()

         time.sleep(0.1)
    
         if int(read_data) == 1:
            ss1 = os.popen("ps -ef | grep cvl*").read()
            if 'sh -c cvlc' in ss1:
                #print ("incoming")
                pass
            else:
                sun_run = threading.Thread(target=vlcon, args=(1,))
                sun_run.start()

    time.sleep(0.1)

    if 'hook=ringing' in result:
        emg()

    time.sleep(0.1)
