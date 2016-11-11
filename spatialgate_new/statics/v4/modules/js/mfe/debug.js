define("mfe/debug",[],function(require, exports, module){

    var debug = {};


    /**
     * 打印信息到控制台
     * @param  {[type]} msg  消息内容
     * @param  {[type]} type 输出方式 log error warn
     */
    debug.log = function(msg, type) {

        window.console &&
        // Do NOT print `log(msg)` in non-debug mode
        (type || seajs.debug) &&
        // Set the default value of type
        (console[type || (type = "log")]) &&
        // Call native method of console
        console[type](msg)
    }

    /**
     * 打印当前window对象上用户自定义的环境环境变量
     * @return {[type]} [description]
     */
    debug.logGlobal = function logGlobal(){

        function getIframe() {
            var el = document.createElement('iframe');
            el.style.display = 'none';
            document.body.appendChild(el);
            var win = el.contentWindow;
            document.body.removeChild(el);
            return win;
        }

        function detectGlobals() {
            var iframe = getIframe();
            var ret = Object.create(null);
            for (var prop in window) {
                if (!(prop in iframe)) {
                    ret[prop] = window[prop];
                }
            }
            return ret;
        }
        debug.log(detectGlobals());

    }


    if (typeof module!="undefined" && module.exports ) {
        module.exports = debug;
    }

});
