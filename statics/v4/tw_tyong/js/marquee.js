define('tw_tyong/marquee', function(require, exports, module) {
	var speed=50 ;
	var marquee_box = document.getElementById('marquee_box'),
		marquee_box1 = document.getElementById('marquee_box1'),
		marquee_box2 = document.getElementById('marquee_box2');
		
	marquee_box2.innerHTML=marquee_box1.innerHTML; 
	function Marquee(){ 
		if(marquee_box.scrollLeft>=marquee_box1.scrollWidth){ 
			marquee_box.scrollLeft = 0; 
		}else{ 
			marquee_box.scrollLeft++ ;
		} 
	} 
	var MyMar=setInterval(Marquee,speed) 
	marquee_box.onmouseover=function() {clearInterval(MyMar)} 
	marquee_box.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
})
seajs.use(["tw_tyong/marquee"])