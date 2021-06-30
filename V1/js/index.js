    var banner = $(".banner_img").height()
    $('.banner_img img').load(function () {
        $(".banner").css("height", banner)
    });
//懒加载
var Height = $(window).height()
 $(function(){
		//初始化插件
		$('img').lazyload({
			effect: "fadeIn", //出现的效果 fadeIn   show   slideDown
			//placeholder:"./images/load.gif",//提前占位 图片地址
			threshold: Height, //提前加载，滚动距离
			// event:'mouseover',//如果有该属性，那么提前加载将失效 需要条件出发，参数值为事件名
			// container:$("div"), //浏览器的滚动条会影响到某些元素内部的图片的懒加载，使用这样的属性可以解决
			failure_limit : 10000 //图片混排 同时加载更多的图片避免出现当前屏幕上图片不能加载出来的问题
		});
		// 如果你的图片在某个div中，该div有滚动条，那么就去设置cotainer:$(div的选择器)
   })

// 移动端菜单
$(document).ready(function () {
    $(".hamburger").click(function () {
        $(this).toggleClass("is-active");
        $(".nav").toggleClass("on")
    });
});


 // 溢出隐藏，点击不隐藏
 $(".game_title").on("click", ".game_title_more", function () {
    $(".game_title").find(".game_team_depiction p").toggleClass("active");
    $(".game_title_more").toggleClass("active")
})


// vs_data1切换
$(function () {
    //第一个高亮
    $(".game_detail_ul li:first").addClass("active");
    //展示第二个tab中的第一个div   其他的都隐藏
    $(".game_detail_div_item:first").addClass("active").siblings().removeClass("active");
    // $(".game_detail_div_item:first li:first").addClass("active")
    //展示第二个tab中的第一个div中的第一个vs_data2_item  其他的都隐藏
    $(".vs_data2 .vs_data2_item:first").addClass("active").siblings().removeClass("active");

    //点击li
    $(".game_detail_ul li").click(function () {
        // li选中的添加new   其他的都去掉
        $(this).addClass("active").siblings().removeClass("active");
        // console.log($(".game_detail_ul li").index(this))
        $(".game_detail_div_item").eq($(".game_detail_ul li").index(this))
        .show().siblings().hide();
    });

    //这是点击info的
    $(".game_detail_div_item li").click(function () {
        $(this).addClass("active").siblings().removeClass("active")
        $(".vs_data2 .vs_data2_item").eq($(".game_detail_div_item li").index(this)).addClass("active").siblings().removeClass("active");
    });
})

// if ($(".game_detail_ul li").length > 5) {
//     console.log($(".game_detail_ul li").length)
//     $(".game_detail_ul li").addClass("active1")
// }

$(".game_before_after").on("click", 'li', function () {
    $(".game_before_after li").removeClass("active");
    $(this).addClass("active");
    $(this).parents(".game_detail_item6").find(".vs_data3").find(".vs_data3_left").removeClass("active").eq($(this).index()).addClass("active");
})



 //字体溢出隐藏
 var str = $(".dk").text();
            
 var tempt = str;
 coverup();
 function coverup() {
     if (str.length > 38) {
         $(".dk").text(tempt.slice(0, 38) + "...");
     }
     var readmore = "<a onclick='showmore()'  style='color: #ff6649;'>查看全部</a>"
     $(".dk").append(readmore);
 }

 function showmore() {
     $(".dk").text(str);
     var readmore = "<a onclick='coverup()'  style='color: #ff6649;'>收起</a>"
     $(".dk").append(readmore);
 }
 

 

 var str1 = $(".dk1").text();
 
 var tempt1 = str1;
 coverup1();
 function coverup1() {
     if (str1.length > 38) {
         $(".dk1").text(tempt1.slice(0, 38) + "...");
     }
     var readmore1 = "<a onclick='showmore1()'  style='color: #ff6649;'>查看全部</a>"
     $(".dk1").append(readmore1);
 }

 function showmore1() {
     $(".dk1").text(str1);
     var readmore1 = "<a onclick='coverup1()'  style='color: #ff6649;'>收起</a>"
     $(".dk1").append(readmore1);
 }


// 右边悬浮窗
$(".suspension").on("click",".suspension_close",function(){
    $(".suspension").css("display","none")
})



// 懒加载

 // onload是等所有的资源文件加载完毕以后再绑定事件


 //这是dota2中比赛详情的tab切换
 $(function () {
    //第一个高亮
    $(".live_box_ul li:first").addClass("active");
    //展示第二个tab中的第一个div   其他的都隐藏
    $(".live_box_item:first").addClass("active").siblings().removeClass("active");
    // $(".live_box_item:first li:first").addClass("active")
    //展示第二个tab中的第一个div中的第一个vs_data2_item  其他的都隐藏
    $(".battle_list .battle_item:first").addClass("active").siblings().removeClass("active");

    //点击li
    $(".live_box_ul li").click(function () {
        // li选中的添加new   其他的都去掉
        $(this).addClass("active").siblings().removeClass("active");
        // console.log($(".game_detail_ul li").index(this))
        $(".live_box_item").eq($(".live_box_ul li").index(this))
        .show().siblings().hide();
    });

    //这是点击live_box_item .battleBox_vs_data1 li的
    $(".live_box_item .battleBox_vs_data1 li").click(function () {
        $(this).addClass("active").siblings().removeClass("active")
        $(".battle_list .battle_item").eq($(".live_box_item .battleBox_vs_data1 li").index(this)).addClass("active").siblings().removeClass("active");
    });


    //这是点击lineup_bottom .lineup_vs_data2 li的
    $(".lineup_bottom .lineup_vs_data2 li").click(function () {
        $(this).addClass("active").siblings().removeClass("active")
        $(".lineup_list .lineup_item").eq($(".lineup_bottom .lineup_vs_data2 li").index(this)).addClass("active").siblings().removeClass("active");
    });
})


