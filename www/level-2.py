import matplotlib
matplotlib.use('Agg')
import pyaudio
import numpy as np
import pylab
import time

RATE = 44100 #44100
#CHUNK = 1024
CHUNK = int(RATE/20) # RATE / number of updates per second

def soundplot(streama):
#def soundplot(stream, data):
    t1=time.time()
    #data = np.fromstring(stream.read(CHUNK),dtype=np.int16)
    pylab.plot(data)
    pylab.title(i)
    pylab.grid()
    pylab.axis([0,len(data),-2**16/2,2**16/2])
    #pylab.axis([0,len(data),-2**16/2,2**16/2])
    pylab.savefig("/var/www/html/img/03.png",dpi=50)
    pylab.close('all')
    print("took %.02f ms"%((time.time()-t1)*1000))

if __name__=="__main__":
    p=pyaudio.PyAudio()
    stream=p.open(format=pyaudio.paInt16,channels=1,rate=RATE,input=True,frames_per_buffer=CHUNK)
     
    #while(True):
        #data = np.fromstring(stream.read(CHUNK),dtype=np.int16)
    for i in range(int(20*RATE/CHUNK)):
    #for i in range(int(20*RATE/CHUNK)): #do this for 10 seconds
        data = np.fromstring(stream.read(CHUNK, exception_on_overflow = False),dtype=np.int16)
        soundplot(stream)
        #print (int(np.average(np.abs(data))))
          
     
    stream.stop_stream()
    stream.close()
    p.terminate()
