//签到
function ogreyBox(elebtn,disBtn,greyEle,pos){
	
	elebtn.flag=true;
	elebtn.onclick=function greyBox(){
		if(this.flag){
		elebtn.flag=false;
		var login=creatMask();
		wind(login);
		elebtn.style.zIndex=9999;
		greyEle.style.zIndex=9999;
		//document.body.style.overflow="hidden";
		greyEle.style.display="block";
		if(pos){
			greyEle.style.left=scrollL+w/2-222+"px";
			greyEle.style.top=scrollT+h/2-148+"px";
		}
		window.onscroll=function(){wind(login);}
		disBtn.onclick = function() {
				document.body.removeChild(login);
				greyEle.style.display="none";
				elebtn.style.zIndex=0;
				greyEle.style.zIndex=0;
				elebtn.flag=true;
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
		w=document.documentElement.clientWidth||document.body.clientWidth;//窗口的kuan
		ele.style.width=w+scrollL+"px";
		ele.style.height=h+scrollT+"px";
		
	}//end  宽高
	}
}// JavaScript Document
$("classname").each(function(){
	var elebtn=$(this).get(0);
})		
	
	var index_weixin=document.getElementById("index_weixin");
	if(index_weixin!==null){ 
		var dialog_weixin=document.getElementById("dialog_weixin");
		var fr1=document.getElementById("fr1");
		ogreyBox(index_weixin,fr1,dialog_weixin,true);
	}
	
	 









