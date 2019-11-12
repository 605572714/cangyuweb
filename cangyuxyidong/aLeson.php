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
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉课程</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="dist/css/framework7-icons.css">
    <link rel="stylesheet" href="dist/css/framework7.ios.min.css">
    <!--<link rel="stylesheet" href="dist/css/framework7.material.min.css">-->
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/aLeson.css">
    <link rel="stylesheet" href="css/jade.css">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
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
            <div class="pages">
                <div data-page="jianding_xiangqing" class="page">
                    <!-- <div class="navbar cangyu_bbs_top_tabber">
                        <div class="navbar-inner">
                            <div class="center ">课程详情</div>
                        </div>
                    </div> -->
                    <div class="page-content infinite-scroll" data-distance="100">
                        <div class="card facebook-card">
                            <div class="buy_mess_div"></div>
                        </div>
                        <div class="leson_tab">
                            <div style="display: inline-block;width:50%;text-align:center;" class="" id="jianjie">
                                <div style="color:#bc2e2e;border-bottom:none; width:50px;line-height:50px; margin:0 auto;"
                                    class="unselect" id="chick1" onclick="aaa()">简介</div>
                            </div>
                            <div style="display: inline-block;width:50%;text-align:center;" class="" id="mulu">
                                <div style="color:#6b6b6b; border-bottom:2px; width:50px;line-height:50px; margin:0 auto;"
                                    class="unselect" id="chick2" onclick="bbb()">目录</div>
                            </div>
                        </div>



                        <div class="card facebook-card" id="div1">
                            <div class="buy_mess_div2"></div>
                        </div>

                        <div class="cangyu_bbs_comment" id="div2" style="display: none;">
                            <div class="buy_comm_div_list"></div>
                        </div>

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

    <script type="text/javascript" src="js/config.js"></script>

    <script>
        $(".close").click(function () {
            $(".cangyu_bbs_tabber").hide();
        });
    </script>



    <script type="text/html" id="buy_mess">
        <div class="paipin_shuju">

            <div>
                <!-- <img src="<%=data.video_cover%>" style="width:100%;"> -->
                <video src="<%=data.video_url%>" controls='controls' poster="<%=data.video_cover%>"
                    style="width:100%;"></video>
            </div>

            <div style="margin:10px 12px;">
                <div style="font-size:16px;color:#383838;"><%=data.title%></div>
            </div>

            <%if(data.price <= 0){%>
            <div style="display:inline-block;font-size:25px;font-weight:bold;"><span
                    style="margin:0 12px 12px; color: #b61616;">免费</span></div>
            <%}else{%>
            <div style="display:inline-block;font-size:25px;font-weight:bold;"><span
                    style="margin:0 12px 12px; color: #b61616;"><%=data.price%></span></div>
            <%}%>

            <div style="display:inline-block; text-decoration:line-through;line-height:25px; text-align:center;color:#ddd; font-size:12px;"><%=data.price_original%>
        </div>

        </div>
    </script>



    <script type="text/html" id="buy_mess2">
        <div class="card-content" style="display:block;">

            <div class="card-content-inner">
                <h2 class="card-content-yylm-t" style="margin:10px 0;font-weight: bold;padding-top: 20px">老师简介</h2>
                <img src="<%=data.lector_avatar%>"
                    style="width: 40px;height: 40px;margin:0 auto;display:block;border-radius: 20px;">
                <h3 style="text-align:center;margin: 20px;"><%=data.lector_name%></h3>
                <h3 class="card-content-yylm-t" style="text-indent: 2em;"><%=data.lector_des%></h3>
            </div>

            <div class="card-content-inner">
                <h2 class="card-content-yylm-t" style="margin:10px 0;font-weight: bold;">课程简介</h2>
                <h3 class="card-content-yylm-t" style="text-indent: 2em;"><%=data.course_content%></h3>
            </div>

            <div style="height: 50px"></div>

        </div>
    </script>



    <script type="text/html" id="buy_comm_list">
        <div class="cangyu_bbs_comment">

            <div class="buy_comm_div_list">


                <%for(var i = 0; i < list.length; i ++){%>

                <div class="comment-item" onclick="playAction(<%=i%>)">
                    <div class="m-box comment-con-top">

                        <div class="index-num"
                            style="color:#6b6b6b; font-size:15px;width:37px;height:49px;text-align:center;line-height:49px;">
                            <%=i+1%></div>
                        <div class="index-num">
                            <p><span class=""><%=list[i].title%></span></p>
                        </div>

                    </div>

                </div>

                <%}%>


            </div>

        </div>
    </script>


    <script>
        var square_id = HttpHelper.getQuery('item_id');
        //课程详情
        $.getJSON(`${CYHOST}/icyApiCourse/courseDetails?id=${square_id}`, function (data) {
            console.log(data);
            var Odata = data;
            var html = template('buy_mess', Odata);
            $('.buy_mess_div').html(html);
            var html = template('buy_mess2', Odata);
            $('.buy_mess_div2').html(html);
            var shareTitle = Odata.title
            var shareContent = Odata.course_content
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": shareContent, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": shareTitle, //分享卡片标题
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
        })
        //课节列表
        $.getJSON(`${CYHOST}/icyApiCourse/courseList?id=${square_id}`, function (data) {

            console.log(data);
            var Odata = data.data;
            var html = template('buy_comm_list', Odata);
            $('.buy_comm_div_list').html(html);
        })
        // Initialize your app
        var maimaiApp = new Framework7({
            router: false,
            swipePanel: 'left',
            // ... other parameters
        });


        var div1 = document.getElementById("div1");
        var chick1 = document.getElementById('chick1')
        var div2 = document.getElementById("div2");
        var chick2 = document.getElementById('chick2')


        function aaa() {
            div1.style.display = "block";
            chick1.style.color = '#bc2e2e';
            div2.style.display = "none";
            chick2.style.color = '#6b6b6b';

        }

        function bbb() {
            div2.style.display = "block";
            chick2.style.color = '#bc2e2e';
            div1.style.display = "none";
            chick1.style.color = '#6b6b6b';


        }

        function playAction(argument) {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCLessonDetailVC',
                    'shareAndroid': 'icangyu.jade.activities.course.CourseDetailsActivity'
                }
            }];
            new JMLink(configs);
        }
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
                    'shareIOS': 'KCLessonDetailVC',
                    'shareAndroid': 'icangyu.jade.activities.course.CourseDetailsActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>

</body>

</html>