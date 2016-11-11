define('tabs',['jquery','mfe','widget'],function(require, exports, module){

    var $ = require("jquery"),
    mfe = require("mfe"),
    Widget = require("widget");

    // 基于 Widget 定义 SimpleTabView 组件
    var Tabs = Widget.extend({

        attrs: {
            triggers: {
                value: '.nav li'
            },

            panels: {
                value: '.content div',
                getter: function(val) {
                    return this.$(val);
                }
            },

            activeIndex: {
                value: 0
            },

            eventType: {
              value: "mouseover"
            }
        },

        events: function(){
            //'mouseover .nav li': '_switchToEventHandler';
            var eventType = this.get('eventType');
            var events = {};
            var trigger = this.get("triggers");
            evEle = eventType + trigger;
            //console.log(evEle)
            events[evEle] = '_switchToEventHandler';
            return events;
        },

        _onRenderActiveIndex: function(val, prev) {
            //console.log(prev);
            var _this = this;
            this.element.each(function(){
                //console.log($(this));
                var triggers = $(_this.get('triggers'),this);
                var panels = _this.get('panels');
                //console.log(triggers);
                triggers.eq(prev).removeClass('active');
                triggers.eq(val).addClass('active');

                panels.eq(prev).hide();
                panels.eq(val).show();
            });
        },  
        _switchToEventHandler: function(ev) {
          console.log(this.element);
            var index = $(this.get('triggers')).index(ev.target);
            this.switchTo(index);
        },

        switchTo: function(index) {
            this.set('activeIndex', index);
        },
        //初始化属性
        setup: function() {
            this.get('panels').hide();
            this.switchTo(this.get('activeIndex'));
        }
    });
      
    module.exports = Tabs;
      
});