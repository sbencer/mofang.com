{require name="common:statics/js/v6/login_top.js"}
{* 头部css *}
{literal}
<style>
.icon-red {position: absolute;right: 17px;top: 10px;width: 6px;height: 6px;background: url(../../statics/img/v6/red.png) no-repeat;background-size: 100% 100%;display: none;}
.header{position:relative;z-index:1000;height:50px;background:#333;min-width: 1280px;}
.header .nav .header-navl dl dt,.header .nav .header-navl dl dd{float:left;font-size:18px;margin-right:-30px;}
.header .nav .header-navl dl dt{width:96px;height:30px;padding:10px;padding-right:0px;margin-right:45px;}
.header .nav .header-navl dl a{color:#fff;margin-right:35px;float:left;line-height:50px;}
.header .nav .header-navl dl a:hover{color: #ff9900;}
.header .nav .header-navr .nav-contact{padding-top:15px;float:right;}
.header .nav .header-navr .nav-contact a{   color:#fff;display:inline-block;background: url(../../statics/img/v6/contact_icon.png) no-repeat;text-indent: -99999px;margin-left:26px;}
.header .nav .header-navr .nav-contact a.mobile-icon{width:22px;height:22px;background-position:0px 0px;}
.header .nav .header-navr .nav-contact a.rss-icon{width:20px;height:22px;background-position:-47px 0px;}
.header .nav .header-navr .nav-contact a.weibo-icon{width:24px;height:22px;background-position:-93px 0px;}
.header .nav .header-navr .nav-contact a.weixin-icon{width:24px;height:22px;background-position:-141px 0px;}

.header .nav .header-navr .nav-contact a.mobile-icon:hover{width:22px;height:22px;background-position:0px -22px;}
.header .nav .header-navr .nav-contact a.rss-icon:hover{width:20px;height:22px;background-position:-47px -22px;}
.header .nav .header-navr .nav-contact a.weibo-icon:hover{width:24px;height:22px;background-position:-93px -22px;}
.header .nav .header-navr .nav-contact a.weixin-icon:hover{width:24px;height:22px;background-position:-141px -22px;}

.header .nav .header-navr .nav-search{padding:9px 10px;float:right;background:#fff;margin:7px 30px 7px 0px;}
.header .nav .header-navr .nav-search .search-text{height:16px;width:144px;margin-right:10px;border:0px;float:left;}
.header .nav .header-navr .nav-search .search-sub{width:16px;height:16px;border:0px;cursor:pointer;background: url(../../statics/img/v6/search.png) no-repeat;}
.header .nav .header-navr .top-login{position:relative;float:right;padding-top:15px;margin-right:20px;margin-left:26px;color:#fff;width:24px;
}
.icon-money {display: inline-block;width: 18px;height: 18px;margin-right: 6px;margin-bottom: 2px;vertical-align: middle;background: url(../../statics/img/v6/money.png) no-repeat;background-size: 100% 100%;}
.header .nav .header-navr .top-login a{color:#fff;}
.header .nav .header-navr .top-login a.login-icon{color:#fff;display:inline-block;background: url(../../statics/img/v6/contact_icon.png) no-repeat;text-indent: -99999px;;
    width:20px;height:22px;background-position:-191px 0px;}
.header .nav .header-navr .top-login a.login-icon:hover{width:20px;height:22px;background-position:-191px -22px;}
.header .nav .top-login .login-end{
    display: none;
    position:relative;top:-2px;width:20px;height:20px;}
.header .nav .top-login .login-end img.avatar{width:24px;height:24px;border-radius: 50%;
}
.header .nav .top-login .login-end .icon-red{right:-2px;top:-9px;
}
.header .nav .top-login .user-info{display: none;position: absolute;top:50px;right:-20px;background: #333;padding:20px;width:240px;z-index:5;overflow: hidden;
}
.header .nav .top-login .user-info .zuji{margin-top:20px;
}
.header .nav .top-login .user-info .zuji a{position: relative;display: inline-block;margin-right: 10px;width:70px;height:30px;line-height: 30px;text-align:center;background: #444444;border-radius: 30px;
}
.header .nav .top-login .user-info .zuji a:hover{color:#ff9900;
}
.header .nav .top-login .user-info .zuji a.libao{margin-right:0px;
}
.header .nav .top-login .user-info .zuji .msg{position: relative;
}
.header .nav .top-login .user-info .zuji .icon-red{right:10px;top:7px;

}
.header .nav .top-login .user-info .info{border-top:1px solid #444444;padding-top:17px;margin-right:-2px;margin-top:18px;
}
.header .nav .top-login .user-info .info a{display: inline-block;width:80px;border-right:1px solid #444444;text-align:center;font-size:14px;color:#999;
}
.header .nav .top-login .user-info .info a:hover{color:#ff9900;
}
.header .nav .top-login .user-info .info a.out{border:0px;
}
.header .nav .header-navr .nav-contact div.weixin-bg{
  display: none;
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9998;
  display: none;
  background: rgba(0, 0, 0 ,0.6);
  z-index: 0;
}
 .weixin-box{
  position: absolute;
  width: 1280px;
  left: 50%;
  margin-left: -640px;
  z-index: 1000;
}
 .weixin-box .weixin-img{
  display: none;
  position: absolute;
  right: 0;
  margin-top: 15px;
  width: 242px;
  height: 265px;
  background:#fff url(../../statics/img/v6/weixin-img.jpg) no-repeat;
  text-align: center;
  background-size:100%;
  line-height:490px;
  font-style: normal;
  z-index: 1000;
}
</style>
{/literal}

<div class="header">
   
   <div class="nav clearfix width-1280">
   		<div class="header-navl l">
   			<dl>
   				<dt><a target="_blank" href="http://www.mofang.com"><img src="../../statics/img/v6/logo.png" alt="魔方网"></a></dt>
   				<dd>
   					<a target="_blank" href="http://www.mofang.com/news/">新闻</a> 
   					<a target="_blank" href="http://v.mofang.com/">视频</a> 
   					<a target="_blank" href="http://c.mofang.com/">产业</a> 
   					<a target="_blank" href="http://game.mofang.com/">游戏库</a> 
   					<a target="_blank" href="http://bbs.mofang.com/">论坛</a> 
   					<a target="_blank" href="http://fahao.mofang.com/">发号</a> 
   					<a target="_blank" href="http://v.mofang.com/tx/">腾讯游戏</a> 
   				</dd>
   			</dl>
   		</div>
   		<div class="header-navr r">
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
                <form action="/" target="_blank">
				    <input type="text" id="topSearch" name="keyword" class="search-text" placeholder="请输入搜索内容"/>
				    <input type="submit" id="topSubmit" class="search-sub" value="" />
                </form>
                {/block}
			</div>
   		</div>
   </div>
</div>