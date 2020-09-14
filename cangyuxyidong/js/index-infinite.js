//************* infinite 相关 *************//
var loading = false; //是否正在加载中

var token = getCookie('JADE_TOKEN');
var infiniteTime = 1000;
var resetLoadingTime = 1500;
var homeRecommendPageIndex = 0;
var homeJianDingPageIndex = 0;
var homeMaiMaiPageIndex = 0;
var homeWeiboPageIndex = 0;
var homeGuanZhuPageIndex = 0;
var topicPageIndex = 0;
var yanXuanPageIndex = 0;
var pageSize = 10; //每次需要加载多少个 item 追加到列表结尾.

// Attach 'infinite' event handler
// 当页面滚动到底部时需要触发该监听事件
$$('.infinite-scroll').on('infinite', function (ev) {
    if (location.hash === '#tab-1' || location.hash === '#view-1') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            homeRecommendPageIndex = homeRecommendPageIndex + pageSize;
            //首页推荐
            HttpHelper.getJSON(`${CYHOST}/icy/square_recommend?page=${homeRecommendPageIndex}&token=${token}`, 'home_list', '.recommend_home_list', false, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            });
        }, infiniteTime);
    } else if (location.hash === '#tab-2') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            homeJianDingPageIndex = homeJianDingPageIndex + pageSize;
            //首页鉴定
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=${homeJianDingPageIndex}&type=2`, 'appraise_list', '.appraise_div_list', false, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            });
        }, infiniteTime);
    } else if (location.hash === '#tab-3') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            homeMaiMaiPageIndex = homeMaiMaiPageIndex + pageSize;
            //首页买卖
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=${homeMaiMaiPageIndex}&type=3`, 'deal_list', '.deal_div_list', false, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            });
        }, infiniteTime);
    } else if (location.hash === '#tab-4') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            homeWeiboPageIndex = homeWeiboPageIndex + pageSize;
            //首页微博
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=${homeWeiboPageIndex}&type=1&token=${token}`, 'weibo_list', '.weibo_div_list', false, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            });
        }, infiniteTime);
    } else if (location.hash === '#tab-5') {

        // setTimeout(function(){
        //     if (loading) return;
        //     loading = true;
        //
        //     homeGuanZhuPageIndex = homeGuanZhuPageIndex + pageSize;
        //     //首页关注
        //     HttpHelper.getJSON(`${CYHOST}/icy/sale_screenings_list`, 'follow_home_list', '.follow_home_div_list', false, function(){
        //
        //         console.log('ooooooooo');
        //
        //         setTimeout(function(){
        //             loading = false;
        //         }, resetLoadingTime);
        //
        //     });
        // }, infiniteTime);

    } else if (location.hash === '#view-2') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            topicPageIndex = topicPageIndex + pageSize;



            HttpHelper.getJSON(`${CYHOST}/icy/sale_screenings_list?page=${topicPageIndex}&token=${token}`, 'car_list', '.car_div_list', false, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            });

            // 专题列表    sale_screenings_list
            // HttpHelper.getJSON(`${CYHOST}/icy/carousel_list?page=${topicPageIndex}`, 'car_list', '.car_div_list', false, function(){
            //     setTimeout(function(){
            //         loading = false;
            //     }, resetLoadingTime);
            // });


        }, infiniteTime);
    } else if (location.hash === '#view-3') {
        setTimeout(function () {
            if (loading) return;
            loading = true;

            // 众选列表
            yanXuanPageIndex = yanXuanPageIndex + pageSize;
            yanXuanVue.load(yanXuanPageIndex, function () {
                setTimeout(function () {
                    loading = false;
                }, resetLoadingTime);
            }, false);
        }, infiniteTime);
        // 
    }
});


//-------------------- pull to refresh content --------------------//

var ptrContent = $$('.pull-to-refresh-content');
// Add 'refresh' listener on it
ptrContent.on('refresh', function (e) {
    // Emulate 2s loading
    setTimeout(function () {
        if (location.hash === '#tab-1' || location.hash === '#view-1') {

            homeRecommendPageIndex = 0;

            //首页推荐
            HttpHelper.getJSON(`${CYHOST}/icy/square_recommend?page=0&token=${token}`, 'home_list', '.recommend_home_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });

        } else if (location.hash === '#tab-2') {
            homeJianDingPageIndex = 0;

            //首页鉴定
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=0&type=2`, 'appraise_list', '.appraise_div_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });
        } else if (location.hash === '#tab-3') {
            homeMaiMaiPageIndex = 0;

            //首页买卖
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=0&type=3`, 'deal_list', '.deal_div_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });
        } else if (location.hash === '#tab-4') {
            homeWeiboPageIndex = 0;

            //首页微博
            HttpHelper.getJSON(`${CYHOST}/icy/square_list?page=0&type=1&token=${token}`, 'weibo_list', '.weibo_div_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });
        } else if (location.hash === '#tab-5') {
            homeGuanZhuPageIndex = 0;

            //首页关注
            HttpHelper.getJSON(`${CYHOST}/icy/sale_screenings_list`, 'follow_home_list', '.follow_home_div_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });

        } else if (location.hash === '#view-2') {
            topicPageIndex = 0;

            HttpHelper.getJSON(`${CYHOST}/icy/sale_screenings_list?page=${topicPageIndex}&token=${token}`, 'car_list', '.car_div_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });

            // 专题列表    sale_screenings_list    &token=${token}
            // HttpHelper.getJSON(`${CYHOST}/icy/carousel_list?page=${topicPageIndex}`, 'car_list', '.car_div_list', true, function(){
            //     // When loading done, we need to reset it
            //     myApp.pullToRefreshDone();
            // });
        } else if (location.hash === '#view-3') {
            yanXuanPageIndex = 0;

            // 众选列表
            yanXuanVue.load(0, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            }, true);
        } else {

            homeRecommendPageIndex = 0;

            //首页推荐
            HttpHelper.getJSON(`${CYHOST}/icy/square_recommend?page=0&token=${token}`, 'home_list', '.recommend_home_list', true, function () {
                // When loading done, we need to reset it
                myApp.pullToRefreshDone();
            });

        }
    }, 1000);
});