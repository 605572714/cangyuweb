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
	<link rel="stylesheet" href="css/mallDetail.css" />
	<link rel="stylesheet" href="css/my-app.css">
	<link rel="stylesheet" href="css/vant.css">
	<link rel="stylesheet" href="photoswipe/default-skin.css">
	<link rel="stylesheet" href="photoswipe/photoswipe.css">
</head>

<body>
	<div ref="vue" id="vue" class="vue">
		<template v-if="detail.video_url">
			<video class="video" :poster="detail.video_cover?detail.video_cover:detail.headlines" controls>
				<source :src="detail.video_url">
			</video>
		</template>
		<template v-else>
			<img class="video" :src="detail.headlines" mode="aspectFill">
		</template>
		<div class="top" ref="top">
			<div class="title">{{ detail.title }}</div>
			<div class="priceList">
				<div class="price">¥{{ detail.discount_price }}</div>
				<div class="member_price" v-if="tag_string.indexOf('会员')!=-1">会员价¥{{ detail.member_price }}
				</div>
				<div class="old_price" v-else-if="tag_string.indexOf('折扣')!=-1">¥{{ detail.old_price }}</div>
			</div>
			<div class="discount">
				<div class="item" v-if="tag_string">{{tag_string }}
				</div>
			</div>
			<div id='goApp' class="members" v-if="tag_string.indexOf('会员')!=-1" @click="getVip">
				<div>
					开通会员，可享专属会员价
					<span>¥{{ detail.member_price }}</span>
				</div>
			</div>
		</div>
		<div class="line"></div>
		<div class="detail">
			<div class="detail-title">详细介绍</div>
			<div class="detail-content" v-if="content.length>5">
				{{detail.content}}
			</div>
			<!-- 图片 -->
			<div class="my-gallery album" data-pswp-uid="1">
				<figure v-for="item,index in detail.album">
					<div>
						<a :href="item.file_path" data-size="1920x1080">
							<img class="img background" :style="content.length>5?'margin-bottom:10px':''" :src="item.file_path"></img>
						</a>
					</div>
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
				'onMenuShareWeibo'
			]
		});
	</script>
	<script type="text/javascript">
		var square_id = HttpHelper.getQuery('item_id');
		console.log(square_id);
		var app = new Vue({
			el: "#vue",
			data() {
				return {
					detail: {},
					tag_string: '',
					content: ''
				}
			},
			created() {
				var that = this;
				var vue = that.$refs.vue;
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
			},
			mounted() {
				var that = this;
				that.getDetail();
			},
			methods: {
				getDetail() {
					var that = this;
					axios.get(`${CYHOST}/icyApi/mall_details?id=${square_id}`).then(res => {
						console.log(res.data.data);
						that.detail = res.data.data;
						that.tag_string = that.detail.tag_string;
						that.content = that.detail.content;
						initPhotoSwipeFromDOM('.my-gallery');
						that.$refs.vue.style.display = 'block';
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
					})
				},
				getVip() {
					var that = this;
					that.$dialog({
						message: '请前往APP查看详细信息'
					})
				},
				// 跳转APP
				goApp() {
					var configs = [{
						jmlink: 'https://a0ipue.jmlk.co/AA09',
						button: document.querySelector('a#btnOpenApp'),
						params: {
							'shareID': square_id,
							'shareIOS': 'KCMallDetailVC',
							'shareAndroid': 'icangyu.jade.activities.mall.JadeMallDetailsActivity'
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