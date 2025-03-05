#!/usr/bin/env python
#-*- coding: utf-8 -*-
import os

#os.system('mpg321 -B /var/www/html/sound/bgm')

os.system('cvlc /var/www/html/sound/bgm/*.mp3 --loop')
