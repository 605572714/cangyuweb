
<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="dist/css/framework7-icons.css">
    <link rel="stylesheet" href="dist/css/framework7.ios.min.css">
    <!--<link rel="stylesheet" href="dist/css/framework7.material.min.css">-->
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/secKillList.css">

    <!-- Path to jquary Library JS-->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>

</head>

<body>

    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>
    <!--弹出发布页面-->
    <div class="popup popup-fabu">
        <div class="fabu_btn_list">
            <a class="qiujianding_btn"></a>
            <a class="fatiezi_btn"></a>
            <a class="woxiangmai_btn"></a>
        </div>
        <p class="popup_fabu_guanbi"><a href="#" class="close-popup"><i class="f7-icons">close</i></a></p>
    </div>

    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views">
        <div id="zhuanti_xiangqing" class="view">
            <div class="pages navbar-through">
                <div data-page="jianding_xiangqing" class="page">
                    <div class="page-content infinite-scroll" data-distance="100" style="padding-top:0px;">
                        <div class="cangyu_bbs_zhuanti">
                            <div class="car_mess_div2" style="background:#f7f7f7;padding:0px"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Tabbar-->
        <div class="cangyu_bbs_tabber">
            <a href="#" class="close"></a>
            <a href="#" id="btnOpenApp">
                <div class="logo"></div>
                <div class="banner-label">
                    <p class="tb" data-node="appName">下载APP</p>
                    <p class="title-sub">参与藏玉拍卖</p>
                </div>
                <div class="open">立即打开</div>
            </a>
        </div>
    </div>
    <script>
        $(".close").click(function () {
            $(".cangyu_bbs_tabber").hide();
        });
    </script>

    //列表模版
    <script type="text/html" id="car_mess_div_list2">
        <ul>
            <%for(var i = 0;i < list.length; i++){%>
            <div class="card_yanxuan">
                <a href="auction.php?item_id=<%=list[i].id%>" class="block-a">
                    <div class="card_zhuanti demo-card-header-pic">
                        <%if(list[i].album.length > 0){%>
                        <%if(list[i].album[0].file_path.indexOf('http')==-1){%>
                        <img src="https://app.icangyu.com<%=list[i].album[0].file_path%>" style='width:100%;'>
                        <%}else{%>
                        <img src="<%=list[i].album[0].file_path%>" style='width:100%;'>
                        <%}%>
                        <%}%>
                    </div>
                    <div class="card_yanxuan_txt">
                        <h2><%=list[i].title%></h2>
                        <p><%=list[i].content.substring(0,24)%>...</p>
                    </div>
                </a>
            </div>
            <%}%>

        </ul>
    </script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

    <script>
        wx.config({
            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。移动端会通过弹窗来提示相关信息。如果分享信息配置不正确的话，可以开了看对应报错信息
            appId: '<?php echo $signPackage["appId"]; ?>',
            timestamp: '<?php echo $signPackage["timestamp"]; ?>',
            nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
            signature: '<?php echo $signPackage["signature"]; ?>',
            jsApiList: [ //需要使用的JS接口列表,分享默认这几个，如果有其他的功能比如图片上传之类的，需要添加对应api进来
                'checkJsApi',
                'onMenuShareTimeline', //
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo'
            ]
        });
    </script>



    <script type="text/javascript" src="js/config.js"></script>
    <script>
        var square_id = HttpHelper.getQuery('screenings');
        var square_title = HttpHelper.getQuery('square_title');
        console.log(square_id);
        //拍品列表
        $.getJSON(`https://app.icangyu.com/icy/sale_list?screenings=${square_id}`, function (data) {
            console.log(data);
            var Odata = data.data;
            var html = template('car_mess_div_list2', Odata);
            $('.car_mess_div2').html(html);
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": square_title, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": '藏玉拍卖', //分享卡片标题
                    "link": window.location.href, //分享出去后的链接，这里可以将链接设置为另一个页面。
                    "success": function () { //分享成功后的回调函数
                    },
                    'cancel': function () {
                        // 用户取消分享后执行的回调函数
                    }
                }
            };
            wx.ready(function () {
                wx.onMenuShareAppMessage(share_config.share); //分享给好友
                wx.onMenuShareTimeline(share_config.share); //分享到朋友圈
                wx.onMenuShareQQ(share_config.share); //分享给手机QQ
            });
        });
        $("#btnOpenApp").click(function () {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCAuctionListVC',
                    'shareAndroid': 'icangyu.jade.activities.auction.AuctionSessionActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>

</body>

</html>