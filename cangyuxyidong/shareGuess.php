
<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
//print_r($signPackage);
//echo "xx";
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <title>藏玉</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="dist/css/framework7-icons.css">
    <link rel="stylesheet" href="dist/css/framework7.ios.min.css">
    <!--<link rel="stylesheet" href="dist/css/framework7.material.min.css">-->
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <!-- Path to jquary Library JS-->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>
</head>

<body>

<!-- Status bar overlay for fullscreen mode-->
<div class="statusbar-overlay"></div>
<!-- Panels overlay-->
<div class="panel-overlay"></div>

<!-- Views, and they are tabs-->
<!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
<div class="views">
    <div id="maimai_xiangqing" class="view">
        <div class="pages">
            <div data-page="jianding_xiangqing" class="page">

                <div class="page-content infinite-scroll" data-distance="100">

                    <div class="card facebook-card">
                        <div class="buy_mess_div"></div>
                    </div>


                    <div class="cangyu_bbs_comment">
                        <div class="buy_comm_div_list"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Bottom Tabbar-->
    <div class="cangyu_bbs_tabber">
        <a href="javascript:void(0)" class="close"></a>
        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" target="_self" class="download" rel="nofollow">
            <div class="logo"></div>
            <div class="banner-label">
                <p class="tb" data-node="appName">下载APP</p>
                <p class="title-sub">参与藏玉猜价格</p>
            </div>
            <div class="open">立即打开</div>
        </a>
    </div>


</div>


<script type="text/javascript" src="js/config.js"></script>

<script>

    $(".close").click(function(){
        $(".cangyu_bbs_tabber").hide();
    });

</script>


<script type="text/html" id="buy_mess">

    <div class="paipin_shuju">

        <%for(var i = 0; i < list.attributes.length; i ++){%>

            <div class="paimai_shuju_xhx">
                <span><%=list.attributes[i].title%>:</span>
            </div>

            <div class="paimai_shuju_xhx">
                <%=list.attributes[i].value%>
            </div>

        <%}%>

    </div>

    <div class="card-content">

            <div class="card-content-inner">

                <h2 class="card-content-yylm-t">产品详情</h2>
                <h3 class="card-content-yylm-t"><%=list.content%></h3>
                <div class="maimai_xq_img">

                    <%for(var k = 0; k < list.album.length; k ++){%>

                        <a onclick="showPhoto('<%=convert_to_string(list.album)%>','<%=k%>')">
                            <img src="https://app.icangyu.com<%=list.album[k].file_path%>"alt=""/>
                        </a>

                    <%}%>

                </div>
            </div>

    </div>


</script>


<script>

    var square_id = HttpHelper.getQuery('item_id');

    //产品详情
    $.getJSON(`${CYHOST}/icyApi/guess_details?id=${square_id}`, function (data) {

        console.log(data);
        var Odata = data.data;
        var html = template('buy_mess',Odata);
        $('.buy_mess_div').html(html);

       var shareContent = Odata.list.content;

       var shareTitle = Odata.list.title;

        window.share_config = {
             "share": {
                "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                "desc" : shareContent,//摘要,如果分享到朋友圈的话，不显示摘要。
                "title" : shareTitle,//分享卡片标题
                "link": window.location.href,//分享出去后的链接，这里可以将链接设置为另一个页面。
                "success":function(){//分享成功后的回调函数
                },
                'cancel': function () {
                    // 用户取消分享后执行的回调函数
                }
            }
        };
            wx.ready(function () {
            wx.onMenuShareAppMessage(share_config.share);//分享给好友
            wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
            wx.onMenuShareQQ(share_config.share);//分享给手机QQ
        });



    })


    // Initialize your app
    var maimaiApp = new Framework7({
        router: false,
        swipePanel: 'left',
        // ... other parameters
    });

</script>



<script>


    template.helper('convert_to_string', function(album){
        var arr = [];
        for(var i = 0; i < album.length; i++){
            arr.push('https://app.icangyu.com'+album[i].file_path);
        }
        return arr.join(';');
    });

    function showPhoto(images,k) {

        var arr = images.split(';');
        var myPhotoBrowserPopupDark = maimaiApp.photoBrowser({
            photos : arr,
            theme: 'dark',
            initialSlide:k,
            type: 'standalone'
        });
        myPhotoBrowserPopupDark.open();

    }

</script>



<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
    wx.config({
        debug: false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。移动端会通过弹窗来提示相关信息。如果分享信息配置不正确的话，可以开了看对应报错信息
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [//需要使用的JS接口列表,分享默认这几个，如果有其他的功能比如图片上传之类的，需要添加对应api进来
            'checkJsApi',
            'onMenuShareTimeline',//
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
        ]
    });
</script>

<script>


</script>


</body>
</html>