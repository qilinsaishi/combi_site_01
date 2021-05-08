<?php
require_once "function/init.php";
$match_id = $_GET['match_id']??0;
//echo $match_id."\n";die();
$params = [
    "matchDetail"=>["source"=>$config['default_source'],"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
$return['matchDetail']['data']['match_pre'] = json_decode($return['matchDetail']['data']['match_pre'],true);
unset($return['matchDetail']['data']['match_pre']);
//$return['matchDetail']['data']['match_data'] = json_decode($return['matchDetail']['data']['match_data'],true);q
//print_R(($return['matchDetail']['data']['match_data']));
//die();
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
    <?php renderHeaderJsCss($config,["progress-bars","game"]);?>
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
            <div class="game_left">
                <!--- 比赛双方基本信息-->
                <div class="game_title">
                    <div class="game_title_top">
                        <div class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img src="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
                        </div>
                        <div class="game_type">
                            <span class="span1"><?php echo $config['game'][$return['matchDetail']['data']['game']];?></span>
                            <span class="span2"><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?></span>
                            <div class="game_vs">
                                <span class="span1"><?php echo $return['matchDetail']['data']['home_score'];?></span>
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/vs.png" alt="<?php echo $return['matchDetail']['data']['home_score'].":".$return['matchDetail']['data']['away_score'];?>">
                                <span class="span2"><?php echo $return['matchDetail']['data']['away_score'];?></span>
                            </div>
                            <p><?php echo date("Y.m.d H:i:s",strtotime($return['matchDetail']['data']['start_time'])+$config['hour_lag']*3600)?>·已结束</p>
                        </div>
                        <div class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>"  class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
                        </div>
                    </div>
                    <div class="game_team_depiction">
                        <p class="active"><?php echo strip_tags(checkJson($return['matchDetail']['data']['home_team_info']['description']));?></p>
                        <p class="active"><?php echo strip_tags(checkJson($return['matchDetail']['data']['away_team_info']['description']));?></p>
                    </div>
                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="" class="game_title_more">
                </div>
                <!--- 比赛双方基本信息-->
                <!--- 比赛信息-->
                <div class="game_detail">
                    <!--- 比赛轮次列表-->
                    <ul class="game_detail_ul clearfix">
                        <?php foreach($return['matchDetail']['data']['match_data']['result_list'] as $key => $round_info) {?>
                            <li <?php if($key==0){echo ' class="active"';} ?>>
                                <a href="##">
                                    <div class="game_detail_img1">
                                        <?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){?>
                                            <img src="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>">
                                        <?php }else{?>
                                            <img src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
                                        <?php }?>
                                    </div>
                                    <span>GAME <?php echo ($key+1);?></span>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                    <!--- 比赛轮次列表-->
                    <!--- 比赛各轮次信息-->
                    <div class="game_detail_div">
                        <?php foreach($return['matchDetail']['data']['match_data']['result_list'] as $key => $round_info) {?>
                            <div class="game_detail_div_item<?php if($key==0){echo ' active';} ?>">
                                <div class="game_detail_item1">
                                    <div class="left">
                                        <div class="imgwidth40 imgheight40">
                                            <img src="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                        </div>
                                        <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
                                        <!--- 如果主队胜利-->
                                        <?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){?>
                                            <div class="imgwidth30 imgheight30">
                                                <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                            </div>
                                        <?php }?>
                                        <!--- 如果主队胜利-->
                                    </div>
                                    <div class="center">
                                        <span class="game_detail_line1"></span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="fz font_color_r"><?php echo $round_info['kills_a'];?></span>
                                        <div class="img_game_detail_vs">
                                            <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="<?php echo $round_info['kills_a'].":".$round_info['kills_b'];?>" class="imgauto">
                                        </div>
                                        <span class="fz font_color_b"><?php echo $round_info['kills_b'];?></span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="game_detail_line1"></span>
                                    </div>
                                    <div class="left right">
                                        <!--- 如果客队胜利-->
                                        <?php if($round_info['win_teamID']==$return['matchDetail']['data']['away_id']){?>
                                            <div class="imgwidth30 imgheight30">
                                                <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                            </div>
                                        <?php }?>
                                        <!--- 如果客队胜利-->
                                        <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
                                        <div class="imgwidth40 imgheight40">
                                            <img src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                        </div>
                                    </div>
                                </div>
                                <!--- 主客队的背锅侠和mvp-->
                                <div class="game_detail_item2 win_<?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){echo "left";}else{echo "right";}?>">
                                    <div class="game_detail_item2_left">
                                        <?php foreach($round_info['record_list_a'] as $key2 => $player_info) {
                                        if($player_info['mvp']==1 || $player_info['beiguo']){?>
                                            <div class="game_detail_item2_img">
                                                <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                            </div>
                                            <div class="game_detail_item2_word">
                                                <span class="span2"><?php echo $player_info['player_name'];?></span>
                                            </div>
                                        <?php }}?>
                                    </div>
                                    <div class="game_detail_item2_right">
                                        <?php foreach($round_info['record_list_b'] as $key2 => $player_info) {
                                            if($player_info['mvp']==1 || $player_info['beiguo']){?>
                                                <div class="game_detail_item2_img">
                                                    <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                                </div>
                                                <div class="game_detail_item2_word">
                                                    <span class="span2"><?php echo $player_info['player_name'];?></span>
                                                </div>
                                            <?php }}?>
                                    </div>
                                </div>
                                <!--- 主客队的背锅侠和mvp-->
                                <div class="game_detail_item3">
                                    <!--- 主客队的金钱收益-->
                                    <div class="game_detail_item3_top">
                                        <div class="left">
                                            <div class="left_img">
                                                <img src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="<?php echo sprintf("%10.1f",$round_info['money_a']/1000);?>k" class="imgauto">
                                            </div>
                                            <span><?php echo sprintf("%10.1f",$round_info['money_a']/1000);?>k</span>
                                        </div>
                                        <!--- 轮次时间-->
                                        <p><?php echo ($round_info['game_time_m']).":".($round_info['game_time_s']);?></p>
                                        <!--- 轮次时间-->
                                        <div class="left">
                                            <span><?php echo sprintf("%10.1f",$round_info['money_b']/1000);?>k</span>
                                            <div class="left_img">
                                                <img src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="<?php echo sprintf("%10.1f",$round_info['money_b']/1000);?>k" class="imgauto">
                                            </div>
                                        </div>
                                    </div>
                                    <!--- 主客队的金钱收益-->
                                    <div class="pk-detail-con">
                                        <div class="progress blue">
                                            <div class="progress-bar" style="width: <?php echo intval(100*$round_info['money_a']/($round_info['money_a']+$round_info['money_b']));?>%;">
                                                <i class="lightning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_div1_item3">
                                        <div class="left">
                                            <div class="img1">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="<?php echo $round_info['dragon_a'];?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['dragon_a'];?></span>
                                            <div class="img1">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="<?php echo $round_info['baron_a'];?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['baron_a'];?></span>
                                            <div class="img1 img2">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['red_tower'];?></span>
                                        </div>
                                        <div class="left right">
                                            <div class="img1">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="<?php echo $round_info['dragon_b'];?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['dragon_b'];?></span>
                                            <div class="img1">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="<?php echo $round_info['baron_b'];?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['baron_b'];?></span>
                                            <div class="img1 img2">
                                                <img src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['blue_tower'];?></span>
                                        </div>
                                    </div>
                                    <div class="line2"></div>
                                </div>
                                <div class="game_detail_item4">
                                    <div class="war_vs">
                                        <div class="war_situation">
                                            <span class="war_red">一塔</span>
                                            <span class="war_blue">一血</span>
                                            <span>先五杀</span>
                                            <span>先十杀</span>
                                            <span>一小龙</span>
                                            <span>一大龙</span>
                                            <span>一先锋</span>
                                        </div>
                                        <div class="war_situation">
                                            <span class="war_red">一塔</span>
                                            <span class="war_blue">一血</span>
                                            <span>先五杀</span>
                                            <span>先十杀</span>
                                            <span>一小龙</span>
                                            <span>一大龙</span>
                                            <span>一先锋</span>
                                        </div>
                                    </div>
                                    <div class="bans_pincks">
                                        <div class="left">
                                            <div class="bans bans_bot">
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans3.png" alt="" class="imgauto">
                                                </div>
                                                <div class="line3"></div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans4.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans5.png" alt="" class="imgauto">
                                                </div>
                                            </div>
                                            <div class="bans picks">
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans3.png" alt="" class="imgauto">
                                                </div>
                                                <div class="line3"></div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans4.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans5.png" alt="" class="imgauto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="center">
                                            <span>Bans</span>
                                            <span>Picks</span>
                                        </div>
                                        <div class="left">
                                            <div class="bans bans_bot">
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans5.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans4.png" alt="" class="imgauto">
                                                </div>
                                                <div class="line3"></div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans3.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                </div>
                                            </div>
                                            <div class="bans picks">
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans5.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans4.png" alt="" class="imgauto">
                                                </div>
                                                <div class="line3"></div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans3.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                </div>
                                                <div class="bans_img">
                                                    <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="game_detail_item5">
                                    <ul class="vs_data1">
                                        <li class="active">
                                            <a href="##">
                                                输出
                                            </a>
                                        </li>
                                        <li>
                                            <a href="##">
                                                承伤
                                            </a>
                                        </li>
                                        <li>
                                            <a href="##">
                                                经济
                                            </a>
                                        </li>
                                        <li>
                                            <a href="##">
                                                补刀
                                            </a>
                                        </li>
                                        <li>
                                            <a href="##">
                                                LFL评分
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="vs_data2">
                                        <?php $keyList = ['_star_atk_o','_star_def_o','_star_money_o','_star_adc_m','_star_score'];?>
                                        <?php foreach($keyList as $i => $key_name){?>
                                            <!--- 输出对比-->
                                            <div class="vs_data2_item<?php if($i==0){echo ' active';}?>">
                                                <?php
                                                $max = max(array_merge(array_column($round_info['record_list_a'],$key_name),array_column($round_info['record_list_b'],$key_name)));
                                                ?>
                                                <div class="left">
                                                    <?php foreach($round_info['record_list_a'] as $key2 => $player_info){?>
                                                        <div class="vs_data_combat">
                                                            <div class="progress1_parent">
                                                                <div class="progress1 red">
                                                                    <span style="width: <?php echo $player_info[$key_name]==0?0:intval($player_info[$key_name]/$max*100);?>%"><span><?php echo $player_info[$key_name];?></span></span>
                                                                </div>
                                                            </div>
                                                            <div class="vs_player">
                                                                <div class="vs_player_game">
                                                                    <img src="<?php echo $player_info['hero_image'];?>" alt="<?php echo $player_info['hero_name'];?>" class="imgauto">
                                                                </div>
                                                                <div class="vs_player_reality">
                                                                    <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <div class="left right">
                                                    <?php foreach($round_info['record_list_b'] as $key2 => $player_info){?>
                                                        <div class="vs_data_combat">
                                                            <div class="vs_player">
                                                                <div class="vs_player_game">
                                                                    <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                                                </div>
                                                                <div class="vs_player_reality">
                                                                    <img src="<?php echo $player_info['hero_image'];?>" alt="<?php echo $player_info['hero_name'];?>" class="imgauto">
                                                                </div>
                                                            </div>
                                                            <div class="progress1_parent">
                                                                <div class="progress2 blue">
                                                                    <span style="width: <?php echo intval($player_info[$key_name]==0?0:$player_info[$key_name]/$max*100);?>%"><span><?php echo $player_info[$key_name];?></span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <!--- 输出对比-->
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <!--- 比赛各轮次信息-->
                </div>
                <!--- 比赛信息-->
                <div class="game_detail_item6">
                    <ul class="game_before_after">
                        <li class="active">
                            <a href="##">
                                赛前数据
                            </a>
                        </li>
                        <li>
                            <a href="##">
                                赛后统计
                            </a>
                        </li>
                    </ul>
                    <div class="vs_data3">
                        <div class="vs_data3_left active vs_data3_pad">
                            <p class="title">近6场赛事数据</p>
                            <div class="top-data clearfix">
                                <div class="l-data fl">
                                    <span class="win_rate mid">50%</span>
                                </div>
                                <div class="r-data fr">
                                    <span class="win_rate mid">70%</span>
                                </div>
                                <div class="rate">胜率</div>
                            </div>
                            <div class="compare-bar clearfix">
                                <div class="progress3 fl progress4 red">
                                    <span class="green" style="width: 40%;"></span>
                                </div>
                                <div class="progress3 fr blue">
                                    <span class="green" style="width: 60%;"></span>
                                </div>
                            </div>
                            <div class="rate_data">
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate_data_item clearfix">
                                    <div class="fr rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
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
                                    <div class="fl rate_data_left">
                                        <div class="rate_data_top">
                                            <span class="fl time1">31:05</span>
                                            <span class="fr time2">27:59</span>
                                            <div class="average_time">场均时长</div>
                                        </div>
                                        <div class="compare-bar compare_bar clearfix">
                                            <div class="progress3 fl progress4 red">
                                                <span class="green" style="width: 40%;"></span>
                                            </div>
                                            <div class="progress3 fr grey">
                                                <span class="green" style="width: 60%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-wrap vs_data3_left">
                            <table class="table red">
                                <thead>
                                <tr>
                                    <th>WE 胜利</th>
                                    <th>出装</th>
                                    <th>KDA</th>
                                    <th>输出</th>
                                    <th>承伤</th>
                                    <th>补兵</th>
                                    <th>金钱</th>
                                    <th>评分</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table blue">
                                <thead>
                                <tr>
                                    <th>VS 败北</th>
                                    <th>出装</th>
                                    <th>KDA</th>
                                    <th>输出</th>
                                    <th>承伤</th>
                                    <th>补兵</th>
                                    <th>金钱</th>
                                    <th>评分</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="##" target="_blank">
                                            <div class="avatar player mid">
                                                <img src="<?php echo $config['site_url'];?>/images/bans1.png">
                                            </div>
                                        </a>
                                        <div class="avatar hero mid">
                                            <img src="<?php echo $config['site_url'];?>/images/bans2.png" class="role-icon mid">
                                            <span class="lv">0</span>
                                        </div>
                                        <div class="jn-icon-wrap mid">
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills1.png"
                                                     class="jn-icon">
                                            </div>
                                            <div class="property-img property-img1">
                                                <img src="<?php echo $config['site_url'];?>/images/game_skills2.png"
                                                     class="jn-icon">
                                            </div>
                                        </div>
                                        <a href="##" target="_blank">
                                            <span title="Qing" class="nickname mid">Qing</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading1.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading2.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading3.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading4.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading5.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading6.png">
                                        </div>
                                        <div class="property-img mid">
                                            <img src="<?php echo $config['site_url'];?>/images/out_loading7.png">
                                        </div>
                                    </td>
                                    <td class="kda">
                                        <p class="p1">3.5</p>
                                        <p class="p2">2 / 2 / 5</p>
                                    </td>
                                    <td class="damage atk">
                                        <p>26.8%</p>
                                    </td>
                                    <td class="damage def">
                                        <p>30.3%</p>
                                    </td>
                                    <td class="hits">
                                        <p class="p1">182</p>
                                        <p class="p2">6.1/分</p>
                                    </td>
                                    <td>
                                        <p>7.2k</p>
                                    </td>
                                    <td>143.8</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="game_right">
                <div class="game_lately">
                    <div class="title clearfix">
                        <div class="fl clearfix">
                            <div class="game_fire fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">近期赛事</span>
                        </div>
                        <div class="more fr">
                            <a href="##">
                                <span>更多</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
                    </div>
                    <ul class="game_match_ul">
                        <li class="col-md-12 col-xs-12">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛常规</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left ov_1">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>常规赛常规常规</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-12 col-xs-12">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img2">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-12 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
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
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">近期赛事</span>
                        </div>
                        <div class="more fr">
                            <a href="##">
                                <span>更多</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
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
<script>
    // 溢出隐藏，点击不隐藏
    $(".game_title").on("click", ".game_title_more", function () {
        $(".game_title").find(".game_team_depiction p").toggleClass("active");
        $(".game_title_more").toggleClass("active")
    })

    // vs_data1切换
    $(".vs_data1").on("click", 'li', function () {
        var _this = $(this).index() - 1;
        $(".vs_data1 li").removeClass("active").eq($(this).index()).addClass("active");
        $(".vs_data1 li").removeClass("active1").eq(_this).addClass("active1");
        $(".vs_data2 .vs_data2_item").removeClass("active").eq($(this).index()).addClass("active");
        // $(".game_team_div").removeClass("active").eq($(this).index()).addClass("active");
    })

    // if ($(".game_detail_ul li").length > 5) {
    //     console.log($(".game_detail_ul li").length)
    //     $(".game_detail_ul li").addClass("active1")
    // }

    $(".game_before_after").on("click", 'li', function () {
        $(".game_before_after li").removeClass("active").eq($(this).index()).addClass("active");
        $(".vs_data3 .vs_data3_left").removeClass("active").eq($(this).index()).addClass("active");
    })

    $(".game_detail_ul").on("click", 'li', function () {
        $(".game_detail_ul li").removeClass("active").eq($(this).index()).addClass("active");
        $(".game_detail_div .game_detail_div_item").removeClass("active").eq($(this).index()).addClass("active");
    })
</script>
<?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
</body>

</html>