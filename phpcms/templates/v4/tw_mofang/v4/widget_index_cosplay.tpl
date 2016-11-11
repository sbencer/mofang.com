{require name="tw_mofang:statics/css/v4/widget_index_cosplay.css"}
<div class="index-atlas">
    <h3 class="title">
        <a href="http://www.mofang.com.tw/SGCOS/10000275-1.html" target="_blank" class="more">更多></a>
        Cosplay & 展場SG 特集
    </h3>
    {pc M=content action=lists catid=10000275 order='id desc' num=14}
    <div class="atlas-list-wrap clearfix">
        <div class="atlas-list fl">
            <ul class="atlas-list-left fl">
                <li class="altas-list-mini altas-list-special">
			  
                	{foreach $data as $val}
	                	{if $val@index eq 0}
		                    <a href="{$val.url}" target="_blank">
		                        <img src="{$val.thumb}" alt="{$val.title}">
		                    </a>
	                      {break}
	                   {/if}
                  {/foreach}
                  
                </li>
                <li class="altas-list-mini">
                    {foreach $data as $val}
		                	{if $val@index eq 1}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 2}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
            </ul>
            <ul class="atlas-list-center fl">
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 3}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-medium">
                    {foreach $data as $val}
		                	{if $val@index eq 4}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
            </ul>
            <ul class="atlas-list-right fl">
                <li class="altas-list-medium">
                    {foreach $data as $val}
		                	{if $val@index eq 5}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 6}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                
            </ul>
        </div>
        <div class="atlas-list fr">
            <ul class="atlas-list-left fl">
                <li class="altas-list-mini altas-list-special">
                    {foreach $data as $val}
		                	{if $val@index eq 7}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-mini">
                    {foreach $data as $val}
		                	{if $val@index eq 8}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 9}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
            </ul>
            <ul class="atlas-list-center fl">
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 10}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-medium">
                    {foreach $data as $val}
		                	{if $val@index eq 11}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
            </ul>
            <ul class="atlas-list-right fl">
                <li class="altas-list-medium">
                    {foreach $data as $val}
		                	{if $val@index eq 12}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                <li class="altas-list-max">
                    {foreach $data as $val}
		                	{if $val@index eq 13}
			                    <a href="{$val.url}" target="_blank">
			                        <img src="{$val.thumb}" alt="{$val.title}">
			                    </a>
		                      {break}
		                   {/if}
                    {/foreach}
                </li>
                
            </ul>
        </div>
    </div>
     {/pc}
</div>
