var scrollLoad = {
    refreshTimer : null,
    init: function () {
        this.getInViewportList();
        this.scrollLoad();
    },
    scrollLoad : function () {
        var self = this;
        $(window).on('scroll', function () {
            if (self.refreshTimer) {
                clearTimeout(self.refreshTimer);
                self.refreshTimer = null;
            }
            self.refreshTimer = setTimeout(function () {
                self.getInViewportList();
            },1e3);
        });
    },
    belowthefold : function (element) {
        var fold = $(window).height() + $(window).scrollTop();
        return fold <= $(element).offset().top;
    },
    abovethetop : function (element) {
        var top = $(window).scrollTop();
        return top >= $(element).offset().top + $(element).height();
    },
    inViewport : function (element) {
        return !this.belowthefold(element) && !this.abovethetop(element)
    },
    getInViewportList : function () {
        var list = $('#thelist li'),
        ret = [],
        self = this;
        list.each(function (i) {
            var li = list.eq(i);
            if (self.inViewport(li)) {
            self.loadImg(li);
            }
        });
    },
    loadImg : function (li) {
        if (li.find('img[_src]').length) {
            var img = li.find('img[_src]'),
                src = img.attr('_src');
            img.attr('src', src).hide().fadeIn().load(function () {
                img.removeAttr('_src');
            });
        }
    }
};



