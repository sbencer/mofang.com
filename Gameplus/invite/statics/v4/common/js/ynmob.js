
var browser={  
versions:function(){          
var u = navigator.userAgent, app = navigator.appVersion;          
return {              
trident: u.indexOf('Trident') > -1, //IE内核              
presto: u.indexOf('Presto') > -1, //opera内核              
webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核              
gecko: u.indexOf('Gecko') > -1 && u.indexOf('Firefox') == -1, //火狐内核
mobile: !!u.match(/Windows Phone/) || !!u.match(/Android/) || !!u.match(/MQQBrowser/),
ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || !!u.match(/AppleWebKit.*Mobile/), //ios终端              
android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器              
iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器              
iPad: u.indexOf('iPad') > -1, //是否iPad              
webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部

};
}()
}

if(browser.versions.mobile==true || browser.versions.android==true) {
    location = "http://www.mofang.com.tw/Gameplus/activity/mobile/";
}
else if(browser.versions.iPhone==true || browser.versions.iPad==true || browser.versions.ios==true) {
    location = "http://www.mofang.com.tw/Gameplus/activity/mobile/indexios.php";
}



