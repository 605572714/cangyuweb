<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=drvice-width,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="../js/config.js"></script>
    <script src="../js/jquery-2.1.4.min.js"></script>
    <title>意见反馈</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0px;
            padding: 0px;
        }

        .container {
            background: #FCF7ED;
            background-repeat: no-repeat;
            background-size: 100%;
            min-height: 100vh;
            padding: 0px;
            margin: 0px;
        }

        .textarea {
            width: 76vw;
            margin-top: 79vw;
            margin-left: 8vw;
            padding: 4vw;
            border-radius: 2vw;
            margin-bottom: 0px;
            font-size: 3.7vw;
            border: none;
            outline: none;
        }

        .nickname {
            width: 84vw;
            height: 10.7vw;
            line-height: 10.7vw;
            display: flex;
            margin-top: 2.7vw;
            align-items: center;
            background: #fff;
            margin-left: 8vw;
            border-radius: 2vw;
        }

        .input-gzh {
            height: 6vw;
            width: 65vw;
            border: none;
            border-radius: 2vw;
            font-size: 3.7vw;
            padding-left: 2.4vw;
            outline: none;
            background-color: rgba(0, 0, 0, 0);
        }

        .check-icon {
            width: 3vw;
            height: 3vw;
        }

        .check-name {
            width: 13vw;
            height: 100%;
            text-align: center;
            font-size: 2.7vw;
            color: #4C3814;
        }

        a {
            text-decoration: none;
            color: #4C3814;
            outline: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        button {
            font-size: 4vw;
            width: 32vw;
            height: 9.3vw;
            background: #C83030;
            border: none;
            border-radius: 0.7vw;
            margin-left: 50%;
            transform: translate(-50%);
            margin-top: 4.7vw;
            color: #fff;
        }

        .img {
            width: 63vw;
            height: 57vw;
            position: absolute;
            margin-top: 43vw;
            margin-left: 50%;
            transform: translate(-50%);
            z-index: 10;
            display: none;
        }

        .overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            bottom: 0px;
            right: 0px;
            z-index: 9;
            display: none;
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>
    <div id="container" class="container">
        <image id="img" class="img" src="../img/feedback_success.png" />
        <textarea class='textarea' id="input" placeholder="点击此处输入反馈意见..." maxlength="80" placeholder-class="textarea-placeholder"></textarea>
        <div class="nickname" id="nickname">
            <input id="input-gzh" class="input-gzh" type="text" placeholder="请输入您的藏玉APP昵称">
            <img id="check-icon" class="check-icon" src="../img/checked.png" alt="">
            <!-- <img id="nocheck" class="check-icon" src="../img/checked.png" alt=""> -->
            <text class="check-name" hover-style="none">
                <a id="check-name" href="#">匿名提交</a>
            </text>

        </div>
        <button type="submit" id="submit">提交反馈</button>
        <div id="overlay" class="overlay"></div>
    </div>
    <script>
        window.onload = function() {
            var token = HttpHelper.getQuery('token');
            // var token = "4d1ov8a1284821778";
            // const url = 'https://app.icangyu.com/icyApi/'; //线上接口
            const url = 'https://testicy.icangyu.com/icyApi/'; //测试接口
            var checked = true;
            var textarea = document.getElementById('input');
            var container = document.getElementById('container');
            var containerApp = document.getElementById('container-app');
            var containerGzh = document.getElementById('container-gzh');
            var button = document.getElementById('submit');
            var overlay = document.getElementById('overlay');
            var img = document.getElementById('img');
            var inputGzh = document.getElementById('input-gzh');
            var checkIcon = document.getElementById('check-icon');
            // var checkIcon = document.getElementById('check-icon');
            var checkName = document.getElementById('check-name');
            var nickname = document.getElementById('nickname');
            if (token) {
                container.style.backgroundImage = "url(../img/feedback_back_app.png)";
                input.style.height = '48vw';
                nickname.style.display = 'none';
            } else {
                container.style.backgroundImage = "url(../img/feedback_back_gzh.png)"
                input.style.height = '37vw';
                nickname.style.display = 'flex';
            }
            checkName.addEventListener('click', function() {
                if (checked) {
                    checked = !checked;
                    checkIcon.src = '../img/nocheck.png'
                } else {
                    checked = !checked;
                    checkIcon.src = '../img/checked.png'
                }
            })
            button.addEventListener("click", function() {
                if (textarea.value == '') {
                    textarea.placeholder = '请输入反馈意见!!!';
                    textarea.placeholder.color = '#bc2e2e';
                    return;
                }
                var content = token ? textarea.value : `${textarea.value}-by-${inputGzh.value}`;
                /*请求参数*/
                $.post(url + 'suggest_submit', {
                    content: content,
                    token: token
                }, function(data) {
                    console.log(JSON.parse(data));
                    overlay.style.display = 'block';
                    img.style.display = 'block';
                    setTimeout(function() {
                        overlay.style.display = 'none';
                        img.style.display = 'none';
                        textarea.value = "";
                        textarea.placeholder = '点击此处输入反馈意见...'
                    }, 1500)

                })
            });
            //IOS中select、input失焦后，页面上移，点击不了解决办法
            $(function() {
                var u = navigator.userAgent;
                var flag;
                var myFunction;
                var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
                if (isIOS) {
                    document.body.addEventListener('focusin', () => { //软键盘弹起事件
                        flag = true;
                        clearTimeout(myFunction);
                    })
                    document.body.addEventListener('focusout', () => { //软键盘关闭事件
                        flag = false;
                        if (!flag) {
                            myFunction = setTimeout(function() {
                                window.scrollTo({
                                    top: 0,
                                    left: 0,
                                    behavior: "smooth"
                                }) //重点  =======当键盘收起的时候让页面回到原始位置(这里的top可以根据你们个人的需求改变，并不一定要回到页面顶部)
                            }, 1);
                        } else {
                            return
                        }
                    })
                } else {
                    return
                }
            });

        }
    </script>
</body>

</html>