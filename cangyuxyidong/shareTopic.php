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
    <title>藏玉</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="dist/css/framework7-icons.css">
    <link rel="stylesheet" href="dist/css/framework7.ios.min.css">
    <!--<link rel="stylesheet" href="dist/css/framework7.material.min.css">-->

    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/appraisal.css">


    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>

    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <script type="text/javascript" src="js/weixinWeb.js"></script>
    <!-- Path to your app js-->
    <!--<script type="text/javascript" src="js/my-app.js"></script>-->
</head>


<body>
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>

    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views">
        <div id="huati_xiangqing" class="view">
            <div class="pages ">
                <div data-page="jianding_xiangqing" class="page no-navbar">



                    <div class="page-content cangyu_bbs_padding_bottom40 infinite-scroll" style="margin-top:0;"
                        data-distance="100">

                        <div class="vux-masker-box cangyu_bbs_huati_top">
                            <div class="m-img">
                            </div>
                            <div class="vux-masker" style="background-color: rgba(0, 0, 0, 0.498039);">
                                <!--201608002这个下面是新加的销售展示样式-->
                                <div class="goumailianjie-xianshi"></div>
                                <div slot="content" class="m-title"> <br>

                                </div>
                            </div>
                        </div>

                        <div class="cangyu_bbs_huati_txt" style="margin-bottom:0px">
                            <p style="text-align:center;">
                                
                            </p>
                        </div>

                        <div id="topic_list"></div>
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
                    <p class="tb" data-node="appName">下载藏玉APP</p>
                    <p class="title-sub">参与互动讨论，获取更多内容</p>
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



    <script type="text/html" id="topic_detail_list">
        <div class='total_support'>
            参与讨论(<%=total%>)
        </div>
        <%for(var i = 0;i < list.length; i++){%>
        <div class="card facebook-card ">
            <div class="card-header">
                <div class="facebook-avatar">
                    <a href="wode_index.html?user_id=<%=list[i].user_id%>">
                        <%if(list[i].avatar.indexOf('http')==-1){%>
                        <img src="https://app.icangyu.com<%=list[i].avatar%>" width="34" height="34">
                        <%}else{%>
                        <img src="<%=list[i].avatar%>" width="34" height="34">
                        <%}%>
                    </a>
                </div>
                <div class="facebook-name">
                    <a href="wode_index.html?user_id=<%=list[i].user_id%>"><%=list[i].nickname%></a>
                    <%if(list[i].rating>8){%>
                    <span class="cangyu_bbs_dengji" style='background:#fbdd6c;'>Lv<%=list[i].rating%></span>
                    <%}else {%>
                    <span class="cangyu_bbs_dengji">Lv<%=list[i].rating%></span>
                    <%}%>

            </div>
            <div class="facebook-date"><%=list[i].createdate%></div>

            </div>

            <div class="card-content">
                <a href="note.php?type=1&item_id=<%=list[i].id%>" class="block-a">

                    <div class="card-content-inner">
                        <h3 class="card-content-yylm-t"><%=list[i].content%></h3>
                        <div class="weibo-detail">
                            <div class="media-pic-list">
                                <ul style="overflow:hidden">
                                    <%for(var k = 0; k < list[i].album.length; k++){%>
                                    <li>
                                        <%if(list[i].album[k].file_path.indexOf('http')==-1){%>
                                        <img data-node="pic" data-act-type="hover"
                                            src="https://app.icangyu.com<%=list[i].album[k].file_path%>" class="loaded">
                                        <%}else{%>
                                        <img data-node="pic" data-act-type="hover" src="<%=list[i].album[k].file_path%>"
                                            class="loaded">
                                        <%}%>
                                    
                                    </li>
                                    <%}%>
                                </ul>
                            </div>
                        </div>
                        <div class="yylm-pinglun-con">
                            <section class="support">
                                <div class="detail-header left">
                                    <%if(list[i].type == 1){%>
                                    <%if(list[i].praise_list.length > 0){%>
                                    <section>
                                        <%for(var n = 0; n < list[i].praise_list.length; n++){%>
                                        <%if(n<3){%>
                                        <span>
                                            <%if(list[i].praise_list[n].avatar_want.indexOf('http')==-1){%>
                                            <img class='left_img'
                                                src="https://app.icangyu.com<%=list[i].praise_list[n].avatar_want%>">
                                            <%}else{%>
                                            <img class='left_img' src="<%=list[i].praise_list[n].avatar_want%>">
                                            <%}%>
                                        </span>
                                        <%}%>
                                            <%}%>
                                        <span><%=list[i].all_nums%>人点赞</span>
                                    </section>
                                    <%}%>
                                <%}else if(list[i].type == 2){%>
                                    <%if(list[i].palm.length > 0){%>
                                    <section>
                                        <%for(var n = 0; n < list[i].palm.length; n++){%>
                                        <%if(n<3){%>
                                        <span>
                                            <%if(list[i].palm[n].avatar_want.indexOf('http')==-1){%>
                                            <img class='left_img'
                                                src="https://app.icangyu.com<%=list[i].palm[n].avatar_want%>">
                                            <%}else{%>
                                            <img class='left_img' src="<%=list[i].palm[n].avatar_want%>">
                                            <%}%>
                                            </span>
                                        <%}%>
                                            <%}%>
                                        <span><%=list[i].all_nums%>人点赞</span>
                                    </section>
                                    <%}%>
                                <%}else if(list[i].type == 3){%>
                                    <%if(list[i].type_list.length > 0){%>
                                    <section>
                                        <%for(var n = 0; n < list[i].type_list.length; n++){%>
                                        <%if(n<3){%>
                                        <span>
                                            <%if(list[i].type_list[n].avatar_want.indexOf('http')==-1){%>
                                            <img class='left_img'
                                                src="https://app.icangyu.com<%=list[i].type_list[n].avatar_want%>">
                                            <%}else{%>
                                            <img class='left_img' src="<%=list[i].type_list[n].avatar_want%>">
                                            <%}%>
                                            </span>
                                        <%}%>
                                            <%}%>
                                        <span><%=list[i].all_nums%>人点赞</span>
                                    </section>
                                    <%}%>
                                <%}else if(list[i].type == 4){%>
                                    <%if(list[i].praise_list.length > 0){%>
                                    <section>
                                        <%for(var n = 0; n < list[i].praise_list.length; n++){%>
                                        <%if(n<3){%>
                                        <span>
                                            <%if(list[i].praise_list[n].avatar_want.indexOf('http')==-1){%>
                                            <img class='left_img'
                                                src="https://app.icangyu.com<%=list[i].praise_list[n].avatar_want%>">
                                            <%}else{%>
                                            <img class='left_img' src="<%=list[i].praise_list[n].avatar_want%>">
                                            <%}%>
                                            </span>
                                        <%}%>
                                            <%}%>
                                        <span>&nbsp;<%=list[i].all_nums%>人点赞</span>
                                    </section>
                                    <%}%>
                                <%}%>
                                </div>
                                <div class='right'>
                                    <a href="javascript:;" onclick="praise(<%=list[i].id%>)" class="icon_support">
                                        <img src="img/support.png" alt=""></a>
                                    <a href="javascript:;" onclick="praise(<%=list[i].id%>)" class="icon_support">
                                        <img src="img/discuss.png" alt=""></a>
                </a>
            </div>
            </section>
            <section class="detail-pinglun clearfix">
                <div class="detail-pinlun-list">
                    <ul>
                        <%for(var m = 0 ; m < list[i].comment_list.length; m++){%>
                        <li>
                            <%if(list[i].comment_list[m].reply_type == 1){%>
                            <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                            <%}else{%>
                            <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                            <%}%>
                                    </li>
                                    <%}%>
                    </ul>
                    <!-- <p>查看全部<span><%=list[i].comment_all%></span>条评论</p> -->
                </div>
            </section>
        </div>
        </div>
        </a>
        </div>
        <!-- <div class="card-footer ">
                <a href="javascript:;" onclick="praise(<%=list[i].id%>)" class="link"><i
                        class="f7-icons size-22"><%=list[i].praise_status === 1 ? 'heart_fill' : 'heart'%></i></a>
                <a href="javascript:;" class="link"><i class="f7-icons size-22">chat</i></a>
            </div> -->
        </div>
        <%}%>
    </script>

    <script type="text/javascript" src="js/store.everything.min.js"></script>

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
        var urlObj = {};
        var urlArray;
        var listObj = {};
        GetRequest(urlObj);
        urlArray = store.get('topic_array');
        var bgurl = urlObj.aa;

        //    $('.m-img').css('background','url(https://app.icangyu.com'+urlArray[bgurl].bgurl+')no-repeat').css('background-size',"cover");
        //    $('.m-title').html(urlArray[bgurl].title)
        //    $(".cangyu_bbs_huati_txt").find('p').html(urlArray[bgurl].content);

        var square_id = HttpHelper.getQuery('topicId');


        listObj.page = 0;
        listObj.token = token;
        listObj.type = 4;
        listObj.tid = square_id;


        // &tid=3&token=43lef6ag4b2k&type=4
        //获取列表接口
        var listData;
        $.post('https://app.icangyu.com/icyApi/square_list', listObj, function (data) {
            //Data = JSON.parse(data);
            Data = data;
            listData = Data.data;
            //console.log(listData);
            if (listData.list.length == 0) {
                $('.infinite-scroll-preloader').hide();
                return;
            }
            var html = template('topic_detail_list', listData);
            $("#topic_list").html(html);
        });

        var topObj = {};
        topObj.id = square_id;

        $.post('https://app.icangyu.com/icyApi/topic_list_top', topObj, function (data) {
            //console.log(data);
            //Data = JSON.parse(data);
            Data = data;
            listData = Data.data.list[0].title;

            $('.m-title').html(Data.data.list[0].title)
            $(".cangyu_bbs_huati_txt").find('p').html(Data.data.list[0].content);
            $('.m-img').css('background', 'url(https://app.icangyu.com' + Data.data.list[0].background_image +
                ')no-repeat').css('background-size', "cover");
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": Data.data.list[0].content, //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": Data.data.list[0].title, //分享卡片标题
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


        //    $('.m-title').html(square_title)
        //    $(".cangyu_bbs_huati_txt").find('p').html(square_content);
        //    $('.m-img').css('background','url(https://app.icangyu.com'+urlArray[bgurl].bgurl+')no-repeat').css('background-size',"cover");



        //获取url并把字符串转化成对象
        function GetRequest(theRequest) {
            var url = location.search; //获取url中"?"符后的字串
            if (url.indexOf("?") != -1) { //如果url中有？
                var str = url.substr(1);
                strs = str.split("&");
                for (var i = 0; i < strs.length; i++) {
                    theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
                }
            } else {
                str = url.split("&");
                for (var i = 0; i < str.length; i++) {
                    theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
                }
            }
            return theRequest;
        }

        function praise(square_id) {
            //点赞
            // $.getJSON(`${CYHOST}/icyApi/square_praise_add?square_id=${square_id}&token=${token}`, function (data) {
            //     if (data.result === 100) {
            //         huatiApp.alert('点赞成功。', '提示');
            //     } else {
            huatiApp.alert('请前往APP操作', '提示');
        }
        // Initialize your app
        var huatiApp = new Framework7({
            router: false,
            swipePanel: 'left'
        });
        huatiApp.addView('#huati_xiangqing');
        // Export selectors engine
        var $$ = Dom7;
        var ptrContent = $$('.pull-to-refresh-content');
        // Add 'refresh' listener on it
        ptrContent.on('refresh', function (e) {
            tieziPageIndex = 0;
            setTimeout(function () {
                //获取话题列表接口
                listObj.page = tieziPageIndex;
                listObj.token = token;
                listObj.type = 4;
                var listData;
                $.post('https://app.icangyu.com/icyApi/square_list', listObj, function (data) {
                    Data = JSON.parse(data);
                    listData = Data.data;
                    // console.log(listData);
                    var html = template('topic_detail_list', listData);
                    $("#topic_list").html(html);
                    $('.infinite-scroll-preloader').show();

                    // When loading done, we need to reset it
                    huatiApp.pullToRefreshDone();
                });
            }, 1500);
        });
    </script>

    <script>
        $("#btnOpenApp").click(function () {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCTalkMessVC',
                    'shareAndroid': 'icangyu.jade.activities.contents.TopicDetailsActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>

</body>

</html>