$(function(){
    var childs = $("#screenTag li");
    childs.click(function(){
        var _index = $(this).index();
        var _jt = $(".listB");

        for(var i=0; i<childs.length; i++){
            childs.eq(i).removeClass("current"+i);
        }
        $(this).addClass("current" + _index);
        _jt.hide().eq(_index).show();
    })
});

