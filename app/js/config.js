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
        }
    };
})();

//----------------------- Config -----------------------//

// var CYHOST = 'http://118.190.47.197';
var CYHOST = 'https://app.icangyu.com';
var CYHOST_TEST = 'https://testicy.icangyu.com';
var token = HttpHelper.getCookie("JADE_TOKEN");