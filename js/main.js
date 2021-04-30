$(document).ready(function(){
  $(".header .an").click(function(){
	$(".nav").toggleClass("on");
    $(this).toggleClass("n");
  });
  $(".fh_top").click(function(){
    $("html,body").animate({scrollTop:0},500);
  });
  jQuery(".zx_zx").slide({mainCell:".bd",delayTime:0,});
  jQuery(".yx_nr").slide({mainCell:".bd",delayTime:0,});
  jQuery(".jn_js").slide({mainCell:".bd",delayTime:0,});
  jQuery(".yx_gx").slide({mainCell:".bd",delayTime:0,});
  $(".yx_gx .t_x ul li").mouseenter(function(){
    var index=$(".yx_gx .t_x ul li").index(this);
    $(this).addClass("on").siblings().removeClass("on");
    $(".yx_gx .w_z p").eq(index).addClass("dk").siblings().removeClass("dk");
  })
});

$(window).scroll(function(){
  var top = $(window).scrollTop();
  if(top>100){
    $(".fh_top").fadeIn();
  }else{
    $(".fh_top").fadeOut();
  }
});