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
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/vant.css">
    <link rel="stylesheet" href="css/articleTopic.css">
    <title>藏玉专题</title>
</head>

<body>
    <div ref="vue" id="vue" class="vue">
        <img :src="header.pic_article" class="topic-header" alt="" />
        <div class="topic">
            <div class="topic-title">
                {{header.title}}
            </div>
            <div class="topic-summary">{{header.summary}}</div>
        </div>
        <div class="topic-about">
            相关文章
        </div>
        <div class="list" v-for="items,index in list" v-key="index">
            <div class="item" v-for="item,index in items.article_list" v-key="index" @click="goDetail(item.id)">
                <div class="item-createdate">{{item.createdate}}</div>
                <img class="item-img" :src="checkImg(item.pic_header)" />
                <div class="item-title">{{item.title}}</div>
                <div class="item-content">{{item.content}}</div>
            </div>
        </div>
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
<script type="text/javascript" src="photoswipe/photoswipe-ui-default.min.js"></script>
<script type="text/javascript" src="photoswipe/photoswipe.js"></script>
<script type="text/javascript" src="js/photo.js"></script>
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
    var vue = new Vue({
        el: "#vue",
        data() {
            return {
                header: {},
                list: []
            }
        },
        mounted() {
            var that = this;
            that.getArticleHeader();
            that.getArticleList();
        },
        methods: {
            getArticleHeader() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/special_article_header?id=${square_id}`)
                    .then(res => {
                        var res = res.data.data;
                        console.log('header', res);
                        that.header = res;
                        that.$refs.vue.style.display = 'block';
                    })
                window.share_config = {
                    "share": {
                        "imgUrl": that.header.article_header,
                        //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                        "desc": that.header.summary, //摘要,如果分享到朋友圈的话，不显示摘要。
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
            },
            getArticleList() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/special_article_list?id=${square_id}`)
                    .then(res => {
                        var res = res.data.data;
                        console.log('list', res.list);
                        that.list = res.list;
                    })
            },
            goDetail(id) {
                window.location.href = `article.html?item_id=${id}`;
            },
            checkImg(img) {
                // console.log('check图片', img, type);
                if (img && img.indexOf('http') == -1) {
                    img = CYHOST + img;
                }
                return img;
            },
            // 跳转APP
            goApp() {
                var configs = [{
                    jmlink: 'https://a0ipue.jmlk.co/AA09',
                    button: document.querySelector('a#btnOpenApp'),
                    params: {
                        'shareID': square_id,
                        'shareIOS': 'KCTopicDetailVC',
                        'shareAndroid': 'icangyu.jade.activities.articles.CorpusDetailsActivity'
                    }
                }];
                new JMLink(configs);
            },
            // 关闭跳转链接
            close() {
                var that = this;
                that.$refs.goApp.style.display = 'none';
            }
        },
    })
</script>

</html>