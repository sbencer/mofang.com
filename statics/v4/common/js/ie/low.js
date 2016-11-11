define("ie/low",['jquery'],function(require, exports, module){
    var $ = require("jquery");
    // 还不能使用
    return false;
   /*
    * Creates a stylesheet from a text blob of rules.
    * These rules will be wrapped in a style tag and appended to the HEAD of the document.
    * if cssText does not contain css hacks, u can just use Dom.create('<style>xx</style>')
    * @param {String} [cssText] The text containing the css rules
    * @param {String} [id] An id to add to the stylesheet for later removal
    */
    function show () {
          var anim;
      if (!tipEl) {
        initTipEl();
      }
      tipEl.show();
      anim = new Anim(tipEl, {
        height: 45
      }, .3, "easeOut");
      return anim.run();
    }

    function hide() {
      var anim;
      anim = new Anim(tipEl, {
        height: 0
      }, .3, "easeOut");
      return anim.run();
    }

    function initTipEl() {
      addStyleSheets();
      buildDOM();
      return bindEvents();
    }

    function addStyleSheets() {
      var cssText = getCSSText();
      return DOM.addStyleSheet(cssText);
    }
   function addStyleSheet ( cssText, id) {

       var doc = window.document;
       var elem;

       // 仅添加一次，不重复添加
       if (elem) {
           return;
       }

       elem = $('<style></style>');

       // 先添加到 Dom 树中，再给 cssText 赋值，否则 css hack 会失效
       $('head').append(elem);
       elem = elem[0];

       if (elem.styleSheet) { // IE
           elem.styleSheet.cssText = cssText;
       } else { // W3C
           elem.appendChild(doc.createTextNode(cssText));
       }
    }

    function getCSSText () {
      var cssText =
'.browser-updator {\
   position: fixed;\
   width: 100%;\
   height: 0;\
   left: 0;\
   bottom: 0;\
   overflow: hidden;\
   z-index: 1000000000 !important;\
   _position: absolute;\
   _top: expression(eval(document.compatMode && document.compatMode=="CSS1Compat")\
          ? documentElement.scrollTop +(documentElement.clientHeight-this.clientHeight)\
          : document.body.scrollTop +(document.body.clientHeight-this.clientHeight));\
   _bottom: auto;\
 }\
.browser-updator p {\
 margin: 0;\
 padding: 0;\
 line-height: 45px;\
 color: #fff;\
 font-size: 12px;\
 text-indent: 16px;\
}\
.browser-updator p a {\
 color: #fff;\
 text-decoration: none;\
 *margin-top: 1px;\
 _margin-top: 6px;\
}\
.browser-updator p a:hover {\
 color: #fff;\
 text-decoration: underline;\
}\
.browser-updator-wrapper {\
 position: relative;\
 zoom: 1;\
 width: 950px;\
 margin: 0 auto;\
 height: 45px;\
 background: #8e8e8e;\
 zoom: 1;\
}\
.browser-updator-close {\
 position: absolute;\
 right: 15px;\
 top: 15px;\
 width: 17px;\
 height: 16px;\
 background: url(http://img03.taobaocdn.com/tps/i3/T1p8v6XfJjXXXTOpDa-17-16.png) no-repeat;\
 text-indent: -999em;\
 overflow: hidden;\
}\
.browser-updator-ie {\
 display: inline-block;\
 width: 99px;\
 height: 35px;\
 line-height: 35px;\
 background: url(http://img01.taobaocdn.com/tps/i1/T1kyVWFe8dXXcjfCvX-140-75.png) no-repeat;\
 padding-left: 15px;\
}\
.browser-updator-ie:hover {\
 background-position: 0 -40px;\
}\
.browser-updator-chrome {\
 display: inline-block;\
 line-height: 21px;\
 padding-left: 3px;\
 background: url(http://img01.taobaocdn.com/tps/i1/T1kyVWFe8dXXcjfCvX-140-75.png) no-repeat -120px 0;\
}\
.browser-updator-taobao {\
 display: inline-block;\
 line-height: 21px;\
 padding-left: 3px;\
 background: url(http://img01.taobaocdn.com/tps/i1/T1kyVWFe8dXXcjfCvX-140-75.png) no-repeat -120px -21px;\
}\
.browser-updator-chrome,\
.browser-updator-taobao {\
 text-decoration: underline !important;\
}\
.browser-updator-chrome:hover,\
.browser-updator-taobao:hover {\
 text-decoration: none !important;\
}';

      return cssText;
    }

    function getHtml() {
      // NOTE:
      // 字符串中中文处在边界位置
      // utf-8 编码 js 有中文在 gbk 页面设置 charset 有可能报错: 未结束的字符串常量
      // 因此给给中文包裹一层标签
      var html =
'<div class="browser-updator">\
<div class="browser-updator-wrapper">\
  <p>\
    <span>亲，您的浏览器版本过低导致图片打开速度过慢，提升打开速度您可以：</span>\
    <a target="_blank" href="http://www.microsoft.com/zh-cn/download/details.aspx?id=43" class="browser-updator-browser browser-updator-ie">升级IE浏览器</a>\
    <span>或者点击下载</span>\
    <a target="_blank" href="http://www.google.cn/intl/zh-CN/chrome/browser/" class="browser-updator-browser browser-updator-chrome">chrome浏览器</a>\
    <span>或</span>\
    <a target="_blank" href="http://download.browser.taobao.com/client/browser/down.php?pid=' + _config.tbDownloadPid + '" class="browser-updator-browser browser-updator-taobao">淘宝浏览器</a>\
  </p>\
  <a href="javascript:;" class="browser-updator-close">关闭</a>\
</div>\
</div>';

      return html;
    }

    function buildDOM() {
      var html = getHtml();
      tipEl =  $(html);
      tipEl.appendTo("body");
      return tipEl;
    }

    function bindEvents() {
      tipEl.delegate("click", ".browser-updator-close", function(e) {
        e.preventDefault();
        setStore(+new Date());
        return hide();
      });
    }

    function initStorage() {
      storageEl = $("<div style=\"behavior:url(#default#userData);\"></div>");
      storageEl.appendTo("body");
      return storageEl = storageEl[0];
    }

    function getStore () {
      try {
        storageEl.load("BrowserUpdatorV2");
        return storageEl.getAttribute("test");
      } catch(e) {}
    };

    function setStore (val) {
      storageEl.setAttribute("test", val);
      return storageEl.save("BrowserUpdatorV2");
    };


});
