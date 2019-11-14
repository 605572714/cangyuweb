<?php
include '../extended/php/jssdk.php';
$jssdk = new JSSDK("wxd076774039b4132e", "3006fa830349f4301e39899e6fe6e230");
$signPackage = $jssdk->GetSignPackage();
//print_r($signPackage);
//echo "xx";
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>藏玉直播</title>
    <!-- If you'd like to support IE8 -->
    <script type="text/javascript" src="ckplayer/ckplayer.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="https://static.jmlk.co/scripts/dist/jmlink.min.js"></script>
    <script src="js/config.js"></script>
</head>

<body>
    <div id="app">
        <img src="img/living.png" style="width:100%;" alt="">
        <div id="video"></div>
    </div>
    <script type="text/javascript">
        // var square_id = HttpHelper.getQuery('item_id');
        var square_id = '1573458572';
        var detail=null;
        var wWidth = document.body.clientWidth;
        var wHeight = document.body.clientHeight;
        var videoDiv = document.getElementById('video')
        videoDiv.style.width = wWidth + 'px;'
        videoDiv.style.height = wHeight + 'px;'
        $.getJSON(`${CYHOST}/icyApi/room_list?kind=1`, function (data) {
            console.log(data)
            var list = data.data.list
            for (let i = 0; i < list.length; i++) {
                if(list[i].room_id == square_id)
                detail = list[i]
            }
            console.log(detail.videoUrl)
            var videoObject = {
            container: '#video', //“#”代表容器的ID，“.”或“”代表容器的class
            variable: 'player', //该属性必需设置，值等于下面的new chplayer()的对象
            flashplayer: false, //如果强制使用flashplayer则设置成true
            // video: 'rtmp://globallivepull.cangyu9.com.cn/live/31004_6152171573478563', //视频地址
            // video: detail.rtmp, //视频地址
            video: detail.videoUrl, //视频地址
            // autoplay: true
        };
        var player = new ckplayer(videoObject);
        });
    </script>
    </div>

</body>

</html>