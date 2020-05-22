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
    <link rel="stylesheet" href="css/firstPublish.css">
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/vant.css">
    <title>藏玉首发</title>
</head>

<body>
    <div ref="vue" id="vue">
        <img :src="live_cover">
        <van-tabs v-model="active">
            <van-tab title="图集">
                <img v-for="item,index in imgList" :src="item.file_path">
            </van-tab>
            <van-tab title="商品">
                <div class="products">
                    <div class="product" v-for='item,index in proList'>
                        <img :src="item.img" alt="">
                        <div class="right">
                            <div class="name" v-text="item.title"></div>
                            <div class="mate" v-text="item.material"></div>
                            <span class="progress" style="margin-top: 2.14vw;">
                                <span class='progress_bgc' :style="getWidth(item)">
                                    <span class='progress_text' v-text="item.last_nums>0?`仅剩${item.last_nums}件`:`已售罄`"></span>
                                </span>
                            </span>
                            <div class="price" v-text="'￥'+item.price"></div>
                        </div>
                    </div>
                </div>
            </van-tab>
        </van-tabs>
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
<script type="text/javascript" src="js/viewer.js"></script>
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
        el: '#vue',
        data() {
            return {
                active: 0,
                live_cover: '',
                title: '',
                content: '',
                imgList: {},
                proList: {}
            }
        },
        created() {
            var that = this;
            that.getDetail()
        },
        methods: {
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/starting_room_details?room_id=${square_id}`).then(res => {
                    console.log(res.data.data, 'detail')
                    that.live_cover = res.data.data.list.live_cover;
                    that.title = res.data.data.list.title;
                    that.content = res.data.data.list.content;

                })
                axios.get(`${CYHOST}/icyApi/live_starting_details?room_id=${square_id}`).then(res => {
                    console.log(res.data.data, 'img')
                    that.imgList = res.data.data.list;
                })
                axios.get(`${CYHOST}/icyApi/live_starting_product_list?room_id=${square_id}`).then(res => {
                    console.log(res.data.data, 'list')
                    that.proList = res.data.data.list

                })
                window.share_config = {
                    "share": {
                        "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                        "desc": that.title, //摘要,如果分享到朋友圈的话，不显示摘要。
                        "title": that.content, //分享卡片标题
                        "link": window.location.href //分享出去后的链接，这里可以将链接设置为另一个页面。
                    }
                };
                wx.ready(function() {
                    wx.onMenuShareAppMessage(share_config.share); //分享给好友
                    wx.onMenuShareTimeline(share_config.share); //分享到朋友圈
                    wx.onMenuShareQQ(share_config.share); //分享给手机QQ
                });
            },
            // 获取剩余数量宽度
            getWidth(item) {
                return ' width:' + (item.last_nums / item.nums * 100).toFixed(0) + '%;';
            },
            // 跳转APP
            goApp() {
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
            },
            // 关闭跳转链接
            close() {
                var that = this;
                that.$refs.goApp.style.display = 'none';
            }
        }
    });
</script>

</html>