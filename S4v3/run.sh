#!/bin/bash

mkdir uploads && mv flag.txt flag-$(cat /proc/sys/kernel/random/uuid).txt
exec gunicorn -b  127.0.0.1:5000 -w 4 app:app

