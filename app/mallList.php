<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉商城</title>
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/mallList.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.2/lib/index.css">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
</head>

<body>
    <div id="vue" class="vue-phone">
        <div class="pc-title">藏玉商城</div>
        <van-tabs v-model="active">
            <van-tab title="全部">
                <div class="list" :style="'display:'+listDisplay" v-if="homeList">
                    <div class="item" v-for="item in homeList">
                        <a :href="'mallDetail.html?item_id='+item.id" class="block-a">
                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <img class="item-img" :src="item.headlines" alt="">
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
                    <div class="get-more" v-else @click="getMore">点击加载更多</div>
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
                            <img class="item-img" :src="item.headlines" alt="">
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
                    <div class="get-more" v-else @click="getMore">点击加载更多</div>
                </div>
            </van-tab>
            <van-tab title="折扣特惠">
                <div class="list" :style="'display:'+listDisplay" v-if="saleList">
                    <div class="item" v-for="item in saleList">
                        <a :href="'mallDetail.html?item_id='+item.id" class="block-a">

                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <img class="item-img" :src="item.headlines" alt="">
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
                    <div class="get-more" v-else @click="getMore">点击加载更多</div>
                </div>

            </van-tab>
            <van-tab title="玉友慧选">
                <div class="list" :style="'display:'+listDisplay" v-if="csmList">
                    <div class="item" v-for="item in csmList">
                        <a :href="'mallDetail.html?item_id='+item.id" class="block-a">

                            <div class="item-muns" v-if="item.left_nums>0">
                                仅剩{{item.left_nums}}件
                            </div>
                            <div class="item-no-muns" v-else>
                                已结缘
                            </div>
                            <img class="item-img" :src="item.headlines" alt="">
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
                    <div class="get-more" v-else @click="getMore">点击加载更多</div>
                </div>
            </van-tab>
        </van-tabs>
        <a class="return-top" href="#top" target="_self">
            <img src="img/returnTop.png" alt="">
        </a>
        <div class="cangyu_bbs_tabber" v-if="!closeBottom">
            <a href="javascript:void(0)" class="close" @click='close'></a>
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade" target="_self" class="download" rel="nofollow">
                <div class="logo"></div>
                <div class="banner-label">
                    <p class="tb" data-node="appName">下载APP</p>
                    <p class="title-sub">了解最新业内资讯</p>
                </div>
                <div class="open">立即打开</div>
            </a>
        </div>
    </div>

</body>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/config.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vant@2.2/lib/vant.min.js"></script>
<script src="https://cdn.bootcss.com/axios/0.19.0-beta.1/axios.min.js"></script>
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
        beforeMounted() {},
        mounted() {
            var that = this;
            this.browserRedirect();
            this.getHomeList();
            this.getVipList();
            this.getSaleList();
            this.getCsmList();
            window.share_config = {
                "share": {
                    "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",
                    //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                    "desc": '', //摘要,如果分享到朋友圈的话，不显示摘要。
                    "title": '商品详情', //分享卡片标题
                    "link": window.location.href, //分享出去后的链接，这里可以将链接设置为另一个页面。
                    "success": function() {
                        //分享成功后的回调函数
                    },
                    'cancel': function() {
                        // 用户取消分享后执行的回调函数
                    }
                }
            };

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
            }
        }
    });
</script>

</html>