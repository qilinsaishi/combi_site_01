<?php
require_once "function/init.php";
$postDate = $_POST['date']??0;
if(strtotime($postDate)>0)
{
    $currentDate =  $postDate;
}
else
{
    $currentDate = $_GET['date']??date("Y-m-d");
}
//$dateRange = generateCalendarDateRange($currentDate,"week");
$currentGame = $_GET['game']??"all";
if(!isset($config['game'][$currentGame])){
	$currentGame ='all';
}
if(strtotime($currentDate)==0)
{
    $currentDate = date("Y-m-d");
}
$dateList = [];
$startDate = $currentDate;
$date = $startDate;
$endDate = date("Y-m-d",strtotime($currentDate)+2*86400);
do
{
    $dateList[] = $date;
    $date = date("Y-m-d",strtotime($date)+86400);
}
while($date<=$endDate);
$currentDay = date("w",strtotime($currentDate));
$params = [
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
	"defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"matchList","date"=>$currentDate,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
//依次加入所有游戏
foreach ($config['game'] as $game => $gameName)
{

  $params[$game."matchList"] =
        ["dataType"=>"matchList","source"=>$config['game_source'][$game]??$config['default_source'],"page"=>1,"page_size"=>100,"game"=>$game,"start_date"=>$startDate,"end_date"=>$endDate,"cache_time"=>3600];

}
$return = curl_post($config['api_get'],json_encode($params),1);

$return["allmatchList"]['data'] = [];
$allGameList = array_keys($config['game']);
array_unshift($allGameList,"all");
$matchCountList = [];
foreach($config['game'] as $game => $game_name)
{	
    $return["allmatchList"]['data'] = array_merge($return["allmatchList"]['data'],$return[$game."matchList"]['data']);
    $matchCountList[$game] = 0;
}
array_multisort(array_column($return["allmatchList"]['data'],"start_time"),SORT_DESC,$return["allmatchList"]['data']);
foreach($allGameList as $key => $game)
{
    $gameList = [];
    foreach($config['game'] as $game_key => $game_name)
    {
		
        foreach($dateList as $date)
        {
            if($game=="all")
            {
                $gameList[$date][$game_key] = [];
            }
            elseif($game == $game_key)
            {
                $gameList[$date][$game_key] = [];
            }
        }
    }
    $List = $return[$game."matchList"]['data'];
    foreach($List as $matchInfo)
    {
		
        if(isset($gameList[date("Y-m-d",strtotime($matchInfo['start_time']))][$matchInfo['game']]))
        {
            $gameList[date("Y-m-d",strtotime($matchInfo['start_time']))][$matchInfo['game']][$matchInfo['tournament_id']][] = $matchInfo;
            if($game!="all")
            {
                $matchCountList[$game] ++;
            }
        }
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
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $currentDate;?><?php if($currentGame=="all"){?>最新电竞赛事赛程-<?php }else{?><?php echo $config['game'][$currentGame];?>最新比赛_<?php echo $config['game'][$currentGame];?>近期赛事大全-<?php } ?><?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php if($currentGame=="all"){?>电竞赛事赛程,电竞比赛<?php }else{?><?php echo $config['game'][$currentGame];?>赛事,<?php echo $config['game'][$currentGame];?>近期有哪些比赛,<?php echo $config['game'][$currentGame];?>比赛<?php } ?>">
    <meta name="description" content="<?php echo $config['site_name'];?><?php if($currentGame=="all"){?>提供最新电子竞技赛事,为广大电竞玩家提供最新电竞赛事赛程信息,了解最新最全电竞赛事赛程信息,请关注<?php }else{?>提供<?php echo $config['game'][$currentGame];?>近期赛事信息,想要了解<?php echo $config['game'][$currentGame];?>最新比赛,掌握一手<?php echo $config['game'][$currentGame];?>赛事赛程,<?php echo $config['game'][$currentGame];?>有哪些比赛,请关注<?php } ?><?php echo $config['site_name'];?>">
    <?php renderHeaderJsCss($config,["right","game3","../fonts/iconfont"]);?>

</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="<?php echo $config['site_url'];?>">
                            <img src="<?php echo $config['site_url'];?>/images/logo.png" data-original="<?php echo $config['site_url'];?>/images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                            <?php generateNav($config,"game");?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="navigation row">
                <a href="<?php echo $config['site_url'];?>">
                    首页
                </a >
                >
                <a href="<?php echo $config['site_url'];?>/match/">
                    赛事赛程
                </a >
                >
                <?php if($currentGame!="all"){?>
                        <a href="javascript:void(0);" onclick="submitDate('<?php echo $currentDate;?>','<?php echo $currentGame;?>')">
                        <?php echo $config['game'][$currentGame];?>
                    </a >
                    >
                <?php }?>
                <span><?php echo $currentDate;?></span>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left game3_left">
                    <div class="calendar">
                        <div class="min_calendar active">
                            <div class="calendar_top clearfix">
                                <div class="war_calendar fl">
                                    <div class="war_calendar_img">
                                        <img data-original="<?php echo $config['site_url'];?>/images/rili.png" src="<?php echo $config['site_url'];?>/images/rili.png" alt="">
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
                                    <a href="javascript:void(0);" onclick="submitDate('<?php echo date('Y-m-d',strtotime($currentDate)-7*86400);?>','<?php echo $currentGame;?>')"  class="prev_week">
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
                                                <li <?php if($date==$currentDate){echo 'class="active calendar1_li"';}?>>
                                                    <a href="javascript:void(0);" onclick="submitDate('<?php echo $date;?>','<?php echo $currentGame;?>')">
                                                        <span class="week"><?php echo $day;?></span>
                                                        <span class="time2"><?php echo date("m.d",strtotime($date));?></span>
                                                    </a>
                                                </li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div class="right fr">
                                    <a href="javascript:void(0);" onclick="submitDate('<?php echo date('Y-m-d',strtotime($currentDate)+7*86400);?>','<?php echo $currentGame;?>')"  class="next_week">
                                        <i class="iconfont icon-xiayige"></i>
                                    </a>
                                 </div>
                            </div>
                        </div>
                        <div class="max_calendar">
                            <div class="calendar_top clearfix">
                                <div class="war_calendar fl">
                                    <div class="war_calendar_img">
                                        <img data-original="<?php echo $config['site_url'];?>/images/rili.png" src="<?php echo $config['site_url'];?>/images/rili.png" alt="">
                                    </div>
                                    <span>对战日历</span>
                                </div>
                                <div class="time3">
                                    <div class="year">
                                        <a href="javascript:void(0);" onclick="submitDate('<?php echo date("Y",strtotime($currentDate)-365*86400).date("-m-d",strtotime($currentDate));?>','<?php echo $currentGame;?>')"  class="prev_year">
                                            <i class="iconfont icon-shangyige"></i>
                                        </a>
                                        <span><?php echo date("Y",strtotime($currentDate));?>年</span>
                                        <a href="javascript:void(0);" onclick="submitDate('<?php echo date("Y",date("Y",strtotime($currentDate)+365*86400).date("-m-d",strtotime($currentDate)));?>','<?php echo $currentGame;?>')"  class="prev_year">
                                            <i class="iconfont icon-xiayige"></i>
                                        </a>
                                    </div>
                                    <div class="month">
                                        <a href="javascript:void(0);" onclick="submitDate('<?php echo  date("Y-m-d",strtotime($currentDate)-30*86400);?>','<?php echo $currentGame;?>')"  class="prev_month">
                                            <i class="iconfont icon-shangyige"></i>
                                        </a>
                                        <span><?php echo date("m",strtotime($currentDate));?>月</span>
                                        <a href="javascript:void(0);" onclick="submitDate('<?php echo date("Y-m-d",strtotime($currentDate)+30*86400);?>','<?php echo $currentGame;?>')"  class="prev_month">
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
                                                <td <?php if(date("m",strtotime($date))!=date("m",strtotime($currentDate))){?>class="grey"<?php }if($date==$currentDate){?> class="active"<?php }?>><a href="javascript:void(0);" onclick="submitDate('<?php echo $date;?>','<?php echo $currentGame;?>')"><?php echo date("m.d",strtotime($date));?></a></td>
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
                            <li <?php if($currentGame=="all"){?>class="active"<?php }?>>
                                <a href="javascript:void(0);" onclick="submitDate('<?php echo $currentDate;?>','all')">
                                    综合
                                </a>
                            </li>
                            <?php foreach($config['game'] as $game => $game_name){?>
                                <li <?php if($currentGame==$game){?>class="active"<?php }?>>
                                    <a href="javascript:void(0);" onclick="submitDate('<?php echo $currentDate;?>','<?php echo $game;?>')">
                                        <?php echo $game_name;?>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                        <div class="game3_days">
                            <?php foreach($allGameList as $key => $game){?>
                                <!-- 游戏 -->
                                <div class="game3_days_item <?php if($currentGame==$game){echo 'active';}?> <?php echo $game;?>">
                                    <!-- 日期 -->
                                    <?php foreach($return[$game."matchList"]['data'] as $date => $dateGameList){?>
                                        <div class="one_day <?php if($date==$currentDate){echo " active";}?>" >
                                            <div class="one_day_top clearfix">
                                                <span class="game3_detail_calendar1 fl"><?php echo date("m.d",strtotime($date));?></span>
                                                <?php if(date("Y-m-d")==$date){?><span class="game3_detail_calendar2 active fl">今天</span><?php } ?>
                                            </div>
                                        <div class="one_day_item">
                                            <ul class="one_day_bottom">
                                                    <!-- 循环游戏 -->
                                                    <?php foreach($dateGameList as $game => $currentGameList){?>
                                                        <div class="game3_classify clearfix">
                                                            <span class="game3_classify1 fl"><?php echo $config['game'][$game];?></span>
                                                        </div>
                                                        <?php if(count($currentGameList)>0) {  ?>
                                                            <!-- 循环赛事 -->
                                                            <!-- 循环比赛 -->
                                                            <?php foreach($currentGameList as $currentTournament => $currentTournamentList){ ?>
                                                                <!-- 循环比赛 -->
                                                                <?php foreach($currentTournamentList as $key => $matchInfo){
                                                                    ?>
                                                <li class="one_day_botitem">
                                                <?php
                                                                    if($key==0){?>
                                                                        <div class="game3_classify2 clearfix">
                                                                            <div class="fl clearfix game3_classify2_detail">
                                                                                <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $matchInfo['game']."-".$matchInfo['tournament_id'];?>">
																					<div class="game3_team_img fl">
                                                                                        <img class="imgauto" data-original="<?php echo $matchInfo['tournament_info']['logo']?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>"  alt="<?php echo $matchInfo['tournament_info']['tournament_name']?>">
                                                                                    </div>
                                                                                    <span class="fr"><?php echo $matchInfo['tournament_info']['tournament_name']?></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                    
                                                                    <div class="game3_game_item">
																		<?php if($matchInfo['game'] !='dota2'){?>
                                                                        <div class="game3_team1 fl">
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <div class="game3_team1_top_img fl">
                                                                                        <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" class="imgauto" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
                                                                                    </div>
                                                                                    <span class="game3_team1_top_name fl"><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                                                                </div>
                                                                                <div class="game3_team1_bottom red">
                                                                                    <div class="game3_team1_allplayer">
                                                                                        <?php $i=0;foreach($matchInfo['home_player_list']??[] as $playerInfo){$i++;?>
                                                                                            <div class="game3_team1_player">
                                                                                                <img data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
                                                                                            </div>
                                                                                            <?php if($i>=5){break;}}?>
                                                                                    </div>
                                                                                    <div class="game3_team_players"><?php echo count($matchInfo['home_player_list']??[]);?></div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div class="game3_team2_vs fl">
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team2_vs_top">
                                                                                    <div class="bg_wr">
                                                                                        <div class="game3_team2_vs_bg">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="time_over">
                                                                                        <p class="game3_team2_vs_time stop"><?php echo date("m-d H:i",strtotime($matchInfo['start_time']));?>·<?php echo generateMatchStatus($matchInfo['start_time']);?></p>
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
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <span class="game3_team1_top_name fl"><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                                                                    <div class="game3_team1_top_img fl">
                                                                                        <img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  class="imgauto" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="game3_team1_bottom red">
                                                                                    <div class="game3_team1_allplayer">
                                                                                        <?php $i=0;foreach($matchInfo['away_player_list']??[] as $playerInfo){$i++;?>
                                                                                            <div class="game3_team1_player">
                                                                                                <img data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
                                                                                            </div>
                                                                                            <?php if($i>=5){break;}}?>
                                                                                    </div>
                                                                                    <div class="game3_team_players"><?php echo count($matchInfo['away_player_list']??[]);?></div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
																		<?php }else{?>
																		<!--dota2-->
																		<div class="game3_team1 fl">
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <div class="game3_team1_top_img fl">
                                                                                            <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" class="imgauto" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
                                                                                        </div>
                                                                                        <span class="game3_team1_top_name fl"><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                                                                </div>
                                                                                
                                                                            </a>
                                                                        </div>
                                                                        <div class="game3_team2_vs fl">
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team2_vs_top">
                                                                                    <div class="bg_wr">
                                                                                        <div class="game3_team2_vs_bg">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="time_over">
                                                                                        <p class="game3_team2_vs_time stop"><?php echo date("m-d H:i",strtotime($matchInfo['start_time']));?>·<?php echo generateMatchStatus($matchInfo['start_time']);?></p>
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
                                                                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                                                                <div class="game3_team1_top clearfix">
                                                                                    <span class="game3_team1_top_name fl"><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                                                                    <div class="game3_team1_top_img fl">
                                                                                        <img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"   class="imgauto" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </a>
                                                                        </div>
																		<!--dota2-->
																		
																		<?php }?>
                                                                    </div>
                                                                  
                                                                    <div class="li_bg">
                                                                        <img data-original="<?php echo $config['site_url'];?>/images/game3_li_bg.png" src="<?php echo $config['site_url'];?>/images/game3_li_bg.png" alt="">
                                                                    </div>
                                                                <?php }?>
                                                                </li>
                                                            <?php }?>
                                                            <!-- 循环比赛 -->
                                                            <!-- 循环赛事 -->
                                                            <?php }else{?>

                                                    <div class="null">
                                                                <img src="<?php echo $config['site_url'];?>/images/null.png" data-original="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                                            </div>
                                                            <?php }?>
                                                    <?php }?>
                                                    <!-- 循环赛事 -->
                                                    <!-- 循环游戏 -->
                                            </ul>
                                        </div>
                                        </div>

                                    <?php }?>

                                    <!-- 日期 -->
                                </div>
                                <!-- 全部 -->
                            <?php }?>

                        </div>
                    </div>
                </div>
                <div class="game_right">
                    <div class='game_right_'>
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
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_team_list_detail">
                                <?php foreach($return['hotTeamList']['data'] as $teamInfo){?>
                                    <li class="active col-xs-6">
                                        <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                            <div class="a1">
                                                <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
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
                                        <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                    </div>
                                    <span class="fl">热门选手</span>
                                </div>
                                <div class="more fr">
                                    <a href="<?php echo $config['site_url'];?>/playerlist/">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_player_ul clearfix">

                                <?php foreach($return['hotPlayerList']['data'] as $playerInfo){?>
                                    <li>
                                        <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                            <div class="game_player_img">
                                                <img  data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  alt="<?php echo $playerInfo['player_name'];?>" class="imgauto">
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
                                        <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                    </div>
                                    <span class="fl">热门资讯</span>
                                </div>
                                <div class="more fr">
                                    <a href="<?php echo $config['site_url'];?>/newslist/">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
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
    </div>
    <div class="foot">
        <div class="container">
            <div class="row">
                <div class="links_title">
                    友情链接
                </div>
            </div>
            <ul class="row links_list clearfix">
                  <?php
				foreach($return['links']['data'] as $linksInfo)
				{   ?>
					<li><a href="<?php echo $linksInfo['url'];?>"><?php echo $linksInfo['name'];?></a></li>
				<?php }?>
            </ul>
			<?php renderCertification();?>
        </div>
    </div>
	<div class="suspension">
        <div class="suspension_close">
            <img src="<?php echo $config['site_url'];?>/images/t_close.png" data-original="<?php echo $config['site_url'];?>/images/t_close.png" alt="">
        </div>
        <div class="suspension_img">
            <img src="<?php echo $config['site_url'];?>/images/suspension.png" data-original="<?php echo $config['site_url'];?>/images/suspension.png" alt="">
        </div>
        <div class="qrcode">
            <div class="qrcode_img">
                <img src="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" data-original="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" alt="扫码下载">
            </div>
        </div>
    </div>
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
    <script>　　
        function submitDate(date,game){
            url = '<?php echo $config['site_url'];?>/match';
            if(game=='')
            {
                form = $("<form method='post' action="+url+'/'+"></form>");
            }else
            {
                form = $("<form method='post' action="+url+'/'+game+'/'+"></form>");
            }

            input = $("<input type='hidden'>").val(date).attr('name','date');
            form.append(input);
            form.appendTo(document.body)
            //....继续添加字段
            form.submit();
        }
    </script>
</body>

</html>