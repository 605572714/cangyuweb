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

    <!-- Path to jquary Library JS-->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>
    <script type="text/javascript" src="js/weixinWeb.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <!-- //必加 -->

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
            <!--<div class="pages navbar-through">-->
            <div data-page="jianding_xiangqing" class="page">

                <!--<div class="navbar cangyu_bbs_top_tabber">-->
                <!--<div class="navbar-inner">-->
                <!--<div class="left sliding"></div>-->
                <!--<div class="center ">专题详情</div>-->
                <!--<div class="right">&lt;!&ndash;右侧按钮暂时隐藏&ndash;&gt;</div>-->
                <!--</div>-->
                <!--</div>-->

                <div class="page-content infinite-scroll pull-to-refresh-content" data-distance="100">

                    <div class="cangyu_bbs_zhuanti">
                        <div class="car_mess_div_top"></div>
                        <div class="car_mess_div_list" style='padding: 15px;'></div>
                    </div>

                </div>

            </div>
            <!--</div>-->
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

    <script type="text/html" id="topic_comm_list">
        <%for(var i = 0; i < list.length; i ++){%>
        <div class="comment-item">
            <div class="m-box comment-con-top">
                <div class="comment-user-img m-avatar-box">
                    <a href="#" class="m-img-box">
                        <%if(list[i].comment_avatar.indexOf('http')==-1){%>
                        <img src="https://app.icangyu.com<%=list[i].comment_avatar%>" alt="">
                        <%}else{%>
                        <img src="<%=list[i].comment_avatar%>" alt="">
                        <%}%>
                    </a>
                </div>
                <div class="m-box-col">
                    <p class="comment-user-name"><span><%=list[i].nickname%></span></p>
                </div>

            </div>
            <div class="comment-con-bot">
                <div class="comment-con">
                    <div><%=list[i].comment%></div>
                </div>
            </div>
        </div>

        <%}%>
    </script>
    <script type="text/html" id="topic_top">
        <div class="title" style='padding:20px 0px 0px 15px;font-size:20px;'>
            <%=title%>
        </div>
    </script>

    <script type="text/javascript" src="js/config.js"></script>
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
        var square_id = HttpHelper.getQuery('item_id');
        var type = HttpHelper.getQuery('type');

        // 专题详情
        $.getJSON(`${CYHOST}/icyApi/details_topic?id=${square_id}`, function (data) {
            console.log(data);
            var Odata = data.data;
            $('.car_mess_div_list').html(Odata[0].custom_page);
            var html = template('topic_top', Odata[0]);
            $('.car_mess_div_top').html(html);
            document.title = Odata[0].title;

            var tit = Odata[0].title;
            var des = Odata[0].content;
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": des, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": tit, //分享卡片标题
                    "link": window.location.href, //分享出去后的链接，这里可以将链接设置为另一个页面。
                    "success": function () {
                        //分享成功后的回调函数
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
                    'shareIOS': 'KCTopicMessVC',
                    'shareAndroid': 'icangyu.jade.activities.articles.ArticleActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>


</body>

</html>