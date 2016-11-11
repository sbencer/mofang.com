define('FixedScrollContent',['jquery'],function(require, exports, module){

    var $ = require('jquery');

    function FixedScrollContent(o) {
        var win, doc, bd,
            cnt,
            lastScrollTop,
            scroll_height,
            space,
            state_fixed_bottom,
            state_fixed_middle,
            state_position_top,
            state_scroll,

            cnt_height,
            win_height,
            top_position,
            wrapper,
            bottom_position,
            absolute_bottom_position;

        if (!o.content) {
            throw new Error("content must be set.");
        }

        win = $(window);
        doc = $(document);
        bd = $("body");

        cnt = o.content;
        var margin_top = cnt.offset().top;
        var margin_bottom = 0;

        wrapper = $('<div></div>');
        wrapper.css({
            position:"relative",
            float:"left",
            paddingLeft:3,
            width:cnt.outerWidth()
        });
        cnt.wrap(wrapper);
        scroll_height = 0;
        cnt_height = 0;
        win_height = 0;
        space = 0;
        bottom_position = 0;
        top_position = 0;
        lastScrollTop = 0;
        cnt.css({
            position: "absolute",
            top: 0
        });
        state_fixed_bottom = false;
        state_fixed_middle = false;
        state_scroll = false;
        state_position_top = true;
        state_absolute_buttom = false;
        function check() {
            var st;
            st = win.scrollTop();
            // 向下
            if (st > lastScrollTop) {
                if (state_position_top) {
                    if (st >= bottom_position + margin_top) {
                        if (!state_fixed_bottom) {
                            state_fixed_bottom = true;
                            state_position_top = false;
                            cnt.css({
                                position: "fixed",
                                top: "",
                                bottom: 0
                            });
                        }
                    }
                } else if (state_fixed_middle) {
                    state_fixed_middle = false;
                    state_scroll = true;
                    cnt.css({
                        position: "absolute",
                        top: st - margin_top,
                        bottom: ""
                    });
                    top_position = st;
                } else if (state_scroll) {
                    if (st >= bottom_position) {
                        if (!state_fixed_bottom) {
                            state_fixed_bottom = true;
                            state_scroll = false;
                            cnt.css({
                                position: "fixed",
                                top: "",
                                bottom: "0"
                            });
                        }
                    }
                } else if (state_fixed_bottom) {
                    top_position = st - (cnt_height - space);
                    // footer
                    if (st > margin_bottom) {
                        absolute_bottom_position = st - cnt_height + space - margin_top;
                        state_absolute_buttom = true;
                        state_fixed_bottom = false;
                        cnt.css({
                            position: "absolute",
                            bottom:"",
                            top: absolute_bottom_position
                        });
                        //切换状态到abs
                    }
                }
            // 向上
            } else if (st < lastScrollTop) {
                // debugger
                if (state_fixed_bottom) {
                    if (st < $(document).height() - win_height) {
                        state_fixed_bottom = false;
                        state_scroll = true;
                        cnt.css({
                            position: "absolute",
                            top: st - (cnt_height - space) -margin_top,
                            bottom: ""
                        });
                        // debugger
                        top_position = st - (cnt_height - space);
                        bottom_position = st ;
                    }
                } else if (state_scroll) {
                    if (st <= top_position) {
                        state_fixed_middle = true;
                        state_scroll = false;
                        cnt.css({
                            position: "fixed",
                            top: scroll_height
                        });
                    } else if (st >= bottom_position + margin_top) {
                        state_fixed_bottom = true;
                        state_scroll = false;
                        cnt.css({
                            position: "fixed",
                            top: "",
                            bottom: "0"
                        });
                    }
                } else if (state_fixed_middle) {
                    if (st <= margin_top) {
                        state_fixed_middle = false;
                        state_position_top = true;
                        cnt.css({
                            position: "absolute",
                            top: "0"
                        });
                    }else{
                        state_fixed_middle = false;
                        state_scroll = true;
                        cnt.css({
                            position: "absolute",
                            top: st - margin_top,
                            bottom: ""
                        });
                        top_position = st ;
                    }
                    bottom_position = cnt_height - space + st;
                } else {
                    // debugger
                    // footer
                    if (state_absolute_buttom && st <= margin_bottom) {
                            state_absolute_buttom = false;
                            state_scroll = true;
                            cnt.css({
                                position: "absolute",
                                top: absolute_bottom_position,
                                bottom: ""
                            });
                    }
                        // state_fixed_bottom = true;
                }
            } else {
                // debugger
                    if (st > margin_bottom) {
                        absolute_bottom_position = st - cnt_height + space - margin_top;
                        state_absolute_buttom = true;
                        state_fixed_bottom = false;
                        cnt.css({
                            position: "absolute",
                            bottom:"",
                            top: absolute_bottom_position
                        });
                        //切换状态到abs
                    }
            }
            return lastScrollTop = st;
        };
        function check2() {
            var st;
            st = win.scrollTop();
            if (st > 0) {
                return cnt.css({
                    position: "fixed",
                    top: scroll_height,
                    bottom: ""
                });
            } else {
                return cnt.css({
                    position: "absolute",
                    top: "0",
                    bottom: ""
                });
            }
        };
        win.resize(function() {
            var doc_height, need_bind;

            scroll_height = 0;

            cnt.css({
                background:"#fff"
            });

            cnt_height = cnt.outerHeight();
            win_height = win.innerHeight();
            space = win_height - scroll_height;

            bottom_position = cnt_height - space;
            doc_height = doc.height();
            need_bind = doc_height - scroll_height - cnt_height > 20;

            margin_bottom = doc_height - (o.margin_bottom || 400) - win_height;

            if (need_bind) {
                if (bottom_position > 0) {
                    win.unbind("scroll", check2);
                    win.bind("scroll", check);
                    return check();
                } else {
                    win.unbind("scroll", check);
                    win.bind("scroll", check2);
                    return check2();
                }
            }
        });
        win.resize();
    }

    if (typeof module!="undefined" && module.exports ) {
        module.exports = FixedScrollContent;
    }
});
