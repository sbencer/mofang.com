seajs.use(['jquery'],function($){

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
    });

    $('.top-menu-box').hover(function() {
        $(this).find('.top-meun-list').length > 0 && $(this).addClass('top-menu-hover'),
        $(this).find('.top-meun-list').show();
    }, function() {
        $(this).removeClass('top-menu-hover');
        $(this).find('.top-meun-list').hide();
    });
})
