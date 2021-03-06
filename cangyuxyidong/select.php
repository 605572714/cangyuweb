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
    <link rel="stylesheet" href="css/secKillDetail.css">

    <!-- Path to jquary Library JS-->
    <script type="text/javascript" src="js/weixinWeb.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <script type="text/javascript" src="js/store.everything.min.js"></script>
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
        <p class="popup_fabu_guanbi">
            <a href="#" class="close-popup">
                <i class="f7-icons">close</i>
            </a>
        </p>
    </div>

    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views">
        <div class="pages navbar-through ">
            <div data-page="jianding_xiangqing" class="page no-navbar">
                <div class="navbar cangyu_bbs_top_tabber_yx">
                    <div class="navbar-inner">
                        <div class="left sliding"></div>
                        <div class="right">
                            <!--右侧按钮暂时隐藏-->
                        </div>
                    </div>
                </div>
                <div class="page-content ">
                    <div class="strict_mess_div"></div>
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
                    <p class="title-sub">参与藏玉严选交易</p>
                </div>
                <div class="open">立即打开</div>
            </a>
        </div>


    </div>

    <script>
        $(".close").click(function() {
            $(".cangyu_bbs_tabber").hide();
        });
    </script>



    <script type="text/html" id="strict_mess">
        <div style='background:#fff;'>
            <div class="header">
                <div class="swiper-container swiper-5 yanxuan-lunbo">
                    <div class="swiper-wrapper">
                        <%for(var k = 0; k < data.album.length; k ++){%>
                        <div class="swiper-slide">
                            <a onclick="showPhoto('<%=convert_to_string(data.album)%>','<%=k%>')">
                                <%if(data.album[k].file_path.indexOf('http')==-1){%>
                                <img src="https://app.icangyu.com<%=data.album[k].file_path%>" class="swiper-lazy" />
                                <%}else{%>
                                <img src="<%=data.album[k].file_path%>" class="swiper-lazy" />
                                <%}%>
                            </a>
                            <div class="preloader"></div>
                        </div>
                        <%}%>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div style='display:block'>
                        <div class="header_title"><%=data.pro_name%></div>
                        <div class="header_price">￥<%=data.pro_price%></div>
                    </div>
                </div>
                <div class="paipin_shuju">
                    <div class="paimai_shuju_xhx">
                        <span>材质:</span>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <%=data.material%>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <span>白度:</span>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <%=data.white%>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <span>细度:</span>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <%=data.fineness%>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <span>润度:</span>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <%=data.run%>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <span>重量:</span>
                    </div>
                    <div class="paimai_shuju_xhx">
                        <%=data.weight%>
                    </div>
                </div>
                <div class='black'></div>
                <div class="card-content content">
                    <div class="card-content-inner">
                        <h2 class="card-content-yylm-t content_title">产品详情</h2>
                        <h3 class="card-content-yylm-t content_detail"><%=data.pro_descript%></h3>
                    </div>
                </div>
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
        var detailsData = {};
        var myApp = new Framework7({
            router: false,
            swipePanel: 'left'
        });

        // //严选详情
        $.getJSON(`${CYHOST}/icyApi/share_product?id=${square_id}`, function(data) {

            detailsData = data;
            store.set('order_details', JSON.stringify(detailsData.data));

            console.log(data);

            var html = template('strict_mess', data);
            $('.strict_mess_div').html(html);

            if (data.data.collect_yn === 'y') {
                $('#isCollection').addClass('yanxuan_active');
            }



            var shareContent = data.data.pro_descript;

            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": shareContent, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": '藏玉严选', //分享卡片标题
                    "link": window.location.href, //分享出去后的链接，这里可以将链接设置为另一个页面。
                    "success": function() { //分享成功后的回调函数
                    },
                    'cancel': function() {
                        // 用户取消分享后执行的回调函数
                    }
                }
            };
            wx.ready(function() {
                wx.onMenuShareAppMessage(share_config.share); //分享给好友
                wx.onMenuShareTimeline(share_config.share); //分享到朋友圈
                wx.onMenuShareQQ(share_config.share); //分享给手机QQ
            });





            setTimeout(function() {
                myApp.swiper('.yanxuan-lunbo', {
                    pagination: '.yanxuan-lunbo .swiper-pagination',
                    preloadImages: false,
                    lazyLoading: true,
                    spaceBetween: 60,
                    observer: true, //修改swiper自己或子元素时，自动初始化swiper
                    observeParents: true, //修改swiper的父元素时，自动初始化swiper
                    autoplay: 3000,
                    autoplayDisableOnInteraction: false,
                    touchRatio: 1
                });
            }, 1500);
        })
    </script>


    <script>
        template.helper('convert_to_string', function(album) {
            var arr = [];
            for (var i = 0; i < album.length; i++) {
                arr.push('https://app.icangyu.com' + album[i].file_path);
            }
            return arr.join(';');
        });

        function showPhoto(images, k) {

            var arr = images.split(';');
            var myPhotoBrowserPopupDark = myApp.photoBrowser({
                photos: arr,
                theme: 'dark',
                initialSlide: k,
                type: 'standalone'
            });
            myPhotoBrowserPopupDark.open();

        }
    </script>
    <script>
        $("#btnOpenApp").click(function() {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCStrictMessVC',
                    'shareAndroid': 'icangyu.jade.activities.select.SelectDetailsActiity'
                }
            }];
            new JMLink(configs);
        });
    </script>
</body>

</html>