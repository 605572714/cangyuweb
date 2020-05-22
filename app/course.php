<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>藏玉课程</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.2/lib/index.css">
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/course.css">
</head>

<body>
    <div ref="vue" id="vue" class="vue">
        <!-- 头部视频播放位和图片展示位 -->
        <div class="video">
            <!-- 播放器 -->
            <video ref="video" :src="detail.video_url" v-show="video" controls @ended='playEnd' @error='playErr' @canplay='videoLoad'></video>
            <!-- 介绍视频可以播放并且没有播放时展示 -->
            <img class="play-icon" src="img/play.png" v-if="canPlay&&!playing" @click='goPlay(index)'>
            <!-- 占位图 -->
            <img class="img" ref="img" :src="detail.video_cover" v-show="!video" />
        </div>
        <!-- 标题价格 -->
        <div class=" top">
            <div class="title" v-text="detail.title"></div>
            <div class="price">
                <span v-text="detail.price>0?detail.price:'免费'"></span>
                <div class="original-price" v-text="detail.price_original"></div>
            </div>
        </div>
        <!-- 分隔符 -->
        <div class="liner"></div>
        <!-- teb标签 -->
        <van-tabs v-model="active">
            <van-tab title="简介">
                <div class="detail">
                    <div class="taber" v-text="'老师简介'"></div>
                    <div class="lector" style="color: #bc2e2e">
                        <div class="avatar">
                            <img :src="detail.lector_avatar">
                            <div class="nickname" v-text="detail.lector_name"></div>
                        </div>
                        <div class="lector-des" v-text="detail.lector_des"></div>
                    </div>
                    <div class="taber" v-text="'课程简介'"></div>
                    <div class="course-content" v-text="detail.course_content"></div>
                </div>
            </van-tab>
            <van-tab title="目录">
                <div class="list">
                    <div class="item" v-for="item,index in list" v-key="index" @click="goPlay(index)">
                        <img class="playing" src="img/playing.png" v-show='playIndex == index'>
                        <div class="index" v-text="index+1" v-show="playIndex != index"></div>
                        <div class="item-detail">
                            <div class="item-title" v-text="item.title" :style="playIndex == index?'color:#bc2e2e':''">
                            </div>
                            <div class="item-nums">
                                <img src="img/play_nums.png" alt="">
                                <span v-text="item.clicks"></span>
                            </div>
                            <div class="item-status">
                                <img src="img/course.png" v-if="detail.price==0">
                                <img src="img/locking.png" v-else-if="item.free==1">
                                <span v-text="'试看'" v-else-if="item.free==0"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </van-tab>
        </van-tabs>
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
    <script src="https://cdn.jsdelivr.net/npm/vant@2.2/lib/vant.min.js"></script>
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
        var square_id = HttpHelper.getQuery('item_id');
        new Vue({

            el: '#vue',
            data() {
                return {
                    active: 0,
                    detail: {},
                    list: [],
                    video: '',
                    playIndex: 999,
                    canPlay: false,
                    playing: false,
                    loadFinish: false
                }
            },
            mounted() {
                window.addEventListener('scroll', this.scrollToTop)
                var that = this;
                that.getDetail();
                that.courseList();
            },
            destroyed() {
                window.removeEventListener('scroll', this.scrollToTop)
            },
            methods: {
                // 课程简介
                getDetail() {
                    var that = this;
                    axios.get(`${CYHOST}/icyApiCourse/courseDetails`, {
                        params: {
                            id: square_id
                        }
                    }).then(res => {
                        that.detail = res.data.data;
                        that.$refs.vue.style.display = "block";
                        console.log('课程简介', that.detail);
                        window.share_config = {
                            "share": {
                                "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png",
                                //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                                "desc": that.detail.course_content, //摘要,如果分享到朋友圈的话，不显示摘要。
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
                    })
                },
                // 课程列表
                courseList() {
                    var that = this;
                    axios.get(`${CYHOST}/icyApiCourse/courseList`, {
                        params: {
                            id: square_id
                        }
                    }).then(res => {
                        that.list = res.data.data.list;
                        console.log('课程列表', that.list);

                    })
                },
                // 播放
                goPlay(index) {
                    var that = this;
                    that.playing = true;
                    if (item == 999) {
                        var video = this.$refs.video;
                        video.src = that.detail.video_url;
                        video.play();
                    } else {
                        if (index >= that.list.length) {
                            that.playIndex = 999;
                            that.video = '';
                            console.log('全部播放完毕');
                            return;
                        }
                        var item = that.list[index];
                        if (item.free == 1) {
                            that.video = '';
                            that.$dialog.confirm({
                                    message: '请前往APP支付并观看',
                                }).then(() => { //点击确认按钮后的调用
                                    console.log("点击了确认按钮噢")
                                    that.goApp();
                                })
                                .catch(() => { //点击取消按钮后的调用
                                    console.log("点击了取消按钮噢")
                                })
                        } else {
                            console.log(index);
                            axios.get(`${CYHOST}/icyApiCourse/play`, {
                                params: {
                                    id: item.id
                                }
                            }).then(res => {
                                console.log('播放');
                                that.video = item.video_url;
                                that.playIndex = index;
                                var video = this.$refs.video;
                                video.src = item.video_url;
                                video.play();
                                that.list[index].clicks = parseInt(that.list[index].clicks) + 1;
                                that.backTop();
                            }).catch(err => {
                                console.log('失败', err);
                            })

                        }
                    }
                },
                // 视频可播放
                videoLoad(event) {
                    console.log('视频可播放', event);
                    var that = this;
                    that.canPlay = true;
                },
                // 播放结束
                playEnd() {
                    var that = this;
                    that.playIndex += 1;
                    that.goPlay(that.playIndex)
                    console.log('播放结束', that.playIndex);
                },
                // 播放失败
                playErr(err) {
                    console.log('播放失败');
                    var that = this;
                    that.canPlay = false;
                    that.playing = false;
                },
                // 回到顶部方法，加计时器是为了过渡顺滑
                backTop() {
                    const that = this
                    let timer = setInterval(() => {
                        let ispeed = Math.floor(-that.scrollTop / 5)
                        document.documentElement.scrollTop = document.body.scrollTop = that.scrollTop +
                            ispeed
                        if (that.scrollTop === 0) {
                            clearInterval(timer)
                        }
                    }, 16)
                },
                // 为了计算距离顶部的高度，当高度大于60显示回顶部图标，小于60则隐藏
                scrollToTop() {
                    const that = this;
                    let scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body
                        .scrollTop
                    that.scrollTop = scrollTop
                    if (that.scrollTop > 210) {
                        that.showSmall = true;
                    } else {
                        that.showSmall = false;
                    }
                },
                // 跳转APP
                goApp() {
                    var configs = [{
                        jmlink: 'https://a0ipue.jmlk.co/AA09',
                        button: document.querySelector('a#btnOpenApp'),
                        params: {
                            'shareID': square_id,
                            'shareIOS': 'KCLessonDetailVC',
                            'shareAndroid': 'icangyu.jade.activities.course.CourseDetailsActivity'
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
</body>

</html>