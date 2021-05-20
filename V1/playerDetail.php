<?php
require_once "function/init.php";
$pid = $_GET['pid']??0;
if($pid<=0)
{
    render404($config);
}
$params = [
    "intergratedPlayer"=>[$pid],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"player","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
if(!isset($return["intergratedPlayer"]['data']['pid']))
{
    render404($config);
}
//雷达图数据
$radarData=[];
if($return['intergratedPlayer']['data']['radarData']!="")
{
	$radarData=json_encode(array_values($return['intergratedPlayer']['data']['radarData']),JSON_UNESCAPED_UNICODE);
}


if($return['intergratedPlayer']['data']['description']!="")
{
    if(substr($return['intergratedPlayer']['data']['description'],0,1)=='"' && substr($return['intergratedPlayer']['data']['description'],-1)=='"')
    {
        $description =  html_entity_decode(json_decode($return['intergratedPlayer']['data']['description'],true));
    }
    else
    {
        $description =   html_entity_decode($return['intergratedPlayer']['data']['description']);

    }
}
else
{
    $description = "暂无";
}

//战队别称
if(count($return['intergratedPlayer']['data']['teamInfo']['aka'])>0){
	$return['intergratedPlayer']['data']['teamInfo']['aka']=implode(',',array_filter($return['intergratedPlayer']['data']['teamInfo']['aka']));
}
//战队描述
if($return['intergratedPlayer']['data']['teamInfo']['description']!="")
{
    if(substr($return['intergratedPlayer']['data']['teamInfo']['description'],0,1)=='"' && substr($return['intergratedPlayer']['data']['teamInfo']['description'],-1)=='"')
    {
        $team_description =  html_entity_decode(json_decode($return['intergratedPlayer']['data']['teamInfo']['description'],true));
    }
    else
    {
        $team_description =   html_entity_decode($return['intergratedPlayer']['data']['teamInfo']['description']);

    }
}
else
{
    $description = "暂无";
}

//队员别称
if(count($return['intergratedPlayer']['data']['aka'])>0){
	$return['intergratedPlayer']['data']['aka']=implode(',',array_filter($return['intergratedPlayer']['data']['aka']));
}

//获取当前战队的游戏
$game=$return['intergratedPlayer']['data']['game'] ?? $config['default_game'];
//当前游戏下面的资讯
$params2=[
	 "keywordMapList"=>["fields"=>"content_id","source_type"=>"player","source_id"=>$return["intergratedPlayer"]['data']['intergrated_id_list'],"page_size"=>10,"content_type"=>"information","list"=>["page_size"=>10,"fields"=>"id,title,create_time,logo"]],
	"hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>7,"fields"=>'tid,team_name,logo',"game"=>$game,"rand"=>1,"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"hotTournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>4,"game"=>$game,"source"=>"scoregg","rand"=>1,"cacheWith"=>"currentPage","cache_time"=>86400*7],
];


$return2 = curl_post($config['api_get'],json_encode($params2),1);
//如果战队资讯不存在
if(count($return2["keywordMapList"]["data"]??[])==0)
{
    $params3 = [
        "informationList"=>["dataType"=>"informationList","page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,create_time,game',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
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
      <title><?php echo $return['intergratedPlayer']['data']['player_name'];?>_<?php echo $config['game'][$game]?><?php echo  $return['intergratedPlayer']['data']['teamInfo']['team_name'] ?>战队<?php if(!in_array($return['intergratedPlayer']['data']['position'],["","?"])){echo $return['intergratedPlayer']['data']['position'];}?>选手<?php echo $return['intergratedPlayer']['data']['player_name'];?><?php echo $return['intergratedPlayer']['data']['cn_name'] ??'' ;?>个人简介资料信息-<?php echo $config['site_name']?>
	  </title>
  <meta name="description" content="<?php echo $config['site_name'];?>提供<?php echo $config['game'][$game]?><?php echo strip_tags($return['intergratedPlayer']['data']['teamInfo']['team_name']);?>战队<?php if(!in_array($return['intergratedPlayer']['data']['position'],["","?"])){echo $return['intergratedPlayer']['data']['position'];}?>选手<?php echo $return['intergratedPlayer']['data']['player_name'];?>个人信息资料，<?php echo $description ;?>">
	<meta name=”Keywords” Content=”<?php echo $return['intergratedPlayer']['data']['player_name'];?>个人信息,<?php echo $return['intergratedPlayer']['data']['player_name'];?>个人资料,<?php echo $config['game'][$game]?><?php echo $return['intergratedPlayer']['data']['teamInfo']['team_name'];?>战队<?php if(!in_array($return['intergratedPlayer']['data']['position'],["","?"])){echo $return['intergratedPlayer']['data']['position'];}?>选手<?php echo $return['intergratedPlayer']['data']['player_name'];?>信息简介">
	<?php renderHeaderJsCss($config,["playerdetail"]);?> 
    <!-- 这是本页面新增的css  playerdetail.css -->
   
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
                            <?php generateNav($config,"player");?>
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
                            <img class="imgauto" src="<?php echo $return['intergratedPlayer']['data']['logo'];?>" alt="<?php echo $return['intergratedPlayer']['data']['player_name'];?>">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <p class="name fl"><?php echo $return['intergratedPlayer']['data']['player_name'];?></p>
							<?php if(isset($return['intergratedPlayer']['data']['position']) && $return['intergratedPlayer']['data']['position'] !=''){ ?>
                            <div class="classify fl">
                                <div class="player_location">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/fuzhu.png" alt="">
                                </div>
                                <span><?php echo $return['intergratedPlayer']['data']['position'];?></span>
                            </div>
							<?php } ?>
                        </div>
                        <div class="team_explain_name clearfix">
                            <p class="clearfix fl">英文名：<span class="English_name fr"><?php echo $return['intergratedPlayer']['data']['en_name'] ?></span></p>
                            <p class="clearfix fl">别称：<span class="chinese_name fr"><?php echo $return['intergratedPlayer']['data']['aka'] ?></span></p>
                            <p class="clearfix fl">昵称：<span class="English_name fr"><?php echo $return['intergratedPlayer']['data']['player_name'];?></span></p>
                            <p class="clearfix fl">地区：<span class="chinese_name fr"><?php echo $return['intergratedPlayer']['data']['country'];?></span></p>
                        </div>
                        <div class="team_explain_bottom">
                            <?php echo $description;?>
                        </div>
                    </div>
                </div>
                <!-- 战队介绍 -->
                <!-- 基础数据 -->
                <div class="mb20 player_data">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/player_data.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">基础数据</span>
                        
                    </div>
                    <div class="player_data_detail clearfix">
                        <div class="radar fl">
                            <div id="chart" style="height: 280px;width: 240px" ></div>
                        </div>
                        <div class="player_data_content fr">
                            <div class="player_data_top clearfix">
                                <div class="circle_right fl">
                                    <div class="win_rate">
                                        <div class="win_rate1 circle" data-num="<?php echo  (isset($return['intergratedPlayer']['data']['player_stat']['victory_rate']) && $return['intergratedPlayer']['data']['player_stat']['victory_rate']>0 )? ($return['intergratedPlayer']['data']['player_stat']['victory_rate']/100):0 ?>">
                                        </div>
                                        <div class="red_explain">
                                            <span class="rate_number"><?php echo $return['intergratedPlayer']['data']['player_stat']['victory_rate']?? 0;?>%</span>
                                            <span class="rate_explain">胜率</span>
                                            <span class="rate"><?php echo $return['intergratedPlayer']['data']['player_stat']['total_count']?? 0;?>场<?php echo $return['intergratedPlayer']['data']['player_stat']['win']?? 0;?>胜<?php echo $return['intergratedPlayer']['data']['player_stat']['lose']?? 0;?>败</span>
                                        </div>
                                    </div>
                                    <div class="part_rate">
                                        <div class="part_rate1 circle" data-num="<?php echo  (isset($return['intergratedPlayer']['data']['player_stat']['join_rate']) && $return['intergratedPlayer']['data']['player_stat']['join_rate']>0 )? ($return['intergratedPlayer']['data']['player_stat']['join_rate']/100):0 ?>">
                                        </div>
                                        <div class="blue_explain">
                                            <span class="rate_number"><?php echo $return['intergratedPlayer']['data']['player_stat']['join_rate']?? 0;?>%</span>
                                            <span class="rate_explain">参团率</span>
                                            <span class="rate">联赛第<i><?php echo $return['intergratedPlayer']['data']['player_stat']['join_rank']?? 0;?></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="kpi_all fr">
                                    <span><?php echo $return['intergratedPlayer']['data']['player_stat']['kda']?? 0;?></span>
                                    <span>KDA·联赛第 <?php echo $return['intergratedPlayer']['data']['player_stat']['kda_rank']?? 0;?></span>
                                </div>
                            </div>
                            <div class="player_data_bot clearfix">
								 <?php
						 if(isset($return['intergratedPlayer']['data']['player_stat']['base_ability_detail'])){
							  foreach($return['intergratedPlayer']['data']['player_stat']['base_ability_detail'] as $key=>$basedetail)
							  { if($key !='kda'){
							  ?>
                                <div class="player_data_cell">
                                    <span class="num1"><?php echo $basedetail['score-num']??0?></span>
                                    <p><?php echo $basedetail['score-des']??''?>&nbsp;<span>联赛第</span><i><?php echo $basedetail['score-rank']??0?></i></p>
                                </div>
							  <?php }}}?> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 基础数据 -->
                <!-- 比赛战绩 -->
                <div class="mb20 player_record">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/player_match.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">kaixuan比赛战绩</span>
                        
                    </div>
                    <div class="scroll">
						<?php if(isset($return['intergratedPlayer']['data']['recentMatchList']) && count($return['intergratedPlayer']['data']['recentMatchList'])>0 ){?>
                        <div class="player_matchs_name">
                            <span class="span1">时间</span>
                            <span class="span2">对阵</span>
                            <span class="span3">英雄</span>
                            <span class="span4">KDA</span>
                            <span class="span5">出装</span>
                            <span class="span6">技能</span>
                            <span class="span7">符文</span>
                        </div>
                        <ul class="player_matchs_content">
							<?php
						  foreach($return['intergratedPlayer']['data']['recentMatchList'] as $recentMatchInfo)
						  { 
								if(in_array($recentMatchInfo['home_id'],$return['intergratedPlayer']['data']['teamInfo']['intergrated_site_id_list'])){$side = "home";}else{$side="away";}
							   if(($recentMatchInfo['home_score'] >= $recentMatchInfo['away_score'])){$win_side = "home";}else{$win_side="away";}
								if(count($recentMatchInfo['player_detail'])>0)
								{
									foreach($recentMatchInfo['player_detail'] as $round_key => $round_detail)
									{
										
										
										?>
										<li class="<?php if($side == $win_side){  ?>red<?php }else{ ?>blue<?php } ?>">
											<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $recentMatchInfo['match_id'];?>">
												<div class="player_matchs_div1">
													<span class="result"><?php if($side == $win_side){  ?>胜<?php }else{ ?>败<?php } ?></span>
													<span class="time"><?php echo date("Y.m.d",strtotime($recentMatchInfo['start_time'])+$config['hour_lag']*3600);?></span>
												</div>
												<div class="player_matchs_div2">
													<div class="team1">
														<img class="imgauto" src="<?php echo $recentMatchInfo['home_team_info']['logo'] ;?>" alt="<?php echo $recentMatchInfo['home_team_info']['team_name'] ;?>">
													</div>
													<div class="player_vs">GAME <?php echo $round_key+1;?></div>
													<div class="team2">
														<img class="imgauto" src="<?php echo $recentMatchInfo['away_team_info']['logo'] ;?>" alt="<?php echo $recentMatchInfo['away_team_info']['team_name'] ;?>">
													</div>
												</div>
												<div class="player_matchs_div3">
													<div class="player_matchs_div3_img">
														<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
															if((strpos($round_son_key,'hero_')!==false) && (strpos($round_son_key,'pic')!==false) ){
														?>
													
														<img class="imgauto" src="<?php echo $round_son_detail; ?>" alt="">
															<?php }}?>
													</div>
												</div>
												<div class="player_matchs_div4">
													<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
													if((strpos($round_son_key,'star_')!==false) && (strpos($round_son_key,'_kills')!==false) ){
														echo $round_son_detail;
													}}?>/<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
													if((strpos($round_son_key,'star_')!==false) && (strpos($round_son_key,'_deaths')!==false) ){
														echo $round_son_detail;
													}}?>/<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
													if((strpos($round_son_key,'star_')!==false) && (strpos($round_son_key,'_assists')!==false) ){
														echo $round_son_detail;
													}}?>
												
												</div>
												<div class="player_matchs_div5 clearfix">
													<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
															if((strpos($round_son_key,'star_')!==false) && (strpos($round_son_key,'equip_')!==false) ){
														?>
													<div>
														<img src="<?php echo $round_son_detail; ?>" class="imgauto" alt="">
													</div>
													<?php }}?>
													
													
												</div>
												<div class="player_matchs_div6 clearfix">
													<?php foreach($round_detail as $round_son_key=>$round_son_detail){ 
															if((strpos($round_son_key,'skill_')!==false) ){
														?>
													<div>
														<img src="<?php echo $round_son_detail; ?>" class="imgauto" alt="">
													</div>
													<?php }}?>
												</div>
												<div class="player_matchs_div7 clearfix">
													<div>
														<img src="<?php echo $config['site_url'];?>/images/game_skills1.png" class="imgauto" alt="">
													</div>
													<div>
														<img src="<?php echo $config['site_url'];?>/images/game_skills2.png" class="imgauto" alt="">
													</div>
												</div>
											</a>
										</li>

									<?php }}?>
                            
						  <?php }?>
                        </ul>
						<?php }else{?>
							 <div class="null">
								<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
							</div>
						<?php } ?>
                    </div>
                </div>
                <!-- 比赛战绩 -->
                <!-- 战队介绍和队员介绍 -->
                <div class="player_explain clearfix mb20">
                    <div class="player_team_explain fl">
                        <div class="team_pub_top clearfix">
                            <div class="team_pub_img fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                            </div>
                            <span class="fl team_pbu_name"><?php echo  $return['intergratedPlayer']['data']['teamInfo']['team_name'] ?>战队简介</span>
                        </div>
                        <div class="player_team_bot clearfix">
                            <div class="left fl">
                                <img class="imgauto"  src="<?php echo  $return['intergratedPlayer']['data']['teamInfo']['logo']?>?x-oss-process=image/resize,m_lfit,h_100,w_100" alt="<?php echo  $return['intergratedPlayer']['data']['teamInfo']['team_name'] ?>">
                            </div>
                            <div class="right fl">
                                <div class="team_explain_top clearfix">
                                    <p class="name fl"><?php echo  $return['intergratedPlayer']['data']['teamInfo']['team_name'] ?></p>
                                    <p class="classify fl"><?php if($return['intergratedPlayer']['data']['teamInfo']['game']=='lol'){?>英雄联盟<?php }elseif($return['intergratedPlayer']['data']['teamInfo']['game']=='kpl'){ ?>王者荣耀<?php }elseif($return['intergratedPlayer']['data']['teamInfo']['game']=='dota2'){ ?>DOTA2<?php } ?></p>
                                </div>
                                <p class="name">英文名：<span><?php echo  $return['intergratedPlayer']['data']['teamInfo']['en_name'] ?></span></p>
                                <p class="name">别&nbsp;&nbsp;&nbsp;称：<span><?php echo  $return['intergratedPlayer']['data']['teamInfo']['aka'] ?></span></p>
                            </div>
                        </div>
                        <div class="player_team_word">
                           <?php echo $team_description; ?>
                        </div>
                    </div>
                    <div class="player_xs_explain fr">
                        <div class="team_pub_top clearfix">
                            <div class="team_pub_img fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_number.png" alt="">
                            </div>
                            <span class="fl team_pbu_name"><?php echo $return['intergratedPlayer']['data']['player_name'];?>队友</span>
                        </div>
						<?php if(isset($return['intergratedPlayer']['data']['playerList']) && count($return['intergratedPlayer']['data']['playerList'])>0 ){?>
                        <ul class="player_xs clearfix">
							 <?php
								foreach($return['intergratedPlayer']['data']['playerList'] as $playerInfo)
								{  ?>
                            <li>
                                <a href="<?php echo $config['site_url']; ?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                    <div class="player_xs_img">
                                        <img class="imgauto" data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>" title="<?php echo $playerInfo['player_name'];?>" alt="<?php echo $playerInfo['player_name'];?>">
                                    </div>
                                    <span><?php echo $playerInfo['player_name'];?></span>
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
                <!-- 战队介绍和队员介绍 -->
                <!-- 战队资讯 -->
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name"><?php echo $return['intergratedPlayer']['data']['player_name'];?>资讯</span>
                        <a href="<?php echo $config['site_url'];?>/newslist/" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
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
					<?php if(isset($return2['hotTeamList']['data'] ) && count($return2['hotTeamList']['data'] )>0){ ?>
                    <ul class="game_team_list_detail">
						<?php foreach($return2['hotTeamList']['data'] as $key => $teamInfo){
							?>
                        <li class="<?php if($key==1){ ?>active <?php }?> col-xs-6">
                            <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                <div class="a1">
                                    <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
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
                                <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['tournament_id'];?>" style="background-image: url('<?php echo $tournamentInfo['logo'] ?>')">
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
    <script src="<?php echo $config['site_url'];?>/js/jquery.min.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/echarts.min.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/index.js"></script>
    <script src="<?php echo $config['site_url'];?>/js/jquery.lineProgressbar.js"></script>
    <!-- 这是本页新增的js -->
    <script src="<?php echo $config['site_url'];?>/js/circle-progress.js"></script>
	<script src="<?php echo $config['site_url'];?>/js/jquery.lazyload.js"></script>
    <script>
        var radar_chart = echarts.init(document.getElementById("chart"));
        // var kill = $('#chart').data('kill');
        // var assists = $('#chart').data('assists');
        // var existence = $('#chart').data('existence');
        // var rate = $('#chart').data('rate');
        // var economy = $('#chart').data('economy');
        // var view = $('#chart').data('view');
         // var value = [kill, assists, existence, rate, economy, view];
            var array=<?php echo $radarData;?>;
 
            //先给数组中的每一个元素添加索引(index)
            var i;
            for(i=0;i<array.length;i++){
                array[i].index=i;
            }

        var value = [array[0].empno, array[1].empno, array[2].empno, array[3].empno ,array[4].empno ,array[5].empno, ];
        var option = {
            // tooltip: {},
            radar: {
                name: {
                    textStyle: {
                        color: '#333',
                        backgroundColor: '#fff',
                        fontSize: 14,
                    }
                },
                //指示器轴的分割段数
                splitNumber: 4,
                axisTick: {
                    color: '#eee',

                },
                indicator: [
                    { name: array[0].name, max: 100 },
                    { name: array[1].name, max: 100 },
                    { name: array[2].name, max: 100 },
                    { name: array[3].name, max: 100 },
                    { name: array[4].name, max: 100 },
                    { name: array[5].name, max: 100 },
                    
                   
                ],
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: '#fff'
                        // 图表背景网格的颜色
                    }
                },
                splitLine: {
                    show: true,
                    lineStyle: {
                        width: 2,
                        color: '#eee'
                        // 图表背景网格线的颜色
                    }
                },
                axisLine: {
                    show: true,
                    lineStyle: {
                        width: 2,
                        color: '#eee',

                    },

                },
            },
            series: [{
                type: 'radar',
                areaStyle: {
                    normal: {
                        opacity: 0.6,
                        color: new echarts.graphic.LinearGradient(         // 设置渐变色
                            0, 0, 0, 1,
                            [
                                { offset: 0, color: 'rgba(255, 92, 106, 1)' },
                                { offset: 1, color: 'rgba(255, 102, 73, 1)' }
                            ]
                        )
                    }
                },
                symbolSize: 0,
                itemStyle: {
                    normal: {
                        color: '#fff',
                    }
                },
                data: [
                    {
                        value: value,
                    },
                ]
            }]
        };
        radar_chart.setOption(option);

    </script>
    <script>    
        var win_rate1 = $('.win_rate1').data('num');
        $('.win_rate1.circle').circleProgress({
            startAngle: -Math.PI / 4 * 2,
            size:94,
            value: win_rate1,
            lineCap: 'round',
            fill: { color: '#FF6649' }
        });
    
        var part_rate1 = $('.part_rate1').data('num');
        $('.part_rate1.circle').circleProgress({
            startAngle: -Math.PI / 4 * 2,
            size:94,
            value: part_rate1,
            lineCap: 'round',
            fill: { color: '#FF6649' }
        });
        </script>
</body>

</html>