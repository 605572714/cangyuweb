(function () {
    var $,
        ele,
        container,
        canvas,
        num,
        prizes,
        btn,
        deg = 0,
        fnGetPrize,
        fnGotBack,
        optsPrize;
    var cssPrefix,
        eventPrefix,
        vendors = {
            '': '',
            Webkit: 'webkit',
            Moz: '',
            O: 'o',
            ms: 'ms'
        },
        testEle = document.createElement('p'),
        cssSupport = {};

    // 嗅探特性 判断浏览器类型
    // Object.keys方法会返回一个由一个给定对象的自身可枚举属性组成的数组， 数组中属性名的排列顺序和正常循环遍历该对象时返回的顺序一致。
    Object.keys(vendors).some(function (vendor) {
        if (testEle.style[vendor + (vendor ? 'T' : 't') + 'ransitionProperty'] !== undefined) {
            cssPrefix = vendor ? '-' + vendor.toLowerCase() + '-' : '';
            eventPrefix = vendors[vendor];
            return true;
        }
    });

    /**
     * [兼容事件前缀]
     * @param  {[type]} name [description]
     * @return {[type]}      [description]
     */
    function normalizeEvent(name) {
        // console.log(name, eventPrefix);
        return eventPrefix ? eventPrefix + name : name.toLowerCase();
    }
    /**
     * [兼容CSS前缀]
     * @param  {[type]} name [description]
     * @return {[type]}      [description]
     */
    function normalizeCss(name) {
        name = name.toLowerCase();
        // console.log(name, cssPrefix);
        return cssPrefix ? cssPrefix + name : name;
    }

    cssSupport = {
        cssPrefix: cssPrefix,
        transform: normalizeCss('Transform'),
        transitionEnd: normalizeEvent('TransitionEnd')
    }
    var transform = cssSupport.transform;
    var transitionEnd = cssSupport.transitionEnd;

    // 转盘初始化
    function init(opts) {
        fnGetPrize = opts.getPrize;
        fnGotBack = opts.gotBack;
        opts.config(function (data) {
            prizes = opts.prizes = data;
            num = prizes.length;
            draw(opts);
        });
        // console.log(opts);
        events();
    }

    /**
     * @param  {String} id
     * @return {Object} HTML element
     */

    $ = function (id) {
        return document.getElementById(id);
    };

    // 绘制表盘
    function draw(opts) {
        opts = opts || {};
        // console.log(opts, '绘制转盘');
        // console.log(num);

        // 移位0位将非number类型的数据转换为number类型，将number类型转换为无符号的32bit数据类型。
        if (!opts.id || num >>> 0 === 0) return;
        var id = opts.id,
            rotateDeg = 360 / num / 2 + 90, // 扇形回转角度
            ctx,
            prizeItems = document.createElement('ul'), // 奖项容器
            turnNum = 1 / num, // 文字旋转 turn 值
            html = []; // 奖项

        ele = $(id);
        // console.log(ele);

        canvas = ele.querySelector('.gb-turntable-canvas');
        container = ele.querySelector('.gb-turntable-container');
        btn = ele.querySelector('.gb-turntable-btn'); // 转盘按钮

        if (!canvas.getContext) {
            showMsg('抱歉！浏览器不支持。');
            return;
        }
        // 获取绘图上下文
        ctx = canvas.getContext('2d');
        for (var i = 0; i < num; i++) {
            // 保存当前状态
            ctx.save();
            // 开始一条新路径
            ctx.beginPath();
            // 位移到圆心，下面需要围绕圆心旋转
            ctx.translate(150, 150);
            // 从(0, 0)坐标开始定义一条新的子路径
            ctx.moveTo(0, 0);
            // 旋转弧度,需将角度转换为弧度,使用 degrees * Math.PI/180 公式进行计算。
            ctx.rotate((360 / num * i - rotateDeg) * Math.PI / 180);
            // 绘制圆弧
            ctx.arc(0, 0, 150, 0, 2 * Math.PI / num, false);

            // 颜色间隔
            if (i % 2 == 0) {
                ctx.fillStyle = '#ffb820';
            } else {
                ctx.fillStyle = '#ffcb3f';
            }

            // 填充扇形
            ctx.fill();
            // 绘制边框
            ctx.lineWidth = 0.5;
            ctx.strokeStyle = '#e4370e';
            ctx.stroke();

            // 恢复前一个状态
            ctx.restore();

            // 奖项列表
            var prizeList = opts.prizes;
            html.push('<li class="gb-turntable-item"> <span style="');
            html.push(transform + ': rotate(' + i * turnNum + 'turn)">');
            !!prizeList[i].img ? html.push('<img src="' + prizeList[i].img + '" />') : html.push(prizeList[i].text)
            html.push('</span> </li>');
            // console.log(html);
            if ((i + 1) === num) {
                prizeItems.className = 'gb-turntalbe-list';
                container.appendChild(prizeItems);
                prizeItems.innerHTML = html.join('');
            }

        }

    }

    /**
     * 旋转转盘
     * @param  {[type]} deg [description]
     * @return {[type]}     [description]
     */
    function runRotate(deg) {
        // runInit();

        // setTimeout(function() {
        // addClass(container, 'gb-run');
        container.style[transform] = 'rotate(' + deg + 'deg)';
        // }, 10);
    }

    // 抽奖事件
    function events(params) {
        bind(btn, 'click', function () {
            /*      var prizeId,
                      chances;*/

            // 添加禁止按钮
            addClass(btn, 'disabled');

            /**
             * 转盘旋转
             * @return {[data]}
             * 停留位置
             */
            fnGetPrize(function (data) {

                optsPrize = {
                    prizeId: data[0],
                    chances: data[1]
                }
                // 计算旋转角度
                deg = deg || 0;
                deg = deg + (360 - deg % 360) + (360 * 10 - data[0] * (360 / num))

                // console.log(deg);

                runRotate(deg);
            });

            // 中奖提示
            bind(container, transitionEnd, eGot);
        });
    }

    function eGot() {
        console.log(optsPrize.chances);
        if (optsPrize.chances) removeClass(btn, 'disabled');
        fnGotBack(prizes[optsPrize.prizeId].text);
    }

    /**
     * Bind events to elements
     * @param {Object}    ele    HTML Object
     * @param {Event}     event  Event to detach
     * @param {Function}  fn     Callback function
     */
    function bind(ele, event, fn) {
        if (typeof addEventListener === 'function') {
            ele.addEventListener(event, fn, false);
        } else if (ele.attachEvent) {
            ele.attachEvent('on' + event, fn);
        }
    }
    /**
     * Bind events to elements
     * @param {Object}    ele    HTML Object
     * @param {Event}     event  Event to detach
     * @param {Function}  fn     Callback function
     */
    function bind(ele, event, fn) {
        if (typeof addEventListener === 'function') {
            ele.addEventListener(event, fn, false);
        } else if (ele.attachEvent) {
            ele.attachEvent('on' + event, fn);
        }
    }

    /**
     * hasClass
     * @param {Object} ele   HTML Object
     * @param {String} cls   className
     * @return {Boolean}
     */
    function hasClass(ele, cls) {
        if (!ele || !cls) return false;
        if (ele.classList) {
            return ele.classList.contains(cls);
        } else {
            return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
        }
    }

    // addClass
    function addClass(ele, cls) {
        // console.log(ele, cls);
        if (ele.classList) {
            ele.classList.add(cls);
        } else {
            if (!hasClass(ele, cls)) ele.className += '' + cls;
        }
    }

    /**
     * [提示]
     * @param  {String} msg [description]
     */
    function showMsg(msg) {
        alert(msg);
    }

    // removeClass
    function removeClass(ele, cls) {
        if (ele.classList) {
            ele.classList.remove(cls);
        } else {
            ele.className = ele.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        }
    }

    var gbTurntable = {
        init: function (opts) {
            // console.log(opts);
            return init(opts);
        }
    }

    window.gbTurntable === undefined && (window.gbTurntable = gbTurntable);

    if (typeof define == 'function' && define.amd) {
        define('GB-canvas-turntable', [], function () {
            return gbTurntable;
        });
    }

})()