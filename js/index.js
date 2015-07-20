
getBgProperty = function () {
	var ratio = 1400 / 1000;
	var winW = $(window).width();
	var winH = $(window).height();
	var winRatio = winW / winH;
	var prop = {};
	prop.winW = winW;
	prop.winH = winH;
	console.log(ratio,winRatio)
	if (ratio < winRatio) {
		prop.h = winH;
		prop.w = winH * ratio;
		prop.top = 0
		prop.left = (winW - prop.w ) / 2;
	} else {
		prop.w = winW;
		prop.h = winW / ratio;

		prop.left = 0;
		prop.top = (winH - prop.h) / 2;
	}
	return prop;
};

function opening() {
	var bgProp = getBgProperty();

	console.debug(bgProp);
	$loading = $("#loading");
	$loading.hide();
	if($.cookie('showlogo')){
		window.location.href="./gallery3/";
	}else{
		var $opening = $('.opening');

		var $openimg = $('#openimg');
		$openimg.width(bgProp.w+"px").height(bgProp.h+"px");//.top(bgProp.top+"px");//.left(bgProp.left+"px");
		$opening.css("top",bgProp.top+"px").css("left",bgProp.left+"px");
		// $opening.height = bgProp.h;
		// $opening.top = bgProp.top;
		// $opening.left = bgProp.left;


		$opening.fadeIn(100, function () {
			setTimeout(function () {
				$opening.fadeOut(100,function(){
					$loading.hide();
					window.location.href="./gallery3/";
				});
			}, 3000);
		});
	}
}