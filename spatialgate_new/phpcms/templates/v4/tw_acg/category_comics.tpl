{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}
{block name='main'}
	{* 轮播图 *}
    {include file="tw_acg/widget/comics/comics_slide.tpl"}
    {* aniComic *}
    {include file="tw_acg/widget/comics/anicomics.tpl"}
    {* 漫咖 *}
    {include file="tw_acg/widget/comics/manga.tpl"}

    {* 浮层 *}
    {include file="tw_acg/widget/comics/comics_works_con.tpl"}
{/block}

{* 弹出层 *}
{block name='pop_box'}
    {include file='tw_acg/widget/pop_box.tpl'}
{/block}