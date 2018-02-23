"use strict";

var ihjs = function ihjs() {

	this.dialogAlert = function (a, b, c) {
		if (a) {
			$(".ih-dialog__title").html(a);
		}

		$(".ih-dialog__bd").html(b);
		var $dialogBox = $(".ih-dialog__box");
		$dialogBox.addClass("mask-active");

		$(".ih-btn__box").off("click", ".ih-dialog__ok").on("click", ".ih-dialog__ok", function () {
			// 回调函数
			if (!!c) {
				if (typeof c === "function") {
					c();
					$dialogBox.removeClass("mask-active");
				} else {
					$dialogBox.removeClass("mask-active");
					console.log("兄弟我是让你传执行方法的");
				}
			} else {
				$dialogBox.removeClass("mask-active");
			}
		}).off("click", ".ih-dialog__not").on("click", ".ih-dialog__not", function () {
			$dialogBox.removeClass("mask-active");
		});
	};

	this.showHidemask = function () {
		// 蒙层显示隐藏
		var $dialogBox = $(".ih-dialog__box");
		$dialogBox.removeClass("mask-active");
		$dialogBox.addClass("mask-active");
		$dialogBox.off("click").on("click", function () {
			$(this).removeClass("mask-active");
		});
	};

	this.handleHref = function () {
		$(".ih-href").off("click").on("click", function () {
			if (!!$(this).data("href")) {
				location.href = $(this).data("href");
			}
		});
	};

	this.handleScore = function () {
		// 点击评分
		$(".mark-item").on("click", function () {
			var _self = $(this);
			var thisMark = $(this).parent(".mark");
			var thisItem = thisMark.find(".mark-item");
			thisItem.removeClass("mark-active");
			thisMark.data("item", _self.index() + 1);
			for (var i = 0; i <= _self.index(); i++) {
				if (!thisItem.eq(i).hasClass("mark-active")) {
					thisItem.eq(i).addClass("mark-active");
				}
			}
		});
	};

	this.handleDropdown = function () {
		$(".ih-dropdown").off("click").on("click", function (e) {
			e.stopPropagation();
			var _self = $(this);

			if (_self.hasClass("dropdown-active")) {
				_self.removeClass("dropdown-active");
			} else {
				$(".ih-dropdown").removeClass("dropdown-active");
				_self.addClass("dropdown-active");
			}
		});

		$(".ih-dropdown").off("click", ".ih-dropdown__item").on("click", ".ih-dropdown__item", function (e) {
			e.stopPropagation();
			var _self = $(this);
			var thisText = _self.parents(".ih-dropdown").find(".ih-dropdown__text");
			thisText.html(_self.html());
			thisText.data("item", _self.data("item"));
		});

		$("body").off("click").on("click", function (e) {
			e.stopPropagation();
			$(".ih-dropdown").removeClass("dropdown-active");
		});
	};

	this.init = function () {
		this.handleHref(); // 非a标签, 页面跳转
		this.handleScore(); // 星星评分
		this.handleDropdown(); // 下拉列表
	};
};

var ih = new ihjs();
ih.init();


Date.prototype.format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}