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
    <title>文章详情</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/article.css">
</head>

<body>
    <div ref="vue" id="vue" class="vue">
        <div class="title" v-text="detail.title"></div>
        <div class="createdate" v-text="detail.createdate"></div>
        <div class="content" v-html='detail.custom_page'></div>
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
            detail: {}
        },
        created() {
            var that = this;
            that.getDetail();
        },
        methods: {
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/article_details?id=${square_id}`).then(res => {
                    that.detail = res.data.data[0];
                    that.$refs.vue.style.display = "block";
                    console.log(that.detail);
                    window.share_config = {
                        "share": {
                            "imgUrl": that.detail.pic_url,
                            //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                            "desc": that.detail.content, //摘要,如果分享到朋友圈的话，不显示摘要。
                            "title": that.detail.title, //分享卡片标题
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
            // 跳转APP
            goApp() {
                var configs = [{
                    jmlink: 'https://a0ipue.jmlk.co/AA09',
                    button: document.querySelector('a#btnOpenApp'),
                    params: {
                        'shareID': square_id,
                        'shareIOS': 'KCArticleDetailVC',
                        'shareAndroid': 'icangyu.jade.activities.articles.ArticleActivity'
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
    })
</script>

</html>