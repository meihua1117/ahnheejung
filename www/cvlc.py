import os
import time
import vlc

if __name__ == '__main__':

    if os.path.isfile('/var/www/html/dv.txt'):
        f = open('/var/www/html/dv.txt', mode='rt')
        read_data = f.readline()
        f.close()
        os.system("amixer -c0 set 'Lineout volume control' " + read_data + "%")

    instance = vlc.Instance()
    player = instance.media_player_new()
    player.set_mrl("http://192.168.0.10:8080")
    player.play()

    value = player.is_playing()
    print('=== Play Value : ' + str(value))
    time.sleep(1)

    while True:

        value = player.is_playing()
        if value == 0:
            print('=== Play Value : ' + str(value))

            os.system("amixer -c0 set 'Lineout volume control' 0%")

            instance = vlc.Instance()
            player = instance.media_player_new()
            player.set_mrl("http://192.168.0.10:8080")
            player.play()

            time.sleep(1)

            if os.path.isfile('/var/www/html/dv.txt'):
                f = open('/var/www/html/dv.txt', mode='rt')
                read_data = f.readline()
                f.close()

                os.system("amixer -c0 set 'Lineout volume control' " + read_data + "%")

            value = player.is_playing()
            print('=== Play Value : ' + str(value))

        time.sleep(0.1)
