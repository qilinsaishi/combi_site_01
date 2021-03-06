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
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_hero_img","default_tournament_img","default_skills_img","default_fuwen_img","default_information_img","default_equipment_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"page_size"=>3,"source"=>$source,"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>$game,"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400],
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
    <title><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>??????????????????????????????_<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>-<?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>,<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>??????">
    <meta name="description" content="<?php echo $config['site_name'];?>??????<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>????????????,??????<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?> vs <?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>???<?php echo $config['game'][$return['matchDetail']['data']['game']]?><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'];?>?????????,?????????<?php echo $config['site_name'];?>">
    <?php renderHeaderJsCss($config,["game","right","progress-bars","dota2"]);?>

</head>

<body>
<div class="wrapper">
    <div class="header">
        <div class="container clearfix">
            <div class="row">
                <div class="logo"><a href="index.html">
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
                <div class="game_title">
                    <div class="game_title_top">
                        <!--<div >-->
							<?php if($return['matchDetail']['data']['home_team_info']['tid']>0){?>
							<a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>" class="game_team1">
							<?php } ?>
                            <div class="game_team1_img">
                                <div class="game_team1_img1"> 
                                    <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name']??'';?></span>
							<?php if($return['matchDetail']['data']['home_team_info']['tid']>0){?>
							</a>
							<?php } ?>
                        <!--</div>-->
                        <div class="game_type">
                            <span class="span1"><?php echo $config['game'][$game];?></span>
                            <span class="span2"><?php echo $return['matchDetail']['data']['tournament_info']['tournament_name'] ?? '';?></span>
                            <div class="game_vs">
                                <span class="span1"><?php echo $return['matchDetail']['data']['home_score']??'0';?></span>
                                <img data-original="<?php echo $config['site_url'];?>/images/vs.png" src="<?php echo $config['site_url'];?>/images/vs.png" alt="">
                                <span class="span2"><?php echo $return['matchDetail']['data']['away_score']??'0';?></span>
                            </div>
                            <p><?php echo date("Y.m.d H:i",strtotime($return['matchDetail']['data']['start_time']))?>??<?php echo generateMatchStatus($return['matchDetail']['data']['start_time']);?></p>
                        </div>
                        <!--<div >-->
							<?php if($return['matchDetail']['data']['away_team_info']['tid']>0){?>
							<a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>" class="game_team1">
							<?php } ?>
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name']??'';?></span>
							<?php if($return['matchDetail']['data']['away_team_info']['tid']>0){?>
							</a>
							<?php } ?>
                        <!--</div>-->
                    </div>
                    <div class="game_team_depiction">
                        <p class="active"><!--????????????--><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['home_team_info']['description'])));?></p>
                        <p class="active"><!--????????????--><?php echo strip_tags(html_entity_decode(checkJson($return['matchDetail']['data']['away_team_info']['description'])));?></p>
                    </div>
                    <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="" class="game_title_more">
                </div>
                <div class="dota2">
                    <ul class="dota2_ul1 clearfix mb20">
                        <li <?php if(is_array($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])==0){?>class="active"<?php } ?>>
                            ????????????
                        </li>
                        <li <?php if(is_array($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])>0){?>class="active"<?php } ?>>
                            ????????????
                        </li>
                    </ul>
                    <div class="dota2_div">
                        <!-- ???????????? -->
                        <div class="dota2_item <?php if(is_array($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])==0){?>active"<?php } ?>">
                            <div class="dota2_top">
                                <img src="<?php echo $config['site_url'];?>/images/dota2_recent.png" data-original="<?php echo $config['site_url'];?>/images/dota2_recent.png" alt="">
                                <span>????????????????????????</span>
                            </div>
                            <div class="dota2_div1_team">
                                
								<a class="teamInfo " href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>">
                                    <div class="colorBlock colorBlock_right red"></div>
									
                                    <div class="teamInfo_img">
										
                                        <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>"  class="imgauto">
									
                                    </div>
                                    <span class="text_left"><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
									</a>
									
                                
                                <div class="dota2_vs">
                                    <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" data-original="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                </div>
								<a class="teamInfo teamInfo_reverse" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>">
                                    <div class="colorBlock blue"></div>
									
                                    <div class="teamInfo_img">
                                        <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].$config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
										
                                    </div>
                                    <span class="text_right"><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
									</a>
                               
                            </div>
                            <div class="bpBox">
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dred third circle" data-num="<?php 
										$awayWinRate=round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']/($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']+$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['loseCount']),2);
										echo $awayWinRate;?>">
                                            <strong>
                                                <p></p>
                                                <span>??????</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['winCount']??'0';?>???<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['loseCount']??'0';?>???</p>
                                        <p class="bpBox_kda red">KDA???<?php echo round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['kda']??'0',2);?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgKill']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgDie']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgAssists']??'0';?></p>
                                    </div>
                                </div>
                                <div class="center">
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??'0';?></span>
											<div class="average_time">????????????</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgEconomics=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??0;
												 $avgEconomics1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??0;
												 $totalAvgEconomics=($avgEconomics+$avgEconomics1);
												echo ($avgEconomics/$totalAvgEconomics)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width:<?php 
												 $avgEconomics=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgEconomics']??0;
												 $avgEconomics1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgEconomics']??0;
												 $totalAvgEconomics=($avgEconomics+$avgEconomics1);
												
												echo ($avgEconomics1/$totalAvgEconomics)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??'0';?></span>
											<div class="average_time">????????????</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgSoldiers=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??0;
												 $avgSoldiers1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??0;
												 $totalAvgSoldiers=($avgSoldiers+$avgSoldiers1);
												echo ($avgSoldiers/$totalAvgSoldiers)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgSoldiers=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgSoldiers']??0;
												 $avgSoldiers1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgSoldiers']??0;
												 $totalAvgSoldiers=($avgSoldiers+$avgSoldiers1);
												echo ($avgSoldiers1/$totalAvgSoldiers)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												echo date("i",$avgLengthTime);
												 ?>'<?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												echo date("s",$avgLengthTime);
												 ?>"</span>
											<span class="fr time2"><?php 
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												echo date("i",$avgLengthTime1);
												 ?>'<?php 
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												echo date("s",$avgLengthTime1);
												 ?>"</span>
											<div class="average_time">????????????</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												 $totalAvgLengthTime=($avgLengthTime+$avgLengthTime1);
												echo ($avgLengthTime/$totalAvgLengthTime)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgLengthTime=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgLengthTime']??0;
												 $avgLengthTime1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgLengthTime']??0;
												 $totalAvgLengthTime=($avgLengthTime+$avgLengthTime1);
												echo ($avgLengthTime1/$totalAvgLengthTime)*100; ?>%;"></span>
											</div>
										</div>
									</div>
									<div class="rate_data_left">
										<div class="rate_data_top">
											<span class="fl time1"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??'0';?></span>
											<span class="fr time2"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??'0';?></span>
											<div class="average_time">????????????</div>
										</div>
										<div class="compare-bar compare_bar clearfix">
											<div class="progress3 fl progress4 red">
												<span class="green" style="width: <?php 
												 $avgOutput=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??0;
												 $avgOutput1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??0;
												 $totalAvgOutput=($avgOutput+$avgOutput1);
												echo ($avgOutput/$totalAvgOutput)*100; ?>%;"></span>
											</div>
											<div class="progress3 fr blue">
												<span class="green" style="width: <?php 
												 $avgOutput=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['avgOutput']??0;
												 $avgOutput1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgOutput']??0;
												 $totalAvgOutput=($avgOutput+$avgOutput1);
												echo ($avgOutput1/$totalAvgOutput)*100; ?>%;"></span>
											</div>
										</div>
									</div>
                                    
                                </div>
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dblue third circle" data-num="<?php 
										$homeWinRate=round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']/($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']+$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['loseCount']),2);echo $homeWinRate;?>">
                                            <strong>
                                                <p></p>
                                                <span>??????</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['winCount']??'0';?>???<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['loseCount']??'0';?>???</p>
                                        <p class="bpBox_kda blue">KDA???<?php echo round($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['kda']??'0',2);?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgKill']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgDie']??'0';?>/<?php echo $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['avgAssists']??'0';?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="barChart">
									<div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstBloodRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstBloodRate']??'0';
												echo ($firstBloodRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstBloodRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstBloodRate']??'0';
												echo ($firstBloodRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height:<?php 
												$firstBloodRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstBloodRate']??'0';
												echo ($firstBloodRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstBloodRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstBloodRate']??'0';
												echo ($firstBloodRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">?????????</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstTowerRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstTowerRate']??'0';
												echo ($firstTowerRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstTowerRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstTowerRate']??'0';
												echo ($firstTowerRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$firstTowerRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstTowerRate']??'0';
												echo ($firstTowerRate1*100);?>%;">
                                                    <span class="bar_rate"> <?php 
												$firstTowerRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstTowerRate']??'0';
												echo ($firstTowerRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">?????????</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$fiveKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['fiveKillRate']??'0';
												echo ($fiveKillRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$fiveKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['fiveKillRate']??'0';
												echo ($fiveKillRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$fiveKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['fiveKillRate']??'0';
												echo ($fiveKillRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$fiveKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['fiveKillRate']??'0';
												echo ($fiveKillRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">?????????</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$tenKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['tenKillRate']??'0';
												echo ($tenKillRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$tenKillRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['tenKillRate']??'0';
												echo ($tenKillRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$tenKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['tenKillRate']??'0';
												echo ($tenKillRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$tenKillRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['tenKillRate']??'0';
												echo ($tenKillRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">?????????</span>
                                        </div>
                                    </div>
                                    <div class="bar_item">
                                        <div class="outCol">
                                            <div class="col">
                                                <div class="bar red" style="height: <?php 
												$firstRoushanRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstRoushanRate']??0;
												echo ($firstRoushanRate*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstRoushanRate=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['firstRoushanRate']??0;
												echo ($firstRoushanRate*100);?>%</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bar blue" style=" height: <?php 
												$firstRoushanRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstRoushanRate']??0;
												echo ($firstRoushanRate1*100);?>%;">
                                                    <span class="bar_rate"><?php 
												$firstRoushanRate1=$return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['firstRoushanRate']??0;
												echo ($firstRoushanRate1*100);?>%</span>
                                                </div>
                                            </div><span class="itemName">?????????</span>
                                        </div>
                                    </div>
                                
                            </div>
                            <div class="recentGame-box red">
                                <div class="box">
                                    <div class="thead">
                                        <span class="th flex15">??????</span>
                                        <span class="th flex2">??????/????????????</span>
                                        <span class="th flex15">????????????</span>
                                        <span class="th flex15">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                    </div>
                                    <div class="rowBox">
										<?php if(isset($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList']) && count($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList'])>0){
											foreach($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['battleDetailList'] as $battleDetailInfo){?>
                                        <div class="row1">
                                            <span title="cSc" class="td elips flex15">
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][0]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
                                                    
                                            </span>
                                            <span title="Pinnacle???" class="td flex2 wrap">
                                                    <span class="leagueName elips"><?php echo $battleDetailInfo['tournamentName'] ??''; ?></span>
                                                    <span class="leagueTime"><?php echo date("Y-m-d H:i:s",substr($battleDetailInfo['matchTime'] ??0,0,-3));?></span>
                                                </span>
                                            <span class="td flex15"><?php echo date("i",$battleDetailInfo['lengthTime']??0 );?>???<?php echo date("s",$battleDetailInfo['lengthTime']??0 );?>???</span>
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
											<img src="<?php echo $config['site_url'];?>/images/null.png" data-original="<?php echo $config['site_url'];?>/images/null.png" alt="">
										</div>
										<?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="recentGame-box blue">
                                <div class="box">
                                    <div class="thead">
                                        <span class="th flex15">??????</span>
                                        <span class="th flex2">??????/????????????</span>
                                        <span class="th flex15">????????????</span>
                                        <span class="th flex15">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                        <span class="th">??????</span>
                                    </div>
                                    <div class="rowBox">
                                        <?php if(isset($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList']) && count($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList'])>0){
											foreach($return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['battleDetailList'] as $battleDetailInfo){?>
                                        <div class="row1">
                                            <span title="cSc" class="td elips flex15">
													
													<?php  if( $return['matchDetail']['data']['match_pre']['teamBaseData']['teamVoList'][1]['teamName']==$battleDetailInfo['radiantName'] ){echo $battleDetailInfo['direName'] ??'';}else{echo $battleDetailInfo['radiantName'] ??'';} ?>
                                                    
                                            </span>
                                            <span title="Pinnacle???" class="td flex2 wrap">
                                                    <span class="leagueName elips"><?php echo $battleDetailInfo['tournamentName'] ??''; ?></span>
                                                    <span class="leagueTime"><?php echo date("Y-m-d H:i:s",substr($battleDetailInfo['matchTime'] ??0,0,-3));?></span>
                                                </span>
                                            <span class="td flex15"><?php echo date("i",$battleDetailInfo['lengthTime']??0 );?>???<?php echo date("s",$battleDetailInfo['lengthTime']??0 );?>???</span>
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
											<img src="<?php echo $config['site_url'];?>/images/null.png" data-original="<?php echo $config['site_url'];?>/images/null.png" alt="">
										</div>
										<?php }?>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ???????????? -->

						
                        <!-- ???????????? -->
                        <div class="dota2_item live_box <?php if(is_array($return['matchDetail']['data']['match_data']['matchData']) &&count($return['matchDetail']['data']['match_data']['matchData'])>0){?>active<?php } ?>">
							<?php if(isset($return['matchDetail']['data']['match_data']['matchData']) && count($return['matchDetail']['data']['match_data']['matchData'])>0){?>
                                <div class="war_report mb20">
                                    <div class="dota2_top">
                                        <img src="<?php echo $config['site_url'];?>/images/report.png" data-original="<?php echo $config['site_url'];?>/images/report.png" alt="">
                                        <span>????????????</span>
                                    </div>
									
                                    <div class="war_report_detail">
										<div class="war_report_detail_top">
											<?php 
												$is_display=0;
												if($return['matchDetail']['data']['away_score']>$return['matchDetail']['data']['home_score']){
													$totalWinTeam=$return['matchDetail']['data']['away_team_info']['team_name']?? '';
													$totalLoseTeam=$return['matchDetail']['data']['home_team_info']['team_name']?? '';
													$totalWinScore=$return['matchDetail']['data']['away_score']??0;
													$totalLoseScore=$return['matchDetail']['data']['home_score']??0;
													$is_display=1;
												}elseif($return['matchDetail']['data']['away_score']<$return['matchDetail']['data']['home_score']){
													$totalWinTeam=$return['matchDetail']['data']['home_team_info']['team_name']?? '';
													$totalLoseTeam=$return['matchDetail']['data']['away_team_info']['team_name']?? '';
													$totalWinScore=$return['matchDetail']['data']['home_score']??0;
													$totalLoseScore=$return['matchDetail']['data']['away_score']??0;
													$is_display=1;
												}?>
                                            <img src="<?php echo $config['site_url'];?>/images/dota2_war_report.png" data-original="<?php echo $config['site_url'];?>/images/dota2_war_report.png"  alt="">
                                            <p>??????????????????<?php echo count($return['matchDetail']['data']['match_data']['matchData']);?>???<?php if($is_display==1){?>???????????????<?php echo $totalWinTeam; ?><span><?php echo $totalWinScore;?>:<?php echo $totalLoseScore;?></span>??????<?php echo $totalLoseTeam; ?>???????????????????????????<?php }else{?>???<?php }?></p>
                                        </div>
										<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){
												if(isset($matchInfo['homeTeam']['teamStat']['firstBlood']) && $matchInfo['homeTeam']['teamStat']['firstBlood']==0){
													$firstBloodTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}else{
													$firstBloodTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}
												if(isset($matchInfo['homeTeam']['teamStat']['firstTower']) && $matchInfo['homeTeam']['teamStat']['firstTower']==0){
													$firstTowerTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}else{
													$firstTowerTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}
												if(isset($matchInfo['homeTeam']['teamStat']['fiveKill']) && $matchInfo['homeTeam']['teamStat']['fiveKill']==0){
													$fiveKillTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}else{
													$fiveKillTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}
												if(isset($matchInfo['homeTeam']['teamStat']['tenKill']) && $matchInfo['homeTeam']['teamStat']['tenKill']==0){
													$tenKillTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}else{
													$tenKillTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}
												if(isset($matchInfo['homeTeam']['teamStat']['fifteenKill']) && $matchInfo['homeTeam']['teamStat']['fifteenKill']==0){
													$fifteenKillTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}else{
													$fifteenKillTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}
												if($matchInfo['homeTeam']['teamStat']['win']==1){
													$gameWinTeam=$return['matchDetail']['data']['home_team_info']['team_name'];
												}else{
													$gameWinTeam=$return['matchDetail']['data']['away_team_info']['team_name'];
												}
												$economyLinesList=(is_array($matchInfo['economyLinesList']) && count($matchInfo['economyLinesList'])>0)?array_pop($matchInfo['economyLinesList']):[] ;
												$expLinesList=(is_array($matchInfo['expLinesList']) && count($matchInfo['expLinesList'])>0)?array_pop($matchInfo['expLinesList']):[] ;
												$economicDiff=$economyLinesList['diff']??0;
												$expDiff=$expLinesList['diff']??0;
												
												
												
											?>
										
                                        <!-- ???????????? -->
                                        <div class="firstStep">
                                            <span><?php echo ($matchKey+1)?></span>
                                            <p>???<?php echo ($matchKey+1)?>????????????<?php echo date("i",$matchInfo['lengthTime'])?>:<?php echo date("s",$matchInfo['lengthTime'])?>????????? <?php echo $gameWinTeam ??''; ?>  ???????????????????????????</p>
                                        </div>
                                        <p class="pl38">???????????????<?php echo $firstBloodTeam; ?>  ???????????????<?php echo $firstTowerTeam; ?> ?????????????????????????????????<?php echo $fiveKillTeam; ?> ???????????????<?php echo $tenKillTeam; ?> 
                                            ???????????????<?php echo $fifteenKillTeam; ?> ???????????????</p>
                                        <div class="secondStep">
                                            <div class="secondStep_img">
                                                <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_20,w_20';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'].'?x-oss-process=image/resize,m_lfit,h_20,w_20';?>" alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>">
                                            </div>
                                            <p><?php echo $matchInfo['homeTeam']['teamName'] ?? '';?> ??????<?php echo $matchInfo['homeTeam']['teamStat']['killCount']??0;?>??????????????????<?php if($economicDiff>0){?>??????<?php  }else{?>??????<?php }?><?php echo abs($economicDiff);?>????????????<?php if($expDiff>0){?>??????<?php }else{?>??????<?php }?><?php echo abs($expDiff);?>????????????<?php echo $matchInfo['awayTeam']['teamStat']['towerCount']??0;?>???????????????<?php echo $matchInfo['homeTeam']['teamStat']['crystalCount']??0;?></p>
                                        </div>
                                        <div class="thirdStep">
                                            <div class="thirdStep_img">
                                                <img src="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_20,w_20';?>" alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>">
                                            </div>
                                            <p><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?> ??????<?php echo $matchInfo['homeTeam']['teamStat']['killCount']??0;?>??????????????????<?php if($economicDiff>0){?>??????<?php }else{?>??????<?php }?><?php echo abs($economicDiff);?>????????????<?php if($matchInfo['awayTeam']['teamStat']['expCount']>$matchInfo['homeTeam']['teamStat']['expCount']){?>??????<?php }else{?>??????<?php }?><?php echo abs($expDiff);?>????????????<?php echo $matchInfo['awayTeam']['teamStat']['towerCount']??0;?>???????????????<?php echo $matchInfo['awayTeam']['teamStat']['crystalCount']??0;?></p>
                                        </div>
                                        <!-- ???????????? -->
                                        

										<?php }?>
                                       
                                    </div>
									
                                </div>
                                <ul class="live_box_ul clearfix">
									<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){?>
                                    <li <?php if($matchKey==0){?>class="active"<?php }?>>
                                        <div class="game_detail_img1">
											<?php 
											if($matchInfo['homeTeam']['teamStat']['win']==1){
												$team_logo_icon=$return['matchDetail']['data']['home_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_30,w_30';
												
											}else{
												$team_logo_icon=$return['matchDetail']['data']['away_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_30,w_30';
											}
											?>
                                            <img src="<?php echo $team_logo_icon;?>" data-original="<?php echo $team_logo_icon;?>"  alt="">
                                        </div>
                                        <span>GAME <?php echo ($matchKey+1);?></span>
                                      
                                    </li>
									<?php }?>
                                    
                                   
                                </ul>
                                <div class="live_box_detail ">
								
									<!--?????????-->
									<?php foreach($return['matchDetail']['data']['match_data']['matchData'] as $matchKey=>$matchInfo){?>
                                    <div class="live_box_item active">
                                        <div class="battle_details mb20">
                                            <div class="game_detail_item1">
                                                
													<a class="left" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['home_team_info']['tid'];?>">
                                                    <div class="imgwidth40 imgheight40">
                                                        <img data-original="<?php echo $return['matchDetail']['data']['home_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?>" class="imgauto">
                                                    </div>
                                                    <span><?php echo $return['matchDetail']['data']['home_team_info']['team_name'];?></span>
													
                                                    <?php if($matchInfo['homeTeam']['teamStat']['win']==1){?>
                                                    <div class="liveBox_img">
                                                        <img data-original="<?php echo $config['site_url'];?>/images/victory.png" src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
                                                    </div>
													<?php }?>
													</a>
                                             
                                                <div class="center">
                                                    <span class="game_detail_line1"></span>
                                                    <span class="game_detail_circle1"></span>
                                                    <span class="fz font_color_r"><?php echo  $matchInfo['homeTeam']['teamStat']['killCount']??0;?></span>
                                                    <div class="img_game_detail_vs">
                                                        <img data-original="<?php echo $config['site_url'];?>/images/game_detail_vs.png" src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="" class="imgauto">
                                                    </div>
                                                    <span class="fz font_color_b"><?php echo  $matchInfo['awayTeam']['teamStat']['killCount']??0;?></span>
                                                    <span class="game_detail_circle1"></span>
                                                    <span class="game_detail_line1"></span>
                                                </div>
                                                
													<a class="left right" href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $return['matchDetail']['data']['away_team_info']['tid'];?>">
                                                    <div class="imgwidth40 imgheight40">
                                                        <img data-original="<?php echo $return['matchDetail']['data']['away_team_info']['logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?>" class="imgauto">
                                                    </div>
                                                    <span><?php echo $return['matchDetail']['data']['away_team_info']['team_name'];?></span>
													
													<?php if($matchInfo['awayTeam']['teamStat']['win']==1){?>
                                                    <div class="liveBox_img">
                                                        <img data-original="<?php echo $config['site_url'];?>/images/victory.png" src="<?php echo $config['site_url'];?>/images/victory.png" alt="" class="imgauto">
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
														?????????
                                                    </li>
                                                    <li class="">
                                                        ?????????
                                                    </li>
                                                    <li class="">
                                                        ?????????
                                                    </li>
                                                    <li class="">
                                                        ?????????
                                                    </li>
                                                    <li class="active1">
                                                        ?????????
                                                    </li>
                                                </ul>
                                                <div class="battle_list">
													<!--??????-->
													<?php if(isset($matchInfo['homeTeam']['playerList']) && count($matchInfo['homeTeam']['playerList'])>0){
														foreach($matchInfo['homeTeam']['playerList'] as $playerKey=>$playerInfo){ ?>
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
                                                                    <img  data-original="<?php echo $equipmentInfo['logo']?? '';?>" src="<?php echo $return['defaultConfig']['data']['default_equipment_img']['value'];?>" alt="<?php echo $equipmentInfo['nameZh']?? '';?>">
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
                                                                    <span class="blue kad_small"><?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['killCount']??0;?>/<?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['dieCount']??0;?>/<?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['assistsCount']??0;?></span>
                                                                    <span class="blue kad_big"><?php 
																	if($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['dieCount'] !=0){
																		$kda=($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['killCount'] +$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['assistsCount'])/$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['dieCount'];
																	}else{
																		$kda=($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['killCount'] +$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['assistsCount']);
																	}
																	 echo round($kda,1);?></span>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['economicCount']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['economicCount']??0;?></span>
                                                                        <div class="average_time">??????</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['economicCount']/($playerInfo['playerStat']['economicCount']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['economicCount']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['economicCount']/($playerInfo['playerStat']['economicCount']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['economicCount']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['xpm']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['xpm']??0;?></span>
                                                                        <div class="average_time">????????????</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width:<?php echo ($playerInfo['playerStat']['xpm']/($playerInfo['playerStat']['xpm']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['xpm']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['xpm']/($playerInfo['playerStat']['xpm']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['xpm']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['gpm']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['gpm']??0;?></span>
                                                                        <div class="average_time">????????????</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['gpm']/($playerInfo['playerStat']['gpm']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['gpm']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['gpm']/($playerInfo['playerStat']['gpm']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['gpm']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="rate_data_left">
                                                                    <div class="rate_data_top">
                                                                        <span class="fl time1"><?php echo $playerInfo['playerStat']['lastHits']??0;?></span>
                                                                        <span class="fr time2"><?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['lastHits']??0;?></span>
                                                                        <div class="average_time">??????/??????</div>
                                                                    </div>
                                                                    <div class="compare-bar compare_bar clearfix">
                                                                        <div class="progress3 fl progress4 red">
                                                                            <span class="green" style="width: <?php echo ($playerInfo['playerStat']['lastHits']/($playerInfo['playerStat']['lastHits']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['lastHits']))*100;?>%;"></span>
                                                                        </div>
                                                                        <div class="progress3 fr blue">
                                                                            <span class="green" style="width: <?php echo ($matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['lastHits']/($playerInfo['playerStat']['lastHits']+$matchInfo['awayTeam']['playerList'][$playerKey]['playerStat']['lastHits']))*100;?>%;"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="battle_top_left">
                                                                <div class="battle_hero">
                                                                    <div class="heroBox">
                                                                        <img data-original="<?php echo  $matchInfo['awayTeam']['playerList'][$playerKey]['playerLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>" alt="<?php echo  $matchInfo['awayTeam']['playerList'][$playerKey]['playerName'];?>" class="imgauto">
																		
                                                                    </div>
                                                                    <div class="heroUse">
                                                                        <img data-original="<?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['heroLogo'];?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $matchInfo['awayTeam']['playerList'][$playerKey]['heroName']??'';?>" class="imgauto">
                                                                    </div>
                                                                </div>
                                                                <span class="battle_hero_name"><?php echo  $matchInfo['awayTeam']['playerList'][$playerKey]['playerName'];?></span>
                                                                <div class="thumbList">
																	<?php if(isset($matchInfo['awayTeam']['playerList'][$playerKey]['equipmentList']) && count($matchInfo['awayTeam']['playerList'][$playerKey]['equipmentList'])>0){
																		foreach($matchInfo['awayTeam']['playerList'][$playerKey]['equipmentList'] as $equipmentInfo){?>
                                                                    <img  data-original="<?php echo $equipmentInfo['logo']?? '';?>" src="<?php echo $return['defaultConfig']['data']['default_equipment_img']['value'];?>" alt="<?php echo $equipmentInfo['nameZh']?? '';?>">
																	<?php }}?>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="battle_item_bottom">
                                                            <div class="battle_bottom1">
                                                                <div class="war_situation">
														<span <?php if(isset($matchInfo['homeTeam']['teamStat']['firstTower']) && $matchInfo['homeTeam']['teamStat']['firstTower']>0){ ?>class="war_red" <?php }?>>??????</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['firstBlood']) && $matchInfo['homeTeam']['teamStat']['firstBlood']>0){ ?>class="war_red" <?php }?>>??????</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['fiveKill']) && $matchInfo['homeTeam']['teamStat']['fiveKill']>0){ ?>class="war_red" <?php }?>>?????????</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['tenKill']) && $matchInfo['homeTeam']['teamStat']['tenKill']>0){ ?>class="war_red" <?php }?>>?????????</span>
                                                                    <span <?php if(isset($matchInfo['homeTeam']['teamStat']['fifteenKill']) && $matchInfo['homeTeam']['teamStat']['fifteenKill']>0){ ?>class="war_red" <?php }?>>????????????</span>
                                                                   
                                                                </div>
                                                                <div class="war_situation" style="justify-content: flex-end;">
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['firstTower']) && $matchInfo['awayTeam']['teamStat']['firstTower']>0){ ?>class="war_blue" <?php }?>>??????</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['firstBlood']) && $matchInfo['awayTeam']['teamStat']['firstBlood']>0){ ?>class="war_blue" <?php }?>>??????</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['fiveKill']) && $matchInfo['awayTeam']['teamStat']['fiveKill']>0){ ?>class="war_blue" <?php }?>>?????????</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['tenKill']) && $matchInfo['awayTeam']['teamStat']['tenKill']>0){ ?>class="war_blue" <?php }?>>?????????</span>
                                                                    <span <?php if(isset($matchInfo['awayTeam']['teamStat']['fifteenKill']) && $matchInfo['awayTeam']['teamStat']['fifteenKill']>0){ ?>class="war_blue" <?php }?>>????????????</span>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="battle_bottom2">
                                                                <div class="row2 mb20">
                                                                    <div class="heroBan">
																		<?php if(isset($matchInfo['homeTeam']['ban']) && count($matchInfo['homeTeam']['ban'])>0){ 
																		 foreach($matchInfo['homeTeam']['ban'] as $banInfo){ ?>
                                                                        <img data-original="<?php echo $banInfo['logo']??''; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $banInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                        
                                                                    </div>
                                                                    <span class="bans">Bans</span>
                                                                    <div class="heroBan">
                                                                        <?php if(isset($matchInfo['awayTeam']['ban']) && count($matchInfo['awayTeam']['ban'])>0){ 
																		 foreach($matchInfo['awayTeam']['ban'] as $banInfo){ ?>
                                                                        <img  data-original="<?php echo $banInfo['logo']??''; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>"  alt="<?php echo $banInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                </div>
                                                                <div class="row2">
                                                                    <div class="heroPick">
                                                                       <?php if(isset($matchInfo['homeTeam']['pick']) && count($matchInfo['homeTeam']['pick'])>0){ 
																		 foreach($matchInfo['homeTeam']['pick'] as $pickInfo){ ?>
                                                                        <img data-original="<?php echo $pickInfo['logo']??''; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>"  alt="<?php echo $pickInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                    <span class="bans">Picks</span>
                                                                    <div class="heroPick">
                                                                        <?php if(isset($matchInfo['awayTeam']['pick']) && count($matchInfo['awayTeam']['pick'])>0){ 
																		 foreach($matchInfo['awayTeam']['pick'] as $pickInfo){ ?>
                                                                        <img data-original="<?php echo $pickInfo['logo']??''; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>" alt="<?php echo $pickInfo['nameZh']??''; ?>">
																		 <?php }}?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }}?>
                                                    <!--??????-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lineup_data">
                                            <div class="dota2_top">
                                                <img data-original="<?php echo $config['site_url'];?>/images/dota2_recent.png"  src="<?php echo $config['site_url'];?>/images/dota2_recent.png" alt="">
                                                <span>????????????</span>
                                            </div>
                                            <div class="lineup_mid">
												
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeKernel']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayKernel']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeKernel']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeKernel']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayKernel']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeControl']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayControl']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeControl']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeControl']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayControl']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeSente']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awaySente']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeSente']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeSente']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awaySente']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeBurst']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayBurst']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeBurst']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeBurst']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayBurst']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeEscape']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayEscape']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeEscape']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayEscape']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeEscape']))*100; ?>%;">
                                                                <i class="lightning"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="game_detail_item3">
                                                    <div class="game_detail_item3_top">
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeFightingWild']??0;?></span>
                                                        </div>
                                                        <p>??????</p>
                                                        <div class="left">
                                                            <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayFightingWild']??0;?></span>
                                                        </div>
                                                    </div>
                                                    <div class="pk-detail-con">
                                                        <div class="progress red">
                                                            <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeFightingWild']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayFightingWild']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeFightingWild']))*100; ?>%;">
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
                                                        <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeAdvance']??0;?></span>
                                                    </div>
                                                    <p>??????</p>
                                                    <div class="left">
                                                        <span><?php echo $matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayAdvance']??0;?></span>
                                                    </div>
                                                </div>
                                                <div class="pk-detail-con">
                                                    <div class="progress red">
                                                        <div class="progress-bar" style="width: <?php echo ($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeAdvance']/($matchInfo['lineupContent']['dataAnalysis']['heroAttr']['awayAdvance']+$matchInfo['lineupContent']['dataAnalysis']['heroAttr']['homeAdvance']))*100; ?>%;">
                                                            <i class="lightning"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<?php $statistical=["winRate"=>"??????","firstBloodRate"=>"?????????","firstTowerRate"=>"?????????","fiveKillRate"=>"?????????","tenKillRate"=>"?????????"]; ?>
                                            <div class="lineup_bottom">
                                                <ul class="vs_data2 lineup_vs_data2">
												<!--??????????????????????????????????????????????????????-->
													<?php foreach($statistical as $statisticalKey=>$statisticalInfo){?>
                                                    <li <?php if($statisticalKey=="winRate"){ ?>class="active" <?php }?>>
                                                        <?php echo $statisticalInfo;?>
                                                    </li>
                                                    <?php }?>
                                                </ul>
                                                <div class="lineup_list">
													<?php 
														$position=["??????","??????","ADC","??????","??????"];
														$winRateDataAnalysis=$firstBloodRateDataAnalysis=$firstTowerDataAnalysis=$fiveKillRateDataAnalysis=$tenKillRateDataAnalysis=[];
														//??????
														if(isset($matchInfo['lineupContent']['dataAnalysis']['homeHeroStat'])){
															foreach($matchInfo['lineupContent']['dataAnalysis']['homeHeroStat'] as $homeHeroStatKey=>$homeHeroStatInfo){
																//??????
																if($homeHeroStatInfo['allTotal']>0){
																	$winRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allWinCount']/$homeHeroStatInfo['allTotal'],3)*100;
																}else{
																	$winRateDataAnalysis[$homeHeroStatKey]['homeRate']=0;
																}
																
																$winRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allWinCount']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//????????????
																if($homeHeroStatInfo['currTotal']>0){
																	$winRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currWinCount']/$homeHeroStatInfo['currTotal'],3)*100;
																}else{
																	$winRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=0;
																}
																
																$winRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currWinCount']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																$winRateDataAnalysis[$homeHeroStatKey]['postion']=$position[$homeHeroStatKey];
																//??????
																if(strpos($homeHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$winRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??'';
																}else{
																	$winRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']='';
																}
																
																$winRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//?????????
																if($homeHeroStatInfo['allTotal']>0){
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFirstBloodsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																}else{
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeRate']=0;
																}
																
																
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//????????????
																if($homeHeroStatInfo['currTotal']>0){
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFirstBloodsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																}else{
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=0;
																}
																
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['postion']=$position[$homeHeroStatKey];
																//??????
																if(strpos($homeHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??'';
																}else{
																	$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']='';
																}
																
																$firstBloodRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//?????????
																if($homeHeroStatInfo['allTotal']>0){
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFirstTowersCount']/$homeHeroStatInfo['allTotal'],3)*100;
																}else{
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeRate']=0;
																}
																
																
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFirstTowersCount']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//????????????
																if($homeHeroStatInfo['currTotal']>0){
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFirstTowersCount']/$homeHeroStatInfo['currTotal'],3)*100;
																}else{
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=0;
																}
																
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFirstTowersCount']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																$firstTowerDataAnalysis[$homeHeroStatKey]['postion']=$position[$homeHeroStatKey];
																//??????
																if(strpos($homeHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??'';
																}else{
																	$firstTowerDataAnalysis[$homeHeroStatKey]['homeheroLogo']='';
																}
																
																$firstTowerDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//?????????
																if($homeHeroStatInfo['allTotal']>0){
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allFiveKillsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																}else{
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=0;
																}
																
																
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//????????????
																if($homeHeroStatInfo['currTotal']>0){
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currFiveKillsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																}else{
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=0;
																}
																
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['postion']=$position[$homeHeroStatKey];
																
																//??????
																if(strpos($homeHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??'';
																}else{
																	$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']='';
																}
																
																$fiveKillRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
																
																//?????????
																if(isset($homeHeroStatInfo['allTotal']) && $homeHeroStatInfo['allTotal']>0){
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=number_format($homeHeroStatInfo['allTenKillsCount']/$homeHeroStatInfo['allTotal'],3)*100;
																}else{
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeRate']=0;
																}
																
																
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeAllWinCount']=$homeHeroStatInfo['allTenKillsCount']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeAllTotal']=$homeHeroStatInfo['allTotal']??0;
																//????????????
																if($homeHeroStatInfo['currTotal']>0){
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=number_format($homeHeroStatInfo['currTenKillsCount']/$homeHeroStatInfo['currTotal'],3)*100;
																}else{
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinRate']=0;
																}
																
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrWinCount']=$homeHeroStatInfo['currTenKillsCount']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeCurrTotal']=$homeHeroStatInfo['currTotal']??0;
																$tenKillRateDataAnalysis[$homeHeroStatKey]['postion']=$position[$homeHeroStatKey];
																
																//??????
																if(strpos($homeHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']=$homeHeroStatInfo['heroLogo']??'';
																}else{
																	$tenKillRateDataAnalysis[$homeHeroStatKey]['homeheroLogo']='';
																}
																
																$tenKillRateDataAnalysis[$homeHeroStatKey]['homeheroName']=$homeHeroStatInfo['heroName']??0;
															}
															
														}
														//??????
														if(isset($matchInfo['lineupContent']['dataAnalysis']['awayHeroStat'])){
															foreach($matchInfo['lineupContent']['dataAnalysis']['awayHeroStat'] as $awayHeroStatKey=>$awayHeroStatInfo){
												
																//??????
																if($awayHeroStatInfo['allTotal']>0){
																	$winRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allWinCount']/$awayHeroStatInfo['allTotal'],3)*100;
																}else{
																	$winRateDataAnalysis[$awayHeroStatKey]['awayRate']=0;
																}
																
																$winRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allWinCount']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//????????????
																if($awayHeroStatInfo['currTotal']>0){
																	$winRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currWinCount']/$awayHeroStatInfo['currTotal'],3)*100;
																}else{
																	$winRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=0;
																}
																
																$winRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currWinCount']??0;
																$winRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																//??????
																if(strpos($awayHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$winRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??'';
																}else{
																	$winRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']='';
																}
																
																$winRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																
																//?????????
																if($awayHeroStatInfo['allTotal']>0){
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFirstBloodsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																}else{
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayRate']=0;
																}
																
																
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//????????????
																if($awayHeroStatInfo['currTotal']>0){
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFirstBloodsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																}else{
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=0;
																}
																
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFirstBloodsCount']??0;
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																//??????
														
																if(strpos($awayHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??'';
																}else{
																	$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']='';
																}
																
																$firstBloodRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//?????????
																if($awayHeroStatInfo['allTotal']>0){
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFirstTowersCount']/$awayHeroStatInfo['allTotal'],3)*100;
																}else{
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayRate']=0;
																}
																
																
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFirstTowersCount']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayeAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//????????????
																if($awayHeroStatInfo['currTotal']>0){
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFirstTowersCount']/$awayHeroStatInfo['currTotal'],3)*100;
																}else{
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=0;
																}
																
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFirstTowersCount']??0;
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																//??????
																if(strpos($awayHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??'';
																}else{
																	$firstTowerDataAnalysis[$awayHeroStatKey]['awayheroLogo']='';
																}
																
																$firstTowerDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//?????????
																if($awayHeroStatInfo['allTotal']>0){
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allFiveKillsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																}else{
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayRate']=0;
																}
																
																
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//????????????
																if($awayHeroStatInfo['currTotal']){
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currFiveKillsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																}else{
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=0;
																}
																
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currFiveKillsCount']??0;
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																//??????
																if(strpos($awayHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??'';
																}else{
																	$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']='';
																}
																
																$fiveKillRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
																
																//?????????
																if($awayHeroStatInfo['allTotal']>0){
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['awayRate']=number_format($awayHeroStatInfo['allTenKillsCount']/$awayHeroStatInfo['allTotal'],3)*100;
																}else{
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['homeRate']=0;
																}
																
																
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayAllWinCount']=$awayHeroStatInfo['allTenKillsCount']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayAllTotal']=$awayHeroStatInfo['allTotal']??0;
																//????????????
																if($awayHeroStatInfo['currTotal']>0){
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinRate']=number_format($awayHeroStatInfo['currTenKillsCount']/$awayHeroStatInfo['currTotal'],3)*100;
																}else{
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['vCurrWinRate']=0;
																}
																
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrWinCount']=$awayHeroStatInfo['currTenKillsCount']??0;
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayCurrTotal']=$awayHeroStatInfo['currTotal']??0;
																//??????
																if(strpos($awayHeroStatInfo['heroLogo'],'esports-cdn.namitiyu.com')===false){
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']=$awayHeroStatInfo['heroLogo']??'';
																}else{
																	$tenKillRateDataAnalysis[$awayHeroStatKey]['awayheroLogo']='';
																}
																
																$tenKillRateDataAnalysis[$awayHeroStatKey]['awayheroName']=$awayHeroStatInfo['heroName']??0;
															}
															
														}
														
														$dataAnalysis=[];
														
													foreach($statistical as $statisticalKey=>$statisticalInfo){
														if($statisticalKey=='winRate'){
															//????????????
															$dataAnalysis=$winRateDataAnalysis;
														}elseif($statisticalKey=='firstBloodRate'){
															//???????????????
															$dataAnalysis=$firstBloodRateDataAnalysis;
														}elseif($statisticalKey=='firstTowerRate'){
															//???????????????
															$dataAnalysis=$firstTowerDataAnalysis;
														
														}elseif($statisticalKey=='fiveKillRate'){
															//???????????????
															$dataAnalysis=$fiveKillRateDataAnalysis;
														}elseif($statisticalKey=='tenKillRate'){
															//?????????????????????
															$dataAnalysis=$tenKillRateDataAnalysis;
														} 
													
														?>
                                                    <div class="lineup_item <?php if($statisticalKey=='winRate'){ ?>active <?php }?>">
                                                        <div class="lineup_th">
                                                            <div class="lineup_thItem red">
                                                                <span class="flex15">????????????(???/??????)</span>
                                                                <span class="flex15">????????????(???/??????)</span>
                                                                <span>??????</span>
                                                                <span>???</span>
                                                            </div>
                                                            <div class="lineup_thItem blue lineup_thRever">
                                                                <span class="flex15">????????????(???/??????)</span>
                                                                <span class="flex15">????????????(???/??????)</span>
                                                                <span>??????</span>
                                                                <span>???</span>
                                                            </div>
                                                        </div>
														<?php foreach($dataAnalysis as $key=>$dataAnalysisInfo){?>
                                                        <div class="lineup_td">
                                                            <div class="lineup_thItem">
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['homeRate']; ?>%<i>(<?php echo $dataAnalysisInfo['awayAllWinCount'];?>/<?php echo $dataAnalysisInfo['homeAllTotal'];?>)</i></span>
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['homeCurrWinRate']; ?>%<i>(<?php echo $dataAnalysisInfo['homeCurrWinCount']; ?>/<?php echo $dataAnalysisInfo['homeCurrTotal']; ?>)</i></span>
                                                                <span>
                                                                    <img  class="lineup_img"  data-original="<?php echo $dataAnalysisInfo['homeheroLogo']; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>"  alt="<?php echo $dataAnalysisInfo['homeheroName']; ?>">
                                                                </span>
                                                                <span class="dn">???</span>
                                                            </div>
                                                            <div class="lineup_thItem lineup_thRever">
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['awayRate']; ?>%<i>(<?php echo $dataAnalysisInfo['awayAllWinCount']; ?>/<?php echo $dataAnalysisInfo['awayAllTotal']; ?>)</i></span>
                                                                <span class="flex15"><?php echo $dataAnalysisInfo['awayCurrWinRate']; ?>%<i>(<?php echo $dataAnalysisInfo['awayCurrWinCount']; ?>/<?php echo $dataAnalysisInfo['awayCurrTotal']; ?>)</i></span>
                                                                <span>
                                                                    <img  class="lineup_img"  data-original="<?php echo $dataAnalysisInfo['awayheroLogo']; ?>" src="<?php echo $return['defaultConfig']['data']['default_hero_img']['value'];?>"   alt="<?php echo $dataAnalysisInfo['awayheroName']; ?>">
                                                                </span>
                                                                <span class="dn">???</span>
                                                            </div>
                                                            <p><?php echo $dataAnalysisInfo['postion']; ?></p>
                                                        </div>
                                                        
														<?php }?>
														
                                                    </div>
													<?php } ?>
													<!--??????-->
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php }?>
									<!--?????????-->
                                    
                                </div>
								<?php }else{?>
								<div class="null">
									<img src="<?php echo $config['site_url'];?>/images/null.png" data-original="<?php echo $config['site_url'];?>/images/null.png" alt="">
								</div>
								<?php } ?>
                            </div>
                        <!-- ???????????? -->
                    </div>
                </div>
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
						<?php foreach($return['recentMatchList']['data'] as $matchInfo){ ?>
                        <li class="col-md-12 col-xs-12">
                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                <div class="game_match_top">
                                    <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                    <span class="game_match_time"><?php echo date("m???d??? H:i",strtotime($matchInfo['start_time']));?></span>
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
                                    <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
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
                                <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
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
                                <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/game_fire.png" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
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

<?php renderFooterJsCss($config,[],["jquery.lineProgressbar","echarts.min","circle-progress"]);?>
<script>
    //???????????????
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


    //?????????????????????????????????
    $(".dota2_ul1").on("click", 'li', function () {
        $(".dota2_ul1 li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".dota2").find(".dota2_div").find(".dota2_item").removeClass("active").eq($(this).index()).addClass("active");
    })

    //????????????tab??????
    $(".battleBox .vs_data1").on("click", 'li', function () {
        var _this = $(this).index() - 1;
        $(".battleBox .vs_data1 li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".vs_data1").find("li").removeClass("active1").eq(_this).addClass("active1");
        $(".battleBox .vs_data2 .vs_data2_item").removeClass("active").eq($(this).index()).addClass("active");
        $(this).parents(".battleBox").find(".battle_list").find(".battle_item").removeClass("active").eq($(this).index()).addClass("active")
    })


    //????????????tab??????
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