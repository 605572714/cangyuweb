//----------------------- HTTP -----------------------//

var HttpHelper = (function () {
    return {
        getJSON: function (url, templateId, containerId, isReset, cb) {
            $.getJSON(url, function (data) {
                var Odata = data.data;
                var html = template(templateId, Odata);
                if (isReset) {
                    $(containerId).html(html);
                } else {
                    $(containerId).append(html);
                }

                if (cb && typeof (cb) === 'function') {
                    cb(data);
                }
            })
        },
        getCookie: function (name) {
            if (!name) return null;

            var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
            if (arr = document.cookie.match(reg)) {
                return unescape(arr[2]);
            } else {
                return null;
            }
        },
        getQuery: function (name) {
            if (!name) return null;
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) {
                return unescape(r[2]);
            }
            return null;
        },
    };
})();

var convertToChinaNum = function (num) {
    var arr1 = new Array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    var arr2 = new Array('', '十', '百', '千', '万', '十', '百', '千', '亿', '十', '百', '千', '万', '十', '百',
        '千', '亿'); //可继续追加更高位转换值
    if (!num || isNaN(num)) {
        return "零";
    }
    var english = num.toString().split("")
    var result = "";
    for (var i = 0; i < english.length; i++) {
        var des_i = english.length - 1 - i; //倒序排列设值        
        result = arr2[i] + result;
        var arr1_index = english[des_i];
        result = arr1[arr1_index] + result;
    }
    //将【零千、零百】换成【零】 【十零】换成【十】     
    result = result.replace(/零(千|百|十)/g, '零').replace(/十零/g, '十');
    //合并中间多个零为一个零
    result = result.replace(/零+/g, '零');
    //将【零亿】换成【亿】【零万】换成【万】     
    result = result.replace(/零亿/g, '亿').replace(/零万/g, '万');
    //将【亿万】换成【亿】     
    result = result.replace(/亿万/g, '亿');
    //移除末尾的零    
    result = result.replace(/零+$/,
        '')
    //将【零一十】换成【零十】     
    //result=result.replace(/零一十/g, '零十' );
    //貌似正规读法是零一十  
    //将【一十】换成【十】     
    result = result.replace(/^一十/g, '十');
    return result;
}

//----------------------- Config -----------------------//

// var CYHOST = 'http://118.190.47.197';
var CYHOST = 'https://app.icangyu.com';
var CYHOST_TEST = 'https://testicy.icangyu.com';
var token = HttpHelper.getCookie("JADE_TOKEN");
var alert = function () {
    window.alert = function (name) {
        var iframe = document.createElement("IFRAME");
        iframe.style.display = "none";
        iframe.setAttribute("src", 'data:text/plain,');
        document.documentElement.appendChild(iframe);
        window.frames[0].window.alert(name);
        iframe.parentNode.removeChild(iframe);
    };

};