define("jquery/amplifyImg",['jquery'],function(require, exports, module){

    var $ = require('jquery');
    /*
    *移动端，图片弹出插件 
    *@author xukuikui
    *@date 2014-4-27
    * noImgClass ,排除不想弹出的照片
    */
    $.fn.amplifyImg=function(noImgClass){
        var _this = this;
        noImgClass = noImgClass || '';

        var aImg = $(_this).find("img:not("+noImgClass+")");

        var oDiv = '<div class="amplifyImg-bg" style="display:none;position:fixed;left:0px;top:0px;z-index:99998;width:100%;height:100%;background:rgba(0,0,0,0.8)"></div>'
                    +'<div class="amplifyImg" style="display:none;position:fixed;left:50%;top:50%;z-index:99999;overflow:hidden;-webkit-transform:0px 0px;transform:0px 0px">'
                    +'<img src="" alt="" style="max-width:100%;width:100%;height:100%;">'
                +'</div>';
        $('body').append(oDiv);

        var _imgWidth = 0;//图片的宽
        var _imgHeight = 0;//图片的高
        var _imgLeft = 0;//图片的左
        var _imgTop = 0;//图片的右
        var tX = 0; //拖动的left
        var tY = 0; //拖动的top
        //点击图片弹出遮罩层
        $(aImg).on('touchstart',function(){
            //点击
            var _this = this;
            simulateClick(_this,function(_this){
                showImg($(_this));
            });
            //return false;
        });
        //点击隐藏遮罩层
        $(".amplifyImg-bg,.amplifyImg").on('touchstart',function(){
            var _this = this;
            //点击
            simulateClick(_this,function(_this){
                
                $(".amplifyImg-bg").hide();
                $(".amplifyImg").hide();
            });
            //return false;
        });
        //消除移动端点击事件300ms,替代click
        function simulateClick(_this,fnCallBack){
            var $this = $(_this);
            $this.s = new Date().getTime();
            $(_this).on('touchend',function(){
                $this.s1 = new Date().getTime();
                if($this.s1-$this.s<150){
                    fnCallBack(_this);
                    return true;
                }
            });
        }
        //显示图片
        function showImg(_this){
            var _img = _this;
            var oDocWidth = $(document).width();
            var oDocHeight = $(document).height();
            
            var _imgOriginalWidth = _img.width();
            var _imgOriginalHeight = _img.height();

            _imgWidth = _imgOriginalWidth>oDocWidth ? oDocWidth : _imgOriginalWidth;
            _imgHeight = _imgWidth*_imgOriginalHeight/_imgOriginalWidth;
            _imgLeft = '-'+_imgWidth/2;
            _imgTop = '-'+_imgHeight/2;
            tX = _imgLeft;//给初始位置赋值Left
            tY = _imgTop;//给初始位置赋值Top
            var _imgSrc = _img.attr("src");

            $(".amplifyImg").find("img").attr("src",_imgSrc);

            $(".amplifyImg").css({
                'width': _imgWidth,
                'height': _imgHeight,
                '-webkit-transform': 'translate('+_imgLeft+'px, '+_imgTop+'px)',
                'transform': 'translate('+_imgLeft+'px, '+_imgTop+'px)'
            });
            $(".amplifyImg-bg").show();
            $(".amplifyImg").show();
        }
        //拖动放大效果
        $(".amplifyImg").get(0).addEventListener('touchstart',function(ev){
            var _this = this;
            
            //判断几根手指
            if(ev.targetTouches.length == 2){
                fnTouches2();
            }else{
                fnTouches1();
            }
            var _Width = _imgWidth; //移动前保存 img width
            var _Height = _imgHeight;//移动前保存 img height
            var _Left = _imgLeft;//移动前保存 img left
            var _Top = _imgTop;//移动前保存 img top

            //非俩根手指操作
            function fnTouches1(){
                var disX=ev.targetTouches[0].pageX-tX;
                var disY=ev.targetTouches[0].pageY-tY;
                //alert(disX);
                function fnMove(ev){
                    tX=ev.targetTouches[0].pageX-disX;
                    tY=ev.targetTouches[0].pageY-disY;
                    _this.style.WebkitTransform='translate('+tX+'px,'+tY+'px)';
                    _this.style.transform='translate('+tX+'px,'+tY+'px)';
                    _imgLeft = tX;
                    _imgTop = tY;

                }

                _this.addEventListener('touchmove',fnMove,false);

                function fnEnd(){
                    _this.removeEventListener('touchmove',fnMove,false);
                    _this.removeEventListener('touchend',fnEnd,false);
                }
                _this.addEventListener('touchend',fnEnd,false);
                ev.preventDefault();
            }
            //两根手指操作
            function fnTouches2(){
                var disX =  Math.abs(ev.targetTouches[0].pageX - ev.targetTouches[1].pageX);
                //alert(disX);
                function fnMove(ev){
                    
                    var disX2 = Math.abs(ev.targetTouches[0].pageX - ev.targetTouches[1].pageX);
                    var scale = disX2/disX;
                    
                    _imgWidth = _Width*scale;
                    _imgHeight = _Height*scale;
                    _imgLeft = _Left-(_imgWidth-_Width)/2;
                    _imgTop = _Top-(_imgHeight-_Height)/2;
                    tX = _imgLeft;
                    tY = _imgTop;
                    $(_this).css({
                        "width": _imgWidth,
                        "height":_imgHeight,
                        '-webkit-transform': 'translate('+_imgLeft+'px, '+_imgTop+'px)',
                        'transform': 'translate('+_imgLeft+'px, '+_imgTop+'px)'
                    });
                }
                _this.addEventListener('touchmove',fnMove,false);
                function fnEnd(){
                    _this.removeEventListener('touchmove',fnMove,false);
                    _this.removeEventListener('touchend',fnEnd,false);
                }
                _this.addEventListener('touchend',fnEnd,false);
                ev.preventDefault();
            }
            
        });
    };
    //////////////////////////////////////////////////////////////
    if (typeof module!="undefined" && module.exports ) {
        module.exports = $;
    }
});
