define('jquery/video',['jquery'],function (require,exports,module) {

	var jquery = $ = require("jquery");

	function anima(parent_name,son_name,direction,bttm,distance,speed){
	    var direc = {};
	    $("."+parent_name).hover(function() {
	      direc[direction] = 0;
	      $(this).children('.info-title').css({"display":"none"});
	      $(this).children("."+son_name).stop().animate(direc, speed)
	    }, function() {
	      direc[direction] = -distance;
	      
	      $(this).children("."+son_name).stop().animate(direc, speed,function(){$(this).siblings('.info-title').css({"display":"block"});});
	     // setTimeout()
	    });
	}

	if (typeof module!="undefined" && module.exports ) {
        module.exports = anima;
    }
	//anima("event-pic","opacity-bg","left","",213,200)
});
