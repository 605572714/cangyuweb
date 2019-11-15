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
    <title>藏玉秒杀</title>
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

            <div data-page="jianding_xiangqing" class="page">

                <div class="page-content infinite-scroll" data-distance="100">
                    <div class="cangyu_bbs_zhuanti secpage">
                        <div class="car_mess_div3"></div>
                    </div>

                </div>

            </div>

        </div>



        <!-- Bottom Tabbar-->
        <div class="cangyu_bbs_tabber">
            <a href="javascript:void(0)" class="close"></a>
            <a id="btnOpenApp">
                <div class="logo"></div>
                <div class="banner-label">
                    <p class="tb" data-node="appName">下载APP</p>
                    <p class="title-sub">了解最新业内资讯</p>
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
        <div class='header_title'><%=header.screenings_des%>·<%=header.total%>件商品</div>
    </script>

    <script type="text/html" id="car_mess_div_list3">
        <%for(var i = 0; i < list.length; i ++){%>
        <div class="list">
            <a href="secKill.php?item_id=<%=list[i].id%>" class="block-a">
                <%if(list[i].pic_url.indexOf('http')==-1){%>
                <img src="https://app.icangyu.com<%=list[i].pic_url%>">
                <%}else{%>
                <img src="<%=list[i].pic_url%>">
                <%}%>
                <div class="bottom">
                    <div class="list_title"><%=list[i].content%></div>
        <div class='list_price'>&nbsp;￥<%=list[i].price%></div>
        </div>

        </a>
        </div>
        <%}%>
    </script>

    <script type="text/javascript" src="js/config.js"></script>

    <script>
        var square_id = HttpHelper.getQuery('item_id');
        if(!square_id){
            square_id = HttpHelper.getQuery('screenings');
        }
        //拍品列表
        $.getJSON(`https://app.icangyu.com/icyApi/spike_list?id=${square_id}`, function (data) {
            console.log(data);
            var Odata = data.data;
            var html3 = template('car_mess_div_list3', Odata);
            var html2 = template('car_mess_div_list2', Odata);
            $('.car_mess_div3').html(html3);
            $('.car_mess_div2').html(html2);


            var share_title = Odata.header.screenings_des;
            var share_content = Odata.header.content;

            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": share_content, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": share_title, //分享卡片标题
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
    <script>
        $("#btnOpenApp").click(function () {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCSecKillListVC',
                    'shareAndroid': 'icangyu.jade.activities.seckill.SecKillSessionActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>

</body>

</html>