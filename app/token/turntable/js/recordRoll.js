function nes(father, children1, children2, length) {
    var width = window.screen.width;
    console.log(width);
    //获取列表父容器
    var vip = father;
    //获取信息列表
    var list = children1;
    var list1 = children2;
    //创建第二个列表设置一系列样式id等
    // var list1 = document.createElement("ul");
    // list1.setAttribute("id", "list1");
    //初始位置为300正好在第一个列表的下面
    list1.style.top = width / 375 * 26 * length + "px";
    list1.style.position = "absolute";
    //插入文档流
    vip.appendChild(list1);
    //把第一个列表的结构内容复制给第二个
    // list1.innerHTML = list.innerHTML;
    //第一个列表
    function b() {
        //top值为当前的top减10   
        list.style.top = parseInt(list.style.top) - (width / 375 * 12.75) + "px";
        //如果top值为-300那么初始化top
        if (parseInt(list.style.top) <= -parseInt(width / 375 * 25.5 * length)) {
            list.style.top = 0;
        }
        //这里是实现间隔滚动判断
        //当top值整除50(每个li的高度)时候清除定时器  
    };
    //定时器
    time = setInterval(b, 1000);
    //第二个列表与第一个列表操作一样，只是修改了高度
    function c() {
        list1.style.top = parseInt(list1.style.top) - (width / 375 * 12) + "px";
        if (parseInt(list1.style.top) < 0) {
            list1.style.top = width / 375 * 26 * length + "px";
        }
    };
    time1 = setInterval(c, 1000);
}