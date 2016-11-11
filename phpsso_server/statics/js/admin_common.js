function confirmurl(url,message)
{
	if(confirm(message)) redirect(url);
}
function redirect(url) {
	if(url.indexOf('://') == -1 && url.substr(0, 1) != '/' && url.substr(0, 1) != '?') url = $('base').attr('href')+url;
	location.href = url;
}
//滾動條
$(function(){
	//inputStyle
	$(":text").addClass('input-text');
})

/**
 * 全選checkbox,注意：標識checkbox id固定為為check_box
 * @param string name 列表check名稱,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}