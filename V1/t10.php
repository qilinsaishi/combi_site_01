<!DOCTYPE html>
<?php
require_once "function/init.php";
$params=[
    "connectInfo"=>["dataType"=>"keywordMapList","fields"=>"content_id","source_type"=>"another","word"=>$config['ti10']['keyword'],"page_size"=>10,"content_type"=>"information","list"=>["page_size"=>10,"fields"=>"id,title,create_time,logo"]],
];
$return = curl_post($config['api_get'],json_encode($params),1);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <?php renderHeaderJsCss($config,["newevents","events","../fonts/iconfont"]);?>
    <title>TI10_2021年DOTA2国际邀请赛ti10赛事赛程奖金规则热门资讯-<?php echo $config['site_name'];?></title>
    <meta name=”Keywords” Content=”TI10,dota2ti10,ti10赛程,ti10奖金″>
    <meta name="description" content="2021年DOTA2国际邀请赛ti10专题报道,<?php echo $config['site_name'];?>带大家了解2021dota2TI10国际邀请赛时间,TI10最新资讯,TI10总奖金池信息,dota2国际邀请赛2021年度夺冠热门,ti10最新赛程信息。">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="<?php echo $config['site_url'];?>">
                            <img src="<?php echo $config['site_url'];?>/images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                        <ul class="clearfix">
                            <?php generateNav($config,"t10");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row events_top">
                <!-- 比赛介绍 -->
                <div class="team_title mb20 clearfix schedule">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/dota2_logo.png" alt="">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <p class="name fl">Ti10 Dota2国际邀请赛</p>
                            <p class="classify fl">DOTA2</p>
                        </div>
                        <div class="team_explain_bottom">
                            <p>
                                DOTA2国际邀请赛，The International DOTA2
                                Championships。简称Ti，创立于2011年，是一个全球性的电子竞技赛事，每年一届，由ValveCorporation（V社）主办,奖杯为V社特制冠军盾牌，每一届冠军队伍及人员将记录在游戏泉水的冠军盾中。
                            </p>
                            <p>
                                <span>TI10国际邀请赛时间：</span>8月5日至8月8日举办小组赛，8月10日至15日举办正式比赛，举办地点将位于瑞典首都斯德哥尔摩。
                            </p>
                            <p>
                                <span>TI10国际邀请赛奖金：</span>本届ti10国际邀请赛奖金池高达<span>40018195美金（约合人民币2.5亿元）</span>
                            </p>
                        </div>
                    </div>
                    <div class="left_bg">
                        <img src="<?php echo $config['site_url'];?>/images/events_topbg.png" alt="">
                    </div>
                    <div class="right_bg">
                        <img src="<?php echo $config['site_url'];?>/images/events_topbg.png" alt="">
                    </div>
                </div>
                <!-- 比赛介绍 -->
                <!-- 赛制 -->
                <div class="format mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/format_icon.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">Ti10国际邀请赛赛制</span>
                    </div>
                    <div class="format_detail">
                        <p class="format_p">地区预选赛赛制</p>
                        <div class="format_div">
                            <p><span>小组赛：</span>进行组内BO1单循环积分赛，第1-4名晋级淘汰赛，第5-8名直接淘汰</p>
                            <p><span>淘汰赛：</span>4支战队进行双败淘汰赛除总决赛BO5，其余均为BO3，第一名晋级主赛事</p>
                        </div>
                        <p class="format_p">主赛事赛制</p>
                        <div class="format_div format_div1">
                            <p><span>小组赛：</span>共18支战队分为2组（每组9支），进行小组循环积分赛，获胜得2分，平得1分，负得0分，每组排名末位战队被淘汰。</p>
                            <p><span>淘汰赛：</span>双败淘汰制，每组1-4名进入主赛事胜者组，5-8名进入败者组，败者组第一轮为BO1，决赛为BO5，其余比赛均为BO3
                            </p>
                        </div>
                    </div>
                </div>
                <!-- 赛制 -->
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name"><?php echo $config['ti10']['event_name']?>国际邀请赛最新资讯</span>
                        <a href="##" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="team_news_mid">
                        <ul class="team_news_mid_ul clearfix">
                            <?php foreach($return['connectInfo']['data'] as $key => $info){if($key<=3){?>
                            <li>
                                <a href="<?php echo $config["site_url"]."/newsdetail/".$info['id'];?>">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                        </div>
                                        <p><?php echo $info['title'];?></p>
                                    </div>
                                </a>
                            </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <div class="team_news_bot">
                        <ul class="team_news_bot_ul clearfix">
                            <?php foreach($return['connectInfo']['data'] as $key => $info){if($key>3){?>
                                <li class="fl">
                                    <a href="<?php echo $config["site_url"]."/newsdetail/".$info['id'];?>">
                                        <?php echo $info['title'];?>
                                    </a>
                                </li>
                            <?php }}?>
                        </ul>
                    </div>
                </div>
                <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">Ti10国际邀请赛参赛队伍</span>
                    </div>
                    <ul class="dota2_teams clearfix">
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                        <li class="col-xs-2">
                            <a href="##">
                                <div class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_team.png" alt="" class="game_team_img">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="prizePool mb20">
                    <p class="title">Ti10国际邀请赛奖金池</p>
                    <div class="m_wrapper">

                    </div>
                    <!-- <div class="money">
                        <i>$</i>
                        <span>4</span>
                        <span>5</span>
                        <span>,</span>
                        <span>2</span>
                        <span>3</span>
                        <span>1</span>
                        <span>,</span>
                        <span>6</span>
                        <span>9</span>
                        <span>2</span>
                    </div> -->
                    <!-- <div class="money">
                        <i>$</i>
                    </div> -->
                    <div class="champion">
                        <p>$22,543,333</p>
                        <span>冠军&nbsp;|&nbsp;45%</span>
                    </div>
                    <div class="other clearfix">
                        <div class=" other_div other_mr">
                            <p>$5,125,824</p>
                            <span>亚军&nbsp;|&nbsp;13%</span>
                        </div>
                        <div class=" other_div other_mr">
                            <p>$5,125,824</p>
                            <span>季军&nbsp;|&nbsp;9%</span>
                        </div>
                        <div class=" other_div">
                            <p>$5,125,824</p>
                            <span>殿军&nbsp;|&nbsp;6%</span>
                        </div>
                    </div>
                    <div class="others">
                        <div class="others_div">
                            <p>$1,754,223</p>
                            <span>5-6&nbsp;|&nbsp;3.5%</span>
                        </div>
                        <div class="others_div">
                            <p>$1,254,621</p>
                            <span>5-6&nbsp;|&nbsp;2.5%</span>
                        </div>
                        <div class="others_div">
                            <p>$851,634</p>
                            <span>5-6&nbsp;|&nbsp;2%</span>
                        </div>
                        <div class="others_div">
                            <p>$684,881</p>
                            <span>5-6&nbsp;|&nbsp;1.5%</span>
                        </div>
                        <div class="others_div">
                            <p>$154,251</p>
                            <span>5-6&nbsp;|&nbsp;0.25%</span>
                        </div>
                    </div>
                </div>
                <div class="thumbsUp mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/ranking.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">Ti10国际邀请赛冠军预测</span>
                    </div>
                    <div class="clearfix thumbs">
                        <div class="top_three fl clearfix dn_wap">
                            <div class="top_one fl">
                                <a href="##">
                                    <div class="team">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbsUp.png" alt="">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbstop.png" alt="" class="thumbstop">
                                    </div>
                                    <p class="top_name">WEEEEEEEEE</p>
                                    <div id="btn1">
                                        <div class="btn1">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                                </a>
                            </div>
                            <div class="top_right fl">
                                <div class="top_two">
                                    <a href="##">
                                        <div class="team">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp.png" alt="" class="top_twoimg">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbstwo.png" alt="" class="thumbstwo">
                                        </div>
                                        <p class="two_name">WEEEEEEEEE</p>
                                        <div id="btn2">
                                            <div class="btn2">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="top_thre">
                                    <a href="##" class="clearfix">
                                        <div class="fl team">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="" class="top_threeimg">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsthree.png" alt="" class="thumbsthree">
                                        </div>
                                        <div class="fl three_detali">
                                            <p class="thre_name">这里是战队名称这里是战队名称</p>
                                            <div id="btn3">
                                                <div class="btn3">
                                                    <i class="iconfont icon-dianzan i"></i>
                                                </div>
                                                <p class="likes">100</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dn_pc top_threes">
                            <div class="top_two">
                                <a href="##">
                                    <div class="team">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbsUp.png" alt="" class="top_twoimg">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbstwo.png" alt="" class="thumbstwo">
                                    </div>
                                    <p class="two_name">WEEEEEEEEE</p>
                                    <div id="btn2_1">
                                        <div class="btn2">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                                </a>
                            </div>
                            <div class="top_one">
                                <a href="##">
                                    <div class="team">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbsUp.png" alt="" class="top_oneimg">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbstop.png" alt="" class="thumbstop">
                                    </div>
                                    <p class="top_name">WEEEEEEEEE</p>
                                    <div id="btn1_1">
                                        <div class="btn1">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                                </a>
                            </div>
                            <div class="top_three">
                                <a href="##">
                                    <div class="team">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbsUp.png" alt="" class="top_twoimg">
                                        <img src="<?php echo $config['site_url'];?>/images/thumbsthree.png" alt="" class="thumbstwo">
                                    </div>
                                    <p class="two_name">WEEEEEEEEE</p>
                                    <div id="btn3_1">
                                        <div class="btn3">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="fr thumb_others">
                            <ul>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">4</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn4" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">5</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn5" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">6</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn6" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">7</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn7" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">8</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn8" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">9</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn9" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">10</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn10" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">11</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn11" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">12</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn12" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">13</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn13" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <a href="##">
                                        <span class="ranking_span">14</span>
                                        <div class="thumb_others_img">
                                            <img src="<?php echo $config['site_url'];?>/images/thumbsUp3.png" alt="">
                                        </div>
                                        <span class="thumb_others_name">WEEEEEEEEEWEEEEEEEEE</span>
                                        <div id="btn13" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="hot_match mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="##" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
                            <li>
                                <a href="##">
                                    <img src="<?php echo $config['site_url'];?>/images/event_1.png" alt="" class="imgauto1">
                                    <span>2021 LPL春季赛</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <img src="<?php echo $config['site_url'];?>/images/event_2.png" alt="" class="imgauto1">
                                    <span>2021 LPL春季赛</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <img src="<?php echo $config['site_url'];?>/images/event_1.png" alt="" class="imgauto1">
                                    <span>2021 LPL春季赛</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <img src="<?php echo $config['site_url'];?>/images/event_2.png" alt="" class="imgauto1">
                                    <span>2021 LPL春季赛</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="container">
            <div class="row">
                <div class="links_title">
                    友情链接
                </div>
            </div>
            <ul class="row links_list clearfix">
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
            </ul>
            <p>Copyright © 2021 www.qilindianjing.com</p>
            <p>网站内容来源于网络，如果侵犯您的权益请联系删除</p>
        </div>
    </div>
    <div class="suspension">
        <div class="suspension_img">
            <img src="<?php echo $config['site_url'];?>/images/suspension.png" alt="">
        </div>
        <div class="qrcode">
            <div class="qrcode_img">
                <img src="<?php echo $config['site_url'];?>/images/qrcode.png" alt="">
            </div>
        </div>
    </div>
    <script src="<?php echo $config['site_url'];?>/js/jquery.min.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/jquery.lazyload.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/index.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/jquery.lineProgressbar.js"></script>
    <!-- 金额js -->
    <script>
        var a = '13,456,789';
        // Number.prototype.reverse = function(){
        //      var s = this.toString();
        //      var a = [];
        //      for(var i=0;i<9;i++){
        //       a.unshift(s[i]);
        //      }
        //      return a.join("");
        //     }
        //    var n =  a.reverse()
        //    console.log(n.toString().split(""))
        // console.log(a.split('').map(Number))
        var money = a.split('')
        var html = ''
        html += '<div class="money">' + '<i>$</i>'
        for (var i = 0; i < money.length; i++) {
            html += '<span>' + money[i] + '</span>'
        }
        html += '</div>'
        $("<?php echo $config['site_url'];?>m_wrapper").html(html)
    </script>
    <script type="text/javascript">
            (function ($) {
                $.extend({
                    tipsBox: function (options) {
                        options = $.extend({
                            obj: null,  //jq对象，要在那个html标签上显示
                            str: "+1",  //字符串，要显示的内容;也可以传一段html，如: "<b style='font-family:Microsoft YaHei;'>+1</b>"
                            startSize: "12px",  //动画开始的文字大小
                            endSize: "30px",    //动画结束的文字大小
                            interval: 600,  //动画时间间隔
                            color: "red",    //文字颜色
                            callback: function () { }    //回调函数
                        }, options);
                        $("body").append("<span class='num'>" + options.str + "</span>");
                        var box = $("<?php echo $config['site_url'];?>num");
                        var left = options.obj.offset().left + options.obj.width() / 2;
                        var top = options.obj.offset().top - options.obj.height();
                        box.css({
                            "position": "absolute",
                            "left": left + "px",
                            "top": top + "px",
                            "z-index": 9999,
                            "font-size": options.startSize,
                            "line-height": options.endSize,
                            "color": options.color
                        });
                        box.animate({
                            "font-size": options.endSize,
                            "opacity": "0",
                            "top": top - parseInt(options.endSize) + "px"
                        }, options.interval, function () {
                            box.remove();
                            options.callback();
                        });
                    }
                });
            })(jQuery);

        function niceIn(prop) {
            prop.find('.i').addClass('niceIn');
            setTimeout(function () {
                prop.find('.i').removeClass('niceIn');
            }, 1000);
        }
        for (var i = 0; i < $('.likes').length; i++) {
            var ran = Math.floor(Math.random() * 1000000 + 1)
            $('.likes').eq(i).text(ran)
        }
        $("<?php echo $config['site_url'];?>i").click(function () {
            var num = $(this).parent().next().text()
            num++;
            $(this).parent().next().text(num);
        });
        $(function () {
            $("#btn1 .btn1").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn2 .btn2").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn3 .btn3").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn1_1 .btn1").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn2_1 .btn2").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn3_1 .btn3").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(document).ready(function (index) {
            $("<?php echo $config['site_url'];?>thumb_others ul li").each(function (index) {
                var _this = $(this).find('a').find('.btn_others').find('.btn4')
                _this.click(function () {
                    $.tipsBox({
                        obj: _this,
                        str: "+1",
                        callback: function () {
                        }
                    });
                    niceIn(_this);
                });
            });
        });
    </script>

</body>

</html>