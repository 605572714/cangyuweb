var yanXuanVue = new Vue({
    // el: '#yanxuan_list',
    data: {
        YanXuanList: []
    },

    mounted: function(){
        this.load(1);
    },

    methods: {
        load: function(pageIndex, cb, isReset){
            this.$http.get(`${CYHOST}/icy/product_list?page=${pageIndex}`)
                .then(function(response){
                    // console.log(response);

                    if(!response.body.data) return;
                    if(isReset){
                        this.$data.YanXuanList = [];
                    }
                    for(let item of response.body.data.list){
                        this.$data.YanXuanList.push(item);    
                    }

                    cb && cb();

                    setTimeout(function() {
                        var mySwiper3 = myApp.swiper('.swiper-3', {
                            pagination: '.swiper-3 .swiper-pagination',
                            preloadImages: false,
                            lazyLoading: true,
                            spaceBetween: 60,
                            observer: true,//修改swiper自己或子元素时，自动初始化swiper
                            observeParents: true,//修改swiper的父元素时，自动初始化swiper
                            autoplay: 1500,
                            autoplayDisableOnInteraction: false,
                            touchRatio: 1
                        });
                    }, 1500);
                });
        }
    }
});

//---------------------------------------------------------------------------------------
var homeLunBoVue = new Vue({
    data: {
        LunBoList: []
    },
    mounted: function(){
        this.load();
    },
    methods: {
        load: function(){
            this.$http.get(`${CYHOST}/icy/carousel_recommend`)
                .then(function(response){

                    console.log(response);

                    if(!response.body.data) return;
                    for(let item of response.body.data){
                        this.$data.LunBoList.push(item);
                    }

                    var mySwiper1 = myApp.swiper('.icangyu-yyzg-gudong', {
                        pagination: '.icangyu-yyzg-gudong .swiper-pagination',
                        preloadImages: false,
                        lazyLoading: true,
                        spaceBetween: 60,
                        observer: true,//修改swiper自己或子元素时，自动初始化swiper
                        observeParents: true,//修改swiper的父元素时，自动初始化swiper
                        autoplay: 5000,
                        autoplayDisableOnInteraction: false
                    });
                });            
        },
        goTopic: function(item){
            window.location.href = `zhuanti——xiangqing.html?type=4&item_id=${item.id}`;
        }
    }
});


// Initialize your app
var myApp = new Framework7({
    router: false,
    swipePanel: 'left'
});

// Export selectors engine
var $$ = Dom7;

// Add views
var view1 = myApp.addView('#view-1');
var view2 = myApp.addView('#view-2', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});
var view3 = myApp.addView('#view-3');
var view4 = myApp.addView('#view-4');

// 1 Slide Per View, 50px Between

// var mySwiper1 = myApp.swiper('.icangyu-yyzg-gudong', {
//     pagination: '.icangyu-yyzg-gudong .swiper-pagination',
//     // preloadImages: true,
//     // lazyLoading: true,
//     spaceBetween: 50,
//     paginationClickable: true
// });

var mySwiper2 = myApp.swiper('.swiper-2', {
    pagination: '.swiper-2 .swiper-pagination',
    preloadImages: true,
    //direction: 'vertical',
    //lazyLoading: true,
    hashnav: true,
    slidesPerView: 1,
    spaceBetween: 50,
    paginationClickable: true,
    longSwipesRatio: 0.3,
    touchRatio: 1,
    observer: true,//修改swiper自己或子元素时，自动初始化swiper
    observeParents: true,//修改swiper的父元素时，自动初始化swiper
});

// var mySwiper3 = myApp.swiper('.swiper-3', {
//     pagination: '.swiper-3 .swiper-pagination',
//     preloadImages: true,
//     hashnav: true,
//     //direction: 'vertical',
//     //lazyLoading: true,
//     paginationClickable: true,
//     longSwipesRatio: 0.3,
//     touchRatio: 1,
//     observer: true,//修改swiper自己或子元素时，自动初始化swiper
//     observeParents: true,//修改swiper的父元素时，自动初始化swiper
//     slidesPerView: 1,
//     spaceBetween: 50
// });


var mySwiper5 = myApp.swiper('.swiper-5', {
    pagination: '.swiper-5 .swiper-pagination',
    paginationClickable: true,
    longSwipesRatio: 0.3,
    touchRatio: 1,
    observer: true,//修改swiper自己或子元素时，自动初始化swiper
    observeParents: true,//修改swiper的父元素时，自动初始化swiper
});

//---------------------------------------
yanXuanVue.$mount('#yanxuan_list');
homeLunBoVue.$mount('#home_scroll_list');

(function(){

    let nickname = decodeURI(HttpHelper.getCookie('USER_NAME'));
    $.getJSON(`${CYHOST}/icy/personal_center_top?token=${token}`, function(data){
        // console.log(data);
        document.cookie = `USER_AVATAR=${data.data.avatar}`;
        $('#nickname').html(`${nickname}<span class="cangyu_bbs_dengji">Lv.${data.data.rating}</span>`);
        let url = `url(${CYHOST}${data.data.avatar}) no-repeat center center`

        $('#headerPhoto').css('background', url);
        $('#headerPhoto').css('background-size', 'contain');

    });
})();


//首页推荐
$.getJSON(`${CYHOST}/icy/square_recommend?page=0&token=${token}`, function (data) {
    // console.log(data);
    var Odata = data.data;
    var html = template('home_list', Odata);
    $('.recommend_home_list').html(html);

})


//首页鉴定
$.getJSON(`${CYHOST}/icy/square_list?page=0&type=2`, function (data) {
    // console.log(data);
    var Odata = data.data;
    var html = template('appraise_list', Odata);
    $('.appraise_div_list').html(html);
})

//首页买卖
$.getJSON(`${CYHOST}/icy/square_list?page=0&type=3`, function (data) {
    // console.log(data);
    var Odata = data.data;
    var html = template('deal_list', Odata);
    $('.deal_div_list').html(html);
})

//首页微博
$.getJSON(`${CYHOST}/icy/square_list?type=1&page=0&token=${token}`, function (data) {
    // console.log(data);
    var Odata = data.data;
    var html = template('weibo_list', Odata);
    $('.weibo_div_list').html(html);
})

//首页关注 - 拍卖
$.getJSON(`${CYHOST}/icy/sale_screenings_list`, function (data) {
    console.log(data);
    var Odata = data.data;
    var html = template('follow_home_list', Odata);
    $('.follow_home_div_list').html(html);
})

// 点赞
function praise(square_id){
    $.getJSON(`${CYHOST}/icy/square_praise_add?square_id=${square_id}&token=${token}`,function (data) {
        if(data.result === 100){
            myApp.alert('点赞成功。', '提示');
        }else{
            myApp.alert(data.info, '提示');
        }
    })
}

function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}

function addHomeList() {
    $.getJSON(`${CYHOST}/icy/square_recommend?page=0&token=${token}`, function (data) {
        // console.log(data);
        var Odata = data.data;
        var html = template('home_list', Odata);
        $('.recommend_home_list').html(html);
    })
}


myApp.showTab(window.location.hash);
