seajs.config({
    "alias": {
        "mf/login": "/statics/v4/common/js/login.js",
        "login/check": "/statics/v4/common/js/login_check.js",
        "wechat": "/statics/v4/common/js/wechat.js",
        "transform": "/statics/v4/common/js/transform.js",
        "language": "/statics/v4/common/js/language.js",
        "tpl": "/statics/v4/common/js/tpl.js", //login tpl
        "p/popup": "/statics/v4/common/js/p/popup.js", // 专区弹出层
        "ie/low": "/statics/v4/common/js/ie/low.js", // 低版本ie提示
        "jobs": "/statics/v4/common/js/jobs.js",
        "wap/login": "/statics/v4/common/js/wap_login.js",
        "mfe/ad":"/statics/v4/common/js/ad.js",
        "check_login": "/statics/v4/common/js/v6/check_login.js",//v6检查登录
        "mf_face":"/statics/v4/common/js/v6/mf_face.js",//v6表情包
        "comment":"/statics/v4/common/js/v6/comment.js",//v6版评论
        "login/wapcheck": "/statics/v4/common/js/wap_login_check.js"
    }
});
/*域名配置全局变量*/
window.mfconfig = {
    "userInfoUrl":"http://u.mofang.com",
    "mofangUrl":"http://www.mofang.com",
    "bbsUrl":"http://bbs.mofang.com",
    "gameUrl":"http://game.mofang.com",
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
    window.open(shareurl,'_blank','width=600,height=400');
};
