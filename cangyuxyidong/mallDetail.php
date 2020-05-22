<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>商品详情</title>
	<script src="js/vue/vue.min.js"></script>
	<script src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/config.js"></script>
	<script src="js/vue-resource/vue-resource.min.js"></script>
	<script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/mallDetail.css" />
	<link rel="stylesheet" href="css/my-app.css">
	<script type="text/javascript" src="js/weixinWeb.js"></script>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
</head>

<body>
	<div id="app" class="contain">
		<!-- <loading v-if="loading" /> -->
		<template v-if="video_url">
			<video class="video" :src="video_url" :poster="detail.video_cover" controls></video>
		</template>
		<template v-else>
			<img class="video" :src="headlines" mode="aspectFill"></img>
		</template>
		<div class="top">
			<template>
				<div class="progress" v-if="detail.nums > 1">
					<div class="progress_back" :style="'width:' + detail.schedule * 180 + 'rpx;'">
						<span v-if="detail.left_nums > 0">仅剩{{ detail.left_nums }}件</span>
						<span v-else>已售罄</span>
					</div>
				</div>
			</template>
			<div class="title">{{ detail.title }}</div>
			<div class="priceList">
				<div class="price">¥{{ detail.discount_price }}</div>
				<div class="old_price" v-if="detail.tag_string.indexOf('会员') != -1">会员价¥{{ detail.member_price }}</div>
				<div class="old_price" style="text-decoration: line-through" v-else-if="detail.discount_price!== detail.old_price">¥{{ detail.old_price }}
				</div>
			</div>

			<div class="discount">
				<div class="item" v-if="detail.tag_string">{{ detail.tag_string }}</div>
			</div>
			<div class="members" v-if="detail.tag_string.indexOf('会员') != -1" @click="getVip">
				<!-- <img class="vipIcon" src="../../static/img/vipIcon.png" mode=""></img> -->
				<div>
					开通会员，可享专属会员价
					<span>¥{{ detail.member_price }}</span>
				</div>
				<!-- <img class="vipInter" src="../../static/img/vipInter.png" mode=""></img> -->
			</div>
		</div>
		<Service />
		<div class="detail">
			<div class="title">
				<span v-text="'商品描述'"></span>
			</div>
			<div class="content" v-text="detail.content"></div>
			<div class="album" v-for="(item, index) in detail.album" :key="index">
				<img class="img background" :src="item.file_path" :style="detail.content?'margin:0vw 4vw 2.7vw 4vw;width:92vw;':''"></img>
			</div>
		</div>
		<div class="cangyu_bbs_tabber">
			<a href="javascript:void(0)" class="close" @click='close'></a>
			<a>
				<div class="logo"></div>
				<div class="banner-label">
					<p class="tb" data-node="appName">下载APP</p>
					<p class="title-sub">了解最新业内资讯</p>
				</div>
				<div class="open" id="btnOpenApp" hover-class="none" @click='btnOpenApp' hover-class="none">立即打开</div>
			</a>
		</div>
	</div>
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
	<script type="text/javascript">
		var square_id = HttpHelper.getQuery('item_id');
		var app = new Vue({
			el: "#app",
			data() {
				return {
					detail: null,
					video_url: null,
					headlines: null
				}
			},
			mounted() {
				var that = this;
				that.getDetail()
			},
			methods: {
				getDetail() {
					var that = this;
					that.$http.get(`${CYHOST}/icyApi/mall_details?id=${square_id}`).then(
						res => {
							console.log(res.data.data);
							var res = res.data.data
							if (res.album.length > 0) {
								for (var i = 0; i < res.album.length; i++) {
									res.album[i].linheight = 750 / res.album[i].width * res.album[i].height;
								}
							}
							that.detail = res;
							that.video_url = res.video_url;
							that.headlines = res.headlines;
							res.schedule = res.left_nums / res.nums;
						})
					window.share_config = {
						"share": {
							"imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
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
					wx.ready(function() {
						wx.onMenuShareAppMessage(share_config.share); //分享给好友
						wx.onMenuShareTimeline(share_config.share); //分享到朋友圈
						wx.onMenuShareQQ(share_config.share); //分享给手机QQ
					});
				},
				getVip() {
					uni.showModal({
						title: '提示',
						content: '如需开通会员或查看相关信息，请前往APP查看',
						showCancel: false,
						confirmColor: '#d0b483'
					});
				},
				btnOpenApp() {
					var configs = [{
						jmlink: 'https://a0ipue.jmlk.co/AA09',
						button: document.querySelector('#btnOpenApp'),
						params: {
							'shareID': square_id,
							'shareIOS': 'KCMallDetailVC',
							'shareAndroid': 'icangyu.jade.activities.mall.JadeMallDetailsActivity'
						}
					}];
					new JMLink(configs);
				},
				close() {
					this.closeBottom = true
				}
			}
		});
	</script>
</body>

</html>