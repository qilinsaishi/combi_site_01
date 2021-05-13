<?php
require_once "function/init.php";
$tid = $_GET['tid']??0;
if($tid<=0)
{
    render404($config);
}
$params = [
    "intergratedTeam"=>[$tid,"reset"=>1],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"team","site_id"=>$config['site_id']]
];

$return = curl_post($config['api_get'],json_encode($params),1);
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
	$return['intergratedTeam']['data']['aka']=implode(',',$return['intergratedTeam']['data']['aka']);
}

//获取当前战队的游戏
$game=$return['intergratedTeam']['data']['game'] ?? $config['default_game'];
//当前游戏下面的资讯
$params2=[
    "informationList"=>["dataType"=>"informationList","page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,site_time,game',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
	"hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>7,"fields"=>'tid,team_name,logo',"game"=>$game,"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"hotTournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>4,"game"=>$game,"source"=>"scoregg","rand"=>1,"cacheWith"=>"currentPage","cache_time"=>86400*7],
];
$return2 = curl_post($config['api_get'],json_encode($params2),1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $return['intergratedTeam']['data']['team_name'];?>电子竞技俱乐部_<?php echo $return['intergratedTeam']['data']['team_name'];?>战队_<?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部成员介绍-<?php echo $config['site_name'];?></title>
    <meta name="description" content="<?php echo strip_tags($return['intergratedTeam']['data']['description']);?>">
    <meta name=”Keywords” Content=”<?php echo $return['intergratedTeam']['data']['team_name'];?>电子竞技俱乐部,<?php
    if(substr_count($return['intergratedTeam']['data']['team_name'],"战队")==0){echo $return['intergratedTeam']['data']['team_name'].'战队,';}?><?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部成员介绍″>
    
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
                            <p class="classify fl"><?php if($return['intergratedTeam']['data']['game']=='lol'){?>英雄联盟<?php }elseif($return['intergratedTeam']['data']['game']=='kpl'){ ?>王者荣耀<?php } ?></p>
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
                    <ul class="team_member_detail clearfix">
						 <?php
						  foreach($return['intergratedTeam']['data']['playerList'] as $playerInfo)
						  { if(strlen($playerInfo['logo']) >=10){
							  ?>
							<li>
								<a href="<?php echo $config['site_url']; ?>/playerlist/<?php echo $playerInfo['pid'];?>">
									<div class="team_number_photo">
										<?php if(isset($return['defaultConfig']['data']['default_player_img'])){?>
										  <img lazyload="true" data-original="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" src="<?php echo $playerInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" title="<?php echo $playerInfo['player_name'];?>" />
									  <?php }else{?>
										  <img src="<?php echo $playerInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" title="<?php echo $playerInfo['player_name'];?>" />
									  <?php }?>
									</div>
									<span class="team_number_name"><?php echo $playerInfo['player_name']?></span>
                            </a>
                        </li>
                          <?php }}?>  
                    </ul>
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
                            <p class="matches_number fl">比赛场次：<span><?php echo $return['intergratedTeam']['data']['team_stat']['total_count'];?>场</span></p>
                            <p class="matches_rank fl">联赛排名：<span>第 <?php echo $return['intergratedTeam']['data']['team_stat']['victory_rate_rank'];?></span></p>
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
                                            <span class="rate_explain"><?php echo $return['intergratedTeam']['data']['team_stat']['red_count']?? 0;?>场<?php echo $return['intergratedTeam']['data']['team_stat']['red_win'] ?? 0;?>胜<?php echo $return['intergratedTeam']['data']['team_stat']['red_lose'];?>败</span>
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
                    </div>
                </div>
                <!-- 战队荣誉 -->
                <!-- 战队成绩 -->
                <div class="mb20 team_results">
                    <div class="team_results_top clearfix">
                        <div class="team_results_img fl">
                            <img class="imgauto" src="./images/teamdetail_vs_active.png" alt="">
                        </div>
                        <span class="fl team_results_name"><?php echo $return['intergratedTeam']['data']['team_name'];?>战队近期战绩</span>
                        <a href="##" class="team_results_more fr">
                            <span>更多</span>
                            <img src="./images/more.png" alt="">
                        </a>
                    </div>
                    <div class="team_results_bottom">
                        <ul class="team_results_detail">
                            <li>
                               <a href="##" class="clearfix">
                                   <div class="team_results_explain fl clearfix">
                                        <div class="team_result red fl">
                                            胜
                                        </div>
                                        <div class="team_results_content clearfix fl">
                                            <div class="team_results_time fl">
                                                <div class="team_results_timg">
                                                    <img class="imgauto" src="./images/kpl_teamdetail.png" alt="">
                                                </div>
                                                <div class="team_results_timei">
                                                    2021.04.11 15:00 Bo3
                                                </div>
                                            </div>
                                            <div class="team_results_vs">
                                                <span class="team1_name">Team WE</span>
                                                <div class="team1_img">
                                                    <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                </div>
                                                <div class="vs_img honor_bottom_img1">
                                                    <img class="imgauto" src="./images/game_detail_vs.png" alt="">
                                                </div>
                                                <div class="team2_img">
                                                    <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                </div>
                                                <span class="team2_name">Team WE</span>
                                            </div>
                                        </div>
                                   </div>
                                   <div class="team_results_see fr">
                                    查看数据
                                   </div>
                               </a> 
                            </li>
                            <li>
                                <a href="##" class="clearfix">
                                    <div class="team_results_explain fl clearfix">
                                         <div class="team_result blue fl">
                                             败
                                         </div>
                                         <div class="team_results_content clearfix fl">
                                             <div class="team_results_time fl">
                                                 <div class="team_results_timg">
                                                     <img class="imgauto" src="./images/kpl_teamdetail.png" alt="">
                                                 </div>
                                                 <div class="team_results_timei">
                                                     2021.04.11 15:00 Bo3
                                                 </div>
                                             </div>
                                             <div class="team_results_vs">
                                                 <span class="team1_name">Team WE</span>
                                                 <div class="team1_img">
                                                     <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                 </div>
                                                 <div class="vs_img honor_bottom_img1">
                                                     <img class="imgauto" src="./images/game_detail_vs.png" alt="">
                                                 </div>
                                                 <div class="team2_img">
                                                     <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                 </div>
                                                 <span class="team2_name">Team WE</span>
                                             </div>
                                         </div>
                                    </div>
                                    <div class="team_results_see fr">
                                     查看数据
                                    </div>
                                </a> 
                             </li>
                             <li>
                                <a href="##" class="clearfix">
                                    <div class="team_results_explain fl clearfix">
                                         <div class="team_result red fl">
                                             胜
                                         </div>
                                         <div class="team_results_content clearfix fl">
                                             <div class="team_results_time fl">
                                                 <div class="team_results_timg">
                                                     <img class="imgauto" src="./images/kpl_teamdetail.png" alt="">
                                                 </div>
                                                 <div class="team_results_timei">
                                                     2021.04.11 15:00 Bo3
                                                 </div>
                                             </div>
                                             <div class="team_results_vs">
                                                 <span class="team1_name">Team WE</span>
                                                 <div class="team1_img">
                                                     <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                 </div>
                                                 <div class="vs_img honor_bottom_img1">
                                                     <img class="imgauto" src="./images/game_detail_vs.png" alt="">
                                                 </div>
                                                 <div class="team2_img">
                                                     <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                 </div>
                                                 <span class="team2_name">Team WE</span>
                                             </div>
                                         </div>
                                    </div>
                                    <div class="team_results_see fr">
                                     查看数据
                                    </div>
                                </a> 
                             </li>
                             <li>
                                 <a href="##" class="clearfix">
                                     <div class="team_results_explain fl clearfix">
                                          <div class="team_result blue fl">
                                              败
                                          </div>
                                          <div class="team_results_content clearfix fl">
                                              <div class="team_results_time fl">
                                                  <div class="team_results_timg">
                                                      <img class="imgauto" src="./images/kpl_teamdetail.png" alt="">
                                                  </div>
                                                  <div class="team_results_timei">
                                                      2021.04.11 15:00 Bo3
                                                  </div>
                                              </div>
                                              <div class="team_results_vs">
                                                  <span class="team1_name">Team WE</span>
                                                  <div class="team1_img">
                                                      <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                  </div>
                                                  <div class="vs_img honor_bottom_img1">
                                                      <img class="imgauto" src="./images/game_detail_vs.png" alt="">
                                                  </div>
                                                  <div class="team2_img">
                                                      <img class="imgauto" src="./images/teamdetail1.png" alt="">
                                                  </div>
                                                  <span class="team2_name">Team WE</span>
                                              </div>
                                          </div>
                                     </div>
                                     <div class="team_results_see fr">
                                      查看数据
                                     </div>
                                 </a> 
                              </li>
                        </ul>
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
                    <div class="team_news_mid">
                        <ul class="team_news_mid_ul clearfix">
							<?php foreach($return2['informationList']['data'] as $key => $information){
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
						<?php foreach($return2['informationList']['data'] as $key => $information){
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
                </div>
                <!-- 战队资讯 -->
                <!-- 热门战队 -->
                <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门战队</span>
                        <a href="<?php echo $config['site_url'];?>/teamlist/<?php echo $game; ?>" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <ul class="game_team_list_detail">
					<?php foreach($return2['hotTeamList']['data'] as $key => $teamInfo){
							?>
                        <li class="<?php if($key==1){ ?>active <?php }?> col-xs-6">
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
                <!-- 热门战队 -->
                <!-- 热门赛事 -->
                <div class="hot_match mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="./images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>/tournament/" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="./images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
						<?php foreach($return2['hotTournamentList']['data'] as $key => $tournamentInfo){
							?>
                            <li>
                                <a href="##" style="background-image: url('<?php echo $tournamentInfo['logo'] ?>')">
                                   <span><?php echo $tournamentInfo['tournament_name'] ?></span> 
                                </a>
                            </li>
							<?php }?>
                            
                        </ul>
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
  
    <!-- 这是本页新增的js -->
	<script src="<?php echo $config['site_url'];?>/js/jquery.min.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/index.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/jquery.lineProgressbar.js"></script>
    <!-- 这是本页新增的js -->
    <script src="<?php echo $config['site_url'];?>/js/circle-progress.js"></script>
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

    var value_blue = $('.won_red').data('num');
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