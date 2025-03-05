import schedule
import time
import os

#def job():
#    print("I'm working...")

def mpg1():
    os.system('mpg321 /home/sound/1622901671-AEPEL.mp3')
def mpg2():
    os.system('mpg321 /home/sound/1623430348-Door-Close.mp3')
def mpg3():
    os.system('mpg321 /home/sound/1623430475-warning-area.mp3')
def mpg19():
    os.system('mpg321 /home/sound/1622774354-FredAudio.mp3')
def mpg50():
    os.system('mpg321 /home/sound/1622880354-Learn_English_in_30_Minutes_-_ALL_the_English_Basics_You_Need-Vubey.mp3')
def mpg4():
    os.system('mpg321 /home/sound/1623430514-study-start.mp3')
def mpg5():
    os.system('mpg321 /home/sound/1623430542-study-end.mp3')
def mpg6():
    os.system('mpg321 /home/sound/1623430611-08_좋은_아침입니다__오늘도_좋은_하루_보내세요.mp3')
def mpg7():
    os.system('mpg321 /home/sound/1622901978-Siren.mp3')
def mpg8():
    os.system('mpg321 /home/sound/1623223436-tis.mp3')
def mpg10():
    os.system('mpg321 /home/sound/1623591668-차임벨.mp3')
def mpg11():
    os.system('mpg321 /home/sound/1623222505-smokie.mp3')
def mpgBGM():
    os.system('mpg321 /home/sound/1623645448-em-call.mp3')
def mpg34():
    os.system('mpg321 /home/sound/1623812569-study_start.mp3')


while True:
    schedule.run_pending()
    time.sleep(1)
