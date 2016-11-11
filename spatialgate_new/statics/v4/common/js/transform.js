define("Transform",['jquery'],function(require, exports, module) {
        function Transform(settings) {
            settings = settings || {};

            this.settings_ = settings;
            this.from_ = settings.from;
            this.to_ = settings.to;
            this.transform_ = this.transformLow_;
            this.transform_ = this.transformHigh_;
        }
        Transform.prototype.transformLow_ = function() {
            this.from_.hide();
        };
        Transform.prototype.transformHigh_ = function() {
            var f = this.from_;

            var t = this.to_;

            var sx = t.outerWidth() / f.outerWidth();
            var sy = t.outerHeight() / f.outerHeight();
            var tx = (t.offset().left - f.offset().left);
            var ty = (t.offset().top - f.offset().top);
            var transforms = [
                'scale(' + sx + ',' + sy + ')',
                'translate(' + tx + 'px,' + ty + 'px)'
            ];
            var str = transforms.join(" ");
            //this.from_.animate({transform: str});

            f.css({
                overflow: "hidden"
            });
            var w = t.outerWidth();
            var h = t.outerHeight();
            w = 0;
            h = 0;
            var l = f.position().left + tx;
            var to = f.position().top + ty;
            l = l + t.outerWidth() / 2;
            to = to + t.outerHeight() / 2;

            f.animate({
                width: w,
                height: h,
                left: l,
                top: to
            });
        };
        Transform.prototype.load = function() {
            return true;
            /// todo:
            if (this.loading_) {
                return false;
            };
            var self = this;
            this.loading_ = true;
            seajs.use(["jquery/transform2d"], function(transform) {
                self.transform_ = self.transformHigh_;
                self.loading_ = false;
            });
            return true;
        };
        Transform.prototype.setFrom = function(from) {
            this.from_ = from;
        };
        Transform.prototype.setTo = function(to) {
            this.to_ = to;
        };
        Transform.prototype.play = function() {
            if (!this.from_ || !this.to_) {
                throw new Error('to parm error.');
            };
            this.transform_();
        };

    if (typeof module != "undefined" && module.exports) {
        module.exports = Transform;
    }

})

