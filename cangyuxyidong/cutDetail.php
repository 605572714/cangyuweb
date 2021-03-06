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
    <meta name="divport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/cutDetail.css">
    <script src="js/vue/vue.min.js"></script>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="swiper/swiper.min.css">
    <script type="text/javascript" src="js/config.js"></script>
    <script type="text/javascript" src="swiper/swiper.min.js"></script>
    <script src="js/vue-resource/vue-resource.min.js"></script>
    <script src="photoswipe/photoswipe.js"></script>
    <script src="photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/weixinWeb.js"></script>
    <title>藏玉砍价</title>
</head>

<body>
    <div id="app">
        <!-- <swiper class="swiper_container" vertical="true" autoplay="true" circular="true" interval="2000">
            <block v-for="(item, index) in notice" :key="index">
                <swiper-item>
                    <div class="swiper_item">{{ item }}</div>
                </swiper-item>
            </block>
        </swiper> -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for='item,index in imgList' @click="preview(index)">
                    <img :src="item" :style="'height:'+imgHeight+'px;width:100%;'" alt="">
                </div>
            </div>
        </div>
        <div class="top">
            <div class="title">{{pro_name}}</div>
            <div class="price">￥{{price}}</div>
            <div class="content">
                <div class="title">产品详情</div>
                <div class="rich"></div>
                {{content}}
            </div>
        </div>
        <div class="bottom">
            <div class="moreList">更多推荐</div>
            <!-- <div> -->
            <a :href="'cutDetail.html?id='+item.id" class="contain" v-for="(item, index) in proList" :key="index">
                <div class="endIcon" v-if="item.type == 0">已结束</div>
                <img class="img" :src="item.pro_img" mode="aspectFill">
                <div class="detail" :style="'width:'+wWidth+'px;' ">
                    <div class="title">{{ item.pro_name }}</div>
                    <div class="status1">
                        <div class="price">¥{{ item.price }}</div>
                        <my-progress :schedule="item.left_stock / item.stock" :lest="item.left_stock" />
                    </div>
                    <div class="status2" style="margin-top: 30rpx;">
                        <div class="partake" v-if="item.starttime>nowDate">即将开始</div>
                        <div class="partake" v-else-if="item.endtime>nowDate && item.left_stock > 0">我要参与</div>
                        <div class="partake" v-else style="background:#B2B2B2 ;">
                            已结束</div>
                    </div>
                </div>
            </a>
            <!-- </div> -->
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
        var square_id = HttpHelper.getQuery('item_id');
        // var square_id = 6;
        var wWidth = document.body.clientWidth;
        var app = new Vue({
            el: '#app',
            data: {
                configs: null,
                hidden: false,
                detail: null,
                imgList: [],
                pro_name: null,
                price: null,
                content: null,
                proList: null,
                wWidth: wWidth - 200,
                imgHeight: wWidth * 0.56,
                nowDate: Date.parse(new Date()) / 1000
            },
            mounted() {
                var that = this;
                that.getDetail();
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    prevButton: '.swiper-button-prev',
                    paginationClickable: true,
                    autoplay: {
                        disableOnInteraction: false,
                    },
                    autoplay: 1500,
                    observer: true, //修改swiper自己或子元素时，自动初始化swiper
                    observeParents: true, //修改swiper的父元素时，自动初始化swiper
                    loop: true,
                });
            },
            methods: {
                getDetail() {
                    var that = this;
                    that.$http.get(`${CYHOST}/icyApi/bargain/proDetail?id=${square_id}&type=1`).then(res => {
                        console.log(res.body.data)
                        console.log(this.imgHeight)
                        console.log(this.wWidth)
                        that.detail = res.body.data
                        that.imgList = res.body.data.imgList
                        for (let i = 0; i < that.imgList.length; i++) {
                            if (that.imgList[i].indexOf('http') == -1) {
                                that.imgList[i] = CYHOST + that.imgList[i]
                            }
                        }
                        that.pro_name = res.body.data.pro_name
                        that.price = res.body.data.price
                        that.content = res.body.data.content
                        that.proList = res.body.data.proList
                        window.share_config = {
                            "share": {
                                "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                                "desc": that.content, //摘要,如果分享到朋友圈的话，不显示摘要。
                                "title": that.pro_name, //分享卡片标题
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
                        wx.error(function (res) {
                            console.log(res)
                        })
                        wx.checkJsApi({
                            jsApiList: ['previewImage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                            success: function (res) {
                                console.log(res)
                                // 以键值对的形式返回，可用的api值true，不可用为false
                                // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                            }
                        })
                    })
                },
                preview(index) {
                    var imgArr = this.imgList
                    wx.previewImage({
                        current: imgArr[index], //当前图片地址
                        urls: imgArr, //所有要预览的图片的地址集合 数组形式
                    })
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
            <div class="open" @click="openApp">立即打开</div>
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
                    'shareIOS': 'KCCutDetailVC',
                    'shareAndroid': 'icangyu.jade.activities.crowd.CutDetailsActivity'
                }
            }];
            new JMLink(configs);
        });
    </script>
</body>

</html>