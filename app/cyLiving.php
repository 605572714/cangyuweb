<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<title>藏玉直播</title>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			vertical-align: middle;
		}

		.app {
			position: relative;
			width: 100%;
			background: rgba(253, 243, 242, 1);
		}

		#goApp {
			position: absolute;
			width: 289px;
			height: 58px;
			background: linear-gradient(270deg, rgba(228, 85, 85, 1) 0%, rgba(188, 46, 46, 1) 100%);
			border-radius: 29px;
			font-size: 20px;
			line-height: 58px;
			text-align: center;
			color: #fff;
			bottom: 80px;
			z-index: 2;
			font-family: PingFangSC-Regular, PingFang SC;
		}

		img {
			position: absolute;
			width: 100%;
			z-index: 1;
		}
	</style>
</head>

<body>
	<div id="app" class="app">
		<img src="img/living.png">
		<div id="goApp">
			立即下载APP体验
		</div>
	</div>
</body>
<script src="js/config.js"></script>
<script src="js/jmlink.min.js"></script>
<script src="js/weixinWeb.js"></script>
<script type="text/javascript">
	var square_id = HttpHelper.getQuery('item_id');
	var WinWidth = document.body.scrollWidth;
	var WinHeight = $(document).height()
	$(document).ready(function() {
		$('.app').css("height", WinHeight + 'px');
		$('#goApp').css("margin-left", (WinWidth - 289) / 2 + 'px');
		console.log(WinHeight);
	});
	// $("#goApp").click(function () {
	// 	var configs = [{
	// 		jmlink: 'https://a0ipue.jmlk.co/AA09',
	// 		button: document.querySelector('#goApp'),
	// 		params: {
	// 			'shareID': square_id || '',
	// 			'shareIOS': 'KCWorksMessageVC',
	// 			'shareAndroid': 'icangyu.jade.activities.community.SellDetailsActivity'
	// 		}
	// 	}];
	// 	new JMLink(configs);
	// });
</script>

</html>