<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 為QQ提供的遊戲視頻接口，需對方傳遞包名
  * 業務邏輯：根據傳遞的包名，請求李偉接口，獲取老遊戲對應ID，使用此ID，去查詢欄目下關聯此遊戲的視頻，並進行返回!
  * http://game.mofang.com/api/web/GetGameOldIdsByPackages?type=0&packages=com.fotoable.gam
  *參數type: 0=url scheme(ios)       1=package(android)
  *參數packages:包名或者url scheme
  */
$test = $_GET['test'] ? $_GET['test'] : 0;
$type_array = array(0,1);
$type = intval($_GET['type']) ? intval($_GET['type']):1;
$package_name = $_GET['packages'];
$videoBack = $_GET['videoBack'];
$is_mobile = $_GET['is_mobile'] ? intval($_GET['is_mobile']) : 0 ;

//定義寬高
$width = $_GET['width'] ? $_GET['width'] : 840 ;
$height = $_GET['height'] ? $_GET['height'] : 550;

$err_info = array();
if(empty($package_name)|| !in_array($type, $type_array)){
	$err_info['code'] = -1;
	$err_info['msg'] = '輸入參數異常!';
	$return = json_encode($err_info);
	if($videoBack){
		echo $videoBack."($return)";
	}else{
		echo $return;
	}
	exit();
}


//請求李偉接口獲取對應老產品庫遊戲ID ，先走CACHE
$game_search = 'video_'.$type.'_'.$package_name;
$game_search_key = sha1($game_search);
$game_search_key .= '_liwei_new';
if(!empty($test) || !$datas = getcache($game_search_key, '', 'memcache', 'html')) { 
	$request_api = "http://game.mofang.com/api/web/GetGameIdsByPackage?type=".$type."&packages=".$package_name;
	$datas = mf_curl_get($request_api);
	$datas = json_decode($datas,true);
	setcache($game_search_key, $datas, '', 'memcache', 'html', 1800);
}else{
	$datas = getcache($game_search_key, '', 'memcache', 'html');
} 
$array = array();
if($datas['code']=='0' && !empty($datas['data'])) {
	$select_catid = 472; //指定欄目ID，只搜索指定遊戲視頻攻略大全
	$modelid_array = array(20,21);
	$MODEL = getcache('model','commons');
	$modelid = $modelid_array[$type]; //計算當前查詢MODELID值
	$content_db= pc_base::load_model('content_model');
	$content_db->set_catid($select_catid);	

	//先查新ID，是否有關聯視頻，沒有再查老ID
	$query_sql = " select video.id, video.title, video.thumb,video.description, video.updatetime, video.videotime, video.shortname,video_d.letv_id,video_d.relation_game from  www_video as video,www_video_data as video_d where  video.`catid`= $select_catid AND video_d.`relation_game`='".$datas['data']['newgameid']."' and video.id = video_d.id order by video.id desc limit 0,1";
	//讀緩存，減輕服務器壓力
	$cache_key = sha1($query_sql);
	$cache_key .= '_d_qq';
	if (!$return_array = getcache($cache_key, '', 'memcache', 'html')) {
		$sql_return = $content_db->query($query_sql);
		$rs = $content_db->fetch_array();
		$return_array = $rs[0];//只取第一個關聯到的視頻
	    setcache($cache_key, $return_array, '', 'memcache', 'html', 1800);
	}else{
		$return_array = getcache($cache_key,'','memcache','html');
	}
	//通過relation_gameid，沒有查到對應視頻，則通過oldgaemid再查一遍
	if(empty($return_array['letv_id'])){
		if(!empty($test) || $datas['data']['oldgameid']){
			$new_where = " `catid`= $select_catid AND `gameid` ='|$modelid-".$datas['data']['oldgameid'][0]."|'";
			//讀緩存，減輕服務器壓力
			$cache_key = sha1($new_where);
       		$cache_key .= '_oldgameid_query';
			if (!$return_array = getcache($cache_key, '', 'memcache', 'html')) {
				$return_array = $content_db->get_one($new_where,'id,title,thumb,keywords,description,url,updatetime,videotime,shortname');
				//如查出關聯了此遊戲的視頻，則繼續查詢其樂視ID 
				if($return_array && !empty($return_array)){
					$content_db->table_name = $content_db->table_name.'_data';
		        	$r2 = $content_db->get_one(array('id'=>$return_array['id']),'letv_id,relation_game','id desc'); 
		       		$return_array = $r2 ? array_merge($return_array,$r2) : $return_array;
				}
		        setcache($cache_key, $return_array, '', 'memcache', 'html', 1800);
		    }else{
        		$return_array = getcache($cache_key,'','memcache','html');
		    }
		}
	} 
	//根據return_array 裡面是否有letv_id，來時時生成JS代碼。 這樣更通用些。   
	if(!empty($return_array['letv_id'])){
		if($is_mobile==1){//移動端播放器代碼
			$return_array['player'] = '<div id="mofang_video"></div><script type="text/javascript"> var letvcloud_player_conf =  {"uu":"bc8ddac985","vu":"'.$return_array['letv_id'].'","auto_play":1,"gpcflag":1,"width":'.$width.',"height":'.$height.'};</script><script type="text/javascript" src="http://yuntv.letv.com/bcloud.js"></script><script type="text/javascript">__loadjs(\'base\');</script>';
		}else{//pc端播放器代碼
$js = '!function(){function e(e){var a={containerId:null,uu:"bc8ddac985",vu:"aadbd42a10",autoplay:1,width:640,height:360,gpcflag:1,videoCover:"",loadingUrl:"http://sts0.mofang.com/statics/v4/mplayer/img/loading_67f0b65.swf",video_swf:"http://sts0.mofang.com/statics/v4/mplayer/img/mplayer_6cdf4aa.swf",xiSwfUrlStr:"http://sts0.mofang.com/statics/v4/mplayer/img/expressinstall_be332eb.swf"},n={};for(var i in a){var r=a[i];e.hasOwnProperty(i)&&(r=e[i]),n[i]=r}var o=(n.width,n.height,n.containerId),l="11.2.0",s={uu:n.uu,vu:n.vu,autoplay:n.autoplay,gpcflag:n.gpcflag,width:n.width,height:n.height,videoCover:window.encodeURI(n.videoCover),loadingUrl:window.encodeURI(n.loadingUrl)},d={};d.quality="high",d.bgcolor="#000",d.allowscriptaccess="always",d.allowfullscreen="true";var c={};c.id=o,c.name=o,c.align="middle",t.embedSWF(n.video_swf,o,n.width,n.height,l,n.xiSwfUrlStr,s,d,c),t.createCSS("#"+o,"display:block;text-align:left;")}if(!window.mofang||!window.mofang.Mplayer){var t=function(){function e(){if(!H){try{var e=U.getElementsByTagName("body")[0].appendChild(g("span"));e.parentNode.removeChild(e)}catch(t){return}H=!0;for(var a=P.length,n=0;a>n;n++)P[n]()}}function a(e){H?e():P[P.length]=e}function n(e){if(typeof M.addEventListener!=k)M.addEventListener("load",e,!1);else if(typeof U.addEventListener!=k)U.addEventListener("load",e,!1);else if(typeof M.attachEvent!=k)m(M,"onload",e);else if("function"==typeof M.onload){var t=M.onload;M.onload=function(){t(),e()}}else M.onload=e}function i(){R?r():o()}function r(){var e=U.getElementsByTagName("body")[0],t=g(B);t.setAttribute("type",F);var a=e.appendChild(t);if(a){var n=0;!function(){if(typeof a.GetVariable!=k){var i=a.GetVariable("$version");i&&(i=i.split(" ")[1].split(","),X.pv=[parseInt(i[0],10),parseInt(i[1],10),parseInt(i[2],10)])}else if(10>n)return n++,setTimeout(arguments.callee,10),void 0;e.removeChild(t),a=null,o()}()}else o()}function o(){var e=W.length;if(e>0)for(var t=0;e>t;t++){var a=W[t].id,n=W[t].callbackFn,i={success:!1,id:a};if(X.pv[0]>0){var r=y(a);if(r)if(!w(W[t].swfVersion)||X.wk&&X.wk<312)if(W[t].expressInstall&&s()){var o={};o.data=W[t].expressInstall,o.width=r.getAttribute("width")||"0",o.height=r.getAttribute("height")||"0",r.getAttribute("class")&&(o.styleclass=r.getAttribute("class")),r.getAttribute("align")&&(o.align=r.getAttribute("align"));for(var f={},u=r.getElementsByTagName("param"),p=u.length,v=0;p>v;v++)"movie"!=u[v].getAttribute("name").toLowerCase()&&(f[u[v].getAttribute("name")]=u[v].getAttribute("value"));d(o,f,a,n)}else c(r),n&&n(i);else C(a,!0),n&&(i.success=!0,i.ref=l(a),n(i))}else if(C(a,!0),n){var h=l(a);h&&typeof h.SetVariable!=k&&(i.success=!0,i.ref=h),n(i)}}}function l(e){var t=null,a=y(e);if(a&&"OBJECT"==a.nodeName)if(typeof a.SetVariable!=k)t=a;else{var n=a.getElementsByTagName(B)[0];n&&(t=n)}return t}function s(){return!G&&w("6.0.65")&&(X.win||X.mac)&&!(X.wk&&X.wk<312)}function d(e,t,a,n){G=!0,A=n||null,N={success:!1,id:a};var i=y(a);if(i){"OBJECT"==i.nodeName?(E=f(i),I=null):(E=i,I=a),e.id=j,(typeof e.width==k||!/%$/.test(e.width)&&parseInt(e.width,10)<310)&&(e.width="310"),(typeof e.height==k||!/%$/.test(e.height)&&parseInt(e.height,10)<137)&&(e.height="137"),U.title=U.title.slice(0,47)+" - Flash Player Installation";var r=X.ie&&X.win?"ActiveX":"PlugIn",o="MMredirectURL="+encodeURI(window.location).toString().replace(/&/g,"%26")+"&MMplayerType="+r+"&MMdoctitle="+U.title;if(typeof t.flashvars!=k?t.flashvars+="&"+o:t.flashvars=o,X.ie&&X.win&&4!=i.readyState){var l=g("div");a+="SWFObjectNew",l.setAttribute("id",a),i.parentNode.insertBefore(l,i),i.style.display="none",function(){4==i.readyState?i.parentNode.removeChild(i):setTimeout(arguments.callee,10)}()}u(e,t,a)}}function c(e){if(X.ie&&X.win&&4!=e.readyState){var t=g("div");e.parentNode.insertBefore(t,e),t.parentNode.replaceChild(f(e),t),e.style.display="none",function(){4==e.readyState?e.parentNode.removeChild(e):setTimeout(arguments.callee,10)}()}else e.parentNode.replaceChild(f(e),e)}function f(e){var t=g("div");if(X.win&&X.ie)t.innerHTML=e.innerHTML;else{var a=e.getElementsByTagName(B)[0];if(a){var n=a.childNodes;if(n)for(var i=n.length,r=0;i>r;r++)1==n[r].nodeType&&"PARAM"==n[r].nodeName||8==n[r].nodeType||t.appendChild(n[r].cloneNode(!0))}}return t}function u(e,t,a){var n,i=y(a);if(X.wk&&X.wk<312)return n;if(i)if(typeof e.id==k&&(e.id=a),X.ie&&X.win){var r="";for(var o in e)e[o]!=Object.prototype[o]&&("data"==o.toLowerCase()?t.movie=e[o]:"styleclass"==o.toLowerCase()?r+=\' class="\'+e[o]+\'"\':"classid"!=o.toLowerCase()&&(r+=" "+o+\'="\'+e[o]+\'"\'));var l="";for(var s in t)t[s]!=Object.prototype[s]&&(l+=\'<param name="\'+s+\'" value="\'+t[s]+\'" />\');i.outerHTML=\'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"\'+r+">"+l+"</object>",D[D.length]=e.id,n=y(e.id)}else{var d=g(B);d.setAttribute("type",F);for(var c in e)e[c]!=Object.prototype[c]&&("styleclass"==c.toLowerCase()?d.setAttribute("class",e[c]):"classid"!=c.toLowerCase()&&d.setAttribute(c,e[c]));for(var f in t)t[f]!=Object.prototype[f]&&"movie"!=f.toLowerCase()&&p(d,f,t[f]);i.parentNode.replaceChild(d,i),n=d}return n}function p(e,t,a){var n=g("param");n.setAttribute("name",t),n.setAttribute("value",a),e.appendChild(n)}function v(e){var t=y(e);t&&"OBJECT"==t.nodeName&&(X.ie&&X.win?(t.style.display="none",function(){4==t.readyState?h(e):setTimeout(arguments.callee,10)}()):t.parentNode.removeChild(t))}function h(e){var t=y(e);if(t){for(var a in t)"function"==typeof t[a]&&(t[a]=null);t.parentNode.removeChild(t)}}function y(e){var t=null;try{t=U.getElementById(e)}catch(a){}return t}function g(e){return U.createElement(e)}function m(e,t,a){e.attachEvent(t,a),_[_.length]=[e,t,a]}function w(e){var t=X.pv,a=e.split(".");return a[0]=parseInt(a[0],10),a[1]=parseInt(a[1],10)||0,a[2]=parseInt(a[2],10)||0,t[0]>a[0]||t[0]==a[0]&&t[1]>a[1]||t[0]==a[0]&&t[1]==a[1]&&t[2]>=a[2]?!0:!1}function b(e,t,a,n){if(!X.ie||!X.mac){var i=U.getElementsByTagName("head")[0];if(i){var r=a&&"string"==typeof a?a:"screen";if(n&&(T=null,L=null),!T||L!=r){var o=g("style");o.setAttribute("type","text/css"),o.setAttribute("media",r),T=i.appendChild(o),X.ie&&X.win&&typeof U.styleSheets!=k&&U.styleSheets.length>0&&(T=U.styleSheets[U.styleSheets.length-1]),L=r}X.ie&&X.win?T&&typeof T.addRule==B&&T.addRule(e,t):T&&typeof U.createTextNode!=k&&T.appendChild(U.createTextNode(e+" {"+t+"}"))}}}function C(e,t){if(J){var a=t?"visible":"hidden";H&&y(e)?y(e).style.visibility=a:b("#"+e,"visibility:"+a)}}function S(e){var t=/[\\\"<>\.;]/,a=null!=t.exec(e);return a&&typeof encodeURIComponent!=k?encodeURIComponent(e):e}{var E,I,A,N,T,L,k="undefined",B="object",O="Shockwave Flash",x="ShockwaveFlash.ShockwaveFlash",F="application/x-shockwave-flash",j="SWFObjectExprInst",$="onreadystatechange",M=window,U=document,V=navigator,R=!1,P=[i],W=[],D=[],_=[],H=!1,G=!1,J=!0,X=function(){var e=typeof U.getElementById!=k&&typeof U.getElementsByTagName!=k&&typeof U.createElement!=k,t=V.userAgent.toLowerCase(),a=V.platform.toLowerCase(),n=a?/win/.test(a):/win/.test(t),i=a?/mac/.test(a):/mac/.test(t),r=/webkit/.test(t)?parseFloat(t.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):!1,o=!1,l=[0,0,0],s=null;if(typeof V.plugins!=k&&typeof V.plugins[O]==B)s=V.plugins[O].description,!s||typeof V.mimeTypes!=k&&V.mimeTypes[F]&&!V.mimeTypes[F].enabledPlugin||(R=!0,o=!1,s=s.replace(/^.*\s+(\S+\s+\S+$)/,"$1"),l[0]=parseInt(s.replace(/^(.*)\..*$/,"$1"),10),l[1]=parseInt(s.replace(/^.*\.(.*)\s.*$/,"$1"),10),l[2]=/[a-zA-Z]/.test(s)?parseInt(s.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0);else if(typeof M.ActiveXObject!=k)try{var d=new ActiveXObject(x);d&&(s=d.GetVariable("$version"),s&&(o=!0,s=s.split(" ")[1].split(","),l=[parseInt(s[0],10),parseInt(s[1],10),parseInt(s[2],10)]))}catch(c){}return{w3:e,pv:l,wk:r,ie:o,win:n,mac:i}}();!function(){X.w3&&((typeof U.readyState!=k&&"complete"==U.readyState||typeof U.readyState==k&&(U.getElementsByTagName("body")[0]||U.body))&&e(),H||(typeof U.addEventListener!=k&&U.addEventListener("DOMContentLoaded",e,!1),X.ie&&X.win&&(U.attachEvent($,function(){"complete"==U.readyState&&(U.detachEvent($,arguments.callee),e())}),M==top&&!function(){if(!H){try{U.documentElement.doScroll("left")}catch(t){return setTimeout(arguments.callee,0),void 0}e()}}()),X.wk&&!function(){return H?void 0:/loaded|complete/.test(U.readyState)?(e(),void 0):(setTimeout(arguments.callee,0),void 0)}(),n(e)))}(),function(){X.ie&&X.win&&window.attachEvent("onunload",function(){for(var e=_.length,a=0;e>a;a++)_[a][0].detachEvent(_[a][1],_[a][2]);for(var n=D.length,i=0;n>i;i++)v(D[i]);for(var r in X)X[r]=null;X=null;for(var o in t)t[o]=null;t=null})}()}return{registerObject:function(e,t,a,n){if(X.w3&&e&&t){var i={};i.id=e,i.swfVersion=t,i.expressInstall=a,i.callbackFn=n,W[W.length]=i,C(e,!1)}else n&&n({success:!1,id:e})},getObjectById:function(e){return X.w3?l(e):void 0},embedSWF:function(e,t,n,i,r,o,l,c,f,p){var v={success:!1,id:t};X.w3&&!(X.wk&&X.wk<312)&&e&&t&&n&&i&&r?(C(t,!1),a(function(){n+="",i+="";var a={};if(f&&typeof f===B)for(var h in f)a[h]=f[h];a.data=e,a.width=n,a.height=i;var y={};if(c&&typeof c===B)for(var g in c)y[g]=c[g];if(l&&typeof l===B)for(var m in l)typeof y.flashvars!=k?y.flashvars+="&"+m+"="+l[m]:y.flashvars=m+"="+l[m];if(w(r)){var b=u(a,y,t);a.id==t&&C(t,!0),v.success=!0,v.ref=b}else{if(o&&s())return a.data=o,d(a,y,t,p),void 0;C(t,!0)}p&&p(v)})):p&&p(v)},switchOffAutoHideShow:function(){J=!1},ua:X,getFlashPlayerVersion:function(){return{major:X.pv[0],minor:X.pv[1],release:X.pv[2]}},hasFlashPlayerVersion:w,createSWF:function(e,t,a){return X.w3?u(e,t,a):void 0},showExpressInstall:function(e,t,a,n){X.w3&&s()&&d(e,t,a,n)},removeSWF:function(e){X.w3&&v(e)},createCSS:function(e,t,a,n){X.w3&&b(e,t,a,n)},addDomLoadEvent:a,addLoadEvent:n,getQueryParamValue:function(e){var t=U.location.search||U.location.hash;if(t){if(/\?/.test(t)&&(t=t.split("?")[1]),null==e)return S(t);for(var a=t.split("&"),n=0;n<a.length;n++)if(a[n].substring(0,a[n].indexOf("="))==e)return S(a[n].substring(a[n].indexOf("=")+1))}return""},expressInstallCallback:function(){if(G){var e=y(j);e&&E&&(e.parentNode.replaceChild(E,e),I&&(C(I,!0),X.ie&&X.win&&(E.style.display="block")),A&&A(N)),G=!1}}}}();window.mofang=window.mofang||{},window.mofang.Mplayer=e}}();';
						$return_array['player'] = '<div id="mofang_video">
</div><script type="text/javascript">
'.$js.'
(function  () {
var cid = "mfplayer" + Math.floor(Math.random() * Math.pow(10,10));
var player = new mofang.Mplayer({
    containerId:"mofang_video",   // div的id
    uu:"bc8ddac985",    // 魔方id
    vu:"'.$return_array['letv_id'].'",    // 視頻id
    autoplay:0,         // 是否自動播放
    videoCover:"'.$return_array['thumb'].'",
    width:"'.$width.'",
    height:"'.$height.'"
});
})();
</script>';			
		}
	}else{
		//沒有獲取到letv_id 
		$err_info['code'] = -3;
		$err_info['msg'] = '未查到對應的遊戲視頻!';
		$return = json_encode($err_info);
		if($videoBack){
			echo $videoBack."($return)";
		}else{
			echo $return;
		}
		exit();
	}

}else{
	//李偉接口返回，查詢失敗 
	$err_info['code'] = -2;
	$err_info['msg'] = '新庫不存在此遊戲！';
	$return = json_encode($err_info);
	if($videoBack){
		echo $videoBack."($return)";
	}else{
		echo $return;
	}
	exit();
}

 
if($_GET['test']=='test'){
	$return_data[$package_name] = $return_array;
	print_r($return_data);
	exit;
}else{
	//組合為老接口返回的數據結構
	$err_info['code'] = 0;
	$err_info['msg'] = 'ok';
	$err_info['data'][$package_name] = $return_array;
	$return = json_encode($err_info);
	if($videoBack){
		echo $videoBack."($return)";
	}else{
		echo $return;
	}
	exit;
}

?>