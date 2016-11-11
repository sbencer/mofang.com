define('common/head_video',['jquery'],function(require,exports,module){

    var $ = jquery = jQuery = require("jquery");
    var hoverApp =  $(".J_hover_app"),
        appDownPanel = $(".J_app_down");
        
    hoverApp.hover(function () {
        var self = $(this);
        self.find("h2").addClass("J_hoverdown");
        appDownPanel.show();
    },function (){
        var self = $(this);
        self.find("h2").removeClass("J_hoverdown");
        appDownPanel.hide();

    })
})