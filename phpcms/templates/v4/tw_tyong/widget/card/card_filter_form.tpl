<div class="nav-common title1-bg">
	<ul class="nav-com-list w120 clearfix">
        {foreach $table_list as $val}
        <li class="bg-line {if $val.id == $smarty.get.setid}curr{/if}">
            <a href="{card_list_url($val.id, $smarty.get.p)}">{$val.name}</a>
        </li>
        {/foreach}
    </ul>
</div>

<div class="card_filter clearfix">
    <form class="filter_form" method="get" action="{card_list_url($smarty.get.setid, $smarty.get.p)}?url=1">

    {foreach $table_info as $key =>$val}
      <div class="item">
          <label class="fl">{$val.name}</label>
          {if $val.field_info.addition_type == 'select'}
          <input type="hidden" name="{$key}" value="{$smarty.get[$key]}" />
          <ul class="fl">
            {$gets = explode(",", $smarty.get[$key])}
            {foreach $val.field_info.select_value as $v}
              <li {if in_array($v.value, $gets)}class="curr"{/if}>
                <a href="javascript:;">{$v.value}</a>
              </li>
            {/foreach}
          </ul>
          {else}
          <div class="fl">
              <input name="{$key}[min]" class="input_text" type="text" value="{$smarty.get[$key]['min']}">
              到
              <input name="{$key}[max]" class="input_text" type="text" value="{$smarty.get[$key]['max']}">
          </div>
          {/if}
      </div>
      {/foreach}
      <div class="item"> 
          <label class="fl">&nbsp;</label>
          <div class="fl">
              <input class="input_btn" type="submit" value="確定">
              <input class="input_btn reset_btn" type="button" value="重置">
          </div>
      </div>
    </form>
</div>
{require name="tw_tyong:statics/css/game_load.css"}
{require name="tw_tyong:statics/js/filter.js"}
