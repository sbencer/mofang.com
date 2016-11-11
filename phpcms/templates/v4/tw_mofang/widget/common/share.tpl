<div class="hw-share-wrap w680 mb10">
	<span>分享到：</span>{$url}
	<a href="http://www.facebook.com/sharer.php?u={trim($url)}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="share-fb" target="_self"></a>
	<a href="http://twitter.com/share?url={trim($url)}&amp;text={$rs.title}&amp;via=mofang" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="share-tt" target="_self"></a>
	<a href="https://plus.google.com/share?url={trim($url)}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="share-gg" target="_self"></a>
</div>
{require name="tw_mofang:statics/css/share.css"}
