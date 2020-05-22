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
    <title>藏玉话题</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/appraisal.css">
    <link rel="stylesheet" href="css/squareList.css">
    <link rel="stylesheet" href="css/vant.css">

</head>

<body>
    <div ref="vue" id="vue" class="vue">
        <img :src="header.background_image">
        <div class="header">
            <div class="header-title" v-text="header.title"></div>
            <div class="header-content" v-text="header.content"></div>
        </div>
        <div class="total" v-text="`相关帖子（${total}）`"></div>
        <div class="list" v-for="detail in list" @click="goToDetail(detail.id)">
            <div class="detail">
                <!-- 发布者信息 -->
                <div class="nick">
                    <img class="avatar" :src="checkImg(detail.avatar,'avatar')">
                    <div class="nick-right">
                        <div class="nickname">
                            <span v-text="detail.nickname"></span>
                            <span class="nick-lv" v-text="'LV.'+detail.rating"></span>
                        </div>
                        <div class="createdate" v-text="detail.createdate"></div>
                    </div>
                </div>
                <div class="content" v-text="detail.content"></div>
                <!-- 图片 -->
                <div id="album" ref="album" class="album">
                    <img class="img" v-for="item,index in detail.album" :src="checkImg(item.file_path,'img')">
                </div>
            </div>
            <div class="support" v-if="detail.all_nums>0">
                <div>
                    <img class="support-left" :src="checkImg(item.avatar_want,'avatar')" v-if="index<3" v-for="item,index in detail.praise_list">
                    <img class="support-left" style="margin-left: -2.4vw" src="img/moreuser.png" v-if="detail.all_nums>=3">
                </div>
                <span class="support-right" v-text="detail.all_nums+'人点赞'"></span>
            </div>
            <div class="detail-comment" v-if="detail.comment_all>0">
                <div class="comment-li van-ellipsis" v-for="item,index in detail.comment_list" v-if="index<4">
                    <span class="nick" v-text="item.nickname_comment"></span>
                    <span class="content" v-text="'回复'" v-if="item.tonickname"></span>
                    <span class="nick" v-text="item.tonickname" v-if="item.tonickname"></span>
                    <span class="content van-ellipsis" v-text="'：'+item.comment"></span>
                </div>
            </div>
            <div class="hr"></div>
        </div>
        <div class="get-more" v-if="total>0&&finish" style="color: #888">已加载全部</div>
        <div class="get-more" v-else-if="total>0" @click="getMore">加载更多中...</div>
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
<!-- <script type="text/javascript" src="js/weixinWeb.js"></script> -->
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
        data: {
            header: {},
            list: [],
            total: 0,
            page: 0,
            finish: false
        },

        destroyed() {
            window.removeEventListener('scroll', this.scroll, true)
        },
        created() {
            var that = this;
            that.getDetail();
            that.getHeader();
            window.addEventListener('scroll', this.scroll, true)
        },
        methods: {
            getHeader() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/topic_list_top?id=${square_id}&type=4`).then(res => {
                    that.header = res.data.data.list[0];
                    console.log(that.header, 'header');
                })
            },
            getDetail() {
                var that = this;
                console.log(that.finish);
                if (that.finish == true) return;
                axios.get(`${CYHOST}/icyApi/square_list`, {
                    params: {
                        tid: square_id,
                        type: 4,
                        page: that.page
                    }
                }).then(res => {
                    console.log(res.data.data);
                    that.total = res.data.data.total;
                    that.list = that.list.concat(res.data.data.list);
                    if (that.list.length < that.total) {
                        that.page += that.list.length;
                    } else {
                        that.finish = true;
                    }
                    that.$refs.vue.style.display = 'block';
                    console.log(that.list, that.total);
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
                });
            },
            // 验证图片是否有效
            checkImg(img, type) {
                // console.log('check图片', img, type);
                if (img && img.indexOf('http') == -1) {
                    img = CYHOST + img;
                } else {
                    if (type == 'avatar') {
                        img = 'img/avatar.png';
                    }
                }
                return img;

            },
            // 跳转帖子
            goToDetail(id) {
                console.log(id);
                window.location.href = `post.php?item_id=${id}`;
            },
            // 获取更多
            getMore() {
                var that = this;
                that.getDetail();

            },
            scroll() {
                var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                var windowHeight = document.documentElement.clientHeight || document.body.clientHeight;
                var scrollHeight = document.body.scrollHeight;
                // console.log(scrollTop + windowHeight, scrollHeight)
                if (scrollTop + windowHeight >= scrollHeight) { //测试浏览器有的时候相加 会出现小数点 这里用 >= 不用 ==
                    console.log('加载更多');
                    if (!this.timer) {
                        this.timer = setTimeout(() => {
                            this.getMore(); //请求商品数据的方法
                            this.timer = null;
                        }, 1000)
                    }
                }
            },
            // 跳转APP
            goApp() {
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