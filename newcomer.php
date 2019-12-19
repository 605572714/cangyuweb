<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="js/config.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>

    <title>新人注册</title>
    <style>
        * {
            padding: 0px;
            margin: 0px;
            border: none;
            font-size: 16px;
            width: 100%;
            color: #333;
        }

        body {
            position: fixed;
        }

        a{
            text-decoration: none;
        }

        .background {
            width: 100%;
            z-index: 1;
        }


        .page {
            box-shadow: 0px 0px 0px 2px rgba(255, 244, 244, 1);
            border-radius: 18px;
            width: 84vw;
            margin-top: -40%;
            left: 8vw;
            right: 8vw;
            background: #fff;
            position: absolute;
            padding-top: 2em;
            height: 50vh;
            padding-bottom: 2em;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .input,
        .invitation,
        .button {
            margin: 0 8%;
            width: 84%;
            height: 3em;
            line-height: 3em;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            background: #F8F8F8;
            border-radius: 4px;
        }

        .input img {
            width: 18px;
            height: 21px;
            margin-left: 10px;
            margin-right: 10px;
            position: relative;
        }

        #code {
            float: left;
        }


        input {
            width: 50%;
            height: 100%;
            line-height: 1em;
            background: #F8F8F8;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            font-size: 14px;
            outline: none;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .input .icon {
            width: 15%;
            position: relative;
            line-height: 100%;
            text-align: center;

        }

        .input .div {
            width: 35%;
            height: 2em;
            line-height: 2em;
            text-align: center;
            font-family: PingFangSC-Regular;
        }

        .input .div p {
            font-size: 12px;
            color: #999;
            width: 6em;
            float: right;
            padding-right: 20%;
        }

        #invitation {
            margin-left: 10px;
            color: #333;
        }

        .login {
            height: 6em;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .remind {
            text-align: center;
            font-size: 14px;
            color: #bc2e2e;
            height: 2em;
        }

        .button {
            background: #999;
            border-radius: 26px;
            color: #fff;
            justify-content: center;
        }


        .msg {
            text-align: center;
            font-size: 14px;
            color: rgba(153, 153, 153, 1);
        }

        .onshow {
            display: none;
            min-width: 100px;
            max-width: 200px;
            height: 100px;
            border-radius: 10px;
            background: #000;
            text-align: center;
            position: absolute;
            line-height: 100px;
            color: #fff;
            opacity: 0.64;
            z-index: 999;
            margin-left: 50%;
            margin-top: 50vh;
            transform: translate(-50%, -50%);
        }

        .coupons {
            z-index: 999;
            width: 80vw;
            position: absolute;
            margin-left: 10vw;
            margin-top: 25%;
            display: none;
        }

        .coupons img{
            width: 100%;
            height: 100%;
        }

        .coupons a{
            width: 80%;
            position: absolute;
            font-size: 14px;
            height: 3em;
            line-height: 3em;
            text-align: center;
            background: linear-gradient(180deg, rgba(246, 69, 71, 1) 0%, rgba(188, 46, 46, 1) 100%);
            border-radius: 3em;
            bottom:10%;
            margin-left: 50%;
            transform: translate(-50%);
            color: #fff;
        }
    </style>
</head>

<body id="app">
    <div class="coupons" id="coupons">
        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=icangyu.jade">确定</a>
        <img src="img/getCoupons.png">
    </div>
    <div class="onshow" id="onshow">注册成功</div>
    <img class="background" id="background" src="img/backnew.png" alt="" />
    <div class="page" id="page">
        <div class="input">
            <div class="icon">
                <img src="img/phone.png">
            </div>
            <input id="phone" type="tel" pattern="\d*"/ pattern="[0-9]*" maxlength="13" placeholder="请输入手机号">
        </div>
        <div class="input">
            <div class="icon">
                <img src="img/code.png">
            </div>
            <input id="code" type="tel" pattern="\d*"/ pattern="[0-9]*" maxlength="6" placeholder="短信验证码">
            <div class="div">
                <p id="getCode">获取验证码</p>
            </div>
        </div>
        <div class="invitation">
            <input id="invitation" disabled>
        </div>
        <div class="login">
            <p class="remind" id="remind"></p>
            <input id="button" class="button" type="button" value="领取优惠券">
            <!-- <p class="msg">首次注册即可创建藏玉账号</p> -->
        </div>
    </div>

    <script>
        // const user_id = 22; //临时赋值
        const user_id = HttpHelper.getQuery('user_id'); //获取user_id
        console.log('user_id', user_id);
        const url = 'http://app.icangyu.com/icyApi/'; //线上接口
        // const url = 'http://testicy.icangyu.com/icyApi/'; //测试接口
        var hrt = document.documentElement.clientHeight; // 获取页面初始高度
        var wrt = document.documentElement.clientwidth; // 获取页面初始宽度
        window.onload = function name(params) {
            document.getElementById('page').style.height = hrt / 2 + 'px'; //将页面初始高度赋值'page'，使其不随输入框而变化
            document.getElementById('app').style.height = hrt + 'px'; //将页面初始高度赋值'page'，使其不随输入框而变化
            document.getElementById('coupons').style.height = wrt + 'px'; //将页面初始高度赋值'page'，使其不随输入框而变化
        }
        $(function () {
            var timer = null, //倒计时
                codeType = false, //1.可以获取验证码，2.不可以获取验证码
                buttonType = false; //1.注册按钮可用，2.注册按钮不可用

            // Base64转码
            function enCode(data) {
                function b64EncodeUnicode(str) {
                    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
                        return String.fromCharCode('0x' + p1);
                    }));
                }
                return enId = b64EncodeUnicode(data); // "5oiR5piv5b6I5Y6J5a6z55qE"
            }
            // Base64解码
            function deCode(data) {
                function b64DecodeUnicode(str) {
                    return decodeURIComponent(atob(str).split('').map(function (c) {
                        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                    }).join(''));
                }
                return deId = b64DecodeUnicode(data); //"我是很厉害的"
            }

            //显示邀请码转译
            $('#invitation').val('邀请码' + " " + enCode(user_id))
            console.log(deCode('MjE3Nzg='));

            // 获取输入手机号
            $('#phone').keyup(function () { //输入时触发
                var that = $(this);
                value = that.val();
                value = value.replace(/[^0-9]/g, ""); //判断输入是否为数字
                var arr = value.split('');
                if (arr.length >= 4) {
                    arr.splice(3, 0, ' '); //第四位空格
                }
                if (arr.length >= 9) {
                    arr.splice(8, 0, ' '); //第九位空格
                }
                this.value = arr.join('');
                this.phone = value
                if (this.phone.length == 11) {
                    codeType = true; //获取验证码可点击
                    $('#getCode').css('color', '#bc2e2e'); //手机号正确，获取验证码状态变红
                    $('#remind').text(''); //错误提示框消失
                } else {
                    console.log('手机号有误');
                    $('#getCode').css('color', '#999'); //手机号有误，获取验证码状态变灰
                    codeType = false; //获取验证码不可点击
                }
            }).change(function () { //输入完成时触发
                if (this.phone.length == 11) {
                    phone = this.phone; //手机号正确赋值
                } else {
                    $('#remind').text('请输入正确的手机号');
                    shake("remind"); //手机号错误，报错弹窗
                }
                console.log(phone);

            })

            // 获取输入验证码
            $("#code").on('input', function () { //输入时触发
                var that = $(this);
                var value = that.val();
                value = value.replace(/[^0-9]/ig, "");
                var arr = value.split('');
                this.value = arr.join('');
                this.code = value;
                if (this.code.length == 6) {
                    $('#button').css('background',
                        'linear-gradient(180deg, rgba(246, 69, 71, 1) 0%, rgba(188, 46, 46, 1) 100%)'
                    )
                    $('#remind').text('')
                } else {
                    $('#button').css('background', '#999')
                }
            }).change(function () { //输入完成时触发
                if (this.code.length == 6) {
                    code = this.code;
                } else {
                    $('#remind').text('请输入正确的验证码');
                    shake("remind");
                }
                console.log(code);
            })

            // 发送手机验证码  
            $('#getCode').click((function () {
                /*请求参数*/
                if (codeType == true) {
                    console.log(phone);
                    $('#getCode').text('已发送');
                    $.post(url + 'get_password', {
                        mobile: phone
                    }, function (data) {
                        console.log(data);
                        if (data.result == 100) {
                            console.log("获取成功")
                            codeType = false;
                            var i = 60
                            timer = setInterval(() => {
                                console.log("倒计时", i, codeType)
                                $('#getCode').text(i + 's');
                                i--;
                                if (i < 0) {
                                    clearInterval(timer);
                                    codeType = true;
                                    $('#getCode').text('获取验证码');
                                }
                            }, 1000);
                        }
                    })
                }
            }))

            //点击注册
            $('#button').click(function () {
                // 验证信息
                console.log(phone, code, user_id);
                if (phone.length != 11) { //验证手机号
                    $('#remind').text('请输入正确的手机号');
                    shake('remind');
                    return;
                } else if (code.length != 6) { //验证验证码
                    $('#remind').text('请输入正确的验证码');
                    shake('remind');
                    return;
                }
                console.log('验证成功');
                buttonType = true; //允许点击
                $.post(url + 'register_drainage', {
                    mobile: phone,
                    code: code,
                    user_id: user_id
                }, function (data) {
                    console.log("请求返回", data);
                    if (timer) {
                        clearInterval(timer); //清除倒计时    
                    }
                    codeType = true;
                    $('#getCode').text('获取验证码');
                    if (data.result == 100) { //注册成功
                        console.log("获取成功")
                        $('#coupons').css({
                            'display':'block'
                        })
                    } else { //注册失败
                        console.log("获取失败")
                        $('#onshow').css({
                            'display': 'block'
                        }).text(data.info)
                        setTimeout(() => {
                            $('#onshow').css({
                                'display': 'none'
                            })
                        }, 1500);
                    }
                })
            })

            //报错左右抖动
            function shake(data) {
                var $panel = $("#" + data);
                box_left = 0;
                $panel.css({
                    'left': box_left,
                    'position': 'relative'
                });
                for (var i = 1; 4 >= i; i++) {
                    $panel.animate({
                        left: box_left - (20 - 5 * i)
                    }, 30);
                    $panel.animate({
                        left: box_left + (20 - 5 * i)
                    }, 30);
                }
            }

            //IOS中select、input失焦后，页面上移，点击不了解决办法
            $(function () {
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
                            myFunction = setTimeout(function () {
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
        });
    </script>

</body>
</html>