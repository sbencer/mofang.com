#!/bin/sh
rsync -zar --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/html/special/* mofang@mofang.com::www/mofang.com/html/special/
