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
    <title>藏玉严选</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/vant.css">
    <link rel="stylesheet" href="css/pickupList.css">
    <style>
        .title {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding-top: 2vw;
        }

        .title .price {
            margin-right: 4vw;
            color: #bc2e2e;
        }

        .content {
            padding: 0vw 4vw;
            margin-bottom: 4vw;
            font-size: 3.7vw;
            color: #888;
        }
    </style>
</head>

<body>
    <div ref=vue id="vue" class="vue">
        <div class="header-title" v-text="`${header.title}·${header.total}件商品`"></div>
        <div class="rule">
            <span v-text="'点击查看严选规则'" @click="ruleDetail"></span>
        </div>
        <div class="list">
            <div class="item" v-for="item,index in list" @click="spickDetail(item.id)">
                <img :src="checkImg(item.file_path)" style="background: #f7f7f7">
                <div class="title">
                    <span v-text="item.pro_name"></span>
                    <span class="price" v-text="`￥${item.pro_price}`"></span>
                </div>
                <div class="content van-multi-ellipsis--l2" v-text="item.pro_descript"></div>
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
            list: []
        },
        created() {
            var that = this;
            that.getDetail();
        },
        methods: {
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/chosen_list?id=${square_id}`).then(res => {
                    console.log(res.data.data);
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
                            "title": that.header.title, //分享卡片标题
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
            // 跳转规则页面
            ruleDetail() {
                window.location.href = 'appRuleDetail.html?item_id=rule002';
            },
            // 跳转详情
            spickDetail(id) {
                window.location.href = `selectDetail.php?item_id=${id}`;
            },
            // 跳转APP
            goApp() {
                var configs = [{
                    jmlink: 'https://a0ipue.jmlk.co/AA09',
                    button: document.querySelector('a#btnOpenApp'),
                    params: {
                        'shareID': square_id,
                        'shareIOS': 'KCStrictListVC',
                        'shareAndroid': 'icangyu.jade.activities.select.SelectSessionActivity'
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