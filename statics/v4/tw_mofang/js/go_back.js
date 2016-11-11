seajs.config({
    alias: {
        'jScrollPane': '/statics/v4/tw_acg/js/jscrollpane.js'
    }
}) 
define('go_back',['jquery','jquery/fancybox','jScrollPane'],function(require,exports,module){
	var $ =  require('jquery');
  require('jquery/fancybox');
  require('jScrollPane');

	$(".back-content .top").on("click",function(){
  		$('body,html').animate({scrollTop:0},600);  
        return false;  
  	})

  //点击回作品情报
  var SURL = "/index.php?m=content&c=index&a=show_comics&format=html"
  $('.back_works').click(function(){
    var catid = $(this).attr('data-catid'),
      id = $(this).attr('data-id');
    $.ajax({
      url:SURL,
      data:{"catid":catid,"id":id},
      type:"GET",
      dataType:"HTML",
      success:function(data){
        $("#pop_works").html(data);
        $.fancybox.open('#pop_works');
        $('.chapter-ul').jScrollPane();
      },
      error:function(){
        console.log('请求错误');
      }
    })
  })

  //点击返回关闭浮层
  $('.works_back').live('click',function(){
    $.fancybox.close();
  })
    
})
seajs.use('go_back');