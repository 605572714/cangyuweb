<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>藏玉拍卖</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/vant.css">
    <link rel="stylesheet" href="css/pickupList.css">
    <style>
        .check {
            position: absolute;
            bottom: 4vw;
            right: 4vw;
            border: 1px solid #d9d9d9;
            padding: 1.5vw 4vw;
            border-radius: 1vw;
            font-size: 3.8vw;
            background: #bc2e2e;
            color: #fff;
        }
    </style>
</head>

<body>
    <div ref=vue id="vue" class="vue">
        <div class="top">
            <div>
                <van-count-down class="time" style="color:#fff" :time="header.timeStamp*1000" :format="checkTime(header,'text')" @finish="getDetail" />
            </div>

            <img :src="checkTime(header,'img')" />
        </div>
        <div class="header-title" v-text="`${header.screenings_des}·${header.total}件商品`"></div>
        <div class="rule">
            <span v-text="'点击查看拍卖规则'" @click="ruleDetail"></span>
        </div>
        <div class="list">
            <div class="item" v-for="item,index in list" @click="spickDetail(item.id)">
                <span ref="state" class="status" :style="checkStatus(item,'style')" v-text="checkStatus(item,'text')"></span>
                <img :src="checkImg(item.pic_url)" style="background: #f7f7f7">
                <span class="title" v-text="item.title"></span>
                <div class="price">
                    <span class="title" v-text="'当前价格'"></span>
                    <span class="value" v-text="`￥${item.highest_price}`"></span>
                </div>
                <span class="check" v-text="item.status==3?'已结束':'去看看'"></span>
            </div>
        </div>

        <!-- Bottom Tabbar-->
        <div ref="goApp" class="cangyu_bbs_tabber">
            <a href="javascript:void(0)" class="close" @click="close"></a>
            <a id="btnOpenApp">
                <div class="logo"></div>
                <div class="banner-label">
                    <p class="tb" data-node="appName" v-text="'下载APP'"></p>
                    <p class="title-sub" v-text="'了解最新业内资讯'"></p>
                </div>
                <div class="open" @click='goApp' v-text="'立即打开'"></div>
            </a>
        </div>
    </div>
</body>
<!-- 图片预览 -->
<!-- <script type="text/javascript" src="js/viewer.js"></script> -->
<!-- 极光魔链 -->
<script type="text/javascript" src="js/jmlink.min.js"></script>
<!-- 微信验证 -->
<script type="text/javascript" src="js/weixinWeb.js"></script>
<!-- 公共文件 -->
<script type="text/javascript" src="js/config.js"></script>
<!-- vue -->
<script type="text/javascript" src="js/vue.min.js"></script>
<!-- axios -->
<script type="text/javascript" src="js/axios.min.js"></script>
<!-- vant -->
<script type="text/javascript" src="js/vant.js"></script>
<!-- 微信分享 -->
<script type="text/javascript" src="js/jssdk.js"></script>
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
    var square_id = HttpHelper.getQuery('item_id');
    console.log(square_id);
    var vue = new Vue({
        el: "#vue",
        data: {
            header: {},
            time: 0,
            list: []
        },
        created() {
            var that = this;
            that.getDetail();
        },
        methods: {
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/AuctionIndex?id=${square_id}`).then(res => {
                    // console.log(res.data.data);
                    that.header = res.data.data.header;
                    that.list = res.data.data.list
                    that.$refs.vue.style.display = 'block';
                    console.log('头部', that.header);
                    console.log('列表', that.list);
                    window.share_config = {
                        "share": {
                            "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",
                            //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                            "desc": that.header.content, //摘要,如果分享到朋友圈的话，不显示摘要。
                            "title": that.header.screenings_des, //分享卡片标题
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
                }).catch(err => {
                    console.log(err);
                })
            },
            // 检查图片状态

            checkImg(img) {
                if (img && img.indexOf('http') == -1) {
                    img = CYHOST + img;
                }
                return img;
            },
            // 判断商品状态
            checkStatus(item, type) {
                switch (item.status) {
                    case 1:
                        return type == 'text' ? '即将开始' : 'width:16vw;';
                        break;
                    case 2:
                        return type == 'text' ? '进行中' : 'color:#fff;';
                        break;
                    case 3:
                        if (item.nums == 0) {
                            return type == 'text' ? '已结缘' : 'background: #b8b8b8;';
                        } else {
                            return type == 'text' ? '已结束' : 'background: #b8b8b8;';
                        }
                        break;
                }
            },
            // 倒计时
            checkTime(item, type) {
                var that = this;
                switch (item.status) {
                    case 1:
                        return type == 'text' ? `即将开始 距开始还剩  HH 时 mm 分 ss 秒` : 'img/header_fen.png';
                        break;
                    case 2:
                        return type == 'text' ? `进行中 距结束还剩  HH 时 mm 分 ss 秒` : 'img/header_huang.png';
                        break;
                    case 3:
                        return type == 'text' ? `已结束 ${item.endTime}` : 'img/header_hui.png';
                        break;
                }
            },
            // 跳转规则页面
            ruleDetail() {
                window.location.href = 'appRuleDetail.html?item_id=rule001';
            },
            // 跳转详情
            spickDetail(id) {
                window.location.href = `auctionDetail.php?item_id=${id}`;
            },
            // 跳转APP
            goApp() {
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
            },
            // 关闭跳转链接
            close() {
                var that = this;
                that.$refs.goApp.style.display = 'none';
            },
        }
    });
</script>

</html>