//**************************************/
/**
 * 搜索
 * jozhliu 2014-03-28
 */
seajs.use(['jquery'],function($) {
    $("#search-header").click(
    function (){
        domain = "http://www.mofang.com/tag/";
        key = $(":input[name=q-header]").val();
        if(key != '') {
            window.open(domain + key + ".html");
        }else{
        	window.open('http://www.mofang.com/zqnr/935-1.html');
        }
        return false;
    });
});
