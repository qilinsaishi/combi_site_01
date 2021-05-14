<?php
require_once "function/init.php";
$tournament_id = $_GET['tournament_id']??0;
$params = [
    "tournament"=>[$tournament_id,"source"=>$config['default_source']],
    "tournamentList"=>["page"=>1,"page_size"=>4,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
    "matchList" =>
        ["dataType"=>"matchList","tournament_id"=>$tournament_id,"source"=>$config['default_source'],"page"=>1,"page_size"=>100,"cache_time"=>3600],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    //"hotNewsList"=>["dataType"=>"informationList","page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    //"hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    //"hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "currentPage"=>["name"=>"tournamentDetail","tournament_id"=>$tournament_id,"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
$matchList = [];
foreach($return['tournament']['data']['roundList'] as $roundInfo)
{
    $matchList[$roundInfo['round_id']] = [];
}
foreach($return['matchList']['data'] as $matchInfo)
{
    $matchList[$matchInfo['round_id']][] = $matchInfo;
}
unset($return['matchList']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>赛事专题</title>
    <?php renderHeaderJsCss($config,["right","events"]);?>
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
                            <?php generateNav($config,"tournament");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row events_top">
                <!-- 比赛介绍 -->
                <div class="team_title mb20 clearfix">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" src="<?php echo $return['tournament']['data']['logo'];?>" alt="<?php echo $return['tournament']['data']['tournament_name'];?>">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <p class="name fl"><?php echo $return['tournament']['data']['tournament_name'];?></p>
                            <p class="classify fl"><?php echo $config['game'][$return['tournament']['data']['game']];?></p>
                        </div>
                        <div class="team_explain_bottom">
                            <p>
                                王者荣耀职业联赛（简称KPL）是王者荣耀最高规格专业竞技赛事。全年分别为春季赛和秋季赛两个赛季，每个赛季分为常规赛、季后赛及总决赛三部分。 
                            </p>
                            <p>
                                2019年9月10日，KPL联盟主席张易加宣布，未来将与广州体育学院合作，将有一批职业选手回到学校接受再教育。
                            </p>
                        </div>
                    </div>
                </div>
                <!-- 比赛介绍 -->
                <div class="event_detail mb20">
                    <ul class="event_detail_ul">
                        <?php foreach($return['tournament']['data']['roundList'] as $key => $roundInfo){?>
                            <li<?php if($key==0){echo ' class="active"';}?>>
                                <a href="##"><?php echo $roundInfo['round_name'];?></a>
                            </li>
                        <?php }?>
                    </ul>
                    <div class="event_detail_content">
                        <?php foreach($return['tournament']['data']['roundList'] as $key => $roundInfo){?>
                            <div class="event_detail_div <?php if($key==0){echo ' active';}?>">
                                <div class="scroll">
                                    <ul class="event_detail_item">
                                        <?php if(count($matchList[$roundInfo['round_id']])>0){?>
                                        <?php foreach($matchList[$roundInfo['round_id']] as $matchInfo){?>
                                                <li>
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
                                                                    <div class="game3_team_players"><?php echo count($matchInfo['home_player_list']??[]);?></div>
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
                                                                    <div class="game3_team_players"><?php echo count($matchInfo['away_player_list']??[]);?></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }?>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="best_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/best_team.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">最佳阵容</span>
                        <div class="fr best_team_match">
                            <div class="match1">
                                <p>常规赛第一周</p>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </div>
                            <ul class="match2">
                                <li>
                                    <a href="##">常规赛第一周</a>
                                </li>
                                <li>
                                    <a href="##">常规赛第二周</a>
                                </li>
                                <li>
                                    <a href="##">
                                        常规赛第三周
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        常规赛第四周
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="best_team_tab">
                        <ul class="best_team_tab1 clearfix active">
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/sd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/sd_active.png" alt="">
                                        </div>
                                        <span class="white">上单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">444星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/daye.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/daye_active.png" alt="">
                                        </div>
                                        <span class="white">打野·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team2.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/zd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/zd_active.png" alt="">
                                        </div>
                                        <span class="white">中单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/adc.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/adc_active.png" alt="">
                                        </div>
                                        <span class="white">ADC·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team3.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu_active.png" alt="">
                                        </div>
                                        <span class="white">辅助·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="best_team_tab1 clearfix">
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/sd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/sd_active.png" alt="">
                                        </div>
                                        <span class="white">上单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇22</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/daye.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/daye_active.png" alt="">
                                        </div>
                                        <span class="white">打野·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team2.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/zd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/zd_active.png" alt="">
                                        </div>
                                        <span class="white">中单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/adc.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/adc_active.png" alt="">
                                        </div>
                                        <span class="white">ADC·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team3.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu_active.png" alt="">
                                        </div>
                                        <span class="white">辅助·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="best_team_tab1 clearfix">
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/sd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/sd_active.png" alt="">
                                        </div>
                                        <span class="white">上单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇33</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/daye.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/daye_active.png" alt="">
                                        </div>
                                        <span class="white">打野·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team2.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/zd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/zd_active.png" alt="">
                                        </div>
                                        <span class="white">中单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/adc.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/adc_active.png" alt="">
                                        </div>
                                        <span class="white">ADC·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team3.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu_active.png" alt="">
                                        </div>
                                        <span class="white">辅助·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="best_team_tab1 clearfix">
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/sd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/sd_active.png" alt="">
                                        </div>
                                        <span class="white">上单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇44</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/daye.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/daye_active.png" alt="">
                                        </div>
                                        <span class="white">打野·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team2.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/zd.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/zd_active.png" alt="">
                                        </div>
                                        <span class="white">中单·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/adc.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/adc_active.png" alt="">
                                        </div>
                                        <span class="white">ADC·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team3.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                            <li class="fl">
                                <a href="##">
                                    <div class="location">
                                        <div class="sd">
                                            <img class="img1 active imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu.png" alt="">
                                            <img class="img2 imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu_active.png" alt="">
                                        </div>
                                        <span class="white">辅助·评分</span>
                                        <span class="orange">200.2</span>
                                    </div>
                                    <div class="team_img">
                                        <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team1.png" alt="">
                                    </div>
                                    <p class="team_name">星宇</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">参赛队伍</span>
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
                    </ul>
                </div>
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">WE战队资讯</span>
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
                <div class="hot_match mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>\tournamentList" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
                            <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>\tournamentdetail\<?php echo $tournamentInfo['tournament_id'];?>" style="background-image: url('<?php echo $tournamentInfo['logo'];?>')">
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
    <script src="<?php echo $config['site_url'];?>/js/index.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/jquery.lineProgressbar.js"></script>
    <script>
         $(".event_detail").on("click",".event_detail_ul li",function(){
            $(".event_detail_ul li").removeClass("active");
            $(this).addClass("active");
            $(this).parents(".event_detail").find(".event_detail_content").find(".event_detail_div").removeClass("active").eq($(this).index()).addClass("active");
        })
        $(".best_team_match").hover(function(callback){
            $(".match2").css("display","block")
            $(".best_team").on("click",".match2 li",function(){
            $(".match1 p").text($(this).find("a").text().replace(/^\s*|\s*$/g,""))
            $(".match2 li").removeClass("active");
            $(this).addClass("active");
            $(".match2").css("display","none")
            $(this).parents(".events_top").find(".best_team").
            find(".best_team_tab").find(".best_team_tab1")
            .removeClass("active").eq($(this).index()).addClass("active");
            })
        },function(){
            $(".match2").css("display","none")
        });
        
        $(".best_team_match").click(function(){
            $(".match2").css("display","block")
            $(".best_team").on("click",".match2 li",function(){
            $(".match1 p").text($(this).find("a").text().replace(/^\s*|\s*$/g,""))
            $(".match2 li").removeClass("active");
            $(this).addClass("active");
            $(".match2").css("display","none")
            $(this).parents(".events_top").find(".best_team").
            find(".best_team_tab").find(".best_team_tab1")
            .removeClass("active").eq($(this).index()).addClass("active");
            })
        });
        

    </script>
</body>

</html>