

<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
//print_r($signPackage);
//echo "xx";
?>

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
window.share_config = {
     "share": {
        "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
        "desc" : "藏玉社区",//摘要,如果分享到朋友圈的话，不显示摘要。
        "title" : '藏玉',//分享卡片标题
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
</script>











<!DOCTYPE html>
<html>

<!--head-->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉</title>


      <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="dist/css/framework7-icons.css">
    <link rel="stylesheet" href="dist/css/framework7.ios.min.css">

    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <style type="text/css"></style>

  </head>

<!--body-->
  <body>
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>

    <!--弹出发布页面-->
    <div class="popup popup-fabu tablet-fullscreen">

        <div class="fabu_btn_list">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" class="qiujianding_btn"></a>
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" class="fatiezi_btn"></a>
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade"    class="woxiangmai_btn"></a>
        </div>
        <p class="popup_fabu_guanbi"><a class="close-popup"><i class="f7-icons">close</i></a></p>

    </div>

    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs toolbar-through">
      <!-- Your first view, it is also a .tab and should have "active" class to make it visible by default-->
        <div id="view-1" class="view view-main tab active">

        <!-- Pages-->
            <div class="pages toolbar-fixed navbar-fixed">

                <div class="toolbar tabbar tabbar-scrollable cangyu_bbs_top_tabber">
                    <div class="toolbar-inner">
                      <a href="#tab-1" class="tab-link active">推荐</a>
                      <a href="#tab-2" class="tab-link">鉴定</a>
                      <a href="#tab-3" class="tab-link">买卖</a>
                      <a href="#tab-4" class="tab-link">帖子</a>
                      <a href="#tab-5" class="tab-link">拍卖</a>
                    </div>
                </div>

                <!-- Page, data-page contains page name-->
                <div data-page="index-1" class="page ">

            <!-- Floating Action Button -->
              <a href="#" data-popup=".popup-fabu" class="open-popup floating-button color-pink fudong_btn_fabu">
                  发布
              </a>




                    <!-- Scrollable page content-->
                    <div class="page-content infinite-scroll pull-to-refresh-content" data-distance="10">
                        <div class="pull-to-refresh-layer">
                            <div class="preloader"></div>
                            <div class="pull-to-refresh-arrow"></div>
                        </div>
                        <!--<div class="tabs">-->

                            <!-- Tabs, tabs wrapper -->
                            <div class="tabs">


                                <!------------    Tab 1 推荐    ------------>
                                <div id="tab-1" class="tab active">


                                    <!--滚动图片-->
                                    <div class="swiper-container icangyu-yyzg-gudong" id="home_scroll_list">
                                        <div class="swiper-pagination color-white"></div>
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide" v-for="item in LunBoList" v-on:click="goTopic(item)" >


                                                <img v-bind:data-src="item.pic_url | alb" alt="" class="swiper-lazy" />

                                                <span class="lunbo-image-message">{{item.message}}</span>
                                                <!--<div class="preloader"></div>-->

                                            </div>

                                        </div>
                                    </div>


                                    <!--推荐列表开始-->
                                    <div class="recommend_home_list"></div>

                                </div>


                                <!------------   Tab 2 鉴定   ----------- -->
                                <div id="tab-2" class="tab">

                                    <div class="appraise_div_list"></div>

                                </div>


                                <!-------------- Tab 3 买卖 -------------->
                                <div id="tab-3" class="tab">

                                    <div class="deal_div_list"></div>

                                </div>


                                <!----------------  Tab 4 帖子 ---------------->
                                <div id="tab-4" class="tab">

                                    <div class="weibo_div_list"></div>

                                </div>


                                <!-------------  Tab 5 拍卖  -------------------->
                                <div id="tab-5" class="tab">

                                    <div class="follow_home_div_list"></div>

                                </div>


                            </div>

                        <!--</div>-->

                    </div>

                </div>

            </div>


        </div>

      <!-- Second view (for second wrap) -->
      <div id="view-2" class="view tab"></div>

      <!-- three view (for second wrap) -->
      <div id="view-3" class="view tab"></div>

      <!-- four view (for second wrap) -->
      <div id="view-4" class="view tab"></div>



        <!-- Bottom Tabbar-->
      <div class="cangyu_bbs_tabber">
       <a href="javascript:void(0)" class="close"></a>
        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" target="_self" class="download" rel="nofollow">
            <div class="logo"></div>
            <div class="banner-label">
                <p class="tb" data-node="appName">下载藏玉APP</p>
                <p class="title-sub">参与互动讨论，获取更多内容</p>
            </div>
            <div class="open">立即打开</div>
        </a>
      </div>


    </div>



    <!----------------以下为 script 部分-------------->


    <!--关注列表-->
    <script type="text/html" id="follow_home_list">

        <%for(i = 0; i < list.length; i++){%>

            <div class="card_zhuanti demo-card-header-pic">

                <a href="auctionList.html?screenings=<%=list[i].screenings%>" class="block-a">

                    <%if(list[i].album.length > 0){%>
                          <div style="background-image:url(https://app.icangyu.com<%=list[i].album[0].file_path%>)" valign="bottom" class="card-header color-white no-border"></div>
                    <%}%>

                    <div class="card_zhuanti_txt"><%=list[i].content%></div>

                </a>

            </div>

        <%}%>

    </script>


    <!--微博列表-->
    <script type="text/html" id="weibo_list">

        <%for(i = 0; i < list.length; i ++){%>
        <div class="card facebook-card ">

            <div class="card-header">
                <div class="facebook-avatar m-avatar-box">
                    <!--<a href="wode_index.html?user_id=<%=list[i].user_id%>">-->
                        <img src="https://app.icangyu.com<%=list[i].avatar%>" width="34" height="34">
                    <!--</a>-->
                </div>
                <div class="facebook-name">
                    <a href="wode_index.html?user_id=<%=list[i].user_id%>"><%=list[i].nickname%></a>
                    <span class="cangyu_bbs_dengji">Lv<%=list[i].rating%></span>
                </div>
                <div class="facebook-date"><%=list[i].createdate%></div>
            </div>


            <div class="card-content">
                <a href="tiezi——xiangqing.html?type=1&item_id=<%=list[i].id%>" class="block-a">
                    <div class="card-content-inner">

                        <%if(list[i].content.length > 60){%>

                              <h3 class="card-content-yylm-t"><%=list[i].content.substring(0,60)%></h3>

                        <%}else{%>

                              <h3 class="card-content-yylm-t"><%=list[i].content%></h3>

                        <%}%>

                        <div class="weibo-detail">
                            <div class="media-pic-list">
                                <ul style="overflow:hidden">
                                    <%for(k = 0; k < list[i].album.length; k++){%>
                                    <li>
                                        <img data-node="pic" data-act-type="hover" src="<%=list[i].album[k].file_path%>" class="loaded">
                                    </li>
                                    <%}%>
                                </ul>
                            </div>
                        </div>
                        <div class="yylm-pinglun-con">

                            <%if(list[i].praise_list.length > 0){%>

                                <section class="detail-num clearfix">
                                    <div class="detail-header">

                                        <%for(n = 0; n < list[i].praise_list.length; n++){%>
                                        <span><img src="https://app.icangyu.com<%=list[i].praise_list[n].avatar_want%>"></span>
                                        <%}%>

                                    </div>
                                    <div class="yylm-dianzan-shu"><span><%=list[i].praise_list.length%>人点赞</span></div>
                                </section>

                            <%}%>


                            <%if(list[i].comment_list.length > 0){%>

                                <section class="detail-pinglun clearfix">
                                    <div class="detail-pinlun-list">
                                        <ul>
                                            <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                            <li>
                                                <%if(list[i].comment_list[m].reply_type == 1){%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                                <%}else{%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                                <%}%>
                                            </li>
                                            <%}%>
                                        </ul>
                                        <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>
                                    </div>
                                </section>

                            <%}%>

                        </div>
                    </div>
                </a>
            </div>
            <!--<div class="card-footer ">-->
                <!--<a class="link" onclick="praise(<%=list[i].id%>)"><i class="f7-icons size-22"><%=list[i].praise_status === 1 ? 'heart_fill' : 'heart'%></i></a>-->
                <!--<a><i class="f7-icons size-22">chat</i></a>-->
            <!--</div>-->
        </div>
        <%}%>

    </script>

    <!--首页买卖列表-->
    <script type="text/html" id="deal_list">

        <%for(i = 0; i < list.length; i ++){%>

        <div class="card facebook-card ">

            <div class="card-header">
                <div class="facebook-avatar">
                    <img src="https://app.icangyu.com<%=list[i].avatar%>" width="34" height="34" />
                </div>
                <div class="facebook-name">
                    <a href="wode_index.html?user_id=<%=list[i].user_id%>"><%=list[i].nickname%></a>
                    <span class="cangyu_bbs_dengji">Lv<%=list[i].rating%></span>
                </div>
                <div class="facebook-date"><%=list[i].createdate%></div>
            </div>

            <!--下半部分-->
            <div class="card-content">
                <a href="maimai——xiangqing.html?type=3&item_id=<%=list[i].id%>" class="block-a">
                    <div class="card-content-inner">
                        <div class="yylm-pinglun-con">
                            <div class="cangyu_bbs_maimai maimai-img-container" style="height: 200px;">
                                <!-- Slider container
                                <div class="swiper-container swiper-2" >
                                    <div class="swiper-wrapper">

                                        <%for(k = 0; k < list[i].album.length; k++){%>
                                        <div class="swiper-slide">
                                            <img src="<%=list[i].album[k].file_path%>" alt="" class="swiper-lazy" />
                                        </div>
                                        <%}%>

                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div> -->
                                <div class="maimai-img maimai-img-1">
                                    <img src="<%=list[i].album[0].file_path%>" width="100%" height="200" alt="" class="swiper-lazy">
                                </div>
                                <%if(list[i].album.length > 2){%>
                                <div class="maimai-img maimai-img-2">
                                    <div>
                                        <img src="<%=list[i].album[1].file_path%>" width="100%" height="97" style="margin-bottom:3px;" alt="" class="swiper-lazy">
                                    </div>
                                    <div>
                                        <img src="<%=list[i].album[2].file_path%>" width="100%" height="97" style="margin-top:3px;" alt="" class="swiper-lazy">
                                    </div>
                                    <div class="maimai-img-clear"></div>
                                </div>
                                <%}%>

                            </div>


                            <section class="detail-num clearfix">

                                <div class="detail-header">
                                    <%for(n = 0; n < list[i].type_list.length; n++){%>
                                    <span><img src="https://app.icangyu.com<%=list[i].type_list[n].avatar_want%>" /></span>
                                    <%}%>
                                </div>

                                <div class="yylm-dianzan-shu"><span><%=list[i].all_nums%>人喜欢</span></div>

                            </section>


                            <%if(list[i].comment_list.length > 0){%>

                                <section class="detail-pinglun clearfix">

                                    <div class="detail-pinlun-list">

                                        <ul>
                                            <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                            <li>
                                                <%if(list[i].comment_list[m].reply_type == 1){%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                                <%}else{%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                                <%}%>
                                            </li>
                                            <%}%>
                                        </ul>
                                        <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>

                                    </div>

                                </section>

                            <%}%>


                        </div>
                    </div>
                </a>
            </div>

        </div>
        <%}%>

    </script>

    <!--首页鉴定列表-->
    <script type="text/html" id="appraise_list">

        <%for(i = 0; i < list.length; i ++){%>
        <div class="card facebook-card ">


            <div class="card-header">
                <div class="facebook-avatar">
                    <!--<a href="wode_index.html?user_id=<%=list[i].user_id%>">-->
                        <img src="https://app.icangyu.com<%=list[i].avatar%>" width="34" height="34">
                    <!--</a>-->
                </div>
                <div class="facebook-name">
                    <a href="wode_index.html?user_id=<%=list[i].user_id%>"><%=list[i].nickname%></a>
                    <span class="cangyu_bbs_dengji">Lv<%=list[i].rating%></span>
                </div>
                <div class="facebook-date"><%=list[i].createdate%></div>
            </div>


            <div class="card-content">
                <a href="jianding——xiangqing.html?type=2&item_id=<%=list[i].id%>" class="block-a">
                    <div class="card-content-inner">
                        <h3 class="card-content-yylm-t"><%=list[i].content%></h3>
                        <div class="weibo-detail">
                            <div class="media-pic-list">
                                <ul style="overflow:hidden">
                                    <%for(k = 0; k < list[i].album.length; k++){%>
                                    <li>
                                        <img data-node="pic" data-act-type="hover" src="<%=list[i].album[k].file_path%>" class="loaded">
                                    </li>
                                    <%}%>
                                </ul>
                            </div>
                        </div>
                        <div class="yylm-pinglun-con">

                            <%if(list[i].palm.length > 0){%>
                                <section class="detail-zhangyan">
                                    <div class="yylm-zhangyan">
                                        <b>邀请掌眼：</b>
                                        <%for(n = 0; n < list[i].palm.length; n++){%>
                                        <span><%=list[i].palm[n].nickname%></span>
                                        <%}%>
                                    </div>
                                </section>
                            <%}%>

                            <section class="detail-pinglun clearfix">
                                <div class="detail-pinlun-list">
                                    <ul>
                                        <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                        <li>
                                            <%if(list[i].comment_list[m].reply_type == 1){%>
                                            <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                            <%}else{%>
                                            <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                            <%}%>
                                        </li>
                                        <%}%>
                                    </ul>
                                    <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>
                                </div>
                            </section>

                        </div>
                    </div>
                </a>
            </div>
        </div>
        <%}%>

    </script>

    <!-- 首页推荐列表模板 -->
    <script type="text/html" id='home_list'>

      <%for(i = 0; i < list.length; i ++){%>
        <div class="card facebook-card ">

          <div class="card-header">
            <div class="facebook-avatar">
              <!--<a href="wode_index.html?user_id=<%=list[i].user_id%>">-->
                <img src="https://app.icangyu.com<%=list[i].avatar%>" width="34" height="34">
              <!--</a>-->
            </div>
            <div class="facebook-name">
              <a href="wode_index.html?user_id=<%=list[i].user_id%>"><%=list[i].nickname%></a>
              <span class="cangyu_bbs_dengji">Lv<%=list[i].rating%></span>
            </div>
            <div class="facebook-date"><%=list[i].createdate%></div>
          </div>

          <div class="card-content">


              <%if( list[i].type == "2"){%>

                    <a href="jianding——xiangqing.html?type=2&item_id=<%=list[i].id%>" class="block-a">
                        <div class="card-content-inner">


                            <%if(list[i].content.length > 60){%>

                                <h3 class="card-content-yylm-t"><%=list[i].content.substring(0,60)%></h3>

                            <%}else{%>

                                <h3 class="card-content-yylm-t"><%=list[i].content%></h3>

                            <%}%>


                            <div class="weibo-detail">
                                <div class="media-pic-list">
                                    <ul style="overflow:hidden">
                                        <%for(k = 0; k < list[i].album.length; k++){%>
                                        <li>
                                            <img data-node="pic" data-act-type="hover" src="<%=list[i].album[k].file_path%>" class="loaded">
                                        </li>
                                        <%}%>
                                    </ul>
                                </div>
                            </div>
                            <div class="yylm-pinglun-con">

                                <%if(list[i].palm.length > 0){%>
                                <section class="detail-zhangyan">
                                    <div class="yylm-zhangyan">
                                        <b>邀请掌眼：</b>
                                        <%for(n = 0; n < list[i].palm.length; n++){%>
                                        <span><%=list[i].palm[n].nickname%></span>
                                        <%}%>
                                    </div>
                                </section>
                                <%}%>

                                <section class="detail-pinglun clearfix">
                                    <div class="detail-pinlun-list">
                                        <ul>
                                            <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                            <li>
                                                <%if(list[i].comment_list[m].reply_type == 1){%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                                <%}else{%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                                <%}%>
                                            </li>
                                            <%}%>
                                        </ul>
                                        <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>
                                    </div>
                                </section>

                            </div>
                        </div>


              <%}else if(list[i].type == "3"){%>

                    <a href="maimai——xiangqing.html?type=3&item_id=<%=list[i].id%>" class="block-a">

                        <div class="card-content-inner">
                            <div class="yylm-pinglun-con">
                                <div class="cangyu_bbs_maimai maimai-img-container" style="height: 200px;">
                                    <!-- Slider container
                                    <div class="swiper-container swiper-2" >
                                        <div class="swiper-wrapper">

                                            <%for(k = 0; k < list[i].album.length; k++){%>
                                            <div class="swiper-slide">
                                                <img src="<%=list[i].album[k].file_path%>" alt="" class="swiper-lazy" />
                                            </div>
                                            <%}%>

                                        </div>
                                        <div class="swiper-pagination"></div>
                                    </div> -->
                                    <div class="maimai-img maimai-img-1">
                                        <img src="<%=list[i].album[0].file_path%>" width="100%" height="200" alt="" class="swiper-lazy">
                                    </div>

                                    <%if(list[i].album.length > 2){%>

                                    <div class="maimai-img maimai-img-2">
                                        <div>
                                            <img src="<%=list[i].album[1].file_path%>" width="100%" height="97" style="margin-bottom:3px;" alt="" class="swiper-lazy">
                                        </div>
                                        <div>
                                            <img src="<%=list[i].album[2].file_path%>" width="100%" height="97" style="margin-top:3px;" alt="" class="swiper-lazy">
                                        </div>
                                        <div class="maimai-img-clear"></div>
                                    </div>

                                    <%}%>

                                </div>


                                <section class="detail-num clearfix">

                                    <div class="detail-header">
                                        <%for(n = 0; n < list[i].type_list.length; n++){%>
                                        <span><img src="https://app.icangyu.com<%=list[i].type_list[n].avatar_want%>" /></span>
                                        <%}%>
                                    </div>

                                    <div class="yylm-dianzan-shu"><span><%=list[i].all_nums%>人喜欢</span></div>

                                </section>


                                <%if(list[i].comment_list.length > 0){%>

                                <section class="detail-pinglun clearfix">

                                    <div class="detail-pinlun-list">

                                        <ul>
                                            <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                            <li>
                                                <%if(list[i].comment_list[m].reply_type == 1){%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                                <%}else{%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                                <%}%>
                                            </li>
                                            <%}%>
                                        </ul>
                                        <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>

                                    </div>

                                </section>

                                <%}%>
                            </div>
                        </div>

              <%}else{%>

                    <a href="tiezi——xiangqing.html?type=<%=list[i].type%>&item_id=<%=list[i].id%>" class="block-a">
                        <div class="card-content-inner">


                            <%if(list[i].content.length > 60){%>

                                  <h3 class="card-content-yylm-t"><%=list[i].content.substring(0,60)%></h3>

                            <%}else{%>

                                  <h3 class="card-content-yylm-t"><%=list[i].content%></h3>

                            <%}%>


                            <div class="weibo-detail">
                                <div class="media-pic-list">
                                    <ul style="overflow:hidden">
                                        <%for(k = 0; k < list[i].album.length; k++){%>
                                        <li>
                                            <img data-node="pic" data-act-type="hover" src="<%=list[i].album[k].file_path%>" class="loaded">
                                        </li>
                                        <%}%>
                                    </ul>
                                </div>
                            </div>
                            <div class="yylm-pinglun-con">
                                <section class="detail-num clearfix">
                                    <div class="detail-header">
                                        <%if( list[i].type == "1"){%>
                                        <%for(n = 0; n < list[i].praise_list.length; n++){%>
                                        <span><img src="https://app.icangyu.com<%=list[i].praise_list[n].avatar_want%>"></span>
                                        <%}%>
                                        <%}else if(list[i].type == "2"){%>
                                        <%for(n = 0; n < list[i].palm.length; n++){%>
                                        <span>掌眼邀请 <%=list[i].palm[n].nickname%></span>
                                        <%}%>
                                        <%}else if(list[i].type == "3"){%>
                                        <%for(n = 0; n < list[i].type_list.length; n++){%>
                                        <span><img src="https://app.icangyu.com<%=list[i].type_list[n].avatar_want%>" /></span>
                                        <%}%>
                                        <%}else if(list[i].type == "4"){%>
                                        <%for(n = 0; n < list[i].type_list.length; n++){%>
                                        <span><img src="https://app.icangyu.com<%=list[i].type_list[n].avatar_want%>" /></span>
                                        <%}%>
                                        <%}%>
                                    </div>
                                    <div class="yylm-dianzan-shu"><span><%=list[i].all_nums%>人点赞</span></div>
                                </section>

                                <section class="detail-pinglun clearfix">
                                    <div class="detail-pinlun-list">
                                        <ul>
                                            <%for(m = 0 ; m < list[i].comment_list.length; m++){%>
                                            <li>
                                                <%if(list[i].comment_list[m].reply_type == 1){%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<span><%=list[i].comment_list[m].tonickname%>:</span><%=list[i].comment_list[m].comment%>
                                                <%}else{%>
                                                <b><%=list[i].comment_list[m].nickname_comment%></b>&nbsp;<%=list[i].comment_list[m].comment%>
                                                <%}%>
                                            </li>
                                            <%}%>
                                        </ul>
                                        <p>查看全部<span><%=list[i].comment_all%></span>条评论</p>
                                    </div>
                                </section>

                            </div>
                        </div>

               <%}%>


            </a>


          </div>
          <!--<div class="card-footer ">-->
            <!--<a class="link" onclick="praise(<%=list[i].id%>)"><i class="f7-icons size-22"><%=list[i].praise_status === 1 ? 'heart_fill' : 'heart'%></i></a>-->
            <!--<a class="link"><i class="f7-icons size-22">chat</i></a>-->
          <!--</div>-->
        </div>
      <%}%>

    </script>



    <!-- Path to jquary Library JS-->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/template-native.js"></script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="dist/js/framework7.min.js"></script>

    <!-- other Library  -->
    <script type="text/javascript" src="js/vue/vue.min.js"></script>
    <script type="text/javascript" src="js/vue-resource/vue-resource.js"></script>
    <script type="text/javascript" src="js/store.everything.min.js"></script>

    <!-- Path to your app js-->
    <script type="text/javascript" src="js/config.js"></script>
    <script type="text/javascript" src="js/vue-filter.js"></script>
    <script type="text/javascript" src="js/my-app.js"></script>

    <script type="text/javascript" src="js/index-infinite.js"></script>

  </body>
</html>