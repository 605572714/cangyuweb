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
    <title>藏玉砍价</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/vant.css">
    <link rel="stylesheet" href="css/cutDetail.css">
    <link rel="stylesheet" href="photoswipe/default-skin.css">
    <link rel="stylesheet" href="photoswipe/photoswipe.css">

</head>

<body>
    <div ref="vue" id="vue" class="vue">
        <img class="headlines" :src="detail.pro_img" alt="">
        <div class="status" style="background:#f89649">
            <div class="state">
                <span v-text="checkStatus(detail)"></span>
                <span class="progress" style="background: rgba(255,245,229,0.38)">
                    <span class='progress_bgc' :style="getWidth(detail)">
                        <span class='progress_text' v-text="detail.left_stock>0?`仅剩${detail.left_stock}件`:`已售罄`"></span>
                    </span>
                </span>
            </div>

            <!-- <van-count-down :time="time" /> -->
            <van-count-down :time="time">
                <template v-slot="timeData">
                    <span class="time" v-if="checkStatus(detail)=='即将开始'" v-text="timeData.days>0?`距开始还剩 ${timeData.days}天${ timeData.hours }时`:`${timeData.hours}时${
          timeData.minutes }分${ timeData.seconds }秒`">
                    </span>
                    <span class="time" v-if="checkStatus(detail)=='进行中'" v-text="timeData.days>0?`距结束还剩 ${timeData.days}天${ timeData.hours }时`:`${timeData.hours}时${
          timeData.minutes }分${ timeData.seconds }秒`">
                    </span>
                    <span class="time" v-if="checkStatus(detail)=='已结束'" v-text="">
                    </span>
                </template>
            </van-count-down>
        </div>
        <div class="top">
            <div class="title" v-text="detail.pro_name"></div>
            <div class="price" v-text="`￥${detail.price}`"></div>
        </div>
        <div class="rule">
            <span v-text="'点击查看砍价规则'" @click="ruleDetail"></span>
        </div>
        <!-- <div class="hr"></div> -->
        <div class="detail">
            <div class="title">
                <span v-text="'产品详情'"></span>
            </div>
            <div class="content" v-text="detail.content"></div>
            <!-- 图片 -->
            <div class="my-gallery album" data-pswp-uid="1">
                <figure v-for="item,index in detail.imgList">
                    <div>
                        <a :href="checkImg(item,'img')" data-size="1920x1080">
                            <img class="img" :src="checkImg(item,'img')">
                        </a>
                    </div>
                    <!-- <figcaption style="display:none;">在这里可增加图片描述</figcaption> -->
                </figure>
            </div>
            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="pswp__bg"></div>
                <div class="pswp__scroll-wrap">
                    <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                    </div>
                    <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                            <div class="pswp__counter"></div>
                            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                            <button class="pswp__button pswp__button--share" title="Share"></button>
                            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                            <div class="pswp__preloader">
                                <div class="pswp__preloader__icn">
                                    <div class="pswp__preloader__cut">
                                        <div class="pswp__preloader__donut"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div>
                        </div>
                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                        </button>
                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                        </button>
                        <div class="pswp__caption">
                            <div class="pswp__caption__center"></div>
                        </div>
                    </div>
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
    var nowDate = (new Date()).valueOf();
    console.log(square_id);
    var vue = new Vue({
        el: "#vue",
        data: {
            time: 0,
            detail: {},
            promise: ['平台保障', '如实描述', '三日包退'],
            notice: []
        },
        created() {
            var that = this;
            that.getDetail();
            that.getNotice();
        },
        methods: {
            getDetail() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/bargain/proDetail?id=${square_id}`).then(res => {
                    // console.log(res.data.data);
                    that.detail = res.data.data;
                    that.checkStatus(that.detail);
                    initPhotoSwipeFromDOM('.my-gallery');
                    that.$refs.vue.style.display = 'block';
                    console.log(that.detail);
                    window.share_config = {
                        "share": {
                            "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",
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
            // 砍价公告
            getNotice() {
                var that = this;
                axios.get(`${CYHOST}/icyApi/bargain/notice?id=${square_id}`).then(res => {
                    console.log(res.data.data, 'notice');
                    // that.detail = res.data.data;
                    // console.log(that.detail);
                }).catch(err => {
                    console.log(err);
                })
            },
            // 获取剩余数量宽度
            getWidth(item) {
                return ' width:' + (item.left_stock / item.stock * 100).toFixed(0) + '%;';
            },
            // 倒计时
            // 判断商品状态 
            checkStatus(item) {
                var that = this;
                if (nowDate < item.starttime * 1000) {
                    that.time = item.starttime * 1000 - nowDate;
                    return '即将开始';

                } else if (nowDate < item.endtime * 1000) {

                    that.time = item.endtime * 1000 - nowDate;
                    return '进行中';
                } else {
                    return '已结束';
                    that.time = ''
                }
            },
            // 跳转规则页面
            ruleDetail() {
                window.location.href = 'appRuleDetail.html?item_id=rule022';
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
                        'shareIOS': 'KCCutDetailVC',
                        'shareAndroid': 'icangyu.jade.activities.crowd.CutDetailsActivity'
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