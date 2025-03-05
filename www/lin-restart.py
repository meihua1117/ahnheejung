import subprocess
import atexit

def my_cleanup(name):
    print 'my_cleanup(%s)' % name

def unregister():
    subprocess.call(["linphonecsh", "unregister"])

atexit.register(unregister)
#atexit.register(my_cleanup, 'second')
#atexit.register(my_cleanup, 'third')
