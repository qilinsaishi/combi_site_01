<?php
require_once "function/init.php";
$currentDate = $_GET['date']??date("Y-m-d");
if(strtotime($currentDate)==0)
{
    $currentDate = date("Y-m-d");
}
$currentDay = date("w",strtotime($currentDate));
$params = [
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$config['game'],"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$config['game'],"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotNewsList"=>["dataType"=>"informationList","page"=>1,"page_size"=>8,"game"=>$config['game'],"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "currentPage"=>["name"=>"matchList","date"=>$currentDate,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
$params["allmatchList"] =
    ["dataType"=>"matchList","source"=>$config['default_source'],"page"=>1,"page_size"=>100,"game"=>array_keys($config['game']),"start_date"=>$currentDate,"cache_time"=>3600];
//依次加入所有游戏
foreach ($config['game'] as $game => $gameName)
{
    $params[$game."matchList"] =
        ["dataType"=>"matchList","source"=>$config['default_source'],"page"=>1,"page_size"=>100,"game"=>$game,"start_date"=>$currentDate,"cache_time"=>3600];
}
$return = curl_post($config['api_get'],json_encode($params),1);
$allGameList = array_keys($config['game']);
array_unshift($allGameList,"all");
foreach($allGameList as $key => $game)
{
    $gameList = [];
    $List = $return[$game."matchList"]['data'];
    foreach($List as $matchInfo)
    {
        $gameList[$matchInfo['game']][$matchInfo['tournament_id']][] = $matchInfo;
    }
    if(count($gameList)>1)
    {
        foreach($config['game'] as $game_key => $game_name)
        {
            if(!isset($gameList[$game_key]))
            {
                $gameList[$game_key] = [];
            }
        }
        //array_multisort(array_keys($gameList),array_keys($config['game']),$gameList);
    }
    $return[$game."matchList"]['data'] = $gameList;
}
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
                            <?php
                                $dateRange = generateCalendarDateRange($currentDate,"week");
                            ?>
                            <div class="min_calendar_bottom">
                                <div class="left fl">
                                    <a href="<?php echo $config['site_url'];?>\match\<?php echo date('Y-m-d',strtotime($currentDate)-7*86400);?>" class="prev_week">
                                        <i class="iconfont icon-shangyige"></i>
                                    </a>
                                </div>
                                <div class="calendar1">
                                    <ul>
                                        <?php $weekdayList = ["星期一","星期二","星期三","星期四","星期五","星期六","星期日"];
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
                                    <a href="<?php echo $config['site_url'];?>\match\<?php echo date('Y-m-d',strtotime($currentDate)+7*86400);?>" class="next_week">
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
                            <?php foreach($config['game'] as $game => $game_name){?>
                                <li>
                                    <a href="##">
                                        <?php echo $game_name;?>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                        <div class="game3_days">
                            <?php foreach($allGameList as $key => $game){?>
                                <!-- 游戏 -->
                                <div class="game3_days_item <?php if($key==0){echo 'active';}?> <?php echo $game;?>">
                                    <div class="one_day">
                                        <div class="one_day_top clearfix">
                                            <span class="game3_detail_calendar1 fl"><?php echo date("m.d",strtotime($currentDate));?></span>
                                            <?php if(date("Y-m-d")==$currentDate){?><span class="game3_detail_calendar2 active fl">今天</span><?php } ?>
                                        </div>
                                        <div class="one_day_item">
                                            <ul class="one_day_bottom">
                                                <li class="one_day_botitem">
                                                    <!-- 循环游戏 -->
                                                    <?php foreach($return[$game."matchList"]['data'] as $currentGame => $currentGameList){?>
                                                        <div class="game3_classify clearfix">
                                                            <span class="game3_classify1 fl"><?php echo $config['game'][$currentGame];?></span>
                                                        </div>
                                                        <!-- 循环赛事 -->
                                                        <?php foreach($currentGameList as $currentTournament => $currentTournamentList){?>
                                                            <!-- 循环比赛 -->
                                                            <?php foreach($currentTournamentList as $key => $matchInfo){
                                                                if($key==0){?>
                                                                    <div class="game3_classify2 clearfix">
                                                                        <div class="fl clearfix game3_classify2_detail">
                                                                            <a href="##">
                                                                                <div class="game3_team_img fl">
                                                                                    <img class="imgauto" src="<?php echo $matchInfo['tournament_info']['logo']?>" alt="<?php echo $matchInfo['tournament_info']['tournament_name']?>">
                                                                                </div>
                                                                                <span class="fr"><?php echo $matchInfo['tournament_info']['tournament_name']?></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>

                                                                    <div class="game3_game_item">
                                                                        <div class="game3_team1 fl">
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <div class="game3_team1_top_img fl">
                                                                                        <img src="<?php echo $matchInfo['home_team_info']['logo'];?>" class="imgauto" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
                                                                                    </div>
                                                                                    <span class="game3_team1_top_name fl"><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                                                                </div>
                                                                                <div class="game3_team1_bottom red">
                                                                                    <div class="game3_team1_allplayer">
                                                                                        <?php $i=0;foreach($matchInfo['home_player_list']??[] as $playerInfo){$i++;?>
                                                                                        <div class="game3_team1_player">
                                                                                            <img src="<?php echo $playerInfo['logo'];?>" class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
                                                                                        </div>
                                                                                        <?php if($i>=5){break;}}?>
                                                                                    </div>
                                                                                    <div class="game3_team_players"><?php echo count($matchInfo['home_player_id_list']??[]);?></div>
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
                                                                                        <p class="game3_team2_vs_time stop"><?php echo date("h:i",strtotime($matchInfo['start_time'])+$config['hour_lag']*3600);?>·<?php echo generateMatchStatus($matchInfo['start_time']);?></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="game3_team2_vs_bot">
                                                                                    <div class="frequency clearfix">
                                                                                        <?php $maxScore = ($matchInfo['home_score']+$matchInfo['away_score']);?>
                                                                                        <span class="fl frequency_left"><?php echo $matchInfo['home_score'];?></span>
                                                                                        <p class="fl frequency_center grey">对战详情</p>
                                                                                        <span class="fr frequency_right"><?php echo $matchInfo['away_score'];?></span>
                                                                                    </div>
                                                                                    <div class="compare-bar">
                                                                                        <div class="l-bar fl red" style="width: <?php echo $maxScore==0?0:intval(($matchInfo['home_score']/$maxScore*100));?>%;">
                                                                                        </div> <div class="r-bar fr blue" style="width: <?php echo $maxScore==0?0:intval(($matchInfo['away_score']/$maxScore*100));?>%;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div class="game3_team2 fr">
                                                                            <a href="##">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <span class="game3_team1_top_name fl"><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                                                                    <div class="game3_team1_top_img fl">
                                                                                        <img src="<?php echo $matchInfo['away_team_info']['logo'];?>" class="imgauto" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="game3_team1_bottom red">
                                                                                    <div class="game3_team1_allplayer">
                                                                                        <?php $i=0;foreach($matchInfo['away_player_list']??[] as $playerInfo){$i++;?>
                                                                                            <div class="game3_team1_player">
                                                                                                <img src="<?php echo $playerInfo['logo'];?>" class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
                                                                                            </div>
                                                                                            <?php if($i>=5){break;}}?>
                                                                                    </div>
                                                                                    <div class="game3_team_players"><?php echo count($matchInfo['home_player_id_list']??[]);?></div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="li_bg">
                                                                        <img src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                                    </div>
                                                                    <?php }}?>
                                                            <!-- 循环比赛 -->
                                                        <!-- 循环赛事 -->
                                                    <?php }?>
                                                    <!-- 循环游戏 -->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- 全部 -->
                            <?php }?>

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
                                <a href="<?php echo $config['site_url'];?>/teamlist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_team_list_detail">
                            <?php foreach($return['hotTeamList']['data'] as $teamInfo){?>
                                <li class="active col-xs-6">
                                    <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                        <div class="a1">
                                            <img src="<?php echo $teamInfo['logo'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
                                        </div>
                                        <span><?php echo $teamInfo['team_name'];?></span>
                                    </a>
                                </li>
                            <?php }?>
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
                                <a href="<?php echo $config['site_url'];?>/playerlist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_player_ul clearfix">

                            <?php foreach($return['hotPlayerList']['data'] as $playerInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                        <div class="game_player_img">
                                            <img src="<?php echo $playerInfo['logo'];?>" alt="<?php echo $playerInfo['player_name'];?>" class="imgauto">
                                        </div>
                                        <span><?php echo $playerInfo['player_name'];?></span>
                                    </a>
                                </li>
                            <?php }?>
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
                                <a href="<?php echo $config['site_url'];?>/newslist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul>
                            <?php foreach($return['hotNewsList']['data'] as $info){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>"><?php echo $info['title'];?></a>
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