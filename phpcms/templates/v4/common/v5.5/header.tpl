{require name="common:statics/js/v5.5/login_top.js"}
{* 头部css *}
{literal}
<style>
.header{position: relative;width: 100%; min-width: 1000px; height: 110px; background: url(/statics/v4/common/img/v5.5/header_bg.jpg) left top repeat-x; }
.nav{ width: 1000px; height: 60px; margin: 0 auto;}
.nav-logo{display:inline-block;width: 112px; height: 36px; padding-top: 12px;}
.nav-logo{width: 112px; height: 36px;}
.nav nav{position: absolute; left: 0px; bottom: -36px; font-size: 18px;}
.nav nav a{padding: 12px; margin-right: 12px;}
.nav nav a:hover{font-weight: bold; text-decoration: none;}
.nav-contact{padding-top:18px;float:right;}
.nav-contact a{color:#fff;display:inline-block;background: url(/statics/v4/common/img/v5.5/contact_icon.png) no-repeat;text-indent: -99999px;margin-left:26px; }
.nav-contact a.mobile-icon{width:14px;height:24px;background-position:0px 0px;}
.nav-contact a.rss-icon{width:24px;height:24px;background-position:-35px 0px;}
.nav-contact a.weibo-icon{width:31px;height:25px;background-position:-77px 0px;}
.nav-contact a.weixin-icon{width:31px;height:25px;background-position:-129px 0px;}

.nav-contact a.mobile-icon:hover{width:14px;height:24px;background-position:0px -25px;}
.nav-contact a.rss-icon:hover{width:24px;height:24px;background-position:-35px -25px;}
.nav-contact a.weibo-icon:hover{width:31px;height:25px;background-position:-77px -25px;}
.nav-contact a.weixin-icon:hover{width:31px;height:25px;background-position:-129px -25px;}
.header .nav{position: relative;}
.header .nav .user-info{display: none;position: absolute;top:50px;right:-20px;background: #333;padding:20px;width:240px;z-index:5;overflow: hidden;
}
.header .nav .user-info .zuji{margin-top:20px;
}
.header .nav .user-info .zuji a{position: relative;display: inline-block;margin-right: 10px;width:70px;height:30px;line-height: 30px;text-align:center;background: #444444;border-radius: 30px;
}
.header .nav .user-info .zuji a:hover{color:#ff9900;}
.header .nav .user-info .zuji a.libao{margin-right:0px;}
.header .nav .user-info .zuji .msg{position: relative;}
.header .nav .user-info .zuji .icon-red{right:10px;top:7px;}
.header .nav .user-info .info{border-top:1px solid #444444;padding-top:17px;margin-right:-2px;margin-top:18px;}
.header .nav .user-info .info a{display: inline-block;width:80px;border-right:1px solid #444444;text-align:center;font-size:14px;color:#999;}
.header .nav .user-info .info a:hover{color:#ff9900;}
.header .nav .user-info .info a.out{border:0px;}
.nav-search{float:right;background:#fff;height: 30px;margin:15px 23px 15px 0px;-webkit-border-radius: 15px;-moz-border-radius: 15px;-ms-border-radius: 15px;-o-border-radius: 15px;border-radius: 15px;}
.nav-search:hover{border: 1px solid #ff9200;margin:14px 22px 15px 0px;}
.nav-search .search-text{padding:5px 10px;height:20px;width:195px;margin-right:10px;border:0px;float:left;font-size:15px;-webkit-border-radius: 15px;-moz-border-radius: 15px;-ms-border-radius: 15px;-o-border-radius: 15px;border-radius: 15px;}
.nav-search .search-sub{width:35px;height:30px;border:0px;cursor:pointer;background: url(/statics/v4/common/img/v5.5/search_btn.png) no-repeat;}
.top-login{position:relative;float:right;padding-top:18px;margin-right:20px;margin-left:26px;color:#fff;width:24px;}
.icon-money {display: inline-block;width: 18px;height: 18px;margin-right: 6px;margin-bottom: 2px;vertical-align: middle;background: url(/statics/v4/common/img/v5.5/money.png) no-repeat;background-size: 100% 100%;}
.top-login a{color:#fff;}
.top-login a.login-icon{color:#fff;display:inline-block;background: url(/statics/v4/common/img/v5.5/contact_icon.png) no-repeat;text-indent: -99999px;;
    width:20px;height:24px;background-position:-180px 0px;}
.top-login a.login-icon:hover{width:20px;height:22px;background-position:-180px -24px;}
.header .nav .login-end{display: none;position:relative;top:-2px;width:26px;height:26px;}
.header .nav .login-end img.avatar{width:26px;height:26px;border-radius: 50%; border: 1px solid #ff9200;}
.header .nav .login-end .icon-red{right:-2px;top:-9px;}
.nav-contact div.weixin-bg{display: none;position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 9998; display: none; background: rgba(0, 0, 0 ,0.6); z-index: 1000; }
 .weixin-box{ position: absolute; width: 1280px; left: 50%; margin-left: -640px; z-index: 1000; }
 .weixin-box .weixin-img{ display: none; position: absolute; right: 0; margin-top: 15px; width: 242px; height: 265px; background:#fff url(/statics/v4/common/img/v5.5/weixin-img.jpg) no-repeat; text-align: center; background-size:100%; line-height:490px; font-style: normal; z-index: 1000; }
.header-map{position: absolute; right: 25px; bottom: -33px; display: block; width: 18px; height: 18px; background: url(/statics/v4/common/img/v5.5/map.png) no-repeat;background-position: 0px 0px;}
.header-map:hover{ background-position: 0px -18px;}
</style>


{/literal}

<div class="header">
    <div class="nav">
        <a href="http://www.mofang.com" target="_blank" class="nav-logo"><img src="/statics/v4/common/img/v5.5/logo.png" alt="魔方网"></a>
        <nav>
            <a href="http://v.mofang.com/" target="_blank">视频</a>
            <a href="http://www.mofang.com/news/" target="_blank">新闻</a>
            <a href="http://game.mofang.com/" target="_blank">游戏</a>
            <a href="http://c.mofang.com/" target="_blank">产业</a>
            <a href="http://bbs.mofang.com/" target="_blank">论坛</a>
            <a href="http://fahao.mofang.com/" target="_blank">发号</a>
            <a href="http://v.mofang.com/tx/" target="_blank">腾讯游戏</a>
            <a href="http://tu.mofang.com/" target="_blank">图片</a>
            <a href="http://www.mofang.com/pandian/" target="_blank">盘点</a>
            <a href="http://www.mofang.com/wenda/" target="_blank">问答</a>
        </nav>
        <div class="top-login" id="topUserInfo">
           <a class="login-icon" id="login" href="javascript:;">登录</a>
           <a class="login-end" href="http://u.mofang.com/home/person/main" target="_blank"><img class="avatar" id="userImg" src="" /><s class="icon-red"></s></a>
            <div class="user-info">
            <ul class="clearfix">
                <li class="header-money" id="userMoney">    <s class="icon-money"></s>
                </li>
                <li class="zuji">
                    <a href="http://u.mofang.com/home/footprints/games" target="_blank" class="zj">足迹<s class="icon-red"></s></a>
                    <a href="http://u.mofang.com/home/message/reply"  target="_blank"class="msg">消息<s class="icon-red"></s></a>
                    <a href="http://u.mofang.com/home/package/index"  target="_blank" class="libao">礼包库<s class="icon-red"></s></a>
                </li>
                <li class="info">
                   <a href="http://u.mofang.com/home/person/index" target="_blank">个人信息</a><a href="http://u.mofang.com/home/setting/info" target="_blank">设置</a><a href="javascript:;" class="out" id="logout">退出</a> 
                </li>
            </ul>
            </div>
        </div>
        <div class="nav-contact">
            <a class="mobile-icon" target="_blank" href="http://app.mofang.com/">手机</a>
            <a class="rss-icon" target="_blank" href="http://www.mofang.com/rss/">rss</a>
            <a class="weibo-icon" href="http://weibo.com/3228285935/" target="_blank">weibo</a>
            <a class="weixin-icon" href="javascript:;" target="_blank">weixin</a>
            <div class="weixin-bg">
                
            </div>  
            <div class="weixin-box"><em class="weixin-img">扫码关注魔方陪你玩</em></div>
        </div>

        <div class="nav-search">
              {block name=search}
              <form action="http://www.mofang.com/tag/*.html" id="search" target="_blank">
                <input type="text" id="topSearch" value="{$smarty.get.q}" class="search-text" placeholder="请输入关键字" value="CF手游"/>
                <input type="submit" id="topSubmit" class="search-sub" value="" />
              </form>
              {/block}
        </div>
        
        <a href="http://www.mofang.com/sitemap.html" target="_blank" class="header-map" title="站点地图" alt="站点地图"></a>
    </div>
</div>
