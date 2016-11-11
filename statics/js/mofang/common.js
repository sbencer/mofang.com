

//签到
function ogreyBox(elebtn,disBtn,greyEle){
	elebtn.flag=true;
	elebtn.onclick=function greyBox(){
		if(elebtn.flag){
		elebtn.flag=false;
		var login=creatMask();
		wind(login);
		elebtn.style.zIndex=99999;
		greyEle.style.zIndex=9999;
		//document.body.style.overflow="hidden";
		greyEle.style.display="block";
		
		window.onscroll=function(){wind(login);}
		disBtn.onclick=function(){
			document.body.removeChild(login);
			greyEle.style.display="none";
			elebtn.style.zIndex=0;
			greyEle.style.zIndex=0;
			elebtn.flag=true;
			}
		}
}
	// 创建遮罩
	function creatMask(){
		var login=document.createElement("div");
		login.id="omask";
		login.style.opacity=0.6;
		login.style.filter='alpha(opacity=60)';
		login.style.zIndex="999";
		login.style.left=0;
		login.style.top=0;
		login.style.position="absolute";
		login.style.backgroundColor="#000";
		document.body.appendChild(login);
		return login;
	}//end
	//计算遮罩的狂高
	function wind(ele){
		scrollT=(document.documentElement.scrollTop||document.body.scrollTop);//滚动条的位置
		scrollL=(document.documentElement.scrollLeft||document.body.scrollLeft);//左边滚动条的位置
		h=document.documentElement.clientHeight||document.body.clientHeight;//浏览器窗口的高
		var w=document.documentElement.clientWidth||document.body.clientWidth;//窗口的kuan
		ele.style.width=w+scrollL+"px";
		
		ele.style.height=h+scrollT+"px";
		w=w/2;
		greyEle.style.left=(w-200)+"px";
	}//end  宽高
		
}// JavaScript Document
		
// 选项卡
 $.fn.tabs = function (options) {
        var settings = {
            tabList: "",
            tabContent: "",
      			tabOn:"",
            action: ""
        };
        var _this = $(this);
        if (options) $.extend(settings, options);
        _this.find(settings.tabContent).eq(0).show(); //第一栏目显示
        _this.find(settings.tabList).eq(0).addClass(settings.tabOn);
        if (settings.action == "mouseover") {
            _this.find(settings.tabList).each(function (i) {
                $(this).mouseover(function () {
                    $(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                    var _tCon = _this.find(settings.tabContent).eq(i);
                    _tCon.show().siblings().hide();

                }); //滑过切换              

            });

        }
        else if (settings.action == "click") {
            _this.find(settings.tabList).each(function (i) {
                $(this).click(function () {
                    $(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                    var _tCon = _this.find(settings.tabContent).eq(i);
                    _tCon.show().siblings().hide();

                }); //点击切换

            });
        };

    };

