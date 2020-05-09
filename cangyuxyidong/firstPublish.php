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
    <link rel="stylesheet" href="css/firstPublish.css">
    <link rel="stylesheet" href="css/my-app.css">
    <script src="js/vue/vue.min.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/config.js"></script>
    <script src="js/vue-resource/vue-resource.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
	<script type="text/javascript" src="js/weixinWeb.js"></script>
    <title>藏于首发</title>
</head>

<body>
    <div id="app">
        <img :src="live_cover" alt="" class="top_img" mode='aspectFit'>
        <div class="tab">
            <div class="tabbar1" @click='changeType'
                :style="type==1?'color:#bc2e2e;border-bottom:0.5px solid #bc2e2e;':'color:#333;'">图集</div>
            <div class="tabbar2" @click='changeType'
                :style="type==2?'color:#bc2e2e;border-bottom:0.5px solid #bc2e2e;':'color:#333;'">商品</div>
        </div>
        <div class="imgList" v-if='type==1'>
            <div class="item" v-for="item,index in imgList">
                <img :src="item.file_path" alt="">
            </div>
        </div>
        <div class="products" v-if='type==2'>
            <div class="product" v-for='item,index in proList'>
                <img :src="item.img" alt="">
                <div class="right" :style="'width:'+wWidth+'px'">
                    <div class="name">{{item.title}}</div>
                    <div class="mate">产地：{{item.material}}</div>
                    <div class="price">￥{{item.price}}</div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
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
                'onMenuShareWeibo',
                'previewImage'
            ]
        });
    </script>
    <script>
        var square_id = HttpHelper.getQuery('id');
        // var square_id = '1573635956'
        var wWidth = document.body.scrollWidth
        var app = new Vue({
            el: '#app',
            data: {
                detail: null,
                imgList: null,
                title: null,
                proList: null,
                live_cover: null,
                imghost: CYHOST,
                type: 1,
                wWidth: document.body.scrollWidth - 175
            },
            mounted() {
                var that = this;
                that.getDetail()
            },
            methods: {
                getDetail() {
                    var that = this;
                    that.$http.get(`${CYHOST}/icyApi/starting_room_details?room_id=${square_id}`).then(
                        res => {
                            console.log(res.body.data, '1')
                            that.detail = res.body.data.list
                            that.live_cover = res.body.data.list.live_cover
                            if ( that.live_cover.indexOf('http') == -1) {
                                that.live_cover = that.imghost +  that.live_cover
                                }
                            that.title = res.body.data.list.title
                        })
                    that.$http.get(`${CYHOST}/icyApi/live_starting_details?room_id=${square_id}`).then(
                        res => {
                            console.log(res.body.data, '2')
                            that.imgList = res.body.data.list
                            for (var i = 0; i < that.imgList.length; i++) {
                                if (that.imgList[i].file_path.indexOf('http') == -1) {
                                    that.imgList = that.imghost + that.imgList
                                }
                            }
                        })
                    that.$http.get(
                        `${CYHOST}/icyApi/live_starting_product_list?room_id=${square_id}`).then(
                        res => {
                            console.log(res.body.data, '3')
                            that.proList = res.body.data.list

                        })
                    window.share_config = {
                        "share": {
                            "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                            "desc": that.title, //摘要,如果分享到朋友圈的话，不显示摘要。
                            "title": '藏于首发', //分享卡片标题
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
                },
                changeType(type) {
                    var that = this;
                    if (that.type == 1) {
                        that.type = 2
                    } else {
                        that.type = 1
                    }
                }
            }
        });
    </script>
    <div class="cangyu_bbs_tabber" v-if='!hidden'>
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
    <script>
        $(".close").click(function () {
            $(".cangyu_bbs_tabber").hide();
        });
        $("#btnOpenApp").click(function () {
            var configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#btnOpenApp'),
                params: {
                    'shareID': square_id,
                    'shareIOS': 'KCFirstDetailVC',
                    'shareAndroid': 'icangyu.jade.activities.live.LiveSellActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>
</body>

</html>