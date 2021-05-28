<?php
require_once "function/init.php";
$tid = $_GET['tid']??0;
if($tid<=0)
{
    render404($config);
}
$params = [
    "intergratedTeam"=>[$tid],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"team","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
if(!isset($return["intergratedTeam"]['data']['tid']))
{
    render404($config);
}
if($return['intergratedTeam']['data']['description']!="")
{
    if(substr($return['intergratedTeam']['data']['description'],0,1)=='"' && substr($return['intergratedTeam']['data']['description'],-1)=='"')
    {
        $description =  html_entity_decode(json_decode($return['intergratedTeam']['data']['description'],true));
    }
    else
    {
        $description =   html_entity_decode($return['intergratedTeam']['data']['description']);

    }
}
else
{
    $description = "暂无";
}
if(count($return['intergratedTeam']['data']['aka'])>0){
	$return['intergratedTeam']['data']['aka']=implode(',',array_filter($return['intergratedTeam']['data']['aka']));
}

//获取当前战队的游戏
$game=$return['intergratedTeam']['data']['game'] ?? $config['default_game'];
//当前游戏下面的资讯
$params2=[
	 "keywordMapList"=>["fields"=>"content_id","source_type"=>"team","source_id"=>$return["intergratedTeam"]['data']['intergrated_id_list'],"page_size"=>10,"content_type"=>"information","list"=>["page_size"=>10,"fields"=>"id,title,create_time,logo"]],
	"hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>7,"fields"=>'tid,team_name,logo',"game"=>$game,"except_team"=>$tid,"rand"=>1,"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"hotTournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>4,"game"=>$game,"source"=>"scoregg","rand"=>1,"cacheWith"=>"currentPage","cache_time"=>86400*7],
];

$return2 = curl_post($config['api_get'],json_encode($params2),1);
//如果战队资讯不存在
if(count($return2["keywordMapList"]["data"]??[])==0)
{
    $params3 = [
        "informationList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,create_time,game',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    ];
    $return3 = curl_post($config['api_get'],json_encode($params3),1);
    $connectedInformationList = $return3["informationList"]["data"];
}
else
{
    $connectedInformationList = $return2["keywordMapList"]["data"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $return['intergratedTeam']['data']['team_name'];?>战队_<?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部_<?php echo $config['game'][$game]?><?php echo $return['intergratedTeam']['data']['team_name'];?>战队资料-<?php echo $config['site_name'];?></title>
    <meta name="description" content="<?php echo $config['site_name'];?>提供<?php echo $config['game'][$game]?><?php echo $return['intergratedTeam']['data']['team_name'];?>战队资料,<?php echo strip_tags($return['intergratedTeam']['data']['description']);?>">
    <meta name=”Keywords” Content=”<?php
    if(substr_count($return['intergratedTeam']['data']['team_name'],"战队")==0){echo $return['intergratedTeam']['data']['team_name'].'战队,';}?><?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部,<?php echo $config['game'][$game]?><?php echo $return['intergratedTeam']['data']['team_name'];?>战队资料″>
    
    <!-- 这是本页面新增的css   teamdetail.css -->
  <?php renderHeaderJsCss($config,["teamdetail"]);?> 
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
                             <?php generateNav($config,"team");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- 战队介绍 -->
                <div class="team_title mb20 clearfix">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" src="<?php echo $return['intergratedTeam']['data']['logo'];?>" alt="<?php echo $return['intergratedTeam']['data']['team_name'];?>">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <p class="name fl"><?php echo $return['intergratedTeam']['data']['team_name'];?></p>
                            <p class="classify fl"><?php if($return['intergratedTeam']['data']['game']=='lol'){?>英雄联盟<?php }elseif($return['intergratedTeam']['data']['game']=='kpl'){ ?>王者荣耀<?php }elseif($return['intergratedTeam']['data']['game']=='dota2'){ ?>DOTA2<?php } ?></p>
                        </div>
                        <div class="team_explain_name clearfix">
                            <p class="clearfix fl">英文名：<span class="English_name fr"><span class="English_name fr"><?php echo $return['intergratedTeam']['data']['team_name'];?></span></p>
                            <p class="clearfix fl">别称：<span class="chinese_name fr"><?php echo $return['intergratedTeam']['data']['aka'] ?></span></p>
                        </div>
                        <div class="team_explain_bottom">
                             <?php echo $description;?>
                        </div>
                    </div>
                </div>
                <!-- 战队介绍 -->
                <!-- 队员介绍 -->
                <div class="team_member mb20">
                    <div class="team_member_top clearfix">
                        <div class="team_member_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_number.png" alt="">
                        </div>
                        <span class="fl team_number_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队成员</span>
                    </div>
					<?php if(isset($return['intergratedTeam']['data']['playerList']) && count($return['intergratedTeam']['data']['playerList'])>0 ){?>
                    <ul class="team_member_detail clearfix">
						 <?php

						  foreach($return['intergratedTeam']['data']['playerList'] as $playerInfo)
						  { if(strlen($playerInfo['logo']) >=10){
							  ?>
							<li>
								<a href="<?php echo $config['site_url']; ?>/playerdetail/<?php echo $playerInfo['pid'];?>">
									<div class="team_number_photo">
										  <img data-original="<?php echo $playerInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  title="<?php echo $playerInfo['player_name'];?>" />
									</div>
									<span class="team_number_name"><?php echo $playerInfo['player_name']?></span>
                            </a>
                        </li>
                          <?php }}?>  
                    </ul>
					<?php }else{?>
						<div class="null">
							<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
						</div>
					<?php } ?>
                </div>
                <!-- 队员介绍 -->
                <!-- 战队数据 -->
                <div class="team_data mb20">
                    <div class="team_data_top clearfix">
                        <div class="team_data_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_data.png" alt="">
                        </div>
                        <span class="fl team_data_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队基础数据</span>
                        <div class="team_data_frequency fr clearfix">
                            <p class="matches_number fl">比赛场次：<span><?php echo $return['intergratedTeam']['data']['team_stat']['total_count']??0;?>场</span></p>
                            <p class="matches_rank fl">联赛排名：<span>第 <?php echo $return['intergratedTeam']['data']['team_stat']['victory_rate_rank']??9999;?></span></p>
                        </div>
                    </div>
                    <div class="team_data_items clearfix">
                        <div class="data_left fl">
                            <div class="circle_left clearfix">
                                <div class="won_all third circle fl" data-num="<?php echo  (isset($return['intergratedTeam']['data']['team_stat']['victory_rate']) && $return['intergratedTeam']['data']['team_stat']['victory_rate']>0 )? ($return['intergratedTeam']['data']['team_stat']['victory_rate']/100):0 ?>">
                                    <strong></strong>
                                </div>
                                <div class="circle_right fl">
                                    <div class="red">
                                        <div class="won_red circle" data-num="<?php echo  (isset($return['intergratedTeam']['data']['team_stat']['victory_rate']) && $return['intergratedTeam']['data']['team_stat']['victory_rate']>0 )? ($return['intergratedTeam']['data']['team_stat']['victory_rate']/100):0 ?>">
                                        </div>
                                        <div class="red_explain">
                                            <span class="rate_number"><?php echo $return['intergratedTeam']['data']['team_stat']['red_victory_rate']?? 0;?>%</span>
                                            <span class="rate_explain"><?php echo $return['intergratedTeam']['data']['team_stat']['red_count']?? 0;?>场<?php echo $return['intergratedTeam']['data']['team_stat']['red_win'] ?? 0;?>胜<?php echo $return['intergratedTeam']['data']['team_stat']['red_lose']??0;?>败</span>
                                            <span class="rate">红方胜率</span>
                                        </div>
                                    </div>
                                    <div class="blue">
                                        <div class="won_blue circle" data-num="<?php echo  (isset($return['intergratedTeam']['data']['team_stat']['victory_rate']) && $return['intergratedTeam']['data']['team_stat']['victory_rate']>0 )? ($return['intergratedTeam']['data']['team_stat']['victory_rate']/100):0 ?>">
                                        </div>
                                        <div class="blue_explain">
                                            <span class="rate_number"><?php echo $return['intergratedTeam']['data']['team_stat']['blue_victory_rate']??0;?>%</span>
                                            <span class="rate_explain"><?php echo $return['intergratedTeam']['data']['team_stat']['blue_count']??0;?>场<?php echo $return['intergratedTeam']['data']['team_stat']['blue_win']??0;?>胜<?php echo $return['intergratedTeam']['data']['team_stat']['blue_lose']??0;?>败</span>
                                            <span class="rate">蓝方胜率</span>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="data_right fr clearfix">
                            <?php
						 if(isset($return['intergratedTeam']['data']['team_stat']['base_ability_detail'])){
							  foreach($return['intergratedTeam']['data']['team_stat']['base_ability_detail'] as $key=>$basedetail)
							  { 
							  ?>
							  <?php if($key=='kda'){?>
								<div class="data_btn_all fl mb20">
									<span><?php echo $basedetail['score-num']??0?></span>
									<span>KDA·联赛第 <?php echo $basedetail['score-rank']??0?></span>
								</div>
							  <?php }elseif($key=='kills'){ ?>
								<div class="data_kill data_btn fl mb20">
									<p><?php echo $basedetail['score-num']??0?></p>
									<p><?php echo $basedetail['score-des']??0?></p>
									<p>联赛第<span><?php echo $basedetail['score-rank']??0?></span></p>
								</div>
							  <?php }elseif($key=='deaths'){?>
								 <div class="data_death data_btn fl">
									<p><?php echo $basedetail['score-num']??0?></p>
									<p><?php echo $basedetail['score-des']??0?></p>
									<p>联赛第<span><?php echo $basedetail['score-rank']??0?></span></p>
								</div>
							  
							  <?php }else{ ?>
								<div class="data_assists data_btn fl">
									<p><?php echo $basedetail['score-num']??0?></p>
									<p><?php echo $basedetail['score-des']??0?></p>
									<p>联赛第<span><?php echo $basedetail['score-rank']??0?></span></p>
								</div>
							  <?php } ?>
							  
							  <?php }}?>
                        </div>
                    </div>
                </div>
                <!-- 战队数据 -->
                <!-- 战队荣誉 -->
                <div class="team_honor mb20">
                    <div class="team_honor_top clearfix">
                        <div class="team_honor_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_honor.png" alt="">
                        </div>
                        <span class="fl team_honor_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队历史荣誉</span>
                    </div>
                    <div class="team_honor_detail">
						<?php if(isset($return['intergratedTeam']['data']['honor_list']) && count($return['intergratedTeam']['data']['honor_list'])>0 ){?>
                        <div class="honor_top clearfix">
                            <span>时间</span>
                            <span>荣誉/名次</span>
                            <span>赛事</span>
                            <span>赛况</span>
                        </div>
                        <ul class="honor_bottom">
                           <?php
						  foreach($return['intergratedTeam']['data']['honor_list'] as $honorInfo)
						  { 
							if($i<=3){
							?>
                            <li>
                                <a href="javascript:;" class="clearfix">
                                    <div class="w25">
                                        <?php echo $honorInfo['match_time']?>
                                    </div>
                                    <div class="w25 max_span">
                                        <div class="honor_bottom_img1">
											
                                            <img class="imgauto" src="<?php echo $honorInfo['ranking_icon']?>" alt="">
                                        </div>
                                        <span><?php echo $honorInfo['ranking']?></span>
                                    </div>
                                    <div class="w25 max_span">
                                        <div class="honor_bottom_img2">
											<img class="imgauto" src="<?php echo $honorInfo['t_image']?>" alt="">
                                        </div>
                                        <span><?php echo $honorInfo['t_name']?></span>
                                    </div>
                                    <div class="w25">
                                        <div class="honor_bottom_img2">
                                            <img class="imgauto" src="<?php echo $honorInfo['team_a_image']?>" alt="<?php echo $honorInfo['team_name_a']?>">
                                        </div>
                                        <div class="honor_bottom_vs">
                                            <span class="red span_left"><?php echo $honorInfo['team_a_win']?></span>
                                            <div class="honor_bottom_img1">
                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                            </div>
                                            <span class="blue span_right"><?php echo $honorInfo['team_b_win']?></span>
                                        </div>
                                        <div class="honor_bottom_img2">
                                            <img class="imgauto" src="<?php echo $honorInfo['team_b_image']?>" alt="<?php echo $honorInfo['team_name_b']?>">
                                        </div>
                                    </div>
                                </a>
                            </li>
							<?php $i++;} }?>
                            
                        </ul>
						<?php }else{?>
							 <div class="null">
								<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
							</div>
						<?php } ?>
                    </div>
                </div>
                <!-- 战队荣誉 -->
                <!-- 战队成绩 -->
                <div class="mb20 team_results">
                    <div class="team_results_top clearfix">
                        <div class="team_results_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/teamdetail_vs_active.png" alt="">
                        </div>
                        <span class="fl team_results_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队近期战绩</span>
                       
                    </div>
                    <div class="team_results_bottom">
						<?php if(isset($return['intergratedTeam']['data']['recentMatchList']) && count($return['intergratedTeam']['data']['recentMatchList'])>0 ){?>
                        <ul class="team_results_detail">
							  <?php
						  foreach($return['intergratedTeam']['data']['recentMatchList'] as $recentMatchInfo)
						  { 
							?>
                            <li>
                               <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $recentMatchInfo['match_id'];?>" class="clearfix">
							   
                                   <div class="team_results_explain fl clearfix">
                                         <?php if(in_array($recentMatchInfo['home_id'],$return['intergratedTeam']['data']['intergrated_site_id_list']['scoregg'])){$side = "home";}else{$side="away";}
									   if(($recentMatchInfo['home_score'] >= $recentMatchInfo['away_score'])){$win_side = "home";}else{$win_side="away";}
									  
									   if($side == $win_side)
									   {
										   ?>
												 <div class="team_result red fl">
													 胜
												 </div>
												 <?php 
									   }
									   else
									   {?>
												 <div class="team_result blue fl">
													 败
												 </div>
									   <?php
										}
									   ?>
                                        <div class="team_results_content clearfix fl">
                                            <div class="team_results_time fl">
                                                <div class="team_results_timg">
                                                    <img class="imgauto" src="<?php echo $recentMatchInfo['tournament_info']['logo'] ;?>" alt="<?php echo $recentMatchInfo['tournament_info']['tournament_name'] ;?>">
                                                </div>
                                                <div class="team_results_timei">
													<?php echo date("Y.m.d H:i",strtotime($recentMatchInfo['start_time']));?> Bo<?php echo $recentMatchInfo['game_count'] ;?>
                                                    
                                                </div>
                                            </div>
                                            <div class="team_results_vs">
                                                <span class="team1_name"><?php echo $recentMatchInfo['home_team_info']['team_name'] ;?></span>
                                                <div class="team1_img">
                                                    <img class="imgauto" data-original="<?php echo $recentMatchInfo['home_team_info']['logo'] ;?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $recentMatchInfo['home_team_info']['team_name'] ;?>">
                                                </div>
                                                <div class="vs_img honor_bottom_img1">
                                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                                </div>
                                                <div class="team2_img">
                                                    <img class="imgauto" data-original="<?php echo $recentMatchInfo['away_team_info']['logo'] ;?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"   alt="<?php echo $recentMatchInfo['away_team_info']['team_name'] ;?>">
                                                </div>
                                                <span class="team2_name"><?php echo $recentMatchInfo['away_team_info']['team_name'] ;?></span>
                                            </div>
                                        </div>
                                   </div>
                                   <div class="team_results_see fr">
                                    查看数据
                                   </div>
                               </a> 
                            </li>
						  <?php } ?>
                        </ul>
						<?php }else{?>
							 <div class="null">
								<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
							</div>
						<?php } ?>
                    </div>
                </div>
                <!-- 战队成绩 -->
                <!-- 战队资讯 -->
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队资讯</span>
                        <a href="<?php echo $config['site_url']; ?>/newslist/" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
					<?php if(isset($connectedInformationList) && count($connectedInformationList)>0){?>
                    <div class="team_news_mid">
                        <ul class="team_news_mid_ul clearfix">
							<?php foreach($connectedInformationList as $key => $information){
								if($key <=3){
									
								?>
                            <li>
                                <a href="<?php echo $config['site_url']; ?>/newsdetail/<?php echo $information['id'];?>">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" src="<?php echo $information['logo'];?>" alt="<?php echo $information['title'];?>">
                                        </div>
                                        <p><?php echo $information['title'];?></p>
                                    </div>
                                </a>
                            </li>
							<?php }} ?>
                            
                        </ul>
                    </div>
                    <div class="team_news_bot">
                        <ul class="team_news_bot_ul clearfix">
						<?php foreach($connectedInformationList as $key => $information){
								if($key >3){
								?>
                            <li class="fl">
                                <a href="<?php echo $config['site_url']; ?>/newsdetail/<?php echo $information['id'];?>">
                                    <?php echo $information['title'];?>
                                </a>
                            </li>
                            <?php }} ?>
                        </ul>
                    </div>
					<?php }else{?>
							 <div class="null">
								<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
							</div>
					<?php } ?>
                </div>
                <!-- 战队资讯 -->
                <!-- 热门战队 -->
                <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门战队</span>
                        <a href="<?php echo $config['site_url'];?>/teamlist/" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
					<?php if(isset($return2['hotTeamList']['data']) && count($return2['hotTeamList']['data'])>0){ ?>
                    <ul class="game_team_list_detail">
					<?php foreach($return2['hotTeamList']['data'] as $key => $teamInfo){
							?>
                        <li class="<?php if($key==1){ ?>active <?php }?> col-xs-6">
                            <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                <div class="a1">
                                    <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"   alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
                                </div>
                                <span><?php echo $teamInfo['team_name'];?></span>
                            </a>
                        </li>
					<?php }?>
                        
                    </ul>
					<?php }else{?>
						<div class="null">
							<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
						</div>
					<?php } ?>
                </div>
                <!-- 热门战队 -->
                <!-- 热门赛事 -->
                <div class="hot_match mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>/tournamentlist/" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
						<?php if(isset($return2['hotTournamentList']['data']) && count($return2['hotTournamentList']['data'])>0){?>
                        <ul class="clearfix">
						<?php foreach($return2['hotTournamentList']['data'] as $key => $tournamentInfo){
							?>
                            <li>
                                <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['tournament_id'];?>">
                                    <img src="<?php echo $tournamentInfo['logo'].$config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>" class="hot_match_bot_imgs">
                                   <span><?php echo $tournamentInfo['tournament_name'] ?></span>
                                </a>
                            </li>
							<?php }?>
                            
                        </ul>
						<?php }else{?>
							<div class="null">
								<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
							</div>
						<?php } ?>
                    </div>
                </div>  
                <!-- 热门赛事 -->
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
        <div class="suspension_img">
            <img src="<?php echo $config['site_url'];?>/images/suspension.png" alt="">
        </div>
        <div class="qrcode">
            <div class="qrcode_img">
                <img src="<?php echo $config['site_url'];?>/images/qrcode.png" alt="">
            </div>
        </div>
    </div>
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar","echarts.min","circle-progress"]);?>
    <script>

    var value = $('.won_all').data('num');
    $('.won_all.circle').circleProgress({
        value: value,
        size:208,
        lineCap:'round',
        fill: { gradient:['#FF6649'] },
        startAngle: -Math.PI / 4 * 2,
    }).on('circle-animation-progress', function(event, progress, stepValue) {
        $(this).find('strong').html(Math.round(stepValue*100*100)/100+ '<i>%</i><span>胜率</span>');
    });

    var value_red = $('.won_red').data('num');
    $('.won_red.circle').circleProgress({
        startAngle: -Math.PI / 4 * 2,
        size:94,
        value: value_red,
        lineCap: 'round',
        fill: { color: '#FF5C6A' }
    });

    var value_blue = $('.won_blue').data('num');
    $('.won_blue.circle').circleProgress({
        startAngle: -Math.PI / 4 * 2,
        size:94,
        value: value_blue,
        lineCap: 'round',
        fill: { color: '#0C8DFC' }
    });
    </script>
</body>

</html>