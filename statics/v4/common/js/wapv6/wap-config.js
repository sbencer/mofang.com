seajs.config({
    "alias": {
        "check_login": "/statics/v4/common/js/v6/check_login.js",
        "mf_face":"/statics/v4/common/js/v6/mf_face.js",
        "comment":"/statics/v4/common/js/v6/comment.js",
        "v6_vote":"/statics/v4/common/js/v6/vote.js",
        "bg_ads":"/statics/v4/common/js/v6/bg_ads.js"
    }
});
/*此配置和v6(base-config.js)同步*/
window.mfconfig = {
    "userInfoUrl":"http://u.mofang.com",
    "mofangUrl":"http://m.mofang.com",
    "bbsUrl":"http://bbs.mofang.com",
    "gameUrl":"http://game.m.mofang.com",
    "commentUrl":"http://comment.mofang.com"
};
window.mfshare = function (to, title, pic) {
    var url = location.href;
    var shareurl = '';
    switch (to) {
        case 'weibo':
            shareurl = 'http://service.weibo.com/share/share.php?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&appkey=910834796';
            if (pic) { shareurl += '&pic=' + pic; }
            break;
        case 'qzone':
            shareurl = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&desc=&summary=&site=mofang.com';
            break;
        case 'tqq':
            shareurl = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&appkey=a5943ca73ed8d2bfe0e6accc364c1291&site=mofang.com';
            break;
        case 'baidu':
            shareurl = 'http://cang.baidu.com/do/add?iu='+encodeURIComponent(url)+'&it='+encodeURIComponent(title)+'&linkid='+(+new Date).toString(36)+'mfS';
            break;
        default:
            return false;
            break;
    }
    window.open(shareurl,'_blank','width=200,height=120');
};