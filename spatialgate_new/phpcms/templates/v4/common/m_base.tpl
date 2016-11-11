
{extends file='common/m_doctype.tpl'}

{block name=head}

	{$smarty.block.parent}
    <script>

    {* 组件之间调用 *}
    var MFE = {};

    {* 与后台数据交互 *}
    var CONFIG = {};

    </script>

{/block}

