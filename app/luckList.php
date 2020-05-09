<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
//print_r($signPackage);
//echo "xx";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/vue.js"></script>
    <script src="js/config.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="css/my-app.css">
    <script src="js/vue-resource.js"></script>
    <link rel="stylesheet" href="css/pinshouqi.css" type="">
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="js/weixinWeb.js"></script>
    <title>拼手气列表</title>
</head>

<body>
    <div id="app">
        <div v-for='item,index in header_list' :key='index'>
            <img class="header_img" :src="item.file_path" :style="'height:'+wWindth/item.width*item.height+'px'">
        </div>
        <div class="content">
            <div class="detail"
                :style="'width:'+wWindth*0.9+'px;height:'+wWindth*0.36+'px;margin-left:'+wWindth*0.05+'px;margin-bottom:'+wWindth*0.05+'px'"
                v-for='item,index in commodity_list'>
                <img class="detail_img" :style="'width:'+wWindth*0.36+'px'" :src="item.headlines">
                <div class="detail_right">
                    <div class="title">{{item.title}}</div>
                    <div class="price">￥{{item.pro_price}}</div>
                    <div class="support">
                        <div class="contain">
                            <div class="progress" :style="'width:' + item.last_nums/item.nums * 90 + 'px;'">
                                <span v-if="item.last_nums > 0">仅剩{{ item.last_nums }}件</span>
                                <span v-else>已售罄</span>
                            </div>
                        </div>
                    </div>
                    <!-- <a href="#">
                        <div class="goDetail" id="goDetail" @click='goApp()'>立即参与</div>
                    </a> -->

                </div>
            </div>
        </div>
        <div v-for='item,index in bottom_list' :key='index'>
            <img class="header_img" :src="item.file_path" :style="'height:'+wWindth/item.width*item.height+'px'">
        </div>
    </div>
</body>
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
    // var square_id = 5;
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            detail: null,
            header_list: null,
            bottom_list: null,
            commodity_list: null,
            imgHost: 'https://app.icangyu.com',
            wWindth: document.body.clientWidth,
            hHeight: null
        },
        mounted() {
            this.showDetails();
        },
        methods: {
            showDetails() {
                var that = this;
                that.$http.get('https://app.icangyu.com/icyApiFighting/fighting_list?id=' + square_id).then(
                    res => {
                        that.detail = res.body.data.list[0];
                        that.header_list = res.body.data.list[0].header_list;
                        for (var i = 0; i < that.header_list.length; i++) {
                            if (that.header_list[i].file_path.indexOf('http') == -1) {
                                that.header_list[i].file_path = that.imgHost + that.header_list[i].file_path
                            }
                        }
                        that.bottom_list = res.body.data.list[0].bottom_list;
                        for (var i = 0; i < that.bottom_list.length; i++) {
                            if (that.bottom_list[i].file_path.indexOf('http') == -1) {
                                that.bottom_list[i].file_path = that.imgHost + that.bottom_list[i].file_path
                            }
                        }
                        that.commodity_list = res.body.data.list[0].commodity_list;
                        for (var i = 0; i < that.commodity_list.length; i++) {
                            if (that.commodity_list[i].headlines.indexOf('http') == -1) {
                                that.commodity_list[i].headlines = that.imgHost + that.commodity_list[i]
                                    .headlines
                            }
                        }
                        console.log(this.detail)
                    }).catch(res => {
                    console.log('获取失败', res)
                })
                window.share_config = {
                    "share": {
                        "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                        "desc": '', //摘要,如果分享到朋友圈的话，不显示摘要。
                        "title": '藏于拼手气', //分享卡片标题
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
            }
        }
    });
</script>
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
<script>
    $("#btnOpenApp").click(function () {
        var configs = [{
            jmlink: 'https://a0ipue.jmlk.co/AA09',
            button: document.querySelector('a#btnOpenApp'),
            params: {
                'shareID': square_id,
                'shareIOS': 'KCSpellDetailVC',
                'shareAndroid': 'icangyu.jade.activities.crowd.LuckSessionActivity'
            }
        }];
        new JMLink(configs);
    });
</script>

</html>