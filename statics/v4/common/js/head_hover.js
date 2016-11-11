define('common/header_hover',['jquery'],function(require,exports,module){

    var $ = jquery = jQuery = require("jquery");
    var hoverApp =  $(".J_hover_app"),
        appDownPanel = $(".J_app_down");

    hoverApp.hover(function () {
        var self = $(this);
        self.find(".ty_sy").addClass("J_hoverdown");
        appDownPanel.show();
    },function (){
        var self = $(this);
        self.find(".ty_sy").removeClass("J_hoverdown");
        appDownPanel.hide();

    });
    $('.top-menu-box').hover(function() {
        $(this).find('.top-meun-list').length > 0 && $(this).addClass('top-menu-hover'),
        $(this).find('.top-meun-list').show();
    }, function() {
        $(this).removeClass('top-menu-hover');
        $(this).find('.top-meun-list').hide();
    });

});
