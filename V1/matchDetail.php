
<?php
require_once "function/init.php";
$match_id = $_GET['match_id']??0;

$game = $_GET['game']??-1;
if($match_id >= 1000000)
{
    if($game == 0)
    {
        render301($config,"matchdetail/dota2-".$match_id);
        die();
    }
}
$params = [
    "matchDetail"=>["source"=>$config['default_source'],"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_hero_img"],"fields"=>["name","key","value"],"site_id"=>$config["site_id"]],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"recent"=>1,"page_size"=>3,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>3600],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);

if(!isset($return["matchDetail"]['data']['match_id']))
{
    render404($config);
    die();
}
if($game == 0)
{
    render301($config,"matchdetail/".$return['matchDetail']['data']['game']."-".$match_id);
    die();
}
$return['matchDetail']['data']['match_pre'] = json_decode($return['matchDetail']['data']['match_pre'],true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>??????????????????????????????_<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>-<?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>,<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>??????">
    <meta name="description" content="<?php echo $config['site_name'];?>??????<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>????????????,??????<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>???<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>?????????,?????????<?php echo $config['site_name'];?>">
    <?php renderHeaderJsCss($config,["progress-bars","game"]);?>
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
                ??????
            </a >
            >
            <a href="<?php echo $config['site_url'];?>/tournamentlist/<?php echo $return['matchDetail']['data']['game'];?>">
                <?php echo  $config['game'][$return['matchDetail']['data']['game']]; ?>
            </a >
            >
            <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $return['matchDetail']['data']['game'];?>-<?php echo $return['matchDetail']['data']['tournament_info']['tournament_id'];?>">
                <?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>
            </a >
            >
            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
        </div>
    </div>
    <div class="container">
        <div class="row clearfix">
            <div class="game_left">
                <!--- ????????????????????????-->
                <div class="game_title">
                    <div class="game_title_top">
                        <div class="game_team1">
							<?php if($return['matchDetail']['data']['home_team_info']['tid']>0){?>
                            <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>">
							<?php } ?>
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
							<?php if($return['matchDetail']['data']['home_team_info']['tid']>0){?>
                            </a>
							<?php } ?>
                        </div>
                        <div class="game_type">
                            <span class="span1"><?php echo $config['game'][$return['matchDetail']['data']['game']];?></span>
                            <span class="span2"><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?></span>
                            <div class="game_vs">
                                <span class="span1"><?php echo $return['matchDetail']['data']['home_score'];?></span>
                                <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/vs.png" src="<?php echo $config['site_url'];?>/images/vs.png" alt="<?php echo $return['matchDetail']['data']['home_score'].":".$return['matchDetail']['data']['away_score'];?>">
                                <span class="span2"><?php echo $return['matchDetail']['data']['away_score'];?></span>
                            </div>
                            <p><?php echo date("Y.m.d H:i:s",strtotime($return['matchDetail']['data']['start_time']))?>??<?php echo generateMatchStatus($return['matchDetail']['data']['start_time']);?></p>
                        </div>
                        <div class="game_team1">
							<?php if($return['matchDetail']['data']['away_team_info']['tid']>0){?>
                            <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>">
							<?php } ?>
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
							<?php if($return['matchDetail']['data']['away_team_info']['tid']>0){?>
                            </a>
							<?php } ?>
                        </div>
                    </div>
                    <div class="game_team_depiction">
                        <p class="active"><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['home_team_info']['description'])));?></p>
                        <p class="active"><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['away_team_info']['description'])));?></p>
                    </div>
                    <img data-original="<?php echo $config['site_url'];?>/images/more.png" src="<?php echo $config['site_url'];?>/images/more.png" alt="" class="game_title_more">
                </div>
                <!--- ????????????????????????-->
                <!--- ????????????-->
                <div class="game_detail">
                    <!--- ??????????????????-->
                    <ul class="game_detail_ul clearfix">
                        <?php foreach($return['matchDetail']['data']['match_data']['result_list'] as $key => $round_info) {?>
                            <li <?php if($key==0){echo ' class="active"';} ?>>
                                    <div class="game_detail_img1">
                                        <?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){?>
                                            <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>">
                                        <?php }else{?>
                                            <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
                                        <?php }?>
                                    </div>
                                    <span>GAME <?php echo ($key+1);?></span>
                            </li>
                        <?php }?>
                    </ul>
                    <!--- ??????????????????-->
                    <!--- ?????????????????????-->
                    <div class="game_detail_div">
                        <?php foreach($return['matchDetail']['data']['match_data']['result_list'] as $key => $round_info) {
                            $round_minute = $round_info['game_time_m']??"0"+($round_info['game_time_m']??0)/60;?>
                            <div class="game_detail_div_item<?php if($key==0){echo ' active';} ?>">
                                <div class="game_detail_item1">
                                    <!--<div >-->
										  <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>" class="left">
                                        <div class="imgwidth40 imgheight40">
                                            <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                        </div>
                                        <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
										
                                        <!--- ??????????????????-->
                                            <div class="imgwidth30 imgheight30">
											<?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){?> 
                                                <img data-original="<?php echo $config['site_url'];?>/images/victory.png"  src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto active ">
												<?php }?>
                                            </div>
                                        <!--- ??????????????????-->
										</a>
                                    <!--</div>-->
                                    <div class="center">
                                        <span class="game_detail_line1"></span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="fz font_color_r"><?php echo $round_info['kills_a']??0;?></span>
                                        <div class="img_game_detail_vs">
                                            <img data-original="<?php echo $config['site_url'];?>/images/game_detail_vs.png" src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="<?php echo ($round_info['kills_a']??0).":".($round_info['kills_b']??0);?>" class="imgauto">
                                        </div>
                                        <span class="fz font_color_b"><?php echo $round_info['kills_b']??0;?></span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="game_detail_line1"></span>
                                    </div>
                                    <!--<div >-->
                                        <!--- ??????????????????-->
										 <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>" class="left right">
                                            <div class="imgwidth30 imgheight30">
												<?php if($round_info['win_teamID']==$return['matchDetail']['data']['away_id']){?>
                                                <img data-original="<?php echo $config['site_url'];?>/images/victory.png" src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto  active ">
												<?php }?>
                                            </div>
                                        <!--- ??????????????????-->
                                        <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
										
                                        <div class="imgwidth40 imgheight40">
                                            <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                        </div>
										</a>
                                    <!--</div>-->
                                </div>
                                <!--- ????????????????????????mvp-->
                                <div class="game_detail_item2 win_<?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){echo "left";}else{echo "right";}?>">
                                    <div class="game_detail_item2_left">
                                        <?php foreach($round_info['record_list_a'] as $key2 => $player_info) {
                                        if(($player_info['mvp']??0==1) || ($player_info['beiguo']??0==1)){?>
                                            <div class="game_detail_item2_img">
                                                <img data-original="<?php echo $player_info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                            </div>
                                            <div class="game_detail_item2_word">
                                                <span class="span2"><?php echo $player_info['player_name'];?></span>
                                            </div>
                                        <?php }}?>
                                    </div>
                                    <div class="game_detail_item2_right">
                                        <?php foreach($round_info['record_list_b'] as $key2 => $player_info) {
                                            if(($player_info['mvp']??0==1) || ($player_info['beiguo']??0==1)){?>
                                                <div class="game_detail_item2_img">
                                                    <img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']!=0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name'];?>" class="imgauto">
                                                </div>
                                                <div class="game_detail_item2_word">
                                                    <span class="span2"><?php echo $player_info['player_name'];?></span>
                                                </div>
                                            <?php }}?>
                                    </div>
                                </div>
                                <!--- ????????????????????????mvp-->
                                <div class="game_detail_item3">
                                    <!--- ????????????????????????-->
                                    <div class="game_detail_item3_top">
                                        <div class="left">
                                            <div class="left_img">
												<?php $money_a=$round_info['money_a']??0; ?>
                                                <img data-original="<?php echo $config['site_url'];?>/images/gold_coin.png" src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="<?php echo sprintf("%10.1f",$money_a/1000);?>k" class="imgauto">
                                            </div>
                                            <span><?php echo sprintf("%10.1f",$money_a/1000);?>k</span>
                                        </div>
                                        <!--- ????????????-->
                                        <p><?php echo ($round_info['game_time_m']??"??").":".($round_info['game_time_s']??"??");?></p>
                                        <!--- ????????????-->
                                        <div class="left">
											<?php $money_b=$round_info['money_b']??0; ?>
                                            <span><?php echo sprintf("%10.1f",$money_b/1000);?>k</span>
                                            <div class="left_img">
                                                <img data-original="<?php echo $config['site_url'];?>/images/gold_coin.png" src="<?php echo $config['site_url'];?>/images/gold_coin.png" alt="<?php echo sprintf("%10.1f",$money_b/1000);?>k" class="imgauto">
                                            </div>
                                        </div>
                                    </div>
                                    <!--- ????????????????????????-->
                                    <div class="pk-detail-con">
                                        <div class="progress blue">
											<?php 
												$progress_money_a=$round_info['money_a']??0;
												$progress_money_b=$round_info['money_b']??0; 
												$total_progress_money=($progress_money_a+$progress_money_b);
												if($total_progress_money>0){
													$total_progress_rate_a=($progress_money_a/$total_progress_money)*100;
													$total_progress_rate_b=($progress_money_b/$total_progress_money)*100;
												}else{
													$total_progress_rate_a=0;
													$total_progress_rate_b=0;
												}
											
											?>
                                            <div class="progress-bar" style="width: <?php echo $total_progress_rate_a;?>%;">
                                                <i class="lightning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_div1_item3">
                                        <div class="left">
                                            <div class="img1">
                                                <img  data-original="<?php echo $config['site_url'];?>/images/kpl_dalong.png" src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="<?php echo $round_info['dragon_a']??0;?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['dragon_a']??0;?></span>
                                            <div class="img1">
                                                <img data-original="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png"  src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="<?php echo $round_info['baron_a']??0;?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['baron_a']??0;?></span>
                                            <div class="img1 img2">
                                                <img data-original="<?php echo $config['site_url'];?>/images/kpl_ta.png"  src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['red_tower']??0;?></span>
                                        </div>
                                        <div class="left right">
                                            <div class="img1">
                                                <img data-original="<?php echo $config['site_url'];?>/images/kpl_dalong.png" src="<?php echo $config['site_url'];?>/images/kpl_dalong.png" alt="<?php echo $round_info['dragon_b']??0;?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['dragon_b']??0;?></span>
                                            <div class="img1">
                                                <img data-original="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" src="<?php echo $config['site_url'];?>/images/kpl_xiaolong.png" alt="<?php echo $round_info['baron_b']??0;?>" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['baron_b']??0;?></span>
                                            <div class="img1 img2">
                                                <img data-original="<?php echo $config['site_url'];?>/images/kpl_ta.png" src="<?php echo $config['site_url'];?>/images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span><?php echo $round_info['blue_tower']??0;?></span>
                                        </div>
                                    </div>
                                    <div class="line2"></div>
                                </div>
                                <!--- ????????????????????????????????????-->
                                <div class="game_detail_item4">
                                    <div class="war_vs">
                                        <div class="war_situation">
                                            <?php if(isset($round_info['dragon_list']['blue']['firstTowerKill']) && $round_info['dragon_list']['blue']['firstTowerKill']>0) {?>
                                            <span class="war_red">??????</span>
                                            <?php }else{?><span>??????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['firstBloodKill']) && $round_info['dragon_list']['blue']['firstBloodKill']>0) {?>
                                                <span class="war_blue">??????</span>
                                            <?php }else{?><span>??????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['first5Kill']) && $round_info['dragon_list']['blue']['first5Kill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['first10Kill']) && $round_info['dragon_list']['blue']['first10Kill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['firstBaronKill']) && $round_info['dragon_list']['blue']['firstBaronKill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['firstDragonKill']) && $round_info['dragon_list']['blue']['firstDragonKill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['blue']['firstHerald']) && $round_info['dragon_list']['blue']['firstHerald']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                        </div>
                                        <div class="war_situation">
                                            <?php if(isset($round_info['dragon_list']['red']['firstTowerKill']) && $round_info['dragon_list']['red']['firstTowerKill']>0) {?>
                                            <span class="war_red">??????</span>
                                            <?php }else{?><span>??????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['firstBloodKill']) && $round_info['dragon_list']['red']['firstBloodKill']>0) {?>
                                                <span class="war_blue">??????</span>
                                            <?php }else{?><span>??????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['first5Kill']) && $round_info['dragon_list']['red']['first5Kill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['first10Kill']) && $round_info['dragon_list']['red']['first10Kill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['firstBaronKill']) && $round_info['dragon_list']['red']['firstBaronKill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['firstDragonKill']) && $round_info['dragon_list']['red']['firstDragonKill']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                            <?php if(isset($round_info['dragon_list']['red']['firstHerald']) && $round_info['dragon_list']['red']['firstHerald']>0) {?>
                                                <span class="war_blue">?????????</span>
                                            <?php }else{?><span>?????????</span><?php }?>
                                        </div>
                                    </div>
                                    <!--- ????????????Ban/Pick????????????-->
                                    <div class="bans_pincks">
                                        <div class="left">
											<table>
                                                <tr>
												<?php $count=0;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("blue_ban"))=="blue_ban"){
                                                        $count++;}}?>
                                                <?php $i=1;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("blue_ban"))=="blue_ban"){?>
                                                    <td>
                                                            <div class="bans_picks_div">
                                                                <img class="imgauto" data-original="<?php echo $ban;?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="">
                                                            </div>
                                                    </td>
													
                                                    <?php }}?>
                                                    
                                                </tr>
                                                <tr>
													 <?php $count=0;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("blue_pick_"))=="blue_pick_" && count(explode("_",$key_ban))==3){
                                                        $count++;}}?>
                                                <?php $i=1;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("blue_pick_"))=="blue_pick_" && count(explode("_",$key_ban))==3){?>
                                                    <td>
                                                            <div class="bans_picks_div">
                                                                <img class="imgauto" data-original="<?php echo $ban;?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="">
                                                            </div>
                                                    </td>
													
                                                    <?php }}?>
                                                    
                                                </tr>
                                            </table>
											
                                            
                                        </div>
                                        <div class="center">
                                            <span>Bans</span>
                                            <span>Picks</span>
                                        </div>
                                        <div class="right">
											<table>
                                                <tbody>
                                                    <tr>
													<?php $count=0;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("red_ban"))=="red_ban"){
                                                        $count++;}}?>
													<?php $i=1;foreach($round_info as $key_ban => $ban){
                                                    $c = $count-$i;
                                                    if(substr($key_ban,0,strlen("red_ban"))=="red_ban"){?>
                                                        <td>
                                                                <div class="bans_picks_div">
                                                                    <img class="imgauto" data-original="<?php echo $ban;?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="">
                                                                </div>
                                                        </td>
                                                    <?php }}?>
                                                    </tr>
                                                    <tr>
													<?php $count=0;foreach($round_info as $key_ban => $ban){
                                                    if(substr($key_ban,0,strlen("red_pick_"))=="red_pick_" && count(explode("_",$key_ban))==3){
                                                        $count++;}}?>
                                                <?php $i=1;foreach($round_info as $key_ban => $ban){
                                                    $c = $count-$i;
                                                    if(substr($key_ban,0,strlen("red_pick_"))=="red_pick_" && count(explode("_",$key_ban))==3){?>
                                                        <td>
                                                                <div class="bans_picks_div">
                                                                    <img class="imgauto" data-original="<?php echo $ban;?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="">
                                                                </div>
                                                        </td>
                                                    <?php }}?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    <!--- ????????????Ban/Pick????????????-->
                                </div>
                                <!--- ????????????????????????????????????-->
                                <!--- ?????????????????????????????????-->
                                <div class="game_detail_item5">
                                    <ul class="vs_data1">
                                        <li class="active">
                                        ??????
                                        </li>
                                        <li>
                                        ??????
                                        </li>
                                        <li>
                                        ??????
                                        </li>
                                        <li>
                                        ??????
                                        </li>
                                        <li>
                                        LFL??????
                                        </li>
                                    </ul>
                                    <div class="vs_data2">
                                        <?php $keyList = ['_star_atk_o','_star_def_o','_star_money_o','_star_adc_m','_star_score'];?>
                                        <?php foreach($keyList as $i => $key_name){?>
                                            <!--- ????????????-->
                                            <div class="vs_data2_item<?php if($i==0){echo ' active';}?>">
                                                <?php
                                                $max = max(array_merge(array_column($round_info['record_list_a'],$key_name),array_column($round_info['record_list_b'],$key_name),[0]));
                                                ?>
                                                <div class="left">
                                                    <?php foreach($round_info['record_list_a'] as $key2 => $player_info){?>
                                                        <div class="vs_data_combat">
                                                            <div class="progress1_parent">
                                                                <div class="progress1 red">
                                                                    <span style="width: <?php echo $player_info[$key_name]==0?0:intval($player_info[$key_name]/$max*100);?>%"><span><?php echo $player_info[$key_name]??"";?></span></span>

                                                                </div>
                                                            </div>
                                                            <div class="vs_player">
                                                                <div class="vs_player_game">
                                                                    <img data-original="<?php echo $player_info['hero_image']??'';?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $player_info['_hero_name']??'';?>" class="imgauto">
                                                                </div>
                                                                <div class="vs_player_reality">
																	<?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
																	<a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>">
                                                                    <img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>" class="imgauto"></a>
																	<?php }else{?>
																	 <img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>" class="imgauto">
																	<?php }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <div class="left right">
                                                    <?php foreach($round_info['record_list_b'] as $key2 => $player_info){?>
                                                        <div class="vs_data_combat">
                                                            <div class="vs_player">
                                                                <div class="vs_player_reality">
																	<?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
                                                                    <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>"><img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>" class="imgauto"></a>
																	<?php }else{?>
																	<img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>" class="imgauto">
																	<?php }?>
                                                                </div>
                                                                <div class="vs_player_game">
                                                                    <img data-original="<?php echo $player_info['hero_image']??'';?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $player_info['_hero_name']??'';?>" class="imgauto">
                                                                </div>
                                                            </div>
                                                            <div class="progress1_parent">
                                                                <div class="progress2 blue">
                                                                    <span style="width: <?php echo intval($player_info[$key_name]==0?0:$player_info[$key_name]/$max*100);?>%"><span><?php echo $player_info[$key_name]??"";?></span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <!--- ????????????-->
                                        <?php }?>
                                    </div>
                                </div>
                                <!--- ?????????????????????????????????-->
                                <!--- ???????????????????????????????????????-->
                                <div class="game_detail_item6">
                                    <!--<div class="vs_data3">-->
                                        <!--- ????????????-->
                                        <div class="table-wrap vs_data3_left active">
                                            <!--- ??????????????????-->
                                            <table class="table red">
                                                <thead>
                                                <tr>
                                                    <th><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> <?php if($round_info['win_teamID']==$return['matchDetail']['data']['home_id']){echo "??????";}else{echo "??????";}?></th>
                                                    <th>??????</th>
                                                    <th>KDA</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($round_info['record_list_a'] as $key2 => $player_info){
                                                    ?>
                                                    <tr>
                                                        <td>
                                                           
															<div class="avatar player mid">
																<?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
																<a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>"><img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>"></a>
																<?php }else{?>
																<img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>">
																<?php }?>
															</div>
                                                            
                                                            <div class="avatar hero mid">
                                                                <img data-original="<?php echo $player_info['_hero_pic']??'';?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" class="role-icon mid" alt="<?php echo $player_info['_hero_name']??'';?>">
                                                                <span class="lv"><?php echo $player_info['_hero_lv']??0;?></span>
                                                            </div>
                                                            <div class="jn-icon-wrap mid">
                                                                <?php foreach($player_info as $pk => $value){ if(substr($pk,0,strlen("_skill_"))=="_skill_" && !is_null($value)){?>
                                                                    <div class="property-img property-img1">
                                                                        <img data-original="<?php echo $value;?>" src="<?php echo $value;?>"
                                                                             class="jn-icon">
                                                                    </div>
                                                                <?php }}?>
                                                            </div>
															<?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
                                                            <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>" target="_blank">
                                                                <span title="<?php echo $player_info['player_name']??'';?>" class="nickname mid"><?php echo $player_info['player_name']??'';?></span>
                                                            </a>
															<?php }else{?>
															 <span title="<?php echo $player_info['player_name']??'';?>" class="nickname mid"><?php echo $player_info['player_name']??'';?></span>
															 <?php }?>
                                                        </td>
                                                        <td>
                                                            <?php foreach($player_info as $pk => $value){ if(substr($pk,0,strlen("_star_equip_"))=="_star_equip_"){?>
                                                            <div class="property-img mid">
                                                                <img src="<?php echo $value;?>" data-original="<?php echo $value;?>">
                                                            </div>
                                                            <?php }}?>
                                                        </td>
                                                        <td class="kda">
                                                            <p class="p1"><?php echo $player_info['_star_kda']??0;?></p>
                                                            <p class="p2"><?php echo $player_info['_star_kills']??0;?> / <?php echo $player_info['_star_deaths']??0;?> / <?php echo $player_info['_star_assists']??0;?></p>
                                                        </td>
                                                        <td class="damage atk">
                                                            <p><?php echo $player_info['_star_atk_p']??0;?>%</p>
                                                        </td>
                                                        <td class="damage def">
                                                            <p><?php echo $player_info['_star_def_p']??0;?>%</p>
                                                        </td>
                                                        <td class="hits">
                                                            <p class="p1"><?php echo $player_info['_star_hits']??0;?></p>
                                                            <p class="p2"><?php echo $round_minute==0?:sprintf("%10.1f",$player_info['_star_hits']/$round_minute)?>/???</p>
                                                        </td>
                                                        <td>
                                                            <p><?php echo $player_info['_star_money']??0;?></p>
                                                        </td>
                                                        <td><?php echo $player_info['_star_score']??0;?></td>
                                                    </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                            <!--- ??????????????????-->
                                            <!--- ??????????????????-->
                                            <table class="table blue">
                                                <thead>
                                                <tr>
                                                    <th><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?> <?php if($round_info['win_teamID']==$return['matchDetail']['data']['away_id']){echo "??????";}else{echo "??????";}?></th>
                                                    <th>??????</th>
                                                    <th>KDA</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                    <th>??????</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($round_info['record_list_b'] as $key2 => $player_info){?>
                                                <tr>
                                                    <td>
														<div class="avatar player mid">
															<?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
															<a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>"><img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>"></a>
															<?php }else{?>
															<img data-original="<?php echo (isset($player_info['logo']) && $player_info['logo']>0)?$player_info['logo']:$return['defaultConfig']['data']['default_player_img']['value'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>" alt="<?php echo $player_info['player_name']??'';?>">
															<?php }?>
														</div>
                                                        <div class="avatar hero mid">
                                                            <img data-original="<?php echo $player_info['_hero_pic']??'';?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" class="role-icon mid" alt="<?php echo $player_info['_hero_name'];?>">
                                                            <span class="lv"><?php echo $player_info['_hero_lv']??0;?></span>
                                                        </div>
                                                        <div class="jn-icon-wrap mid">
                                                            <?php foreach($player_info as $pk => $value){ if(substr($pk,0,strlen("_skill_"))=="_skill_" && !is_null($value)){?>
                                                                <div class="property-img property-img1">
                                                                    <img data-original="<?php echo $value;?>" src="<?php echo $value;?>"
                                                                         class="jn-icon">
                                                                </div>
                                                            <?php }}?>
                                                        </div>
                                                        <?php if(isset($player_info['pid']) && $player_info['pid']>0){?>
														<a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $player_info['pid'];?>" target="_blank">
															<span title="<?php echo $player_info['player_name']??'';?>" class="nickname mid"><?php echo $player_info['player_name']??'';?></span>
														</a>
														<?php }else{?>
														 <span title="<?php echo $player_info['player_name']??'';?>" class="nickname mid"><?php echo $player_info['player_name']??'';?></span>
														 <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php foreach($player_info as $pk => $value){ if(substr($pk,0,strlen("_star_equip_"))=="_star_equip_"){?>
                                                            <div class="property-img mid">
                                                                <img data-original="<?php echo $value;?>" src="<?php echo $value;?>">
                                                            </div>
                                                        <?php }}?>
                                                    </td>
                                                    <td class="kda">
                                                        <p class="p1"><?php echo $player_info['_star_kda']??0;?></p>
                                                        <p class="p2"><?php echo $player_info['_star_kills']??0;?> / <?php echo $player_info['_star_deaths']??0;?> / <?php echo $player_info['_star_assists']??0;?></p>
                                                    </td>
                                                    <td class="damage atk">
                                                        <p><?php echo $player_info['_star_atk_p']??0;?>%</p>
                                                    </td>
                                                    <td class="damage def">
                                                        <p><?php echo $player_info['_star_def_p']??0;?>%</p>
                                                    </td>
                                                    <td class="hits">
                                                        <p class="p1"><?php echo $player_info['_star_hits']??0;?></p>
                                                        <p class="p2"><?php echo $round_minute==0?0:sprintf("%10.1f",$player_info['_star_hits']/$round_minute)?>/???</p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $player_info['_star_money']??0;?></p>
                                                    </td>
                                                    <td><?php echo $player_info['_star_score']??0;?></td>
                                                </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                            <!--- ??????????????????-->
                                        </div>
                                        <!--- ????????????-->
                                    <!--</div>-->
                                </div>
                                <!--- ???????????????????????????????????????-->
                            </div>
                        <?php }?>
                        <div class="game_pre">
                            <!--- ????????????-->
                            <div id="666" class="vs_data3_left  active vs_data3_pad">
                                <p class="title">???6???????????????</p>
                                <!--- ??????-->
                                <div class="top-data clearfix">
                                    <div class="l-data fl">
                                        <span class="win_rate mid"><?php echo $return['matchDetail']['data']['match_pre']['tournament_biaoxian']['team_a']['VICTORY_RATE'];?>%</span>
                                    </div>
                                    <div class="r-data fr">
                                        <span class="win_rate mid"><?php echo $return['matchDetail']['data']['match_pre']['tournament_biaoxian']['team_b']['VICTORY_RATE'];?>%</span>
                                    </div>
                                    <div class="rate">??????</div>
                                </div>
                                <div class="compare-bar clearfix">
                                    <div class="progress3 fl progress4 red">
                                        <span class="green" style="width: <?php echo $return['matchDetail']['data']['match_pre']['tournament_biaoxian']['team_a']['VICTORY_RATE'];?>%;"></span>
                                    </div>
                                    <div class="progress3 fr blue">
                                        <span class="green" style="width: <?php echo $return['matchDetail']['data']['match_pre']['tournament_biaoxian']['team_b']['VICTORY_RATE'];?>%;"></span>
                                    </div>
                                </div>
                                <!--- ??????-->
                                <div class="rate_data">
                                    <div class="rate_data_item clearfix">
                                        <!--- KDA-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b']){ echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a'];?>[<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a'];?>/<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a'];?>/<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_assists_team_a'];?>]</span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b']){ echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b'];?>[<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b'];?>/<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b'];?>/<?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_assists_team_b'];?>]</span>
                                                <div class="average_time">KDA</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a']/(8.5))?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['average_kda_team_b']/(8.5))?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- KDA-->
                                        <!--- ??????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']){ echo "1";}else{echo "2";}?>"><?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']/60).":".sprintf("%02d",($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']%60));?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']){ echo "2";}else{echo "1";}?>"><?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']/60).":".sprintf("%02d",($return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']%60));?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']){ echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']/(55*60))?>%;"></span>
                                                </div>
                                                <div class="progress3 fl  <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_time_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']){ echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['average_time_b']/(55*60))?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ??????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a']/6200*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_money_team_b']/6200*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                        <!--- ??????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a']/27*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b']){echo " grey";}else{echo " red";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_kills_team_b']/27*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ??????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b']){ echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b']){ echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a']/(40))?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval(100*$return['matchDetail']['data']['match_pre']['strength_index']['minute_hits_team_b']/(40))?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                        <!--- ??????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a']/30*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_deaths_team_b']/30*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ??????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a']/10*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsPlaced_team_b']/10*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                        <!--- ??????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a']/120000*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_money_team_b']/120000*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ??????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a']/10*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_wardsKilled_team_b']/10*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                        <!--- ?????????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b'];?></span>
                                                <div class="average_time">???????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a']/10000*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_money_diff_team_b']/10000*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ?????????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ?????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a'];?>%</span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b'];?>%</span>
                                                <div class="average_time">?????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a']/100*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['firstBloodKill_team_b']/100*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ?????????-->
                                        <!--- ??????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a']/10*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_baron_team_b']/10*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ??????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ???????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a'];?>%</span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b'];?>%</span>
                                                <div class="average_time">???????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a']/100*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_dragon_team_b']/100*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ???????????????-->
                                        <!--- ????????????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a']/10*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_tower_team_b']/10*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ???????????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a'];?>%</span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b'];?>%</span>
                                                <div class="average_time">???????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a']/100*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_baron_team_b']/100*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ???????????????-->
                                        <!--- ???????????????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b'];?></span>
                                                <div class="average_time">???????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a']/10*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['average_be_turretKills_team_b']/10*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ???????????????-->
                                    </div>
                                    <div class="rate_data_item clearfix">
                                        <!--- ?????????-->
                                        <div class="fr rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a'];?>%</span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b'];?>%</span>
                                                <div class="average_time">?????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a']/100*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['rate_full_bureau_team_b']/100*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ?????????-->
                                        <!--- ????????????-->
                                        <div class="fl rate_data_left">
                                            <div class="rate_data_top">
                                                <span class="fl time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b']){echo "1";}else{echo "2";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a'];?></span>
                                                <span class="fr time<?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b']){echo "2";}else{echo "1";}?>"><?php echo $return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b'];?></span>
                                                <div class="average_time">????????????</div>
                                            </div>
                                            <div class="compare-bar compare_bar clearfix">
                                                <div class="progress3 fl progress4 <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b']){echo " red";}else{echo " grey";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a']/40000*100);?>%;"></span>
                                                </div>
                                                <div class="progress3 fr <?php if($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_a']>$return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b']){echo " grey";}else{echo " blue";}?>">
                                                    <span class="green" style="width: <?php echo intval($return['matchDetail']['data']['match_pre']['strength_index']['minute_damage_team_b']/40000*100);?>%;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- ????????????-->
                                    </div>

                                </div>
                            </div>
                            <!--- ????????????-->
                        </div>
                    </div>
                    <!--- ?????????????????????-->
                </div>
                <!--- ????????????-->

            </div>
            <div class="game_right">
                <div class="game_lately">
                    <div class="title clearfix">
                        <div class="fl clearfix">
                            <div class="game_fire fl">
                                <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">????????????</span>
                        </div>
                        <div class="more fr">
                            <a href="<?php echo $config['site_url'];?>/match/">
                                <span>??????</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
                    </div>
                    <ul class="game_match_ul">
                        <?php foreach($return['recentMatchList']['data'] as $matchInfo){?>
                        <li class="col-md-12 col-xs-12">
                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                <div class="game_match_top">
                                    <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                    <span class="game_match_time"><?php echo date("m???d??? H:i",strtotime($matchInfo['start_time']));?></span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                                <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" title="<?php echo $matchInfo['home_team_info']['team_name'];?>" />
                                        </div>
                                        <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                    </div>
                                    <div class="left center">
                                        <span> vs </span>
                                        <span>????????????</span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                           
                                                <img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  title="<?php echo $matchInfo['away_team_info']['team_name'];?>" />
                                                                               </div>
                                        <span><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
				<?php if(isset($return['hotNewsList']['data']) && count($return['hotNewsList']['data'])>0){?>
                <div class="game_news">
                    <div class="title clearfix">
                        <div class="fl clearfix">
                            <div class="game_fire fl">
                                <img class="imgauto"  data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">????????????</span>
                        </div>
                        <div class="more fr">
                            <a href="<?php echo $config['site_url'];?>/newslist/">
                                <span>??????</span>
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
				<?php } ?>
                <div class="game_team">
                    <div class="title clearfix">
                        <div class="fl clearfix">
                            <div class="game_fire fl">
                                <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png"  src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">????????????</span>
                        </div>
                        <div class="more fr">
                            <a href="<?php echo $config['site_url'];?>/teamlist/">
                                <span>??????</span>
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
                                <img class="imgauto"  data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">????????????</span>
                        </div>
                        <div class="more fr">
                            <a href="<?php echo $config['site_url'];?>/playerlist/">
                                <span>??????</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
                    </div>
                    <ul class="game_player_ul clearfix">

                        <?php foreach($return['hotPlayerList']['data'] as $playerInfo){?>
                            <li>
                                <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                    <div class="game_player_img">
                                        <img data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>" alt="<?php echo $playerInfo['player_name'];?>" class="imgauto">
                                    </div>
                                    <span><?php echo $playerInfo['player_name'];?></span>
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
                ????????????
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
			<img src="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" data-original="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" alt="????????????">
		</div>
	</div>
</div>
<?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
</body>

</html>