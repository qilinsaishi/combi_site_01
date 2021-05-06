// 移动端菜单
$(document).ready(function () {
    $(".hamburger").click(function () {
        $(this).toggleClass("is-active");
        $(".nav").toggleClass("on")
    });
});