Vue.filter('alb', function(value){
    if(!value) return '';

    if(value && value.startsWith('data:image')){
        return value;
    }

    return `${CYHOST}${value}`;
});

Vue.filter('yanxuan-url', function(value){
    return `yanxuan——xiangqing.html?type=5&item_id=${value.id}`;
});

Vue.filter('order-type', function(orderTypeId){
    if(!orderTypeId) return '';
    let orderArray = ['已下架', '待付款', '待发货', '已发货', '退款申请中', '退款完成', '已完成', '已删除'];
    
    if(orderTypeId > 0 && orderTypeId < 7){
        return orderArray[orderTypeId];
    }

    return '';
});

Vue.filter('index-with-uid', function(item){
    if(!item) return '';

    return `wode_index.html?user_id=${item.uid}`;
});