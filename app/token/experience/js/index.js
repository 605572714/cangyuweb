const $vue = window.vue;
let li = list.querySelectorAll("li") // 获取抽奖列表
var prize = [0, 1, 2, 4, 7, 6, 5, 3, 0]; //奖品li标签滚动的顺序
function getrandomnum(n, m) {
    return parseInt((m - n) * Math.random() + n);
}

function startinit(num) {
    var i = 0, //定义一个i 用来计算抽奖跑动的总次数
        t = 200, //抽奖跑动的速度 初始为200毫秒
        rounds = 5, //抽奖转动的圈数
        rNum = rounds * 8, //标记跑动的次数（这是一个条件判断分界线）
        timer = setTimeout(startscroll, t); //每t毫秒执行startscroll函数
    //抽奖滚动的函数
    function startscroll() {
        //每次滚动抽奖将所有li的class都设为空
        for (var j = 0; j < li.length; j++) {
            li[j].className = '';
        }
        var prizenum = prize[i % li.length]; //通过i余8得到此刻在prize数组中的数字，该数字就是mask标记出现的位置
        li[prizenum].className = "active";
        if (column.className.indexOf('column-active') != -1) {
            column.className = "column"
        } else {
            column.className = "column column-active"
        }
        i++;
        if (i < 10) { //当i小于转(rNum-8次)的数量，t不变还是200毫秒
            timer = setTimeout(startscroll, t); //继续执行抽奖滚动
        } else if (i < 20) {
            //t时间变长，此时计时器运行速度降低，同时标签刷新速度也降低
            timer = setTimeout(startscroll, 150); //继续执行抽奖滚动
        } else if (i < rNum - 8) {
            //t时间变长，此时计时器运行速度降低，同时标签刷新速度也降低
            timer = setTimeout(startscroll, 100); //继续执行抽奖滚动
        } else if (i >= rNum - 8 && i < rNum + num) {
            //t时间变长，此时计时器运行速度降低，同时标签刷新速度也降低
            t += (i - rNum + 8) * 5;
            timer = setTimeout(startscroll, t); //继续执行抽奖滚动
        }
        if (i >= rNum + num) {
            if (num == 1) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“10元通用优惠券”';
            } else if (num == 2) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“50经验值”';
                $vue.integral += 50;
            } else if (num == 3) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“20元通用优惠券”';
            } else if (num == 4) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“66元通用优惠券”';
            } else if (num == 5) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“10元通用优惠券”';
            } else if (num == 6) {
                $vue.alert.title = '谢谢参与';
                $vue.alert.content = '“下次运气一定会很棒哦~”';
                alertContent.className = "content short"
            } else if (num == 7) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“20元通用优惠券”';
            } else if (num == 8) {
                $vue.alert.title = '恭喜你抽中了';
                $vue.alert.content = '“200经验值”';
                $vue.integral += 200;
            }

            var timer2 = null;
            timer2 = setTimeout(function () {
                $vue.show = true; //奖品展示的信息为显示状态
                clearTimeout(timer2);
            }, 800);
            $vue.bReady = true; //当计时器结束后让span标签变为抽奖状态
            clearTimeout(timer);
        }
    }
}