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
    <link rel="stylesheet" href="css/viewer.css">
    <link rel="stylesheet" href="css/appraisal.css">
    <title>藏玉代卖</title>
    <style>
        /* 375px = 100vw;
        		336px = 89.6vw;
        		290px = 77.33vw;
        		250px = 66.67vw;
        		210px = 56vw;
        		113px = 30.13vw;
        		77px = 20.53vw;
        		50px = 13.33vw;
        		40px = 10.67vw;
        		33px = 8.8vw;
        		30px = 8vw;
        		28px = 7.47vw;
        		22.5px = 6vw;
        		20px = 5.33vw;
        		18px = 4.8vw;
        		16px = 4.27vw;
        		15px = 4vw;
        		14px = 3.7vw;
        		13px = 3.45vw;
        		12px = 3.2vw;
        		10px = 2.7vw;
        		9px = 2.4vw;
        		5px = 1.33vw;
        		4px = 1.07vw;
        		3px = 0.8vw;
        		*/
        .detail .album {
            width: 92vw;
            height: auto;
        }

        .detail .album .img {
            width: 92vw;
            height: auto;
            margin-bottom: 4vw;
        }

        .attributes-list,
        tips {
            width: 100vw;
            padding: 4vw 0vw;
        }


        .attributes-content,
        .tips-title {
            width: 100vw;
            text-align: center;
        }

        .tips-content {
            width: 92vw;
            padding: 4vw;
            color: #888;
            font-size: 3.7vw;
        }
    </style>
</head>



<body>
    <div id="vue" ref="vue" class="vue">
        <!-- 顶部详情 -->
        <div class="detail">
            <!-- 发布者信息 -->
            <div class="nick">
                <img class="avatar" :src="checkImg(detail.avatar,'avatar')">
                <div class="nick-right">
                    <div class="nickname">
                        <span v-text="detail.nickname"></span>
                        <span class="nick-lv" :style="detail.rating<8?'background:#f7f7f7':''" v-text="'LV.'+detail.rating"></span>
                    </div>
                    <div class="createdate" v-text="detail.createdate"></div>
                </div>
            </div>
            <!-- 内容 -->
            <div class="content" v-text="detail.content"></div>
            <!-- 图片 -->
            <div id="album" ref="album" class="album">
                <img class="img" v-for="item,index in detail.album" :src="checkImg(item.file_path,'img')" @click="bigImg(item.file_path)">
            </div>
        </div>
        <!-- 分隔行 -->
        <div class="hr"></div>
        <!-- 点赞人数 -->
        <div class="likes">
            <span>
                <img class="img" :src="checkImg(item.avatar_want,'avatar')" v-for="item in detail.praise_list">
            </span>
            <span v-text="detail.praise_all+'人感兴趣'"></span>
        </div>
        <!-- 分隔行 -->
        <div class="hr"></div>
        <!-- 评论 -->
        <div class="attributes-list">
            <div class="attributes-content" v-text="'产品属性'"></div>
            <div class="attributes">
                <div class="item" v-for="item in detail.attributes">
                    <span class="title" v-text="item.title"></span>
                    <span class="value" v-text="item.value"></span>
                </div>
            </div>
        </div>
        <div class="tips">
            <div class="tips-title" v-text="'温馨提示'"></div>
            <div class="tips-content" v-text="'藏玉买卖旨在给玉友提供一个免费的宝贝交流与展示的平台。对于广大玉友发布的买卖帖子，藏玉严选官方会依据发布的图片内容给出专业建议，仅供玉友参考。'"></div>
        </div>
        <div class="comment-title" v-text="`评论（${total}）`"></div>
        <div class="comment-list" v-for="item,index in list" v-key='index'>
            <img class="comment-avatar" :src="checkImg(item.comment_avatar,'avatar')">
            <div class="comment-right">
                <div class="comment-nickname" v-text="item.nickname" style="color:#bc2e2e"></div>
                <div class="comment-content">
                    <span v-if="item.tonickname" v-text="'回复'"></span>
                    <span v-if="item.tonickname" v-text="item.tonickname" style="color:#bc2e2e"></span>
                    <span v-text="item.comment"></span>
                </div>
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
    var app = new Vue({
        el: '#vue',
        data: {
            detail: {},
            list: [],
            total: 0
        },
        created() {
            var that = this;
            that.getDetail();
            that.getComments();
        },
        methods: {
            // 获取详情
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/details_trade`, {
                    params: {
                        id: square_id
                    }
                }).then(res => {
                    that.detail = res.data.data;
                    that.$refs.vue.style.display = 'block';
                    console.log('买卖详情', that.detail);
                    window.share_config = {
                        "share": {
                            "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",
                            //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                            "desc": that.detail.content, //摘要,如果分享到朋友圈的话，不显示摘要。
                            "title": '藏玉买卖', //分享卡片标题
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
            // 评论信息
            getComments() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/comment_lists`, {
                    params: {
                        id: square_id,
                        type: 9,
                    }
                }).then(res => {
                    that.list = res.data.data.list;
                    that.total = res.data.data.total;
                    console.log('评论列表', that.list);
                }).catch(err => {
                    console.log(err);
                })
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
            // 点击显示大图
            bigImg(img) {
                var viewer = new Viewer(this.$refs.album, {
                    // 具体参数配置，后面会讲到
                    url: img,
                    toolbar: false,
                    button: false,
                    title: false
                });
            },
            // 跳转APP
            goApp() {
                var configs = [{
                    jmlink: 'https://a0ipue.jmlk.co/AA09',
                    button: document.querySelector('a#btnOpenApp'),
                    params: {
                        'shareID': square_id,
                        'shareIOS': 'KCConsignDetailVC',
                        'shareAndroid': 'cangyu.jade.activities.select.ConsignPostActivity'
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