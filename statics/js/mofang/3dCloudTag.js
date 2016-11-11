;
$(function($) {
	$.fn.extend({
		cloudTag: function(config) {
			config = $.extend({
				distr: true,
				tspeed: 15,
				size: 10,
				howElliptical: 1,
				radius: 120,
                click:null
			}, config);
			var mcList = [],
				active = true,
				lasta = 1,
				lastb = 1,
				lastc = 0,
				duration = 16,
				current = 0,
				mouseX = 1,
				mouseY = 0,
				self = $(this),
				height = self.height(),
				width = self.width(),
				msin = Math.sin,
				mcos = Math.cos,
				mmax = Math.max,
				mmin = Math.min,
				mabs = Math.abs,
				mrandom = Math.random,
				macos = Math.acos,
				msqrt = Math.sqrt,
				PI = Math.PI,
				dtr = PI / 180,
				item = null,
				timer = null;
			var sinusoidal = function(current) {
				return -5 / 2 * (mcos(PI * current / 5) - 1) + 1;
			};
			var positionAll = function() {
				var phi = 0,
					theta = 0,
					len = mcList.length;
				for (var i = 1; i < len + 1; i++) {
					if (config.distr) {
						phi = macos(-1 + (2 * i - 1) / len);
						theta = msqrt(len * PI) * phi;
					} else {
						phi = mrandom * (PI);
						theta = mrandom * (2 * PI);
					}
					//坐标变换
					mcList[i - 1].cx = config.radius * mcos(theta) * msin(phi);
					mcList[i - 1].cy = config.radius * msin(theta) * msin(phi);
					mcList[i - 1].cz = config.radius * mcos(phi);
					mcList[i - 1].self.css({
						left: mcList[i - 1].cx + width / 2 - mcList[i - 1].width / 2 + 'px',
						top: mcList[i - 1].cy + height / 2 - mcList[i - 1].height / 2 + 'px'
					});
				}
			};
			var doPosition = function() {
				$.each(mcList, function(index, val) {
					var self = val.self,
						temp = {};
					temp.left = val.cx + width / 2 - val.width / 2 + 'px';
					//temp.top = val.cy + height / 2 - val.height / 2 + 'px';
					temp.top = val.cy + height / 2 - val.height / 2 + 'px';
					temp.filter = "alpha(opacity=" + 100 * val.alpha + ")";
					// temp['font-size'] = Math.ceil(12 * val.scale / 2) + 8 + 'px';
					temp.opacity = val.alpha;
					if (!self.data('pause')) {
						self.css(temp);
					}
				});
			};
			var update = function() {
				current = ++current % 5;
				//mouseX = sinusoidal(current);
				mouseY = sinusoidal(current);
				if (active) {
					lasta = (-mmin(mmax(-mouseY, -config.size), config.size) / config.radius) * config.tspeed;
					lastb = (mmin(mmax(-mouseX, -config.size), config.size) / config.radius) * config.tspeed;
				} else {
					lasta = lasta * 0.98;
					lastb = lastb * 0.98;
				}
				if (mabs(lasta) <= 0.01 && mabs(lastb) <= 0.01) {
					return;
				}
				var d = 200,
					sa = msin(lasta * dtr),
					ca = mcos(lasta * dtr),
					sb = msin(lastb * dtr),
					cb = mcos(lastb * dtr),
					sc = msin(lastc * dtr),
					cc = mcos(lastc * dtr),
					len = mcList.length;
				for (var j = 0; j < len; j++) {
					var rx1 = mcList[j].cx,
						ry1 = mcList[j].cy * ca + mcList[j].cz * (-sa),
						rz1 = mcList[j].cy * sa + mcList[j].cz * ca,
						rx2 = rx1 * cb + rz1 * sb,
						ry2 = ry1,
						rz2 = rx1 * (-sb) + rz1 * cb,
						rx3 = rx2 * cc + ry2 * (-sc),
						ry3 = rx2 * sc + ry2 * cc,
						rz3 = rz2;
					mcList[j].cx = rx3;
					mcList[j].cy = ry3;
					mcList[j].cz = rz3;
					per = d / (d + rz3);
					mcList[j].x = (config.howElliptical * rx3 * per) - (config.howElliptical * 2);
					mcList[j].y = ry3 * per;
					mcList[j].scale = per;
					mcList[j].alpha = per;
					mcList[j].alpha = (mcList[j].alpha - 0.6) * (10 / 6);
				}
				doPosition();
			};
			var init = function() {
                var color;
                self.css('position','relative');
				self.find('a').each(function() {
					var obj = {}, self = $(this);
					obj.width = self.width();
					obj.height = self.height();
					obj.self = self.data('pause', false);
					mcList.push(obj);
				});
                self.undelegate().delegate('a',{
						mouseover: function() {
                            color = $(this).css('color');
                            $(this).show().data('pause', true).css({
								filter: "alpha(opacity=100)",
								opacity: 1,
                                color:'#FFFFFF'
							});
						},
						mouseout: function() {
							$(this).data('pause', false).css('color',color);
						},
						click: function() {
							var self = $(this);
                            if($.isFunction(config.click)){
                                config.click(self);
                            }
						}
					});
				positionAll();
				setInterval(update, duration);
			}();
		}
	});
}(jQuery));
