#!/bin/sh

chown -R www:www /data/www/www.spatialgate.com.tw
#rsync -zarv --no-p --password-file=/etc/rsyncd.pwdtw /data/www/www.spatialgate.com.tw/* mofangtw@210.61.12.172::www/www.spatialgate.com.tw --exclude=.* --exclude=*.mofang.com --exclude=caches/* --exclude=html/* --exclude=event/ --exclude=wmgc/ --exclude=about/ --exclude=git.tar.gz --exclude=uploadfile/* --exclude=sql/ --exclude=phpsso_server/ --exclude=/index.html --exclude=*.sh --exclude=*.gz --exclude=phpcms/init/v3/templates_c/* --exclude=phpcms/init/v4/templates_c/* --exclude=phpcms/templates/v3/* --exclude=phpcms/templates/default/partition/* --exclude=statics/*/mofang/partition/ --exclude=phpcms/languages/zh-cn/system_menu.lang.php --exclude=receiver.php
rsync -zarv --no-p --password-file=/etc/rsyncd.pwdtw /data/www/www.spatialgate.com.tw/* mofangtw@210.61.12.172::www/www.spatialgate.com.tw --exclude=.*
