<!DOCTYPE html>
<?php
require_once "function/init.php";
$params = [
    "tournamentList"=>["page"=>1,"page_size"=>4,"game"=>$config['s11']['game'],"source"=>$config['default_source'],"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img","default_information_img","android_url","ios_url"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"s11","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title>S11英雄联盟LOL2021全球总决赛_S11全球总决赛赛程时间_S11全球总决赛举办地-<?php echo $config['site_name'];?></title>
    <?php renderHeaderJsCss($config,["newevents","events","../fonts/iconfont","animate.min.css","s11"]);?>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="index.html">
                            <img src="<?php echo $config['site_url'];?>/images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                        <?php generateNav($config,"tournament");?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row events_top s11">
                <!-- 比赛介绍 -->
                <div class="team_title mb20 clearfix schedule">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/s11_logo_top.png" alt="">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <h1 class="name fl">2021年度S11英雄联盟全球总决赛</h1>
                            <p class="classify fl"><?php echo $config['game'][$config['s11']['game']];?></p>
                        </div>
                        <div class="team_explain_bottom">
                            <p>
                                英雄联盟全球总决赛（League of Legends World Championship）是英雄联盟一年一度最为盛大的比
                            </p>
                            <p>赛，也是英雄联盟电竞赛事中最高荣誉、最高含金量、最高竞技水平、最高知名度的比赛。</p>
                            <p>
                                2019年全球总决赛在欧洲打破了电竞史上多项收视纪录。
                            </p>
                            <p>
                                2020年全球总决赛全程落地上海，冠亚军决赛于上海浦东足球场盛大举行。
                            </p>
                            <p>
                                2021年全球总决赛在上海、青岛、武汉、成都和深圳五大城市同时举办，五城联动，共襄盛举。
                            </p>
                        </div>
                    </div>
                    <div class="left_bg">
                        <img src="<?php echo $config['site_url'];?>/images/s11_top_bg.png" alt="">
                    </div>
                    <div class="right_bg">
                        <img src="<?php echo $config['site_url'];?>/images/s11_top_bg.png" alt="">
                    </div>
                </div>
                <!-- 比赛介绍 -->
                <!-- 赛制 -->
                <div class="s11_format mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/format_icon.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['s11']['event_name'];?>赛程时间·赛制</h2>
                    </div>
                    <div class="format_detail">
                        <ul class="s11_format_ul">
                            <li class="s11_format_li active">
                                <div class="s11_format_li_top">
                                    <span class="match_name">入围赛</span>
                                    <span class="match_time">10月1日—10月6日</span>
                                </div>
                                <div class="s11_format_li_bot">
                                    <div class="dot"><i></i></div>
                                </div>
                            </li>
                            <li class="s11_format_li">
                                <div class="s11_format_li_top">
                                    <span class="match_name">小组赛</span>
                                    <span class="match_time">10月9日—10月17日</span>
                                </div>
                                <div class="s11_format_li_bot">
                                    <div class="dot"><i></i></div>
                                </div>
                            </li>
                            <li class="s11_format_li">
                                <div class="s11_format_li_top">
                                    <span class="match_name">8强淘汰赛</span>
                                    <span class="match_time">10月21日—10月24日</span>
                                </div>
                                <div class="s11_format_li_bot">
                                    <div class="dot"><i></i></div>
                                </div>
                            </li>
                            <li class="s11_format_li">
                                <div class="s11_format_li_top">
                                    <span class="match_name">半决赛</span>
                                    <span class="match_time">10月30日—10月31日</span>
                                </div>
                                <div class="s11_format_li_bot">
                                    <div class="dot"><i></i></div>
                                </div>
                            </li>
                            <li class="s11_format_li">
                                <div class="s11_format_li_top format_finals">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/s11_format_logo.png" alt="">
                                    </div>
                                    <div class="right">
                                        <span class="match_name">总决赛</span>
                                        <span class="match_time">11月6日</span>
                                    </div>

                                </div>
                                <div class="s11_format_li_bot">
                                    <div class="dot"><i></i></div>
                                </div>
                            </li>
                        </ul>
                        <div class="s11_format_detail">
                            <div class="s11_format_item active">
                                十支入围赛参赛队伍将会被分成两组，每组五支。所有队伍进行单循环赛，两组排名第一的队伍将直接进入小组赛，排名末位的队伍将被淘汰。每组排名第三和第四的队伍进行五局三胜的比赛，负方淘汰，胜方与另一组排名第二的队伍进行五局三胜比赛。最终胜出的队伍也将进入小组赛阶段。
                            </div>
                            <div class="s11_format_item">
                                16强小组赛的分组将由抽签决定，抽签分3个阶段：首先来自四大赛区的一号种子将作为第一档种子队，每组一个；其次从8个第二档队伍池里每组抽2个；最后从入围赛胜出的4个队伍作为第三档的队伍池，抽取到每组一个。小组赛抽签规则是来自同一赛区的队伍不同组，赛制为BO1双循环赛制。小组赛前2名将进入8强淘汰赛环节。
                            </div>
                            <div class="s11_format_item">
                                八强淘汰赛将再次抽签对阵，淘汰赛阶段同赛区队伍不再规避，分为2个半区。唯一的规避规则是小组赛同组队伍将不会安置在同一半区，也就说说同组对手决赛之前不会再碰面了。
                                <br>
                                淘汰赛抽签决定对手，也决定了整个淘汰赛后面的对阵，淘汰赛全程使用BO5赛制。晋级的8个队伍，小组第一和小组第二交叉对打，胜者进入半决赛，半决赛胜者进入决赛。
                            </div>
                            <div class="s11_format_item">
                                八强淘汰赛胜者进入1/4半决赛
                            </div>
                            <div class="s11_format_item">
                                半决赛胜者进入冠亚军总决赛
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 赛制 -->
                <div class="s11_city mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/s11_city.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['s11']['event_name'];?>举办城市</h2>
                    </div>
                    <div class="s11_city_detail">
                        <div class="sz">
                            <div class="sz_normality">
                                <div class="con">
                                    <img src="<?php echo $config['site_url'];?>/images/s11_format_logo.png" alt="">
                                    <span>深圳</span>
                                </div>
                            </div>
                            <div class="sz_active">
                                <div class="con">
                                    <img src="<?php echo $config['site_url'];?>/images/s11_format_logo.png" alt="">
                                    <span>深圳</span>
                                </div>
                                <div class="content">
                                    相信LPL粉丝们早在今年的1月份就已经知道深圳将会成为举办<?php echo $config['s11']['event_name'];?>冠亚军决赛的城市。并且，也因为如此，在LPL春季赛中，表现好的队伍，也是有不少LPL粉丝们表示要“剑指深圳”。值得一提的是，中国英雄联盟的总部就是在深圳，这应该称得上是主场中的主场了。
                                </div>
                            </div>
                        </div>
                        <div class="sqcw">
                            <div class="sq">
                                <div class="sh">
                                    <div class="sh_normality">
                                        上海
                                    </div>
                                    <div class="sh_active">
                                        <span class="city_name">上海</span>
                                        <div class="sqcw_content">
                                            上海已举办过多次英雄联盟的全球性赛事，包括2020年S10全球总决赛，2017全球总决赛半决赛，2016季中冠军赛等。
                                        </div>
                                    </div>
                                </div>
                                <div class="qd">
                                    <div class="qd_normality">
                                        青岛
                                    </div>
                                    <div class="qd_active">
                                        <span class="city_name">青岛</span>
                                        <div class="sqcw_content">
                                            早在2017年就曾举办过英雄联盟德玛西亚杯的赛事，EDG的“六冠王”成就也是在青岛达成的。
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cw">
                                <div class="cd">
                                    <div class="cd_normality">
                                        成都
                                    </div>
                                    <div class="cd_active">
                                        <span class="city_name">成都</span>
                                        <div class="sqcw_content">
                                            作为2020年英雄联盟LPL全明星周末的举办城市，成都自然也是给许多LPL粉丝们留下了非常深刻的印象。
                                        </div>
                                    </div>
                                </div>
                                <div class="wh">
                                    <div class="wh_normality">
                                        武汉
                                    </div>
                                    <div class="wh_active">
                                        <span class="city_name">武汉</span>
                                        <div class="sqcw_content">
                                            武汉刚刚举办了2021年LPL春季赛的总决赛，同时武汉也是S7全球总决赛的举办地之一。
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name"><?php echo $config['s11']['event_name'];?>参赛队伍</span>
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

                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['s11']['event_name'];?>最新资讯</h2>
                        <a href="##" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="team_news_mid">
                        <ul class="team_news_mid_ul clearfix">
                            <li>
                                <a href="##">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                        <p>竞燃杯｜企业电竞联赛竞燃杯｜企业电竞联赛</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                        <p>CSGO精英对抗赛CSGO精英对抗赛</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                        <p>竞燃杯｜企业电竞联赛竞燃杯｜企业电竞联赛</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                        <p>CSGO精英对抗赛CSGO精英对抗赛</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="team_news_bot">
                        <ul class="team_news_bot_ul clearfix">
                            <li class="fl">
                                <a href="##">
                                    dota2新手快速入门教程｜快速上手dota2新手快速入门教程｜快速上手
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    英雄联盟｜11.7版本更新了什么 11.7版本更新内英雄联盟｜11.7版本更新了什么 11.7版本更新内
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    dota2新手快速入门教程｜快速上手dota2新手快速入门教程｜快速上手
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    英雄联盟｜11.7版本更新了什么 11.7版本更新内英雄联盟｜11.7版本更新了什么 11.7版本更新内
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    dota2新手快速入门教程｜快速上手dota2新手快速入门教程｜快速上手
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    英雄联盟｜11.7版本更新了什么 11.7版本更新内英雄联盟｜11.7版本更新了什么 11.7版本更新内
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 冠军回顾 -->
                <div class="s11_previous mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/s11_previous_icon.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['s11']['event_name'];?>历届冠军回顾</h2>
                    </div>
                    <div class="s11_previous_detail">
                        <div class="s11_previous_con">
                            <?php $i=1;foreach($config['s11']['history'] as $year => $history_info){?>
                            <div class="s11_previous_conItem <?php if($i==1){echo "active";}?>">
                                <div class="s11_previous_conLogo">
                                    <img src="<?php echo $config['site_url'];?>/images/s11_previous_conLogo.png" alt="">
                                    <span class="s11_previous_conD">关于英雄联盟全球总决赛</span>
                                </div>
                                <div class="s11_previous_conDetail">
                                    <span class="s11_previous_conTitle">关于英雄联盟全球总决赛</span>
                                    <div class="s11_previous_conP">
                                        英雄联盟全球总决赛（League of Legends World Championship）是英雄联盟一年一度最为盛大的比赛，也是英雄联盟电竞赛事中最高荣誉、最高含金量、最高竞技水平、最高知名度的比赛。
                                    </div>
                                    <p class="s11_previous_conP"><?php echo $history_info['event_name'];?>英雄联盟总决赛于<?php echo $history_info['date'];?>在<?php echo $history_info['location'];?>举办</p>
                                    <p class="s11_previous_conP">冠军队伍：<?php echo $history_info['champ']['team_name'];?>，所属赛区：<?php echo $history_info['champ']['district'];?>赛区</p>
                                </div>
                            </div>
                            <?php $i++;}?>
                        </div>
                        <div class="s11_previous_ul_wrapper">
                            <ul class="s11_previous_ul">
                                <?php $i=1;foreach($config['s11']['history'] as $year => $history_info){?>
                                    <li class="s11_previous_ulLi <?php if($i==1){echo "active";}?>"><span><?php echo $year;?></span></li>
                                <?php $i++;}?>
                            </ul>
                        </div>
                        <div class="s11_previous_champions">
                            <?php $i=1;foreach($config['s11']['history'] as $year => $history_info){?>
                            <div class="s11_champions_item <?php if($i==1){echo "active";}?>">
                                <p class="s11_champions_title"><?php echo $year;?>全球总决赛冠军</p>
                                <div class="s11_champions_con">
                                    <div class="left">
                                        <span><?php echo $history_info['champ']['district'];?>赛区</span>
                                        <span><?php echo $history_info['champ']['team_name'];?></span>
                                    </div>
                                    <div class="right">
                                        <img src="<?php echo $config['site_url'];?>/images/ig.png" alt="">
                                    </div>
                                </div>
                            </div>
                                <?php $i++;}?>

                            <div class="s11_champions_item">
                                <p class="s11_champions_title">2019全球总决赛冠军</p>
                                <div class="s11_champions_con">
                                    <div class="left">
                                        <span>LCK赛区</span>
                                        <span>IG</span>
                                    </div>
                                    <div class="right">
                                        <img src="<?php echo $config['site_url'];?>/images/ig.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="s11_champions_item">
                                <p class="s11_champions_title">2018全球总决赛冠军</p>
                                <div class="s11_champions_con">
                                    <div class="left">
                                        <span>LCK赛区</span>
                                        <span>IG</span>
                                    </div>
                                    <div class="right">
                                        <img src="<?php echo $config['site_url'];?>/images/ig.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 冠军回顾 -->
                <div class="hot_match mb20">

                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>/tournamentlist/<?php echo $config['s11']['game'];?>" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
                            <?php foreach($return['tournamentList']['data'] as $key => $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>">
                                        <img data-original="<?php echo $tournamentInfo['logo'].$config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'].$config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>" class="imgauto1">
                                        <span><?php echo $tournamentInfo['tournament_name'];?></span>
                                    </a>
                                </li>
                            <?php }?>
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

    <script>
        //  $(".nav_lia").on("click",function(){
        //     $(this).parent().find(".submenu_wrapper").toggle("active")
        //  })

        $(".s11_format_ul").on("click", "li", function () {
            $(".s11_format_ul li").removeClass("active");
            $(this).addClass("active");
            $(this).parents(".format_detail").find(".s11_format_detail").find(".s11_format_item").removeClass("active").eq($(this).index()).addClass("active")
        })
  
            if ($(window).width() >= 768) {
              
                // banner移入移出
                $(".sz").on("mouseenter", '.sz_normality', function () {
                    $('.sz_normality').css("display", "none")
                    $(".sz_active").css("display", "block")
                    // $(".sz_active").addClass("animated pulse")  
                })

                $(".sz").on("mouseleave", '.sz_active', function () {
                    $('.sz_active').css("display", "none")
                    $('.sz_normality').css("display", "flex")
                    // $(".sz_normality").addClass("animated headShake")  
                })
                //上海
                $(".sh").on("mouseenter", '.sh_normality', function () {
                    $('.sh_normality').css("display", "none")
                    $(".sh_active").css("display", "block")
                })
                $(".sh").on("mouseleave", '.sh_active', function () {
                    $('.sh_active').css("display", "none")
                    $('.sh_normality').css("display", "block")

                })

                //青岛
                $(".qd").on("mouseenter", '.qd_normality', function () {
                    $('.qd_normality').css("display", "none")
                    $(".qd_active").css("display", "block")
                })
                $(".qd").on("mouseleave", '.qd_active', function () {
                    $('.qd_active').css("display", "none")
                    $('.qd_normality').css("display", "block")

                })

                //成都
                $(".cd").on("mouseenter", '.cd_normality', function () {
                    $('.cd_normality').css("display", "none")
                    $(".cd_active").css("display", "block")
                })
                $(".cd").on("mouseleave", '.cd_active', function () {
                    $('.cd_active').css("display", "none")
                    $('.cd_normality').css("display", "block")

                })
                //武汉
                $(".wh").on("mouseenter", '.wh_normality', function () {
                    $('.wh_normality').css("display", "none")
                    $(".wh_active").css("display", "block")
                })
                $(".wh").on("mouseleave", '.wh_active', function () {
                    $('.wh_active').css("display", "none")
                    $('.wh_normality').css("display", "block")

                })
            }

            if($(window).height() <= 768){
            }
      


            $(".s11_previous_ul").on("click", "li", function () {
                $(".s11_previous_ul li").removeClass("active");
                $(this).addClass("active");
                $(this).parents(".s11_previous_detail").find(".s11_previous_con").find(".s11_previous_conItem").removeClass("active").eq($(this).index()).addClass("active");
                $(this).parents(".s11_previous_detail").find(".s11_previous_champions").find(".s11_champions_item").removeClass("active").eq($(this).index()).addClass("active")
            })
    </script>

</body>

</html>