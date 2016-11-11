seajs.config({
    alias: {
        'jScrollPane': '/statics/v4/tw_acg/js/jscrollpane.js'
    }
}) 
define("comics_works",['jquery','jScrollPane'],function(require,exports,module){
    var  $ = jQuery = require('jquery');
    require('jScrollPane');
    //$('.chapter-ul').jScrollPane();
})
seajs.use("comics_works");