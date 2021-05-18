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
$(".vs_data1").on("click", 'li', function () {
    var _this = $(this).index() - 1;
    $(".vs_data1 li").removeClass("active");
    $(this).addClass("active");
    $(this).parents(".vs_data1").find("li").removeClass("active1").eq(_this).addClass("active1");
    $(".vs_data2 .vs_data2_item").removeClass("active").eq($(this).index()).addClass("active");
    $(this).parents(".game_detail_item5").find(".vs_data2").find(".vs_data2_item").removeClass("active").eq($(this).index()).addClass("active")
})

// if ($(".game_detail_ul li").length > 5) {
//     console.log($(".game_detail_ul li").length)
//     $(".game_detail_ul li").addClass("active1")
// }

$(".game_before_after").on("click", 'li', function () {
    $(".game_before_after li").removeClass("active");
    $(this).addClass("active");
    $(this).parents(".game_detail_item6").find(".vs_data3").find(".vs_data3_left").removeClass("active").eq($(this).index()).addClass("active");
    // $(".vs_data3 .vs_data3_left").removeClass("active").eq($(this).index()).addClass("active");
    console.log($(this).parents(".game_detail_item6").find(".vs_data3").find(".vs_data3_left"))
})

$(".game_detail_ul").on("click", 'li', function () {
    $(".game_detail_ul li").removeClass("active").eq($(this).index()).addClass("active");
    $(".game_detail_div .game_detail_div_item").removeClass("active").eq($(this).index()).addClass("active");
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
// $(".suspension_img").on("")



// 懒加载

 // onload是等所有的资源文件加载完毕以后再绑定事件


