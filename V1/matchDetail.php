<?php
require_once "function/init.php";
$match_id = $_GET['match_id']??0;
$params = [
    "matchDetail"=>["source"=>$config['default_source'],"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
$return['matchDetail']['data']['match_pre'] = json_decode($return['matchDetail']['data']['match_pre'],true);
//$return['matchDetail']['data']['match_data'] = json_decode($return['matchDetail']['data']['match_data'],true);
print_R(($return['matchDetail']['data']['match_data']['result_list']));
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
    <?php renderHeaderJsCss($config,["game","jquery.lineProgressbar"]);?>
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
                <div class="game_title">
                    <div class="game_title_top">
                        <div class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img class="imgauto" src="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
                        </div>
                        <div class="game_type">
                            <span class="span1"><?php echo $config['game'][$return['matchDetail']['data']['game']];?></span>
                            <span class="span2"><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?></span>
                            <div class="game_vs">
                                <span class="span1"><?php echo $return['matchDetail']['data']['home_score'];?></span>
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/vs.png" alt="">
                                <span class="span2"><?php echo $return['matchDetail']['data']['away_score'];?></span>
                            </div>
                            <p><?php echo date("Y.m.d H:i:s",strtotime($return['matchDetail']['data']['start_time'])+$config['hour_lag']*3600)?>·已结束</p>
                        </div>
                        <div class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img class="imgauto" src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
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
                <div class="game_detail">
                    <ul class="game_detail_ul">
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
                    <div class="game_detail_div">
                        <?php foreach($return['matchDetail']['data']['match_data']['result_list'] as $key => $round_info) {?>
                        <div class="game_detail_div_item<?php if($key==0){ echo ' active';}?>">
                            <div class="game_detail_item1">
                                <div class="left">
                                    <div class="imgwidth40 imgheight40">
                                        <img src="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                    </div>
                                    <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
                                    <?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){?>
                                        <div class="imgwidth30 imgheight30">
                                            <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                        </div>
                                    <?php }?>
                                </div>
                                <div class="center">
                                    <span class="game_detail_line1"></span>
                                    <span class="game_detail_circle1"></span>
                                    <span class="fz font_color_r"><?php echo $round_info['kills_a'];?></span>
                                    <div class="img_game_detail_vs">
                                        <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="" class="imgauto">
                                    </div>
                                    <span class="fz font_color_b"><?php echo $round_info['kills_b'];?></span>
                                    <span class="game_detail_circle1"></span>
                                    <span class="game_detail_line1"></span>
                                </div>
                                <div class="left right">
                                    <?php if($round_info['win_teamID']==$return['matchDetail']['data']['away_id']){?>
                                        <div class="imgwidth30 imgheight30">
                                            <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                        </div>
                                    <?php }?>
                                    <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
                                    <div class="imgwidth40 imgheight40">
                                        <img src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                    </div>
                                </div>
                            </div>
                            <div class="game_detail_item2">
                                <?php foreach($round_info['record_list_a'] as $key2 => $player_info) {
                                    if($player_info['mvp']==1 || $player_info['beiguo']){?>
                                    <div class="game_detail_item2_left">
                                        <div class="game_detail_item2_img">
                                            <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                        </div>
                                        <div class="game_detail_item2_word">
                                            <?php if($player_info['mvp']==1) {?>
                                            <span class="span1">MVP</span>
                                            <?php }else{?>
                                            <span class="span1">背锅侠</span>
                                            <?php }?>
                                            <span class="span2"><?php echo $player_info['player_name'];?></span>
                                        </div>
                                        <div class="arrow-up"></div>
                                    </div>
                                <?php }}?>
                                <?php foreach($round_info['record_list_b'] as $key3 => $player_info) {
                                if($player_info['mvp']==1 || $player_info['beiguo']){?>
                                    <div class="game_detail_item2_right">
                                        <div class="arrow-down"></div>
                                        <div class="game_detail_item2_word">
                                            <?php if($player_info['mvp']==1) {?>
                                                <span class="span1">MVP</span>
                                            <?php }else{?>
                                                <span class="span1">背锅侠</span>
                                            <?php }?>
                                            <span class="span2"><?php echo $player_info['player_name'];?></span>
                                        </div>
                                        <div class="game_detail_item2_img">
                                            <img src="<?php echo $player_info['logo'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                        </div>
                                    </div>
                                <?php }}?>

                            </div>
                            <div class="game_detail_item3">
                                <div class="game_detail_item3_top">
                                    <div class="left">
                                        <div class="left_img">
                                            <img src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="" class="imgauto">
                                        </div>
                                        <span><?php echo $round_info['money_a'];?></span>
                                    </div>
                                    <p><?php echo $round_info['game_time_minute'];?>分钟</p>
                                    <div class="left">
                                        <span><?php echo $round_info['money_b'];?></span>
                                        <div class="left_img">
                                            <img src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="" class="imgauto">
                                        </div>
                                    </div>
                                </div>
                                <div class="pk-detail-con">
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?php echo intval(100*$round_info['money_a']/($round_info['money_a']+$round_info['money_b']));?>%;">
                                            <i class="lightning"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="game_detail_div1_item3">
                                    <div class="left">
                                        <div class="img1">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="" class="autoimg">
                                        </div>
                                        <span><?php echo $round_info['dragon_a'];?></span>
                                        <div class="img1">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="" class="autoimg">
                                        </div>
                                        <span><?php echo $round_info['baron_a'];?></span>
                                        <div class="img1 img2">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                        </div>
                                        <span>1</span>
                                    </div>
                                    <div class="left right">
                                        <div class="img1">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="" class="autoimg">
                                        </div>
                                        <span><?php echo $round_info['dragon_b'];?></span>
                                        <div class="img1">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="" class="autoimg">
                                        </div>
                                        <span><?php echo $round_info['baron_b'];?></span>
                                        <div class="img1 img2">
                                            <img src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                        </div>
                                        <span>0</span>
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
                                    <li class="">
                                        <a href="##">
                                            输出
                                        </a>
                                    </li>
                                    <li class="active">
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
                                    <div class="vs_data2_item">
                                        <div class="left">
                                            <div class="vs_data_combat">
                                                <div class="progress1_parent">
                                                    <div class="progress1">
                                                        <span style="width: 40%;"><span>95722</span></span>
                                                    </div>
                                                </div>
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="progress1_parent">
                                                    <div class="progress1">
                                                        <span style="width: 60%;"><span>120530</span></span>
                                                    </div>
                                                </div>
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="progress1_parent">
                                                    <div class="progress1">
                                                        <span style="width: 100%;"><span>120529</span></span>
                                                    </div>
                                                </div>
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="progress1_parent">
                                                    <div class="progress1">
                                                        <span style="width: 40%;"><span>95721</span></span>
                                                    </div>
                                                </div>
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="progress1_parent">
                                                    <div class="progress1">
                                                        <span style="width: 60%;"><span>120529</span></span>
                                                    </div>
                                                </div>
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="left right">
                                            <div class="vs_data_combat">
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                                <div class="progress1_parent">
                                                    <div class="progress2">
                                                        <span style="width: 40%;"><span>95721</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                                <div class="progress1_parent">
                                                    <div class="progress2">
                                                        <span style="width: 60%;"><span>120529</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                                <div class="progress1_parent">
                                                    <div class="progress2">
                                                        <span style="width: 100%;"><span>120529</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                                <div class="progress1_parent">
                                                    <div class="progress2">
                                                        <span style="width: 40%;"><span>95721</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vs_data_combat">
                                                <div class="vs_player">
                                                    <div class="vs_player_game">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans1.png" alt="" class="imgauto">
                                                    </div>
                                                    <div class="vs_player_reality">
                                                        <img src="<?php echo $config['site_url'];?>/images/bans2.png" alt="" class="imgauto">
                                                    </div>
                                                </div>
                                                <div class="progress1_parent">
                                                    <div class="progress2">
                                                        <span style="width: 60%;"><span>120529</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="game_right">

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
<script src="<?php echo $config['site_url'];?>/js/jquery.min.js"></script>
<script src="<?php echo $config['site_url'];?>/js/index.js"></script>
<script src="<?php echo $config['site_url'];?>/js/jquery.lineProgressbar.js"></script>
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
</script>
</body>
</html>