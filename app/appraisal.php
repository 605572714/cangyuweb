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
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/appraisal.css">
		<script src="js/config.js"></script>
		<script src="js/vue.min.js"></script>
		<link rel="stylesheet" href="css/my-app.css">
		<link rel="stylesheet" href="css/framework7-icons.css">
		<link rel="stylesheet" href="css/framework7.ios.min.css">
		<script type="text/javascript" src="js/framework7.min.js"></script>
		<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
		<script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
		<script src="js/vue-resource.min.js"></script>
		<script type="text/javascript" src="js/weixinWeb.js"></script>
		<title>藏玉鉴定</title>
		<style type="text/css">
			.big_imgs {
				width: 100%;
				height: 100%;
				background: #000000;
			}

			.big_imgs img {
				width: 100%;
				margin-top: 25%;
			}
		</style>
	</head>



	<body>
		<div id="app">
			<div id="detail">
				<div class="top">
					<img :src="avatar" alt="" class="avatar">
					<div class="nick">
						<div class="name">{{nickname}}<span class="level" :style="rating<8?'background:#F6F7F9;':''">LV.{{rating}}</span></div>
						<div class="time">{{createdate}}</div>
					</div>
				</div>
				<div class="content">
					{{content}}
				</div>
				<div class="img">
					<div v-for="item,index in album">
						<img id="item.file_path" class="img_item" :src="item.file_path" @click="changeImg(index)">
					</div>
				</div>
				<div class="clear"></div>
				<div class="inner" v-if="palm">
					邀请掌眼：<span v-for='item,index in palm'>{{item.nickname}}&nbsp;</span>
				</div>
				<div class="black"></div>
				<div class="discuss">
					<div class="title">评论</div>
					<div class="discuss_detail" v-for="item,index in comment">
						<div class="detail">
							<img class="discuss_avatar" :src="item.comment_avatar" alt="">
							<div class="name"> {{item.nickname}}</div>
						</div>
						<div class="comment"> <span v-if="item.tonickname">回复<span style="color:#666;">{{item.tonickname}}</span>:</span>{{item.comment}}</div>
					</div>
				</div>
				<!-- Bottom Tabbar-->
				<div class="cangyu_bbs_tabber" v-if='!closeBottom'>
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
					'onMenuShareWeibo',
					'previewImage'
				]
			});
		</script>
		<script>
			var maimaiApp = new Framework7({
				router: false,
				swipePanel: 'left',
				// ... other parameters
			});
			var square_id = HttpHelper.getQuery('item_id');
			var app = new Vue({
				el: '#app',
				data: {
					detail: null,
					avatar: null,
					nickname: null,
					createdate: null,
					rating: null,
					palm: null,
					content: null,
					album: null,
					comment: null,
					closeBottom: false,
					imgList: []

				},
				mounted() {
					var that = this;
					that.getDetail();
				},
				methods: {
					getDetail() {
						this.$http.get(`${CYHOST}/icyApi/details_identify?id=${square_id}`)
							.then(res => {
								console.log(res.body.data)
								this.detail = res.body.data;
								this.nickname = this.detail.nickname;
								this.createdate = this.detail.createdate;
								this.rating = this.detail.rating;
								this.content = this.detail.content;
								this.album = this.detail.album;
								this.palm = this.detail.palm;
								this.avatar = this.detail.avatar;
								for (var i = 0; i < this.album.length; i++) {
									var item = this.album[i].file_path
									if (item.indexOf("http") == -1) {
										this.album[i].file_path = CYHOST + this.album[i].file_path
									}
									this.imgList[i] = this.album[i].file_path;
								}
								if (this.avatar.indexOf("http") == -1) {
									this.avatar = CYHOST + this.detail.avatar
								}
							}).catch(res => {
								console.log(res)
							})
						this.$http.get(`${CYHOST}/icyApi/comment_lists?id=${square_id}&type=2&allLists=1`)
							.then(res => {
								console.log(res.body.data)
								this.comment = res.body.data.list
								for (var i = 0; i < res.body.data.total; i++) {
									var item = this.comment[i].comment_avatar
									if (item.indexOf("http") == -1) {
										this.comment[i].comment_avatar = CYHOST + this.comment[i]
											.comment_avatar
									}
								}

							}).catch(res => {
								console.log(res)
							})
						window.share_config = {
							"share": {
								"imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
								"desc": this.content, //摘要,如果分享到朋友圈的话，不显示摘要。
								"title": '鉴定', //分享卡片标题
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
					btnOpenApp() {
						var configs = [{
							jmlink: 'https://a0ipue.jmlk.co/AA09',
							button: document.querySelector('#btnOpenApp'),
							params: {
								'shareID': square_id,
								'shareIOS': 'KCAppraiseMessVC',
								'shareAndroid': 'icangyu.jade.activities.community.IdentifyDetailsActivity'
							}
						}];
						new JMLink(configs);
					},
					changeImg(k) {
						var myPhotoBrowserPopupDark = maimaiApp.photoBrowser({
							photos: this.imgList,
							theme: 'dark',
							initialSlide: k,
							type: 'standalone'
						});
						myPhotoBrowserPopupDark.open();
					},
					close() {
						this.closeBottom = true
					}
				}
			});
		</script>
	</body>
</html>
