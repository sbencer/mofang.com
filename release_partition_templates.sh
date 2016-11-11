#!/bin/sh

rsync -zar --no-t --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/phpcms/templates/default/partition/* mofang@mofang.com::www/mofang.com/phpcms/templates/default/partition/ -v
rsync -zar --no-t --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/statics/css/mofang/partition/* mofang@mofang.com::www/mofang.com/statics/css/mofang/partition/ -v
rsync -zar --no-t --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/statics/js/mofang/partition/* mofang@mofang.com::www/mofang.com/statics/js/mofang/partition/ -v
rsync -zar --no-t --password-file=/etc/rsyncd.pwd /var/www/mofang_v1/statics/images/mofang/partition/* mofang@mofang.com::www/mofang.com/statics/images/mofang/partition/ -v
