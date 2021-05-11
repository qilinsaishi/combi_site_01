<?php
require_once "function/init.php";
$currentDate = $_GET['date']??date("Y-m-d");
if(strtotime($currentDate)==0)
{
    $currentDate = date("Y-m-d");
}
$currentDay = date("w",strtotime($currentDate));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>赛事赛程</title>
    <?php renderHeaderJsCss($config,["right","game3"]);?>
    <!-- 本页新增的css iconfont.css -->
    <link rel="stylesheet" href="<?php echo $config['site_url'];?>/fonts/iconfont.css">

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
                        <ul class="clearfix">
                            <?php generateNav($config,"game");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left game3_left">
                    <div class="calendar">
                        <div class="min_calendar">
                            <div class="calendar_top clearfix">
                                <div class="war_calendar fl">
                                    <div class="war_calendar_img">
                                        <img src="<?php echo $config['site_url'];?>/images/rili.png" alt="">
                                    </div>
                                    <span>对战日历</span>
                                </div>
                                <p class="time1"><?php echo date("Y.m",strtotime($currentDate));?></p>
                                <div class="open_calendar fr">
                                    展开日历
                                </div>
                            </div>
                            <div class="min_calendar_bottom">
                                <div class="left fl">
                                    <a href="##" class="prev_week">
                                        <i class="iconfont icon-shangyige"></i>
                                    </a>
                                </div>
                                <div class="calendar1">
                                    <ul>
                                        <?php $weekdayList = ["星期一","星期二","星期三","星期四","星期五","星期六","星期日"];
                                        $dateRange = generateCalendarDateRange($currentDate,"week");
                                            foreach($weekdayList as $key => $day)
                                            {
                                                $date = date("Y-m-d",(strtotime($dateRange['startDate'])+$key*86400));
                                            ?>
                                                <li <?php if($date==$currentDate){echo 'class="active"';}?>>
                                                    <a href="<?php echo $config['site_url'];?>\match\<?php echo $date;?>">
                                                        <span class="week"><?php echo $day;?></span>
                                                        <span class="time2"><?php echo date("m.d",strtotime($date));?></span>
                                                    </a>
                                                </li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div class="right fr">
                                    <a href="##" class="next_week">
                                        <i class="iconfont icon-xiayige"></i>
                                    </a>
                                 </div>
                            </div>
                        </div>
                        <div class="max_calendar">
                            <div class="calendar_top clearfix">
                                <div class="war_calendar fl">
                                    <div class="war_calendar_img">
                                        <img src="<?php echo $config['site_url'];?>/images/rili.png" alt="">
                                    </div>
                                    <span>对战日历</span>
                                </div>
                                <div class="time3">
                                    <div class="year">
                                        <a href="<?php echo $config['site_url'];?>/match/<?php echo date("Y",strtotime($currentDate)-365*86400).date("-m-d",strtotime($currentDate))?>" class="prev_year">
                                            <i class="iconfont icon-shangyige"></i>
                                        </a>
                                        <span><?php echo date("Y",strtotime($currentDate));?>年</span>
                                        <a href="<?php echo $config['site_url'];?>/match/<?php echo date("Y",strtotime($currentDate)+365*86400).date("-m-d",strtotime($currentDate))?>" class="prev_year">
                                            <i class="iconfont icon-xiayige"></i>
                                        </a>
                                    </div>
                                    <div class="month">
                                        <a href="##" class="prev_month">
                                            <i class="iconfont icon-shangyige"></i>
                                        </a>
                                        <span><?php echo date("m",strtotime($currentDate));?>月</span>
                                        <a href="##" class="prev_month">
                                            <i class="iconfont icon-xiayige"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="stop_calendar fr">
                                    收起日期
                                </div>
                            </div>
                            <div class="max_calendar_bottom">
                                <div class="left fl">
                                    <i class="iconfont icon-shangyige"></i>
                                </div>
                                <div class="max_calendar_table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <?php foreach($weekdayList as $key => $day){?>
                                                    <th>
                                                        <a href="##"><?php echo $day;?></a>
                                                    </th>
                                                    <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $dateRange = generateCalendarDateRange($currentDate,"month");
                                            ?>
                                            <?php $date = $dateRange['startDate'];
                                            $i=1;
                                            while($date<=$dateRange['endDate'])
                                            {
                                                if($i%7==1)
                                                {
                                                    echo '<tr>';
                                                }?>
                                                <td <?php if(date("m",strtotime($date))!=date("m",strtotime($currentDate))){?>class="grey"<?php }if($date==$currentDate){?> class="active"<?php }?>><a href="<?php echo $config['site_url'];?>/match/<?php echo $date;?>"><?php echo date("m.d",strtotime($date));?></a></td>
                                                <?php
                                                if($i%7==0)
                                                {
                                                    echo '</tr>';
                                                }
                                                $i++;$date = date("Y-m-d",strtotime($date)+86400);
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="right fr active">
                                    <i class="iconfont icon-xiayige"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="game3_detail">
                        <ul class="game3_detail_ul clearfix">
                            <li class="active">
                                <a href="##">
                                    综合
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    英雄联盟
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    王者荣耀
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    DOTA2
                                </a>
                            </li>
                        </ul>
                        <div class="game3_days">
                            <!-- 全部 -->
                            <div class="game3_days_item active all">
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl"><?php echo date("m.d",strtotime($currentDate));?></span>
                                        <span class="game3_detail_calendar2 active fl">今天</span>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">王者荣耀</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.27</span>
                                        <span class="game3_detail_calendar2 fl">周二</span>
                                        
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- 全部 -->
                            <!-- 英雄联盟 -->
                            <div class="game3_days_item lol">
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.26</span>
                                        <span class="game3_detail_calendar2 active fl">今天</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">lolWEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">lolWEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">王者荣耀</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.27</span>
                                        <span class="game3_detail_calendar2 fl">周二</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- 英雄联盟 -->
                            <!-- 王者荣耀 -->
                             <div class="game3_days_item kpl">
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.26</span>
                                        <span class="game3_detail_calendar2 active fl">今天</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">kplWEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">lolWEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">王者荣耀</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.27</span>
                                        <span class="game3_detail_calendar2 fl">周二</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- 王者荣耀 -->
                            <!-- dota2 -->
                            <div class="game3_days_item dota2">
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.26</span>
                                        <span class="game3_detail_calendar2 active fl">今天</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">dota2WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">lolWEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">王者荣耀</span>
                                                    <div class="game3_classify2 fr clearfix">
                                                        <a href="##">
                                                            <div class="game3_team_img fl">
                                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                            </div>
                                                            <span class="fr">2021 LCS春季赛-常规赛</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time stop">16:00·已结束</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">对战详情</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="one_day">
                                    <div class="one_day_top clearfix">
                                        <span class="game3_detail_calendar1 fl">04.27</span>
                                        <span class="game3_detail_calendar2 fl">周二</span>
                                        <div class="game3_classify2 fr clearfix">
                                            <a href="##">
                                                <div class="game3_team_img fl">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                                </div>
                                                <span class="fr">2021 LCS春季赛-常规赛</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="one_day_item">
                                        <ul class="one_day_bottom">
                                            <li class="one_day_botitem">
                                                <div class="game3_classify clearfix">
                                                    <span class="game3_classify1 fl">英雄联盟</span>
                                                </div>
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                            <li class="one_day_botitem">
                                                <div class="game3_game_item">
                                                    <div class="game3_team1 fl">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                                <span class="game3_team1_top_name fl">WEWEWEWEWEWEWE</span>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2_vs fl">
                                                        <a href="##">
                                                            <div class="game3_team2_vs_top">
                                                                <div class="bg_wr">
                                                                    <div class="game3_team2_vs_bg">
                                                                    </div>
                                                                </div>
                                                                <div class="time_over">
                                                                    <p class="game3_team2_vs_time dark">16:00</p>
                                                                </div>
                                                            </div>
                                                            <div class="game3_team2_vs_bot">
                                                                <div class="frequency clearfix">
                                                                    <span class="fl frequency_left">3</span>
                                                                    <p class="fl frequency_center grey">近6场交战胜场</p>
                                                                    <span class="fr frequency_right">3</span>
                                                                </div>
                                                                <div class="compare-bar">
                                                                    <div class="l-bar fl red" style="width: 48.4871%;">
                                                                    </div> <div class="r-bar fr blue" style="width: 51.5129%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="game3_team2 fr">
                                                        <a href="##">
                                                            <div class="game3_team1_top clearfix">
                                                                <span class="game3_team1_top_name fl">PNGPNGPNGPNG</span>
                                                                <div class="game3_team1_top_img fl">
                                                                    <img src="<?php echo $config['site_url'];?>/images/WElogo.png" class="imgauto" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="game3_team1_bottom red">
                                                                <div class="game3_team1_allplayer">
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player2.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" class="imgauto" alt="">
                                                                    </div>
                                                                    <div class="game3_team1_player">
                                                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" class="imgauto" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="game3_team_players">14</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="li_bg">
                                                    <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- dota2 -->
                        </div>
                    </div>
                </div>
                <div class="game_right">
                    <div class="game_team">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门战队</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_team_list_detail">
                            <li class="active col-xs-6">
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="game_team_img">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="game_player">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门选手</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_player_ul clearfix">
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="game_news">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门资讯</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
                            </li>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
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
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
    <script>
        $(".calendar").on("click",".open_calendar",function(){
            $(".max_calendar").addClass("active")
        })
        $(".calendar").on("click",".stop_calendar",function(){
            $(".max_calendar").removeClass("active")
        })

        $(".game3_detail").on("click",".game3_detail_ul li",function(){
            $(".game3_detail_ul li").removeClass("active");
            $(this).addClass("active");
            $(this).parents(".game3_detail").find(".game3_days").find(".game3_days_item").removeClass("active").eq($(this).index()).addClass("active");
        })
    </script>
</body>

</html>