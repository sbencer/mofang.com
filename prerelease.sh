#!/bin/sh

rsync -zar --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/* mofang@mofang.com::www/ --exclude=.* --exclude=*.mofang.com --exclude=caches/* --exclude=html/* --exclude=wmgc/ --exclude=about/ --exclude=uploadfile/* --exclude=sql/ --exclude=phpsso_server/ --exclude=index.html --exclude=*.sh -v -n
