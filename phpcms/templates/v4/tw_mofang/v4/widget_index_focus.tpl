{require name="tw_mofang:statics/css/v4/widget_index_focus.css"}
<div class="index-focus clearfix">
    <div class="focus-swiper fl">
        <div class="swiper-container" id="focus-swiper">
          <div class="swiper-wrapper">
          
	   {pc M=content action=position posid=10000007 order='listorder desc, id desc' num=5}
         {foreach $data as $val}
              <div class="swiper-slide">
                <a href="{$val.url}" target="_blank">
                 <img src="{qiniuthumb($val.thumb,800,450)}" alt="{$val.title}">
                  <p class="focus-swiper-info">{$val.title}</p>
                </a>
              </div>
     		 {/foreach}
      {/pc}
	  </div>
        </div>
        <span class="focus-swiper-btn focus-swiper-prev">prev</span>
        <span class="focus-swiper-btn focus-swiper-next">next</span>
    </div>
    <div class="focus-list-wrap fr">
        <ul class="focus-list">
           {pc M=content action=position posid=10000008 order='listorder desc, id desc' num=4}
              {foreach $data as $val}
                <li>
                   <a href="{$val.url}" target="_blank">
                       <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                       <p class="focus-list-info">{$val.title}</p>
                   </a> 
                </li>
              {/foreach}
            {/pc}

	</ul>
    </div>
    
</div>
<div id="indexLamp" class="index-lamp">
  <ul>
    <li>
      <a href="" target="_blank"> 跑马灯测试1</a>
    </li>
    <li>
      <a href="" target="_blank"> 跑马灯测试2</a>
    </li>
    <li>
      <a href="" target="_blank"> 跑马灯测试3</a>
    </li>
    <li>
      <a href="" target="_blank"> 跑马灯测试4</a>
    </li>
    <li>
      <a href="" target="_blank"> 跑马灯测试5</a>
    </li>
  </ul>
</div>
