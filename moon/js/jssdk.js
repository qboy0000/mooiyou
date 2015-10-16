//var descContent='';
//var lineLink='';
//var imgUrl='';

    var sharetitle='一份特别的中秋礼物，等待接收！';
    var descContent='一份特别的中秋礼物，等待接收！';
    var lineLink='http://www.lmooie.cn/moonFestivals/';
    var imgUrl='http://www.lmooie.cn/moonFestivals/img/shareImg.jpg';

$(function(){   
    // var url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx5f5f01b1f7070a7e&secret=878b3c31a537b96faf3295f190f54732";
    // var url = "http://query.yahooapis.com/v1/public/yql?q=select%20title%2C%20link%20from%20rss%20where%20url%3D%22http%3A%2F%2Fwww.nytimes.com%2Fservices%2Fxml%2Frss%2Fnyt%2FHomePage.xml%22&format=json&callback=?";
    // jQuery.getJSON(url,function(data){
    //     alert(data);
    // })
    var url = "http://www.lmooie.cn/moon/jssdk.php?url="+escape(window.location.href)
    $.ajax({
        type:"GET",
        url:url,
        async:true,
        success:function(data){
            var json = JSON.parse(data);
            var wxdata = {
                debug: true,
                appId: json.appId,
                timestamp: json.timestamp,
                nonceStr: json.nonceStr,
                signature: json.signature,
                    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage']
                };
                console.log(wxdata)
            wx.config(wxdata);

            wx.ready(function () {
                wx.onMenuShareTimeline({
                    title: descContent, 
                    link: lineLink, 
                    imgUrl: imgUrl, 
                    success: function () { 
                        alert("success");
                    },
                    cancel: function () { 
                        alert("cancel");
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
            wx.error(function(res){
                alert(res);
    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

            });
        },
        error:function(err,a,b,c,d){
            debugger;
        }
    })


});

// var jssdk={"appId":"wx5f5f01b1f7070a7e","nonceStr":"5LIPXQ4mtpmXTRPU","timestamp":1444666225,"url":"http:\/\/www.lmooie.cn\/moon\/index.html","signature":"1b0c8fa376fac9ef61b2dd1ecb7c7285f248a7ec","rawString":"jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VD3BTyYNLaNcsV9ON7kgnbQLTC3GSoJztEVSG73K4_XzzRg4SEwV3-JvGJl696AMaQ&noncestr=5LIPXQ4mtpmXTRPU&timestamp=1444666225&url=http:\/\/www.lmooie.cn\/moon\/index.html"}

// wx.config({
// //debug: true,
// appId: jssdk.appId,
// timestamp: jssdk.timestamp,
// nonceStr: jssdk.noncestr,
// signature: jssdk.signature,
//     jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','chooseImage','previewImage','uploadImage','downloadImage']
// });

// wx.ready(function () {
//     wx.onMenuShareTimeline({
//         title: descContent, 
//         link: lineLink, 
//         imgUrl: imgUrl, 
//         success: function () { 
           
//         },
//         cancel: function () { 
            
//         }
//     });

//     wx.onMenuShareAppMessage({
//         title: sharetitle, 
//         desc: descContent,
//         link: lineLink, 
//         imgUrl: imgUrl,
//         type: 'link', 
//         dataUrl: '', 
//         success: function () { 
//         },
//         cancel: function () { 
//         }
//     });

// });

