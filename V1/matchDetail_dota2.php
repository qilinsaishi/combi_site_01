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
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img","default_hero_img"],"fields"=>["name","key","value"],"site_id"=>$config["site_id"]],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"page_size"=>3,"source"=>$source,"cacheWith"=>"currentPage","cache_time"=>86400],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>$game,"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$game,"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$source,"site_id"=>$config['site_id']]
];

$return = curl_post($config['api_get'],json_encode($params),1);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
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
                                    <img data-original="<?php echo $return['matchDetail']['data']['away_logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['away_name'];?>" class="imgauto">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['away_name']??'';?></span>
                        </div>
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
                        <div class="game_team1">
                            <div class="game_team1_img">
                                <div class="game_team1_img1">
                                    <img data-original="<?php echo $return['matchDetail']['data']['home_logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $return['matchDetail']['data']['home_name'];?>">
                                </div>
                            </div>
                            <span><?php echo $return['matchDetail']['data']['home_name']??'';?></span>
                        </div>
                    </div>
                    <div class="game_team_depiction">
                        <p class="active"><!--主队描述--></p>
                        <p class="active"><!--客队描述--></p>
                    </div>
                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="" class="game_title_more">
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
                                <img src="<?php echo $config['site_url'];?>/images/dota2_recent.png" alt="">
                                <span>近期战队数据对比</span>
                            </div>
                            <div class="dota2_div1_team">
                                <div class="teamInfo ">
                                    <div class="colorBlock colorBlock_right red"></div>
                                    <div class="teamInfo_img">
                                        <img data-original="<?php echo $return['matchDetail']['data']['away_logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>"  alt="<?php echo $return['matchDetail']['data']['away_name'];?>" class="imgauto">
                                    </div>
                                    <span class="text_left"><?php echo $return['matchDetail']['data']['away_name']??'';?></span>
                                </div>
                                <div class="dota2_vs">
                                    <img src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                </div>
                                <div class="teamInfo teamInfo_reverse">
                                    <div class="colorBlock blue"></div>
                                    <div class="teamInfo_img">
                                        <img data-original="<?php echo $return['matchDetail']['data']['home_logo'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'].'?x-oss-process=image/resize,m_lfit,h_40,w_40';?>"  alt="<?php echo $return['matchDetail']['data']['home_name'];?>" class="imgauto">
                                    </div>
                                    <span class="text_right"><?php echo $return['matchDetail']['data']['home_name']??'';?></span>
                                </div>
                            </div>
                            <div class="bpBox">
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dred third circle" data-num="<?php echo ($return['matchDetail']['data']['match_data']['team_base_data']['red_victory_rate']/100)??'0';?>">
                                            <strong>
                                                <p></p>
                                                <span>胜率</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_data']['team_base_data']['red_victory_tip_text']??'';?></p>
                                        <p class="bpBox_kda red">KDA：<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['red_kda']??'0';?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_data']['team_base_data']['red_kills']??'0';?>/<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['red_deaths']??'0';?>/<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['red_assists']??'0';?></p>
                                    </div>
                                </div>
                                <div class="center">
									<?php if($return['matchDetail']['data']['match_data']['team_base_data']['data_list_item'] &&count($return['matchDetail']['data']['match_data']['team_base_data']['data_list_item'])>0){?>
										<?php foreach($return['matchDetail']['data']['match_data']['team_base_data']['data_list_item'] as $dataKeyItem=>$dataInfoItem){ ?>
											<div class="rate_data_left">
												<div class="rate_data_top">
													<span class="fl time1"><?php echo $dataInfoItem['red']??0; ?></span>
													<span class="fr time2"><?php echo $dataInfoItem['blue']??0; ?></span>
													<div class="average_time"><?php echo $dataInfoItem['title']??0; ?></div>
												</div>
												<div class="compare-bar compare_bar clearfix">
													<div class="progress3 fl progress4 red">
														<span class="green" style="width: <?php echo $dataInfoItem['red']/($dataInfoItem['red']+$dataInfoItem['blue'])*100; ?>%;"></span>
													</div>
													<div class="progress3 fr blue">
														<span class="green" style="width: <?php echo $dataInfoItem['blue']/($dataInfoItem['red']+$dataInfoItem['blue'])*100; ?>%;"></span>
													</div>
												</div>
											</div>
										<?php }?>
									<?php } ?>
                                    
                                </div>
                                <div class="left">
                                    <div class="bpBox_circle">
                                        <div class="Dblue third circle" data-num="<?php echo ($return['matchDetail']['data']['match_data']['team_base_data']['blue_victory_rate']/100)??'0';?>">
                                            <strong>
                                                <p></p>
                                                <span>胜率</span>
                                            </strong>
                                        </div>
                                        <p class="bpBox_result"><?php echo $return['matchDetail']['data']['match_data']['team_base_data']['blue_victory_tip_text']??'';?></p>
                                        <p class="bpBox_kda blue">KDA：<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['blue_kda']??'';?></p>
                                        <p class="bpBox_Date"><?php echo $return['matchDetail']['data']['match_data']['team_base_data']['blue_kills']??'0';?>/<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['blue_deaths']??'0';?>/<?php echo $return['matchDetail']['data']['match_data']['team_base_data']['blue_assists']??'0';?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="barChart">
								<?php if($return['matchDetail']['data']['match_data']['team_base_data']['statistics_list'] &&count($return['matchDetail']['data']['match_data']['team_base_data']['statistics_list'])>0){?>
									<?php foreach($return['matchDetail']['data']['match_data']['team_base_data']['statistics_list'] as $statisticsInfo){ ?>
									<div class="bar_item">
										<div class="outCol">
											<div class="col">
												<div class="bar red" style=" height:<?php echo trim($statisticsInfo['red'])??'0';?>%;">
													<span class="bar_rate"><?php echo trim($statisticsInfo['red'])??'0';?>%</span>
												</div>
											</div>
											<div class="col">
												<div class="bar blue" style="height: <?php echo intval(trim($statisticsInfo['blue']))??'0';?>%;">
													<span class="bar_rate"><?php echo trim($statisticsInfo['blue'])??'0';?>%</span>
												</div>
											</div>
											<span class="itemName"><?php echo $statisticsInfo['name']??'0';?></span>
										</div>
									</div>
									<?php }?>
								<?php } ?>
                                
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
                                        <!--<div class="row1">
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
                                        </div>-->
										<div class="null">
											<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
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
                                        <!--<div class="row1">
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
                                        </div>-->
                                        <div class="null">
											<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
										</div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 赛前分析 -->

						
                        <!-- 比赛详情 -->
                        <div class="dota2_item live_box active">
                            <div class="war_report mb20">
                                <div class="dota2_top">
                                    <img src="<?php echo $config['site_url'];?>/images/report.png" alt="">
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
                            <div class="battle_details mb20">
                                <div class="dota2_top">
                                    <img src="<?php echo $config['site_url'];?>/images/dota2_vs.png" alt="">
                                    <span>对战详情</span>
                                </div>
                                <div class="battleBox">
                                    <ul class="vs_data1">
                                        <li class="active">
                                            <a href="##">
                                                一号位
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                二号位
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                三号位
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                四号位
                                            </a>
                                        </li>
                                        <li class="active1">
                                            <a href="##">
                                                五号位
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="battle_list">
                                        <div class="battle_item active">
                                            <div class="battle_item_top">
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="center">
                                                    <div class="kda_detail">
                                                        <span class="red kad_big">12.5</span>
                                                        <span class="red kad_small">2/2/23</span>
                                                        <span class="kad_big">KDA</span>
                                                        <span class="blue kad_small">2/2/23</span>
                                                        <span class="blue kad_big">12.5</span>
                                                    </div>
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
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="battle_item_bottom">
                                                <div class="battle_bottom1">
                                                    <div class="war_situation">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                    <div class="war_situation" style="justify-content: flex-end;">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                </div>
                                                <div class="battle_bottom2">
                                                    <div class="row2 mb20">
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Bans</span>
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="row2">
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Picks</span>
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="battle_item">
                                            <div class="battle_item_top">
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">22222BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="center">
                                                    <div class="kda_detail">
                                                        <span class="red kad_big">12.5</span>
                                                        <span class="red kad_small">2/2/23</span>
                                                        <span class="kad_big">KDA</span>
                                                        <span class="blue kad_small">2/2/23</span>
                                                        <span class="blue kad_big">12.5</span>
                                                    </div>
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
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="battle_item_bottom">
                                                <div class="battle_bottom1">
                                                    <div class="war_situation">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                    <div class="war_situation" style="justify-content: flex-end;">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                </div>
                                                <div class="battle_bottom2">
                                                    <div class="row2 mb20">
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Bans</span>
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="row2">
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Picks</span>
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="battle_item">
                                            <div class="battle_item_top">
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">3323BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="center">
                                                    <div class="kda_detail">
                                                        <span class="red kad_big">12.5</span>
                                                        <span class="red kad_small">2/2/23</span>
                                                        <span class="kad_big">KDA</span>
                                                        <span class="blue kad_small">2/2/23</span>
                                                        <span class="blue kad_big">12.5</span>
                                                    </div>
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
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="battle_item_bottom">
                                                <div class="battle_bottom1">
                                                    <div class="war_situation">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                    <div class="war_situation" style="justify-content: flex-end;">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                </div>
                                                <div class="battle_bottom2">
                                                    <div class="row2 mb20">
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Bans</span>
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="row2">
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Picks</span>
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="battle_item">
                                            <div class="battle_item_top">
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">4444BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="center">
                                                    <div class="kda_detail">
                                                        <span class="red kad_big">12.5</span>
                                                        <span class="red kad_small">2/2/23</span>
                                                        <span class="kad_big">KDA</span>
                                                        <span class="blue kad_small">2/2/23</span>
                                                        <span class="blue kad_big">12.5</span>
                                                    </div>
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
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="battle_item_bottom">
                                                <div class="battle_bottom1">
                                                    <div class="war_situation">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                    <div class="war_situation" style="justify-content: flex-end;">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                </div>
                                                <div class="battle_bottom2">
                                                    <div class="row2 mb20">
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Bans</span>
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="row2">
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Picks</span>
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="battle_item">
                                            <div class="battle_item_top">
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">555BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="center">
                                                    <div class="kda_detail">
                                                        <span class="red kad_big">12.5</span>
                                                        <span class="red kad_small">2/2/23</span>
                                                        <span class="kad_big">KDA</span>
                                                        <span class="blue kad_small">2/2/23</span>
                                                        <span class="blue kad_big">12.5</span>
                                                    </div>
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
                                                <div class="battle_top_left">
                                                    <div class="battle_hero">
                                                        <div class="heroBox">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_hero.png" alt="" class="imgauto">
                                                        </div>
                                                        <div class="heroUse">
                                                            <img src="<?php echo $config['site_url'];?>/images/battle_use.png" alt="" class="imgauto">
                                                        </div>
                                                    </div>
                                                    <span class="battle_hero_name">BraxBraxBraxBraxBrax</span>
                                                    <div class="thumbList">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb1.png" alt="">
                                                        <img src="<?php echo $config['site_url'];?>/images/zb2.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="battle_item_bottom">
                                                <div class="battle_bottom1">
                                                    <div class="war_situation">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                    <div class="war_situation" style="justify-content: flex-end;">
                                                        <span class="war_red">一塔</span>
                                                        <span class="war_blue">一血</span>
                                                        <span>先五杀</span>
                                                        <span>先十杀</span>
                                                        <span>一小龙</span>
                                                        <span>一大龙</span>
                                                        <span>一先锋</span>
                                                    </div>
                                                </div>
                                                <div class="battle_bottom2">
                                                    <div class="row2 mb20">
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Bans</span>
                                                        <div class="heroBan">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="row2">
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                        <span class="bans">Picks</span>
                                                        <div class="heroPick">
                                                            <img src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumitem2.png" alt="">
                                                            <img src="<?php echo $config['site_url'];?>/images/thumbitem2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                <span>3</span>
                                            </div>
                                            <p>核心</p>
                                            <div class="left">
                                                <span>4</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 58%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_item3">
                                        <div class="game_detail_item3_top">
                                            <div class="left">
                                                <span>3</span>
                                            </div>
                                            <p>控制</p>
                                            <div class="left">
                                                <span>4</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 58%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_item3">
                                        <div class="game_detail_item3_top">
                                            <div class="left">
                                                <span>3</span>
                                            </div>
                                            <p>先手</p>
                                            <div class="left">
                                                <span>5</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 78%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_item3">
                                        <div class="game_detail_item3_top">
                                            <div class="left">
                                                <span>3</span>
                                            </div>
                                            <p>爆发</p>
                                            <div class="left">
                                                <span>0</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 100%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_item3">
                                        <div class="game_detail_item3_top">
                                            <div class="left">
                                                <span>3</span>
                                            </div>
                                            <p>逃生</p>
                                            <div class="left">
                                                <span>4</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 38%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_item3">
                                        <div class="game_detail_item3_top">
                                            <div class="left">
                                                <span>2</span>
                                            </div>
                                            <p>打野</p>
                                            <div class="left">
                                                <span>4</span>
                                            </div>
                                        </div>
                                        <div class="pk-detail-con">
                                            <div class="progress red">
                                                <div class="progress-bar" style="width: 28%;">
                                                    <i class="lightning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="game_detail_item3 mb60">
                                    <div class="game_detail_item3_top">
                                        <div class="left">
                                            <span>3</span>
                                        </div>
                                        <p>推进</p>
                                        <div class="left">
                                            <span>4</span>
                                        </div>
                                    </div>
                                    <div class="pk-detail-con">
                                        <div class="progress red">
                                            <div class="progress-bar" style="width: 38%;">
                                                <i class="lightning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lineup_bottom">
                                    <ul class="vs_data2">
                                        <li class="active">
                                            <a href="##">
                                                胜率
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                一血率
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                一塔率
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="##">
                                                五杀率
                                            </a>
                                        </li>
                                        <li class="active1">
                                            <a href="##">
                                                十杀率
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="lineup_list">
                                        <div class="lineup_item active">
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
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">15%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>上单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>打野</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>ADC</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15"></i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>中单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15"></i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>辅助</p>
                                            </div>
                                        </div>
                                        <div class="lineup_item">
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
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">25%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>上单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>打野</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>ADC</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15"></i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>中单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15"></i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>辅助</p>
                                            </div>
                                        </div>
                                        <div class="lineup_item">
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
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">35%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>上单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>打野</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>ADC</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15"></i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>中单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15"></i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>辅助</p>
                                            </div>
                                        </div>
                                        <div class="lineup_item">
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
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">45%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>上单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>打野</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>ADC</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15"></i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>中单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15"></i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>辅助</p>
                                            </div>
                                        </div>
                                        <div class="lineup_item">
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
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>上单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>打野</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>ADC</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15"></i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>中单</p>
                                            </div>
                                            <div class="lineup_td">
                                                <div class="lineup_thItem">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15">66%<i>(2/4)</i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">位</span>
                                                </div>
                                                <div class="lineup_thItem lineup_thRever">
                                                    <span class="flex15">55%<i>(27/49)</i></span>
                                                    <span class="flex15"></i></span>
                                                    <span>
                                                            <img  class="lineup_img" src="<?php echo $config['site_url'];?>/images/dota_hero1.png" alt="">
                                                        </span>
                                                    <span class="dn">置</span>
                                                </div>
                                                <p>辅助</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <span class="game_match_name">常规赛常规常规赛常规常规赛常规</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="imgauto">
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
                                            <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="imgauto">
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
                                            <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="imgauto">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="imgauto">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                </div>
                            </a>
                        </li>
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
<?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
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