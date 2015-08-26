#!/bin/bash

timestamp=$(date +%s)

/home/pi/dropbox_uploader.sh -f ~/.dropbox_uploader  upload /var/www/pic.jpg ${timestamp}.jpg
