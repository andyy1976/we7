"use strict";

;(function ($) {
	var Main = {
		init: function init() {
			$(".info__dt").show();
			Main.handlTouchNav(".message-nav__item");
			Main.handlTouchNav(".nav-item");
		},
		handlTouchNav: function handlTouchNav(a) {
			var $this = $(a);
			if ($this.hasClass("nav-active")) {
				var _nav = $(".nav-active").data("nav");
				$(".info__" + _nav).show();
			}

			$this.on("tap", function () {
				var _self = $(this);
				$this.removeClass("nav-active");
				_self.addClass("nav-active");
				var _nav = _self.data("nav");
				$(".message-info").hide();
				$(".info__" + _nav).show();
			});
		}
	};

	Main.init();
})(Zepto);