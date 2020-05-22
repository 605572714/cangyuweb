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
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉商城</title>
    <!-- <link rel="stylesheet" href="css/my-app.css"> -->
    <link rel="stylesheet" href="css/mallList.css">
    <link rel="stylesheet" href="css/vant.css">
</head>

<body>
    <div id="vue" class="vue-phone">
        <div class="pc-title">藏玉商城</div>
        <van-tabs v-model="active" swipeable @change="onChange">
            <van-tab title="全部">
                <div class="list" :style="'display:'+listDisplay" v-if="homeList">
                    <div class="item" v-for="item in homeList">
                        <a :href="'mallDetail.php?item_id='+item.id" class="block-a">
                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <div class="item-img">
                                <img :src="item.headlines" alt="">
                            </div>
                            <div class="item-detail">
                                <div class="item-title">
                                    {{item.title}}
                                </div>
                                <div class="item-price">
                                    ￥{{item.discount_price}}
                                    <span class="item-memberPrice" v-if="item.tag_string.indexOf('会员')!=-1">会员价￥{{item.member_price}}</span>
                                    <span class="item-oldPrice" v-else-if="item.tag_string.indexOf('折扣')!=-1">￥{{item.old_price}}</span>
                                </div>
                                <div class="item-status"><span>{{item.tag_string}}</span></div>
                            </div>
                        </a>
                    </div>
                    <div class="get-more" v-if="homeFinish" style="color: #888">已加载全部</div>
                    <div class="get-more" v-else @click="getMore">加载更多中...</div>
                </div>
            </van-tab>
            <van-tab title="会员超值">
                <div class="list" :style="'display:'+listDisplay" v-if="vipList">
                    <div class="item" v-for="item in vipList">
                        <a :href="'mallDetail.html?item_id='+item.id" class="block-a">
                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <div class="item-img">
                                <img :src="item.headlines" alt="">
                            </div>
                            <div class="item-detail">
                                <div class="item-title">
                                    {{item.title}}
                                </div>
                                <div class="item-price">
                                    ￥{{item.discount_price}}
                                    <span class="item-memberPrice" v-if="item.tag_string.indexOf('会员')!=-1">会员价￥{{item.member_price}}</span>
                                    <span class="item-oldPrice" v-else-if="item.tag_string.indexOf('折扣')!=-1">￥{{item.old_price}}</span>
                                </div>
                                <div class="item-status"><span>{{item.tag_string}}</span></div>
                            </div>
                        </a>
                    </div>
                    <div class="get-more" v-if="vipFinish" style="color: #888">已加载全部</div>
                    <div class="get-more" v-else @click="getMore">加载更多中...</div>
                </div>
            </van-tab>
            <van-tab title="折扣特惠">
                <div class="list" :style="'display:'+listDisplay" v-if="saleList">
                    <div class="item" v-for="item in saleList">
                        <a :href="'mallDetail.php?item_id='+item.id" class="block-a">

                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <div class="item-img">
                                <img :src="item.headlines" alt="">
                            </div>
                            <div class="item-detail">
                                <div class="item-title">
                                    {{item.title}}
                                </div>
                                <div class="item-price">
                                    ￥{{item.discount_price}}
                                    <span class="item-memberPrice" v-if="item.tag_string.indexOf('会员')!=-1">会员价￥{{item.member_price}}</span>
                                    <span class="item-oldPrice" v-else-if="item.tag_string.indexOf('折扣')!=-1">￥{{item.old_price}}</span>
                                </div>
                                <div class="item-status"><span>{{item.tag_string}}</span></div>
                            </div>
                        </a>
                    </div>
                    <div class="get-more" v-if="saleFinish" style="color: #888">已加载全部</div>
                    <div class="get-more" v-else @click="getMore">加载更多中...</div>
                </div>

            </van-tab>
            <van-tab title="玉友惠选">
                <div class="list" :style="'display:'+listDisplay" v-if="csmList">
                    <div class="item" v-for="item in csmList">
                        <a :href="'mallDetail.html?item_id='+item.id" class="block-a">

                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <div class="item-img">
                                <img :src="item.headlines" alt="">
                            </div>
                            <div class="item-detail">
                                <div class="item-title">
                                    {{item.title}}
                                </div>
                                <div class="item-price">
                                    ￥{{item.discount_price}}
                                    <span class="item-memberPrice" v-if="item.tag_string.indexOf('会员')!=-1">会员价￥{{item.member_price}}</span>
                                    <span class="item-oldPrice" v-else-if="item.tag_string.indexOf('折扣')!=-1">￥{{item.old_price}}</span>
                                </div>
                                <div class="item-status"><span>{{item.tag_string}}</span></div>
                            </div>
                        </a>
                    </div>
                    <div class="get-more" v-if="csmFinish" style="color: #888">已加载全部</div>
                    <div class="get-more" v-else @click="getMore">加载更多中...</div>
                </div>
            </van-tab>
        </van-tabs>
        <a class="return-top" href="#top" target="_self">
            <img src="img/returnTop.png" alt="">
        </a>
        <!-- <div class="cangyu_bbs_tabber" v-if="!closeBottom">
            <a href="javascript:void(0)" class="close" @click='close'></a>
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" target="_self" class="download" rel="nofollow">
                <div class="logo"></div>
                <div class="banner-label">
                    <p class="tb" data-node="appName">下载APP</p>
                    <p class="title-sub">了解最新业内资讯</p>
                </div>
                <div class="open">立即打开</div>
            </a>
        </div> -->
    </div>

</body>

<!-- 图片预览 -->
<script type="text/javascript" src="js/viewer.js"></script>
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
            'onMenuShareWeibo'
        ]
    });
</script>
<script>
    new Vue({
        el: '#vue',
        data() {
            return {
                active: 0,
                homeList: [],
                homePage: 0,
                homeFinish: false,
                vipList: [],
                vipPage: 0,
                vipFinish: false,
                saleList: [],
                salePage: 0,
                saleFinish: false,
                csmList: [],
                csmPage: 0,
                csmFinish: false,
                listDisplay: 'none',
                closeBottom: false
            }
        },
        created() {
            var that = this;
            window.addEventListener('scroll', this.scroll, true)
        },
        mounted() {
            var that = this;
            this.browserRedirect();
            this.getHomeList();
            this.getVipList();
            this.getSaleList();
            this.getCsmList();
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": '', //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": '藏玉商城', //分享卡片标题
                    "link": window.location.href, //分享出去后的链接，这里可以将链接设置为另一个页面。
                    "success": function() {
                        //分享成功后的回调函数
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
        destroyed() {
            window.removeEventListener('scroll', this.scroll, true)
        },
        methods: {
            getHomeList() {
                var that = this;
                // 商城首页
                if (that.homeFinish == true) return;
                axios.get(`${CYHOST}/icyApi/mall_list`, {
                        params: {
                            page: that.homePage
                        }
                    })
                    .then(function(response) {
                        var res = response.data.data;
                        console.log(res);
                        that.listDisplay = 'flex';
                        that.homeList = that.homeList.concat(res.list);
                        if (that.homeList.length < res.total) {
                            that.homePage += res.list.length;
                        } else {
                            that.homeFinish = true;
                        }
                    })
            },
            getVipList() {
                var that = this
                // 会员超值
                if (that.vipFinish == true) return;
                axios.get(`${CYHOST}/icyApi/mall_list`, {
                        params: {
                            type: 2,
                            page: that.vipPage
                        }
                    })
                    .then(function(response) {
                        var res = response.data.data
                        console.log(res);
                        that.listDisplay = 'flex';
                        that.vipList = that.vipList.concat(res.list);
                        if (that.vipList.length < res.total) {
                            that.vipPage += res.list.length;
                        } else {
                            that.vipFinish = true;
                        }
                    })
            },
            getSaleList() {
                var that = this;
                // 折扣特惠
                if (that.saleFinish == true) return;
                axios.get(`${CYHOST}/icyApi/mall_list`, {
                        params: {
                            type: 3,
                            page: that.salePage
                        }
                    })
                    .then(function(response) {
                        var res = response.data.data
                        console.log(res);
                        that.listDisplay = 'flex';
                        that.saleList = that.saleList.concat(res.list);
                        if (that.saleList.length < res.total) {
                            that.salePage += res.list.length;
                        } else {
                            that.saleFinish = true;
                        }
                    })

            },
            getCsmList() {
                var that = this;
                // 玉友代卖
                if (that.csmFinish == true) return;
                axios.get(`${CYHOST}/icyApi/mall_list`, {
                        params: {
                            type: 4,
                            page: that.csmPage
                        }
                    })
                    .then(function(response) {
                        var res = response.data.data
                        console.log(res);
                        that.listDisplay = 'flex';
                        that.csmList = that.csmList.concat(res.list);
                        if (that.csmList.length < res.total) {
                            that.csmPage += res.list.length;
                        } else {
                            that.csmFinish = true;
                        }
                    })
            },
            onChange() {
                document.documentElement.scrollTop = 0;
                document.body.scrollTop = 0;
            },
            // 判断是移动端还是PC端
            browserRedirect() {
                var sUserAgent = navigator.userAgent.toLowerCase();
                var vueClass = document.getElementById('vue');
                if (/ipad|iphone|midp|rv:1.2.3.4|ucweb|android|windows ce|windows mobile/.test(sUserAgent)) {
                    //跳转移动端页面
                    console.log('phone');

                } else {
                    //跳转pc端页面
                    console.log('PC');
                    vueClass.className = "vue-pc";
                }
            },
            getMore() {
                var that = this;
                console.log(that.active);
                switch (that.active) {
                    case 0:
                        console.log('加载首页');
                        that.getHomeList();
                        break;
                    case 1:
                        that.getVipList();
                        break;
                    case 2:
                        that.getSaleList();
                        break;
                    case 3:
                        that.getCsmList();
                        break;
                }
            },
            close() {
                this.closeBottom = true
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
            }
        }
    });
</script>

</html>