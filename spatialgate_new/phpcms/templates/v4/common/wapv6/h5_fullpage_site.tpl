{*

    ********************************
    *  h5活动页面
    ********************************
    *  所有移动端fullpage的付费活动H5活动页面从此页面继承
    *  主要是H5滑屏中，分享、下载、向下滑动导引
    *  wapv6/h5_fullpage_site -> wapv6/doctype
    *
    * main 子页面区域
    *
    ********************************
    * 更改每个活动的下载链接
    ********************************
    *  {block name="main"}
    *     --你在页面中写的内容--
    *  {/block}
    *  {block name=downlink}
    *       http://www.mofang.com
    *  {/block}
    *
    ********************************
*}
{extends file='common/wapv6/doctype.tpl'}
{block name=body}
    {$smarty.block.parent}

    {block name=main}
       
    {/block}
    {block name=h5Public}
        {literal}
        <style>
            /*头部下载分享*/
            .m-logo img{max-width: 30px;max-height: 43px;position: absolute;z-index: 9999;left:0px;top:0px;margin-left: 30px;margin-top: 12px;}
            .m-bkg img{position: absolute;height: 100%;width: 100%;}
            .m-arrows img{position: absolute;z-index: 9999;left: 46%;top: 93%;width: 8%;max-width: 44px;max-height: 34px;}
            .m-download,.m-share{background: rgba(0,0,0,.5);position: absolute;top: 12px;width: 34px;height: 34px;border-radius: 50%;z-index: 9999;background-size: contain;}
            .m-download img,.m-share img{width: 40%;margin-left: 30%;margin-top: 30%;height: auto;}
            .m-download{right: 67px;}
            .m-share{ right: 17px;}
            .m-download a,.m-share a{display: block;width: 100%;height: 100%;background-size: contain;}
            .m-share-img img{position: absolute;left:0px;top:0px;display: none;z-index: 9999;max-height: 100%;max-width: 100%;height: 100%;width: 100%;}
            @media (min-width : 375px) and (max-width : 667px){
                .m-logo img{max-width: 50px;max-height: 70px;}
                .m-download img, .m-share img{margin-left: 0px;}
                .m-download{background: rgba(0,0,0,.5);border-radius: 50%;position: absolute;z-index: 9999;width: 40px;height: 40px;right: 60px;text-align: center;top: 20px;color: #eee3c0;line-height: 30px;}
                .m-share {background: rgba(0,0,0,.5);border-radius: 50%;position: absolute;z-index: 9999;width: 40px;height: 40px;right: 10px;text-align: center;top: 20px;color: #eee3c0;line-height: 30px;}
                .m-download a{font-size: 15px;}
                .m-share a{font-size: 15px;color: #eee3c0;}

            }
            /* iphone6 plus*/
            @media (min-width : 414px) and (max-width : 736px) {
                .m-logo img{max-width: 50px;max-height: 70px;}
                .m-download img, .m-share img{margin-left: 0px;}
                .m-download{background: rgba(0,0,0,.5);border-radius: 50%;position: absolute;z-index: 9999;width: 45px;height: 45px;right: 75px;text-align: center;top: 20px;color: #eee3c0;line-height: 30px;}
                .m-share {background: rgba(0,0,0,.5);border-radius: 50%;position: absolute;z-index: 9999;width: 45px;height: 45px;right: 10px;text-align: center;top: 20px;color: #eee3c0;line-height: 30px;}
                .m-download a{font-size: 15px;}
                .m-share a{font-size: 15px;color: #eee3c0;}
            }
            .autoDownArrow {
                  -webkit-animation: autoDownArrow ease 1.5s both infinite;
                  animation: autoDownArrow ease 1.5s both infinite; }

                @-webkit-keyframes autoDownArrow {
                  0% {
                    -webkit-transform: translateY(-50%);
                    opacity: 0; }
                  50% {
                    -webkit-transform: translateY(0%);
                    opacity: 1; }
                  100% {
                    -webkit-transform: translateY(50%);
                    opacity: 0; } }
                @keyframes autoDownArrow {
                  0% {
                    -webkit-transform: translateY(-50%);
                    transform: translateY(-50%);
                    opacity: 0; }
                  50% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                    opacity: 1; }
                  100% {
                    -webkit-transform: translateY(50%);
                    transform: translateY(50%);
                    opacity: 0; } 
                }
        </style>
        <script>
            seajs.use(["jquery"],function($){
                $('.J_share').on('click', function(){
                    $('.m-share-img img').show()
                });
                $('.J_down').on('click', function(){
                    $(this).hide();
                });
            });
        </script>
        {/literal}
        <div class="m-logo">
            {block name=logo}<img src="/statics/v4/common/img/wapv6/h5_base/mofang.png" alt=""/>{/block}
        </div>
        {block name=shareDown}
        <div class="m-btn">
            <div class="m-download">
                <a href="{block name=downlink}http://app.mofang.com{/block}">
                    <img src="/statics/v4/common/img/wapv6/h5_base/down.png">
                </a>
            </div>
            <div class="m-share J_share">
                <a class="btn-share" href="javascript:void(0)">
                    <img src="/statics/v4/common/img/wapv6/h5_base/share.png">
                </a>
            </div>
        </div>
        {/block}
        {block name="arrows"}
        <div class="m-arrows">
            <img src="/statics/v4/common/img/wapv6/h5_base/next.png" alt="" class="autoDownArrow">
        </div>
        {/block}
        <div class="m-share-img">
            <img src="/statics/v4/common/img/wapv6/h5_base/weixin_share.png" alt="" class="J_down"/>
        </div>
    {/block}
    

{/block}