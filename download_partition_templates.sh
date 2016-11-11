#!/bin/sh

rsync -zar --password-file=/etc/rsyncd.pwd  mofang@mofang.com::www/mofang.com/phpcms/templates/default/partition/* /var/www/mofang_v1/phpcms/templates/default/partition/ -v
rsync -zar --password-file=/etc/rsyncd.pwd  mofang@mofang.com::www/mofang.com/statics/css/mofang/partition/* /var/www/mofang_v1/statics/css/mofang/partition/ -v
rsync -zar --password-file=/etc/rsyncd.pwd  mofang@mofang.com::www/mofang.com/statics/js/mofang/partition/* /var/www/mofang_v1/statics/js/mofang/partition/ -v
rsync -zar --password-file=/etc/rsyncd.pwd  mofang@mofang.com::www/mofang.com/statics/images/mofang/partition/* /var/www/mofang_v1/statics/images/mofang/partition/ -v
