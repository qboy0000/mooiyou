//var descContent='';
//var lineLink='';
//var imgUrl='';

    var sharetitle='一份特别的中秋礼物，等待接收！';
    var descContent='一份特别的中秋礼物，等待接收！';
    var lineLink='http://www.lmooie.cn/moonFestivals/';
    var imgUrl='http://www.lmooie.cn/moonFestivals/img/shareImg.jpg';

wx.config({
//debug: true,
appId: '',
timestamp: '',
nonceStr: '',
signature: '',
    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','chooseImage','previewImage','uploadImage','downloadImage']
});

wx.ready(function () {
    wx.onMenuShareTimeline({
        title: descContent, 
        link: lineLink, 
        imgUrl: imgUrl, 
        success: function () { 
           
        },
        cancel: function () { 
            
        }
    });

    wx.onMenuShareAppMessage({
        title: sharetitle, 
        desc: descContent,
        link: lineLink, 
        imgUrl: imgUrl,
        type: 'link', 
        dataUrl: '', 
        success: function () { 
        },
        cancel: function () { 
        }
    });

});

