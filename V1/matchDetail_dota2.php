<?php
require_once "function/init.php";

$match_id = $_GET['match_id']??0;
$game='dota2';
$match_id=intval($match_id);
/*if(!isset($match_id ) ||$match_id==0 )
{
    render404($config);
}*/
$source=$config['game_source'][$game]??$config['default_source'];

$params = [
    "matchDetail"=>["source"=>$source,"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_hero_img","default_tournament_img","default_skills_img","default_fuwen_img","default_information_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"page_size"=>3,"source"=>$source,"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>$game,"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$source,"site_id"=>$config['site_id']]
];

$return = curl_post($config['api_get'],json_encode($params),1);
$return['matchDetail']['data']['match_pre']=json_decode($return['matchDetail']['data']['match_pre'],true);

if(isset($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])>0){
    array_multisort(array_column($return['matchDetail']['data']['match_data']['matchData'],"boxNum"),SORT_ASC,$return['matchDetail']['data']['match_data']['matchData']);
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
    <title><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>比赛数据比分直播视频_<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>-<?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>,<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>比赛">
    <meta name="description" content="<?php echo $config['site_name'];?>提供<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>比赛数据,了解<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>在<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>的表现,请关注<?php echo $config['site_name'];?>">
    <?php renderHeaderJsCss($config,["game","right","progress-bars","dota2"]);?>

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
                        <?php generateNav($config,"game");?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row clearfix">
            <div class="game_left">
                <div class="game_title">
                    <div class="game_title_top">
                        <!--<div >-->
							<a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>" class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1"> 
                                    <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name']??'';?></span>
							</a>
                        <!--</div>-->
                        <div class="game_type">
                            <span class="span1"><?php echo $config['game'][$game];?></span>
                            <span class="span2"><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'] ?? '';?></span>
                            <div class="game_vs">
                                <span class="span1"><?php echo $return['matchDetail']['data']['away_score']??'0';?></span>
                                <img src="<?php echo $config['site_url'];?>/images/vs.png" alt="">
                                <span class="span2"><?php echo $return['matchDetail']['data']['home_score']??'0';?></span>
                            </div>
                            <p><?php echo date("Y.m.d H:i",strtotime($return['matchDetail']['data']['start_time']))?>·<?php echo generateMatchStatus($return['matchDetail']['data']['start_time']);?></p>
                        </div>
                        <!--<div >-->
							<a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>" class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name']??'';?></span>
							</a>
                        <!--</div>-->
                    </div>
                    <div class="game_team_depiction">
                        <p class="active"><!--主队描述--><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['away_team_info']['description'])));?></p>
                        <p class="active"><!--客队描述--><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['home_team_info']['description'])));?></p>
                    </div>
                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="" class="game_title_more">
                </div>
                <div class="dota2">
                    <ul class="dota2_ul1 clearfix mb20">
                        <li class="active">
                            赛前分析
                        </li>
                        <li >
                            比赛详情
                        </li>
                    </ul>
                    <div class="dota2_div">
                        <!-- 赛前分析 -->
                        <div class="dota2_item active">
                            <div class="dota2_top">
                                <img src="<?php echo $config['site_url'];?>/images/dota2_recent.png" alt="">
                                <span>近期战队数据对比</span>
                            </div>
                            <div class="dota2_div1_team">
                                
								<a class="teamInfo " href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>">
                                    <div class="colorBlock colorBlock_right red"></div>
									
                                    <div class="teamInfo_img">
										
                                        <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>"  class="imgauto">
									
                                    </div>
                                    <span class="text_left"><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
									</a>
									
                                
                                <div class="dota2_vs">
                                    <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                </div>
								<a class="teamInfo teamInfo_reverse" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>">
                                    <div class="colorBlock blue"></div>
									
                                    <div class="teamInfo_img">
                                        <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
										
                                    </div>
                                    <span class="text_right"><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
									</a>
                               
                            </div>
                            <div class="bpBox">
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dred third circle" data-num="<?php 
										$awayWinRate=round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']/($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']+$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['loseCount']),2);
										echo $awayWinRate;?>">
                                            <strong>
                                                <p></p>
                                                <span>胜率</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']??'0';?>胜<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['loseCount']??'0';?>负</p>
                                        <p class="bpBox_kda red">KDA：<?php echo round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['kda']??'0',2);?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgKill']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgDie']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgAssists']??'0';?></p>
                                    </div>
                                </div>
                                <div class="center">
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??'0';?></span>
											<div class="average_time">局均经济</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgEconomics=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??0;
												 $avgEconomics1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??0;
												 $totalAvgEconomics=($avgEconomics+$avgEconomics1);
												echo ($avgEconomics1/$totalAvgEconomics)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width:<?php 
												 $avgEconomics=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??0;
												 $avgEconomics1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??0;
												 $totalAvgEconomics=($avgEconomics+$avgEconomics1);
												
												echo ($avgEconomics/$totalAvgEconomics)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??'0';?></span>
											<div class="average_time">局均补刀</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgSoldiers=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??0;
												 $avgSoldiers1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??0;
												 $totalAvgSoldiers=($avgSoldiers+$avgSoldiers1);
												echo ($avgSoldiers1/$totalAvgSoldiers)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgSoldiers=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??0;
												 $avgSoldiers1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??0;
												 $totalAvgSoldiers=($avgSoldiers+$avgSoldiers1);
												echo ($avgSoldiers/$totalAvgSoldiers)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												echo date("i",$avgLengthTime);
												 ?>'<?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												echo date("s",$avgLengthTime);
												 ?>"</span>
											<span class="fr time2"><?php 
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												echo date("i",$avgLengthTime1);
												 ?>'<?php 
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												echo date("s",$avgLengthTime1);
												 ?>"</span>
											<div class="average_time">局均时长</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												 $totalAvgLengthTime=($avgLengthTime+$avgLengthTime1);
												echo ($avgLengthTime1/$totalAvgLengthTime)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												 $totalAvgLengthTime=($avgLengthTime+$avgLengthTime1);
												echo ($avgLengthTime/$totalAvgLengthTime)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??'0';?></span>
											<div class="average_time">局均输出</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgOutput=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??0;
												 $avgOutput1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??0;
												 $totalAvgOutput=($avgOutput+$avgOutput1);
												echo ($avgOutput1/$totalAvgOutput)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgOutput=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??0;
												 $avgOutput1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??0;
												 $totalAvgOutput=($avgOutput+$avgOutput1);
												echo ($avgOutput/$totalAvgOutput)*100; ?>%;"></span>
											</div>
										</div>
									</div>
                                    
                                </div>
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dblue third circle" data-num="<?php 
										$homeWinRate=round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']/($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']+$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['loseCount']),2);echo $homeWinRate;?>">
                                            <strong>
                                                <p></p>
                                                <span>胜率</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']??'0';?>胜<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['loseCount']??'0';?>负</p>
                                        <p class="bpBox_kda blue">KDA：<?php echo round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['kda']??'0',2);?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgKill']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgDie']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgAssists']??'0';?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="barChart">
									<div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstBloodRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstBloodRate']??'0';
												echo ($firstBloodRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstBloodRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstBloodRate']??'0';
												echo ($firstBloodRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height:<?php 
												$firstBloodRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstBloodRate']??'0';
												echo ($firstBloodRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstBloodRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstBloodRate']??'0';
												echo ($firstBloodRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">一血率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstTowerRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstTowerRate']??'0';
												echo ($firstTowerRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstTowerRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstTowerRate']??'0';
												echo ($firstTowerRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$firstTowerRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstTowerRate']??'0';
												echo ($firstTowerRate1*100);?>%;">
                                                    <span class="bar_rate"> <?php 
												$firstTowerRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstTowerRate']??'0';
												echo ($firstTowerRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">一塔率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$fiveKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['fiveKillRate']??'0';
												echo ($fiveKillRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$fiveKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['fiveKillRate']??'0';
												echo ($fiveKillRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$fiveKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['fiveKillRate']??'0';
												echo ($fiveKillRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$fiveKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['fiveKillRate']??'0';
												echo ($fiveKillRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">五杀率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$tenKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['tenKillRate']??'0';
												echo ($tenKillRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$tenKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['tenKillRate']??'0';
												echo ($tenKillRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$tenKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['tenKillRate']??'0';
												echo ($tenKillRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$tenKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['tenKillRate']??'0';
												echo ($tenKillRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">十杀率</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstRoushanRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstRoushanRate']??0;
												echo ($firstRoushanRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstRoushanRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstRoushanRate']??0;
												echo ($firstRoushanRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$firstRoushanRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstRoushanRate']??0;
												echo ($firstRoushanRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstRoushanRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstRoushanRate']??0;
												echo ($firstRoushanRate1*100);?>%</span>
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
										<?php if(isset($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList']) && count($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList'])>0){
											foreach($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList'] as $battleDetailInfo){?>
                                        <div class="row1">
                                            <span title="cSc" class="td elips flex15">
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
                                                    
                                            </span>
                                            <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips"><?php echo $battleDetailInfo['tournamentName'] ??''; ?></span>
                                                    <span class="leagueTime"><?php echo date("Y-m-d H:i:s",substr($battleDetailInfo['matchTime'] ??0,0,-3));?></span>
                                                </span>
                                            <span class="td flex15"><?php echo date("i",$battleDetailInfo['lengthTime']??0 );?>分<?php echo date("s",$battleDetailInfo['lengthTime']??0 );?>秒</span>
                                            <span title="<?php  if( $battleDetailInfo['direWin']==1 ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>" class="td elips flex15">
											<?php  if( $battleDetailInfo['direWin']==1 ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
													
                                               
                                                </span>
                                            <span class="td">
											
                                                    <span class="span_red">
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['radiantScore'] ??'';}else{echo $battleDetailInfo['direScore'] ??'';} ?>
													</span>:<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direScore'] ??'';}else{echo $battleDetailInfo['radiantScore'] ??'';} ?>
													
                                                </span>
                                            <span class="td">
													<?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamId']==$battleDetailInfo['firstBloodTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamId']==$battleDetailInfo['firstTowerTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamId']==$battleDetailInfo['fiveKillTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamId']==$battleDetailInfo['tenKillTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                   <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamId']==$battleDetailInfo['firstRoushanTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                        </div>
											<?php }}else{?>
										<div class="null">
											<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
										</div>
										<?php }?>
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
                                        <?php if(isset($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList']) && count($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList'])>0){
											foreach($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList'] as $battleDetailInfo){?>
                                        <div class="row1">
                                            <span title="cSc" class="td elips flex15">
													
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
                                                    
                                            </span>
                                            <span title="Pinnacle杯" class="td flex2 wrap">
                                                    <span class="leagueName elips"><?php echo $battleDetailInfo['tournamentName'] ??''; ?></span>
                                                    <span class="leagueTime"><?php echo date("Y-m-d H:i:s",substr($battleDetailInfo['matchTime'] ??0,0,-3));?></span>
                                                </span>
                                            <span class="td flex15"><?php echo date("i",$battleDetailInfo['lengthTime']??0 );?>分<?php echo date("s",$battleDetailInfo['lengthTime']??0 );?>秒</span>
                                            <span title="<?php  if( $battleDetailInfo['direWin']==1 ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>" class="td elips flex15">
                                                  <?php  if( $battleDetailInfo['direWin']==1 ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
                                                </span>
                                            <span class="td">
													 <span class="span_red">
													 
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['radiantScore'] ??'';}else{echo $battleDetailInfo['direScore'] ??'';} ?>
													</span>:<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direScore'] ??'';}else{echo $battleDetailInfo['radiantScore'] ??'';} ?>
                                                </span>
                                            <span class="td">
													<?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamId']==$battleDetailInfo['firstBloodTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamId']==$battleDetailInfo['firstTowerTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamId']==$battleDetailInfo['fiveKillTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                    <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamId']==$battleDetailInfo['tenKillTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                            <span class="td">
                                                   <?php if($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamId']==$battleDetailInfo['firstRoushanTeamId']){  ?>
                                                    <i class="dota2_dot red"></i>
													<?php }?>
                                                </span>
                                        </div>
											<?php }}else{?>
										<div class="null">
											<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
										</div>
										<?php }?>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 赛前分析 -->

						
                        <!-- 比赛详情 -->
                        <div class="dota2_item live_box ">
							<?php if(isset($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])>0){?>
                                <div class="war_report mb20">
                                    <div class="dota2_top">
                                        <img src="<?php echo $config['site_url'];?>/images/report.png" alt="">
                                        <span>对战战报</span>
                                    </div>
									
                                    <div class="war_report_detail">
                                        <span>本次比赛共计<?php echo count($return['matchDetail']['data']['match_data']['matchData']);?>局</span>
										<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){
												if(isset($matchInfo['homeTeam']['teamStat']['firstBlood']) && $matchInfo['homeTeam']['teamStat']['firstBlood']==0){
													$firstBloodTeam=$matchInfo['awayTeam']['teamName'] ??'';
												}else{
													$firstBloodTeam=$matchInfo['homeTeam']['teamName'] ??'';
												}
												if(isset($matchInfo['homeTeam']['teamStat']['firstTower']) && $matchInfo['homeTeam']['teamStat']['firstTower']==0){
													$firstTowerTeam=$matchInfo['awayTeam']['teamName'] ??'';
												}else{
													$firstTowerTeam=$matchInfo['homeTeam']['teamName'] ??'';
												}
												if(isset($matchInfo['homeTeam']['teamStat']['fiveKill']) && $matchInfo['homeTeam']['teamStat']['fiveKill']==0){
													$fiveKillTeam=$matchInfo['awayTeam']['teamName'] ??'';
												}else{
													$fiveKillTeam=$matchInfo['homeTeam']['teamName'] ??'';
												}
												if(isset($matchInfo['homeTeam']['teamStat']['tenKill']) && $matchInfo['homeTeam']['teamStat']['tenKill']==0){
													$tenKillTeam=$matchInfo['awayTeam']['teamName'] ??'';
												}else{
													$tenKillTeam=$matchInfo['homeTeam']['teamName'] ??'';
												}
												if(isset($matchInfo['homeTeam']['teamStat']['fifteenKill']) && $matchInfo['homeTeam']['teamStat']['fifteenKill']==0){
													$fifteenKillTeam=$matchInfo['awayTeam']['teamName'] ??'';
												}else{
													$fifteenKillTeam=$matchInfo['homeTeam']['teamName'] ??'';
												}
											?>
                                        <p>第<?php echo ($matchKey+1)?>局比赛中： <?php echo $firstBloodTeam; ?>夺得一血，<?php echo $firstTowerTeam; ?>首先攻下第一座防御塔，<?php echo $fiveKillTeam; ?>拿下五杀， <?php echo $tenKillTeam; ?> 取得十杀， <?php echo $fifteenKillTeam; ?>  豪取十五杀。</p>
										<?php }?>
                                        
                                        <p>最终恭喜<?php if($return['matchDetail']['data']['away_score']>$return['matchDetail']['data']['home_score']){echo $return['matchDetail']['data']['away_team_info']['team_name']?? '';}else{echo $return['matchDetail']['data']['home_team_info']['team_name']?? '';}?>取得本次<?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'] ?? '';?>的冠军</p>
                                    </div>
									
                                </div>
                                <ul class="live_box_ul clearfix">
									<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){?>
                                    <li <?php if($matchKey==0){?>class="active"<?php }?>>
                                        <div class="game_detail_img1">
											<?php if($matchInfo['awayTeam']['score']>$matchInfo['homeTeam']['score']){
												$team_logo_icon=$return['matchDetail']['data']['away_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_30,w_30';
											}else{
												$team_logo_icon=$return['matchDetail']['data']['home_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_30,w_30';
											}?>
                                            <img src="<?php echo $team_logo_icon;?>" alt="">
                                        </div>
                                        <span>GAME <?php echo ($matchKey+1);?></span>
                                      
                                    </li>
									<?php }?>
                                    
                                   
                                </ul>
                                <div class="live_box_detail">
								
									<!--第一局-->
									<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){?>
                                    <div class="live_box_item active">
                                        <div class="battle_details mb20">
                                            <div class="game_detail_item1">
                                                
													<a class="left" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>">
                                                    <div class="imgwidth40 imgheight40">
                                                        <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                                    </div>
                                                    <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
													
                                                    <?php if($matchInfo['awayTeam']['score']>$matchInfo['homeTeam']['score']){?>
                                                    <div class="liveBox_img">
                                                        <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                                    </div>
													<?php }?>
													</a>
                                             
                                                <div class="center">
                                                    <span class="game_detail_line1"></span>
                                                    <span class="game_detail_circle1"></span>
                                                    <span class="fz font_color_r"><?php echo  $matchInfo['awayTeam']['teamStat']['killCount']??0;?></span>
                                                    <div class="img_game_detail_vs">
                                                        <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="" class="imgauto">
                                                    </div>
                                                    <span class="fz font_color_b"><?php echo  $matchInfo['homeTeam']['teamStat']['killCount']??0;?></span>
                                                    <span class="game_detail_circle1"></span>
                                                    <span class="game_detail_line1"></span>
                                                </div>
                                                
													<a class="left right" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>">
                                                    <div class="imgwidth40 imgheight40">
                                                        <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                                    </div>
                                                    <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
													
													<?php if($matchInfo['awayTeam']['score']<=$matchInfo['homeTeam']['score']){?>
                                                    <div class="liveBox_img">
                                                        <img src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                                    </div>
													<?php }?>
													</a>
                                                
                                            </div>
											<?php  
												if(isset($matchInfo['homeTeam']['playerList'])){
													array_multisort(array_column($matchInfo['homeTeam']['playerList'],"position"),SORT_ASC,$matchInfo['homeTeam']['playerList']);
												}
												
												if(isset($matchInfo['awayTeam']['playerList'])){
													array_multisort(array_column($matchInfo['awayTeam']['playerList'],"position"),SORT_ASC,$matchInfo['awayTeam']['playerList']);
												}
											
											 ?>
                                            <div class="battleBox">
                                                <ul class="battleBox_vs_data1 vs_data2">
                                                    <li class="active">
														一号位
                                                    </li>
                                                    <li class="">
                                                        二号位
                                                    </li>
                                                    <li class="">
                                                        三号位
                                                    </li>
                                                    <li class="">
                                                        四号位
                                                    </li>
                                                    <li class="active1">
                                                        五号位
                                                    </li>
                                                </ul>
                                                <div class="battle_list">
													<!--队员-->
													<?php if(isset($matchInfo['awayTeam']['playerList']) && count($matchInfo['awayTeam']['playerList'])>0){
														foreach($matchInfo['awayTeam']['playerList'] as $playerKey=>$playerInfo){ ?>
														<div class="battle_item <?php if($playerKey==0){?> active <?php } ?>">
                                                        <div class="battle_item_top">
                                                            <div class="battle_top_left">
                                                                <div class="battle_hero">
                                                                    <div class="heroBox">
                                                                        <img  data-original="<?php echo $playerInfo['playerLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  alt="<?php echo $playerInfo['playerName'];?>" class="imgauto">
                                                                    </div>
                                                                    <div class="heroUse">
                                                                        <img data-original="<?php echo $playerInfo['heroLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $playerInfo['heroName']??'';?>" class="imgauto">
                                                                    </div>
                                                                </div>
                                                                <span class="battle_hero_name"><?php echo $playerInfo['playerName'] ?? '';?></span>
                                                                <div class="thumbList">
																	<?php if(isset($playerInfo['equipmentList']) && count($playerInfo['equipmentList'])>0){
																		foreach($playerInfo['equipmentList'] as $equipmentInfo){?>
                                                                    <img src="<?php echo $equipmentInfo['logo']?? '';?>" alt="<?php echo $equipmentInfo['nameZh']?? '';?>">
																	<?php }}?>
                                                                </div>
                                                            </div>
                                                            <div class="center">
                                                                <div class="kda_detail">
                                                                    <span class="red kad_big"><?php 
																	if($playerInfo['playerStat']['dieCount'] !=0){
																		$kda=($playerInfo['playerStat']['killCount'] +$playerInfo['playerStat']['assistsCount'])/$playerInfo['playerStat']['dieCount'];
																	}else{
																		$kda=($playerInfo['playerStat']['killCount'] +$playerInfo['playerStat']['assistsCount']);
																	}
																	 echo round($kda,1);?></span>
                                                                    <span class="red kad_small"><?php echo $playerInfo['playerStat']['killCount']??0;?>/<?php echo $playerInfo['playerStat']['dieCount']??0;?>/<?php echo $playerInfo['playerStat']['assistsCount']??0;?></span>
                                                                    <span class="kad_big">KDA</span>
                                                                    <span class="blue kad_small"><?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['killCount']??0;?>/<?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['dieCount']??0;?>/<?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['assistsCount']??0;?></span>
                                                                    <span class="blue kad_big"><?php 
																	if($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['dieCount'] !=0){
																		$kda=($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['killCount'] +$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['assistsCount'])/$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['dieCount'];
																	}else{
																		$kda=($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['killCount'] +$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['assistsCount']);
																	}
																	 echo round($kda,1);?></span>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['economicCount']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['economicCount']??0;?></span>
                                                                        <div class="average_time">经济</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['economicCount']/($playerInfo['playerStat']['economicCount']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['economicCount']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['economicCount']/($playerInfo['playerStat']['economicCount']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['economicCount']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['xpm']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['xpm']??0;?></span>
                                                                        <div class="average_time">分均经验</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width:<?php echo ($playerInfo['playerStat']['xpm']/($playerInfo['playerStat']['xpm']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['xpm']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['xpm']/($playerInfo['playerStat']['xpm']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['xpm']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['gpm']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['gpm']??0;?></span>
                                                                        <div class="average_time">分均金钱</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['gpm']/($playerInfo['playerStat']['gpm']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['gpm']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['gpm']/($playerInfo['playerStat']['gpm']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['gpm']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['lastHits']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['lastHits']??0;?></span>
                                                                        <div class="average_time">正补/反补</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['lastHits']/($playerInfo['playerStat']['lastHits']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['lastHits']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['lastHits']/($playerInfo['playerStat']['lastHits']+$matchInfo['homeTeam']['playerList'][$playerKey]['playerStat']['lastHits']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="battle_top_left">
                                                                <div class="battle_hero">
                                                                    <div class="heroBox">
                                                                        <img data-original="<?php echo  $matchInfo['homeTeam']['playerList'][$playerKey]['playerLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>" alt="<?php echo  $matchInfo['homeTeam']['playerList'][$playerKey]['playerName'];?>" class="imgauto">
																		
                                                                    </div>
                                                                    <div class="heroUse">
                                                                        <img data-original="<?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['heroLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $matchInfo['homeTeam']['playerList'][$playerKey]['heroName']??'';?>" class="imgauto">
                                                                    </div>
                                                                </div>
                                                                <span class="battle_hero_name"><?php echo  $matchInfo['homeTeam']['playerList'][$playerKey]['playerName'];?></span>
                                                                <div class="thumbList">
																	<?php if(isset($matchInfo['homeTeam']['playerList'][$playerKey]['equipmentList']) && count($matchInfo['homeTeam']['playerList'][$playerKey]['equipmentList'])>0){
																		foreach($matchInfo['homeTeam']['playerList'][$playerKey]['equipmentList'] as $equipmentInfo){?>
                                                                    <img src="<?php echo $equipmentInfo['logo']?? '';?>" alt="<?php echo $equipmentInfo['nameZh']?? '';?>">
																	<?php }}?>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="battle_item_bottom">
                                                            <div class="battle_bottom1">
                                                                <div class="war_situation">
														<span <?php if(isset($matchInfo['awayTeam']['teamStat']['firstTower']) && $matchInfo['awayTeam']['teamStat']['firstTower']>0){ ?>class="war_red" <?php }?>>一塔</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['firstBlood']) && $matchInfo['awayTeam']['teamStat']['firstBlood']>0){ ?>class="war_red" <?php }?>>一血</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['fiveKill']) && $matchInfo['awayTeam']['teamStat']['fiveKill']>0){ ?>class="war_red" <?php }?>>先五杀</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['tenKill']) && $matchInfo['awayTeam']['teamStat']['tenKill']>0){ ?>class="war_red" <?php }?>>先十杀</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['fifteenKill']) && $matchInfo['awayTeam']['teamStat']['fifteenKill']>0){ ?>class="war_red" <?php }?>>先十五杀</span>
                                                                   
                                                                </div>
                                                                <div class="war_situation" style="justify-content: flex-end;">
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['firstTower']) && $matchInfo['homeTeam']['teamStat']['firstTower']>0){ ?>class="war_blue" <?php }?>>一塔</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['firstBlood']) && $matchInfo['homeTeam']['teamStat']['firstBlood']>0){ ?>class="war_blue" <?php }?>>一血</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['fiveKill']) && $matchInfo['homeTeam']['teamStat']['fiveKill']>0){ ?>class="war_blue" <?php }?>>先五杀</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['tenKill']) && $matchInfo['homeTeam']['teamStat']['tenKill']>0){ ?>class="war_blue" <?php }?>>先十杀</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['fifteenKill']) && $matchInfo['homeTeam']['teamStat']['fifteenKill']>0){ ?>class="war_blue" <?php }?>>先十五杀</span>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="battle_bottom2">
                                                                <div class="row2 mb20">
                                                                    <div class="heroBan">
																		<?php if(isset($matchInfo['awayTeam']['ban']) && count($matchInfo['awayTeam']['ban'])>0){ 
																		 foreach($matchInfo['awayTeam']['ban'] as $banInfo){ ?>
                                                                        <img src="<?php echo $banInfo['logo']??''; ?>" alt="<?php echo $banInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                        
                                                                    </div>
                                                                    <span class="bans">Bans</span>
                                                                    <div class="heroBan">
                                                                        <?php if(isset($matchInfo['homeTeam']['ban']) && count($matchInfo['homeTeam']['ban'])>0){ 
																		 foreach($matchInfo['homeTeam']['ban'] as $banInfo){ ?>
                                                                        <img src="<?php echo $banInfo['logo']??''; ?>" alt="<?php echo $banInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                </div>
                                                                <div class="row2">
                                                                    <div class="heroPick">
                                                                       <?php if(isset($matchInfo['awayTeam']['pick']) && count($matchInfo['awayTeam']['pick'])>0){ 
																		 foreach($matchInfo['awayTeam']['pick'] as $pickInfo){ ?>
                                                                        <img src="<?php echo $pickInfo['logo']??''; ?>" alt="<?php echo $pickInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                    <span class="bans">Picks</span>
                                                                    <div class="heroPick">
                                                                        <?php if(isset($matchInfo['homeTeam']['pick']) && count($matchInfo['homeTeam']['pick'])>0){ 
																		 foreach($matchInfo['homeTeam']['pick'] as $pickInfo){ ?>
                                                                        <img src="<?php echo $pickInfo['logo']??''; ?>" alt="<?php echo $pickInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }}?>
                                                    <!--队员-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lineup_data">
                                            <div class="dota2_top">
                                                <img src="<?php echo $config['site_url'];?>/images/dota2_recent.png" alt="">
                                                <span>阵容数据</span>
                                            </div>
                                            <div class="lineup_mid">
												
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayKernel']??0;?></span>
                                                        </div>
                                                        <p>核心</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeKernel']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayKernel']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayKernel']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeKernel']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayControl']??0;?></span>
                                                        </div>
                                                        <p>控制</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeControl']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayControl']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayControl']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeControl']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awaySente']??0;?></span>
                                                        </div>
                                                        <p>先手</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeSente']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awaySente']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awaySente']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeSente']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayBurst']??0;?></span>
                                                        </div>
                                                        <p>爆发</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeBurst']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayBurst']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayBurst']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeBurst']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayEscape']??0;?></span>
                                                        </div>
                                                        <p>逃生</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeEscape']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayEscape']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayEscape']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeEscape']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayFightingWild']??0;?></span>
                                                        </div>
                                                        <p>打野</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeFightingWild']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayFightingWild']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayFightingWild']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeFightingWild']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												
												<!---->
                                            </div>
                                            <div class="game_detail_item3 mb60">
                                                <div class="game_detail_item3_top">
                                                    <div class="left">
                                                        <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayAdvance']??0;?></span>
                                                    </div>
                                                    <p>推进</p>
                                                    <div class="left">
                                                        <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeAdvance']??0;?></span>
                                                    </div>
                                                </div>
                                                <div class="pk-detail-con">
                                                    <div class="progress red">
                                                        <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayAdvance']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayAdvance']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeAdvance']))*100; ?>%;">
                                                            <i class="lightning"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<?php $statistical=["winRate"=>"胜率","firstBloodRate"=>"一血率","firstTowerRate"=>"一塔率","fiveKillRate"=>"五杀率","tenKillRate"=>"十杀率"]; ?>
                                            <div class="lineup_bottom">
                                                <ul class="vs_data2 lineup_vs_data2">
												<!--胜率，一血率，一塔率，五杀率，十杀率-->
													<?php foreach($statistical as $statisticalKey=>$statisticalInfo){?>
                                                    <li <?php if($statisticalKey=="winRate"){ ?>class="active" <?php }?>>
                                                        <?php echo $statisticalInfo;?>
                                                    </li>
                                                    <?php }?>
                                                </ul>
                                                <div class="lineup_list">
													<?php 
														$position=["上单","打野","ADC","中单","辅助"];
														$winRateDataAnalysis=$firstBloodRateDataAnalysis=$firstTowerDataAnalysis=$fiveKillRateDataAnalysis=$tenKillRateDataAnalysis=[];
														//主队
														if(isset($matchInfo['lineupContent']['dataAnalysis']['awayHeroStat'])){
															foreach($matchInfo['lineupContent']['dataAnalysis']['awayHeroStat'] as $awayHeroStatKey=>$awayHeroStatInfo){
																//赢率
																$winRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allWinCount']/$awayHeroStatInfo['allTotal'],3)*100;
																$winRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allWinCount']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//当前赢率
																$winRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currWinCount']/$awayHeroStatInfo['currTotal'],3)*100;
																$winRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currWinCount']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['postion']=$position[$awayHeroStatKey];
																//英雄
																$winRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//一血率
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFirstBloodsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//当前赢率
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFirstBloodsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['postion']=$position[$awayHeroStatKey];
																//英雄
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//一塔率
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFirstTowersCount']/$awayHeroStatInfo['allTotal'],3)*100;
																
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFirstTowersCount']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//当前赢率
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFirstTowersCount']/$awayHeroStatInfo['currTotal'],3)*100;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFirstTowersCount']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['postion']=$position[$awayHeroStatKey];
																//英雄
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//五杀率
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFiveKillsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//当前赢率
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFiveKillsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['postion']=$position[$awayHeroStatKey];
																//英雄
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//十杀率
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allTenKillsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allTenKillsCount']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//当前赢率
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currTenKillsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currTenKillsCount']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['postion']=$position[$awayHeroStatKey];
																//英雄
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
															}
															
														}
														//客队
														if(isset($matchInfo['lineupContent']['dataAnalysis']['homeHeroStat'])){
															foreach($matchInfo['lineupContent']['dataAnalysis']['homeHeroStat'] as $homeHeroStatKey=>$homeHeroStatInfo){
												
																//赢率
																$winRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allWinCount']/$homeHeroStatInfo['allTotal'],3)*100;
																$winRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allWinCount']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//当前赢率
																$winRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currWinCount']/$homeHeroStatInfo['currTotal'],3)*100;
																$winRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currWinCount']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																//英雄
																$winRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																
																//一血率
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFirstBloodsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//当前赢率
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFirstBloodsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																//英雄
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//一塔率
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFirstTowersCount']/$homeHeroStatInfo['allTotal'],3)*100;
																
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFirstTowersCount']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//当前赢率
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFirstTowersCount']/$homeHeroStatInfo['currTotal'],3)*100;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFirstTowersCount']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																//英雄
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//五杀率
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFiveKillsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//当前赢率
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFiveKillsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																//英雄
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//十杀率
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allTenKillsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allTenKillsCount']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//当前赢率
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currTenKillsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currTenKillsCount']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																//英雄
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
															}
															
														}
														
														$dataAnalysis=[];
														
													foreach($statistical as $statisticalKey=>$statisticalInfo){
														if($statisticalKey=='winRate'){
															//按照赢率
															$dataAnalysis=$winRateDataAnalysis;
														}elseif($statisticalKey=='firstBloodRate'){
															//按照一血率
															$dataAnalysis=$firstBloodRateDataAnalysis;
														}elseif($statisticalKey=='firstTowerRate'){
															//按照一塔率
															$dataAnalysis=$firstTowerDataAnalysis;
														
														}elseif($statisticalKey=='fiveKillRate'){
															//按照五杀率
															$dataAnalysis=$fiveKillRateDataAnalysis;
														}elseif($statisticalKey=='tenKillRate'){
															//按照十杀率排序
															$dataAnalysis=$tenKillRateDataAnalysis;
														} 
													
														?>
                                                    <div class="lineup_item <?php if($statisticalKey=='winRate'){ ?>active <?php }?>">
                                                        <div class="lineup_th">
                                                            <div class="lineup_thItem red">
                                                                <span class="flex15">所有战队(胜/局数)</span>
                                                                <span class="flex15">当前战队(胜/局数)</span>
                                                                <span>英雄</span>
                                                                <span>位</span>
                                                            </div>
                                                            <div class="lineup_thItem blue lineup_thRever">
                                                                <span class="flex15">所有战队(胜/局数)</span>
                                                                <span class="flex15">当前战队(胜/局数)</span>
                                                                <span>英雄</span>
                                                                <span>置</span>
                                                            </div>
                                                        </div>
														<?php foreach($dataAnalysis as $key=>$dataAnalysisInfo){?>
                                                        <div class="lineup_td">
                                                            <div class="lineup_thItem">
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['awayRate']; ?>%<i>(<?php echo $dataAnalysisInfo['awayAllWinCount'];?>/<?php echo $dataAnalysisInfo['awayAllTotal'];?>)</i></span>
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['awayCurrWinRate']; ?>%<i>(<?php echo $dataAnalysisInfo['awayCurrWinCount']; ?>/<?php echo $dataAnalysisInfo['awayCurrTotal']; ?>)</i></span>
                                                                <span>
                                                                    <img  class="lineup_img" src="<?php echo $dataAnalysisInfo['awayheroLogo']; ?>" alt="<?php echo $dataAnalysisInfo['awayheroName']; ?>">
                                                                </span>
                                                                <span class="dn">位</span>
                                                            </div>
                                                            <div class="lineup_thItem lineup_thRever">
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['homeRate']; ?>%<i>(<?php echo $dataAnalysisInfo['homeAllWinCount']; ?>/<?php echo $dataAnalysisInfo['homeAllTotal']; ?>)</i></span>
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['homeCurrWinRate']; ?>%<i>(<?php echo $dataAnalysisInfo['homeCurrWinCount']; ?>/<?php echo $dataAnalysisInfo['homeCurrTotal']; ?>)</i></span>
                                                                <span>
                                                                    <img  class="lineup_img" src="<?php echo $dataAnalysisInfo['homeheroLogo']; ?>" alt="<?php echo $dataAnalysisInfo['homeheroName']; ?>">
                                                                </span>
                                                                <span class="dn">置</span>
                                                            </div>
                                                            <p><?php echo $dataAnalysisInfo['postion']; ?></p>
                                                        </div>
                                                        
														<?php }?>
														
                                                    </div>
													<?php } ?>
													<!--胜率-->
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php }?>
									<!--第一局-->
                                    
                                </div>
								<?php }else{?>
								<div class="null">
									<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
								</div>
								<?php } ?>
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
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                            </div>
                            <span class="fl">近期赛事</span>
                        </div>
                        <div class="more fr">
                            <a href="<?php echo $config['site_url'];?>/match/">
                                <span>更多</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
                    </div>
                    <ul class="game_match_ul">
						<?php foreach($return['recentMatchList']['data'] as $matchInfo){ ?>
                        <li class="col-md-12 col-xs-12">
                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                <div class="game_match_top">
                                    <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                    <span class="game_match_time"><?php echo date("m月d日 H:i",strtotime($matchInfo['start_time']));?></span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" title="<?php echo $matchInfo['home_team_info']['team_name'];?>" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>" class="imgauto">
                                        </div>
                                        <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span><?php echo $config['game'][$matchInfo['game']]  ?></span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" title="<?php echo $matchInfo['away_team_info']['team_name'];?>" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>" class="imgauto">
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
                <?php } ?>
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

<?php renderFooterJsCss($config,[],["jquery.lineProgressbar","echarts.min","circle-progress"]);?>
<script>
    //圆形进度条
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

    //对战详情tab切换
    $(".battleBox .vs_data1").on("click", 'li', function () {
        var _this = $(this).index() - 1;
        $(".battleBox .vs_data1 li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".vs_data1").find("li").removeClass("active1").eq(_this).addClass("active1");
        $(".battleBox .vs_data2 .vs_data2_item").removeClass("active").eq($(this).index()).addClass("active");
        $(this).parents(".battleBox").find(".battle_list").find(".battle_item").removeClass("active").eq($(this).index()).addClass("active")
    })


    //阵容数据tab切换
    $(".lineup_bottom .vs_data2").on("click", 'li', function () {
        var _this = $(this).index() - 1;
        $(".lineup_bottom .vs_data2 li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".vs_data2").find("li").removeClass("active1").eq(_this).addClass("active1");
        $(".lineup_bottom .vs_data2 .vs_data2_item").removeClass("active").eq($(this).index()).addClass("active");
        $(this).parents(".lineup_bottom").find(".lineup_list").find(".lineup_item").removeClass("active").eq($(this).index()).addClass("active")
    })

</script>
</body>

</html>