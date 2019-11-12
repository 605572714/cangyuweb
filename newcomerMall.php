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
    <link rel="stylesheet" href="css/my-app.css">
    <script type="text/javascript" src="js/config.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>

    <title>新人专享礼包</title>
    <style>
        * {
            padding: 0px;
            margin: 0px;
            font-size: 16px;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        body {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        .topImg {
            width: 100%;
            position: relative;
        }

        .topImg img {
            width: 100%;
        }

        #flbtn {
            width: 90%;
            margin-left: 5%;
            height: 14vw;
            background: #E17C7C;
            position: absolute;
            bottom: 7.5vw;
            opacity: 0;
        }


        .mallList {
            text-align: center;
            width: 100%;
        }

        .mallList h1 {
            color: #333;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .mallList .listDetail {
            width: 92%;
            margin: 0px 4%;
            position: relative;
        }

        .mallList .detailItem {
            padding: 15px 0px;
            border-bottom: 0.5px solid #D9D9D9;
            overflow: hidden;
        }

        .detailItem:last-child {
            border-bottom: none;
        }

        .mallList .listDetail img {
            width: 140px;
            height: 140px;
            background: url(img/background.jpg) center no-repeat;
            background-size: auto 100%;
            position: relative;
            float: left;
            margin-right: 10px;
        }

        .mallList .listDetail .content {
            display: flex;
            flex-direction: column;
            height: 140px;
            justify-content: space-around;
            align-items: flex-start;
        }

        .content .title {
            text-align: left;
            font-size: 14px;
        }

        .content .price {
            color: #bc2e2e;
        }

        .content .price span {
            margin-left: 10px;
            text-decoration: line-through;
            color: #999;
        }

        .content .progress {
            width: 90px;
            height: 15px;
            border-radius: 8px;
            border: 1px solid #f37f7f;
            line-height: 15px;
            /* text-align: center; */
            position: relative;
            overflow: hidden;
        }

        .content .progress p {
            height: 100%;
            background: #FCF0F0;
            width: 100%;
        }

        .content .progress p span {
            position: absolute;
            color: #E17C7C;
            font-size: 10px;
            height: 15px;
            line-height: 15px;
            width: 90px;
            left: 0px;
        }

        .content .goBuy {
            color: #fff;
            padding: 5px 10px;
            background: #bc2e2e;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="topImg">
        <img src="img/coupon4.png" alt="">
    </div>
    <div class="mallList">
        <h1>新人专享价</h1>
        <div class="listDetail" id='listDetail'></div>
    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
        const _from = HttpHelper.getQuery('from'); //获取user_id
        const url = 'http://app.icangyu.com/icyApi/'; //线上接口
        $.get(url + 'novice_mall_list', function(res) {
            var Winwidth = document.body.clientWidth,
                Winheight = document.body.clientHeight;
            if (res.result == 100) {
                var list = res.data.list
                console.log("获取成功", list, "_from", _from)
                var listHTML = [];
                var progress = [];
                for (var i = 0; i < list.length; i++) {
                    progress[i] = list[i].nums / list[i].nums_total * 90
                    listHTML +=
                        '<div class="detailItem">' +
                        '<a id="goBuy"  onclick="godetail(' + list[i].id +
                        ')" href="#"  target="_self" rel="nofollow">' +
                        '<img src = "' + list[i].headlines + ' ">' +
                        '<div class = "content" >  <div class = "title" id = "title">' + list[i].title +
                        '</div> <div class = "price" >￥' + list[i].price + '<span>' + '￥' + list[i].old_price +
                        '</span>' +
                        '</div>' +
                        '<div class="progress" ><p id="progress" style="width:' + progress[i] + 'px"><span >' +
                        '仅剩' + list[i].nums + '件' +
                        '</span>' + '</p></div>' +
                        '<div  class="goBuy">立即购买</div>' +
                        '</div >' + '</a>' + '</div>';
                }
                $('#listDetail').html(listHTML)
                window.share_config = {
                    "share": {
                        "imgUrl": "http://www.icangyu.com/cangyuxyidong/img/icon.png", //分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                        "desc": '新手商城，特价好物', //摘要,如果分享到朋友圈的话，不显示摘要。
                        "title": '藏玉新手商城', //分享卡片标题
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
            }
            //领取优惠券
            $('#flbtn').click(function coupon() {
                console.log("领取优惠券");
            });
            configs = [{
                jmlink: 'https://a0ipue.jmlk.co/AA09',
                button: document.querySelector('a#goBuy'),
                params: {
                    'shareID': '',
                    'shareIOS': 'KCNoviceShopVC',
                    'shareAndroid': 'icangyu.jade.activities.seckill.NoviceDetailsActivity'
                }
            }];
            new JMLink(configs);

        });

        function godetail(id) {
            if (_from === 'Jade') {
                alert('novice_item_id=' + id)
            } else {
                new JMLink(configs);
            }
        }
    </script>
</body>

</html>