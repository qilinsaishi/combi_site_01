<?php
require_once "function/init.php";

$postParams=explode('-',trim($_GET['match_id']));
if(count($postParams)<2){
	render404($config);
}
$game=$postParams[0]?? $config['default_game'];
$match_id = $postParams[1]??0;
$match_id=intval($match_id);
if(!isset($match_id ) ||$match_id==0 )
{
    render404($config);
}

$params = [
    "matchDetail"=>["source"=>$config['default_source'],"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img","default_hero_img"],"fields"=>["name","key","value"],"site_id"=>$config["site_id"]],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>$game,"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);

if(!isset($return["matchDetail"]['data']['match_id']))
{
    render404($config);
}
$return['matchDetail']['data']['match_pre'] = json_decode($return['matchDetail']['data']['match_pre'],true);
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
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/reset.css">
    <script src="./js/flexible.js"></script>
    <link rel="stylesheet" href="./css/headerfooter.css">
    <!-- 本页新增的css game.css -->
    <link rel="stylesheet" href="./css/game.css">
    <!-- 本页新增的css right.css -->
    <link rel="stylesheet" href="./css/right.css">
    <!-- 本页新增的插件progress-bars.css -->
    <link rel="stylesheet" href="./css/progress-bars.css">
    <!-- 本页新增的dota2.s.css -->
    <link rel="stylesheet" href="./css/dota2.css">
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="index.html">
                            <img src="./images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                        <ul class="clearfix">
                            <li><a href="index.html">首页</a></li>
                            <li class="active"><a href="##">赛事赛程</a></li>
                            <li><a href="##">电竞战队</a></li>
                            <li><a href="##">电竞选手</a></li>
                            <li class="on"><a href="##">电竞资讯</a></li>
                            <li><a href="">游戏攻略</a></li>
                            <li><a href="##">赛事专题</a></li>
                            <li class="on"><a href="##">电竞资讯</a></li>
                            <li><a href="">游戏攻略</a></li>
                            <li><a href="##">赛事专题</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left">
                    <div class="game_title">
                        <div class="game_title_top">
                            <div class="game_team1">
                                <div class="game_team1_img">
                                    <div class="game_team1_img1">
                                        <img src="./images/banner.png" alt="" class="imgauto">
                                    </div>
                                </div>
                                <span>WE</span>
                            </div>
                            <div class="game_type">
                                <span class="span1">英雄联盟</span>
                                <span class="span2">2021 KPL 春季赛</span>
                                <div class="game_vs">
                                    <span class="span1">2</span>
                                    <img src="./images/vs.png" alt="">
                                    <span class="span2">1</span>
                                </div>
                                <p>2021.04.26 18:00·已结束</p>
                            </div>
                            <div class="game_team1">
                                <div class="game_team1_img">
                                    <div class="game_team1_img1">
                                        <img src="./images/game_teaml.png" alt="">
                                    </div>
                                </div>
                                <span>WE</span>
                            </div>
                        </div>
                        <div class="game_team_depiction">
                            <p class="active">TeamWE是一家中国电子竞技俱乐部，成立于2005年4月21日，是TeamWE是一家中国电子竞技俱乐部，成立于2005年4月21日，是</p>
                            <p class="active">
                                SV电子竞技俱乐部于2016年11月成立。SuperValiant译为超级勇猛...SV电子竞技俱乐部于2016年11月成立。SuperValiant译为超级勇猛...</p>
                        </div>
                        <img src="./images/more.png" alt="" class="game_title_more">
                    </div>
                    <div class="dota2">
                        <ul class="dota2_ul1 clearfix mb20">
                            <li>
                                <a href="##">
                                    赛前分析
                                </a>
                            </li>
                            <li class="active">
                                <a href="##">
                                    比赛详情
                                </a>
                            </li>
                        </ul>
                        <div class="dota2_div">
                            <!-- 赛前分析 -->
                            <div class="dota2_item">
                                <div class="dota2_top">
                                    <img src="./images/dota2_recent.png" alt="">
                                    <span>近期战队数据对比</span>
                                </div>
                                <div class="dota2_div1_team">
                                    <div class="teamInfo ">
                                        <div class="colorBlock colorBlock_right red"></div>
                                        <div class="teamInfo_img">
                                            <img src="./images/dota2_team1.png" alt="" class="imgauto">
                                        </div>
                                        <span class="text_left">WE</span>
                                    </div>
                                    <div class="dota2_vs">
                                        <img src="./images/game_detail_vs.png" alt="">
                                    </div>
                                    <div class="teamInfo teamInfo_reverse">
                                        <div class="colorBlock blue"></div>
                                        <div class="teamInfo_img">
                                            <img src="./images/dota2_team2.png" alt="" class="imgauto">
                                        </div>
                                        <span class="text_right">VS</span>
                                    </div>
                                </div>
                                <div class="bpBox">
                                    <div class="left">
                                        <div class="bpBox_circle">
                                            <div class="Dred third circle" data-num="0.5">
                                                <strong>
                                                    <p></p>
                                                    <span>胜率</span>
                                                </strong>
                                            </div>
                                            <p class="bpBox_result">5胜5负</p>
                                            <p class="bpBox_kda red">KDA：4.28</p>
                                            <p class="bpBox_Date">25.4/19.2/56.7</p>
                                        </div>
                                    </div>
                                    <div class="center">
                                        <div class="rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time1">2160.5</span>
                                                <span class="fr time2">2519.4</span>
                                                <div class="average_time">局均经济</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 red">
                                                    <span class="green" style="width: 40%;"></span>
                                                </div>
                                                <div class="progress3 fr blue">
                                                    <span class="green" style="width: 60%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time1">925</span>
                                                <span class="fr time2">1252</span>
                                                <div class="average_time">局均补刀</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 red">
                                                    <span class="green" style="width: 40%;"></span>
                                                </div>
                                                <div class="progress3 fr blue">
                                                    <span class="green" style="width: 60%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time1">35'03"</span>
                                                <span class="fr time2">35'03"</span>
                                                <div class="average_time">局均时长</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 red">
                                                    <span class="green" style="width: 40%;"></span>
                                                </div>
                                                <div class="progress3 fr blue">
                                                    <span class="green" style="width: 60%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time1">36313</span>
                                                <span class="fr time2">63121</span>
                                                <div class="average_time">局均输出</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 red">
                                                    <span class="green" style="width: 40%;"></span>
                                                </div>
                                                <div class="progress3 fr blue">
                                                    <span class="green" style="width: 60%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="left">
                                        <div class="bpBox_circle">
                                            <div class="Dblue third circle" data-num="0.75">
                                                <strong>
                                                    <p></p>
                                                    <span>胜率</span>
                                                </strong>
                                            </div>
                                            <p class="bpBox_result">5胜5负</p>
                                            <p class="bpBox_kda blue">KDA：4.28</p>
                                            <p class="bpBox_Date">25.4/19.2/56.7</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="barChart">
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar blue" style="height: 50%;">
                                                    <span class="bar_rate">50%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar red" style=" height:60%;">
                                                    <span class="bar_rate">60%</span>
                                                </div>
                                            </div><span class="itemName">一血率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar blue" style="height: 50%;">
                                                    <span class="bar_rate">50%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar red" style=" height: 70%;">
                                                    <span class="bar_rate">70%</span>
                                                </div>
                                            </div><span class="itemName">一塔率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar blue" style="height: 20%;">
                                                    <span class="bar_rate">20%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar red" style=" height: 66%;">
                                                    <span class="bar_rate">66%</span>
                                                </div>
                                            </div><span class="itemName">五杀率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar blue" style="height: 20%;">
                                                    <span class="bar_rate">20%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar red" style=" height: 15%;">
                                                    <span class="bar_rate">15%</span>
                                                </div>
                                            </div><span class="itemName">十杀率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar blue" style="height: 100%;">
                                                    <span class="bar_rate">100%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar red" style=" height: 60%;">
                                                    <span class="bar_rate">60%</span>
                                                </div>
                                            </div><span class="itemName">首肉山</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="recentGame-box red">
                                    <div class="box">
                                        <div class="thead">
                                            <span class="th flex15">对战</span>
                                            <span class="th flex2">联赛/比赛时间</span>
                                            <span class="th flex15">比赛时长</span>
                                            <span class="th flex15">胜队</span>
                                            <span class="th">击杀</span>
                                            <span class="th">一血</span>
                                            <span class="th">一塔</span>
                                            <span class="th">五杀</span>
                                            <span class="th">十杀</span>
                                            <span class="th">肉山</span>
                                        </div>
                                        <div class="rowBox">
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_red">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot red"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="recentGame-box blue">
                                    <div class="box">
                                        <div class="thead">
                                            <span class="th flex15">对战</span>
                                            <span class="th flex2">联赛/比赛时间</span>
                                            <span class="th flex15">比赛时长</span>
                                            <span class="th flex15">胜队</span>
                                            <span class="th">击杀</span>
                                            <span class="th">一血</span>
                                            <span class="th">一塔</span>
                                            <span class="th">五杀</span>
                                            <span class="th">十杀</span>
                                            <span class="th">肉山</span>
                                        </div>
                                        <div class="rowBox">
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    cSc
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                            </div>
                                            <div class="row1">
                                                <span title="cSc" class="td elips flex15">
                                                    ADSGASGADSGASGA
                                                </span>
                                                <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips">Pinnacle杯</span>
                                                    <span class="leagueTime">2021-05-30 06:45</span>
                                                </span>
                                                <span class="td flex15">49分12秒</span>
                                                <span title="WE" class="td elips flex15">
                                                    WEWEWEWEWE
                                                </span>
                                                <span class="td">
                                                    <span class="span_blue">23</span>:34
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot "></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot blue"></i>
                                                </span>
                                                <span class="td">
                                                    <i class="dota2_dot"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <!-- 赛前分析 -->
                             <!-- 比赛详情 -->
                            <div class="dota2_item live_box active">
                                <div class="war_report">
                                    <div class="dota2_top">
                                        <img src="./images/report.png" alt="">
                                        <span>对战战报</span>
                                    </div>
                                    <div class="war_report_detail">
                                        <span>本次比赛共计三局</span>
                                        <p>第一局比赛中：The Cut 夺得一血，The Cut 首先攻下第一座防御塔，4Zs 拿下五杀， 4Zs 取得十杀，4Zs 豪取十五杀。</p>
                                        <p>第二局比赛：4Zs 夺得一血，4Zs 首先攻下第一座防御塔，4Zs 拿下五杀， 4Zs 取得十杀，The Cut 豪取十五杀。</p>
                                        <p>第三局比赛：ViKin.gg 夺得一血，Winstrike 首先攻下第一座防御塔，ViKin.gg 拿下五杀， Winstrike 取得十杀</p>
                                        <p>最终恭喜WE取得本次Pinnacle杯赛事的冠军</p>
                                    </div>
                                </div>
                                <div class="">

                                </div>
                            </div>
                            <!-- 比赛详情 -->
                        </div>
                    </div>
                </div>
                <div class="game_right">
                    <div class="game_lately">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="./images/game_fire.png" alt="">
                                </div>
                                <span class="fl">近期赛事</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="./images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_match_ul">
                            <li class="col-md-12 col-xs-12">
                                <a href="##">
                                    <div class="game_match_top">
                                        <span class="game_match_name">常规赛常规常规赛常规常规赛常规</span>
                                        <span class="game_match_time">4月23日 14:00</span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/banner.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                        <div class="left center">
                                            <span>VS</span>
                                            <span>英雄联盟</span>
                                        </div>
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/match.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="col-md-12 col-xs-12">
                                <a href="##">
                                    <div class="game_match_top">
                                        <span class="game_match_name">常规赛常规</span>
                                        <span class="game_match_time">4月23日 14:00</span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/banner.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                        <div class="left center">
                                            <span>VS</span>
                                            <span>英雄联盟</span>
                                        </div>
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/match.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="col-md-12 col-xs-12">
                                <a href="##">
                                    <div class="game_match_top">
                                        <span class="game_match_name">常规赛常规</span>
                                        <span class="game_match_time">4月23日 14:00</span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/banner.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                        <div class="left center">
                                            <span>VS</span>
                                            <span>英雄联盟</span>
                                        </div>
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <img src="./images/match.png" alt="" class="imgauto">
                                            </div>
                                            <span>常规赛常规常规</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="game_news">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="./images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门资讯</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="./images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <a href="##">英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什英雄联盟｜11.7版本更新了什</a>
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
                    <div class="game_team">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="./images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门战队</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="./images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_team_list_detail">
                            <li class="active col-xs-6">
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/banner.png" alt="" class="game_team_img">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
                                    </div>
                                    <span>WE</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="a1">
                                        <img src="./images/WElogo.png" alt="">
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
                                    <img class="imgauto" src="./images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门选手</span>
                            </div>
                            <div class="more fr">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="./images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_player_ul clearfix">
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/banner.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_player_img">
                                        <img src="./images/player1.png" alt="" class="imgauto">
                                    </div>
                                    <span>童谣童谣</span>
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
            <div>
                <p>本站资源均来源于网络，版权属于原作者！仅供学习参考，严禁用于任何商业目的。</p>
                <p>如果无意中侵犯了您的权益，敬请联系 qilinsaishi@163.com， 我们会尽快核实并删除</p>
            </div>
        </div>
    </div>
    <script src="./js/jquery.min.js"></script>
    <!-- <script src="./js/index.js"></script> -->
    <script src="./js/jquery.lineProgressbar.js"></script>
    <!-- 这是本页新增的js -->
    <script src="./js/circle-progress_line.js"></script>
    <script src="./js/echarts.min.js"></script>
    <script>
        var value = $('.Dred').data('num');
        console.log(value)
        $('.Dred.circle').circleProgress({
            value: value,
            size: 132,
            thickness: 20,
            lineCap: 'round',
            emptyFill: "rgba(255, 249, 247, 1)",
            fill: { gradient: ['#FF5C6A'] },
            startAngle: -Math.PI / 4 * 2,
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            $(this).find('strong').find('p').html(Math.round(stepValue * 100 * 100) / 100 + '<i>%</i>');
        });

        var value = $('.Dblue').data('num');
        $('.Dblue.circle').circleProgress({
            value: value,
            size: 132,
            thickness: 20,
            lineCap: 'round',
            emptyFill: "rgba(247, 249, 255, 1)",
            fill: { gradient: ['#0C8DFC'] },
            startAngle: -Math.PI / 4 * 2,
        }).on('circle-animation-progress', function (event, progress, stepValue) {
            $(this).find('strong').find('p').html(Math.round(stepValue * 100 * 100) / 100 + '<i>%</i>');
        });


    //赛前分析与比赛详情切换
    $(".dota2_ul1").on("click", 'li', function () {
        $(".dota2_ul1 li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".dota2").find(".dota2_div").find(".dota2_item").removeClass("active").eq($(this).index()).addClass("active");
    }) 
    </script>
</body>

</html>