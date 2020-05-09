<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>商品详情</title>
	<script src="js/vue.min.js"></script>
	<script src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/config.js"></script>
	<script src="js/vue-resource.min.js"></script>
	<script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/mallDetail.css" />
	<link rel="stylesheet" href="css/my-app.css">
	<!-- <script type="text/javascript" src="js/weixinWeb.js"></script> -->
	<script src="http://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
	<script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
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
		<div class="top" ref="top">
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
				<div class="member_price" v-if="detail.tag_string.indexOf('会员')!=-1">会员价¥{{ detail.member_price }}</div>
				<div class="old_price" v-else-if="detail.tag_string.indexOf('折扣')!=-1">¥{{ detail.old_price }}</div>
			</div>
			<div class="discount">
				<div class="item" v-if="detail.tag_string">{{ detail.tag_string }}
				</div>
			</div>
			<div class="members" v-if="detail.tag_string.indexOf('会员')!=-1" @click="getVip">
				<div>
					开通会员，可享专属会员价
					<span>¥{{ detail.member_price }}</span>
				</div>
			</div>
		</div>
		<div class="line"></div>
		<div class="detail">
			<div class="detail-title">详细介绍</div>
			<div class="detail-content" v-if="detail.content.length>5">
				{{detail.content}}
			</div>
			<div class="album" v-for="(item, index) in detail.album" :key="index">
				<img class="img background" :style="detail.content.length>5?'margin-bottom:10px':''" :src="item.file_path" mode="aspectFill"></img>
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
	<script type="text/javascript">
		var square_id = HttpHelper.getQuery('item_id');
		var vue = document.getElementById('app')
		// 判断是移动端还是PC端
		var sUserAgent = navigator.userAgent.toLowerCase();
		if (/ipad|iphone|midp|rv:1.2.3.4|ucweb|android|windows ce|windows mobile/.test(sUserAgent)) {
			//跳转移动端页面
			console.log('phone');

		} else {
			//跳转pc端页面
			console.log('PC', vue);
			vue.style.width = '375px';
			vue.style.border = '1px solid #d9d9d9';
		}
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
				that.getDetail();
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