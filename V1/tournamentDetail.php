<?php
require_once "function/init.php";
$postParams=explode('-',trim($_GET['tournament_id']));
if(count($postParams)<2){
	render404($config);
}
$game=$postParams[0]?? $config['default_game'];
$tournament_id = $postParams[1]??0;
$tournament_id=intval($tournament_id);
if(!isset($tournament_id ) ||$tournament_id==0 )
{
    render404($config);
}
$source=$config['game_source'][$game]??$config['default_source'];

$params = [
    "tournament"=>[$tournament_id,"source"=>$source],
    "tournamentList"=>["page"=>1,"page_size"=>4,"source"=>$source,"game"=>$game,"cache_time"=>86400],
	"matchList" =>
        ["dataType"=>"matchList","tournament_id"=>$tournament_id,"source"=>$source,"game"=>$game,"page"=>1,"page_size"=>1000,"cache_time"=>3600],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img","default_information_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"tournamentDetail","tournament_id"=>$tournament_id,"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
//获取当前战队的游戏
 $intergrated_id_list=array_column($return['tournament']['data']['teamList'], 'intergrated_id_list');
 $intergrated_id=array();
foreach($intergrated_id_list as $val){
	$intergrated_id=array_merge($intergrated_id,$val);
}
$intergrated_id=array_unique($intergrated_id);


//当前游戏下面的资讯
$params2=[
	 "keywordMapList"=>["fields"=>"content_id","source_type"=>"team","source_id"=>$intergrated_id,"page_size"=>10,"content_type"=>"information","list"=>["page_size"=>10,"fields"=>"id,title,create_time,logo"]],
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


if(!isset($return["tournament"]['data']['tournament_id']))
{
    render404($config);
}
$matchList = [];
$defaultRound = 0;
if($game=='dota2'){
	$return['tournament']['data']['roundList'][] = [
	"round_id"=>0,
	"round_name"=>"默认轮次"
	];
}
else{
    if(count($return['tournament']['data']['roundList'])==0)
    {
        $defaultRound = 1;
    }
    //$return['tournament']['data']['roundList'] = (count($return['tournament']['data']['roundList'])>0)?($return['tournament']['data']['roundList']) : ([["round_id"=>0,"round_name"=>"默认轮次"]]);
}
foreach($return['tournament']['data']['roundList'] as $roundInfo)
{
    $matchList[$roundInfo['round_id']] = [];
}
foreach($return['matchList']['data'] as $matchInfo)
{
    $i=0;
    if($defaultRound == 1)
    {
        $matchInfo['round_id'] = $matchInfo['round_id']??0;
        if(!isset($return['tournament']['data']['roundList'][$matchInfo['round_id']]))
        {
            $return['tournament']['data']['roundList'][$matchInfo['round_id']] = ['round_id'=>$matchInfo['round_id'],"round_name"=>("轮次".($i+1))];
            $i++;
        }
    }
    //$matchInfo['round_id'] = $defaultRound!=1?$matchInfo['round_id']:0;
    $matchList[$matchInfo['round_id']??0][] = $matchInfo;
}
$return['tournament']['data']['roundList'] = array_values($return['tournament']['data']['roundList']);
unset($return['matchList']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $config['game'][$return['tournament']['data']['game']];?><?php echo $return['tournament']['data']['tournament_name'];?>_<?php echo $return['tournament']['data']['tournament_name'];?>数据赛程信息-<?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php echo $return['tournament']['data']['tournament_name'];?>,<?php echo $config['game'][$return['tournament']['data']['game']];?><?php echo $return['tournament']['data']['tournament_name'];?>">
    <meta name="description" content="">
    <?php renderHeaderJsCss($config,["right","events"]);?>
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
                            <?php generateNav($config,"tournament");?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="navigation row">
                <a href="<?php echo $config['site_url'];?>">
                    首页
                </a >
                >
                <a href="<?php echo $config['site_url'];?>/tournamentlist/<?php echo $return['tournament']['data']['game'];?>">
                    <?php echo  $config['game'][$return['tournament']['data']['game']]; ?>
                </a >
                >
                <span><?php echo $return['tournament']['data']['tournament_name'];?></span>
            </div>
        </div>
        <div class="container">
            <div class="row events_top">
                <!-- 比赛介绍 -->
                <div class="team_title mb20 clearfix">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="" data-original="<?php echo $return['tournament']['data']['logo'];?>?x-oss-process=image/resize,m_lfit,h_128,w_128" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>"  src="" alt="<?php echo $return['tournament']['data']['tournament_name'];?>">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <h1 class="name fl"><?php echo $return['tournament']['data']['tournament_name'];?></h1>
                            <p class="classify fl"><?php echo $config['game'][$return['tournament']['data']['game']];?></p>
                        </div>
                        <div class="team_explain_bottom">
                           <?php echo $return['tournament']['data']['description'] ?? '';?>
                        </div>
                    </div>
                </div>
                <!-- 比赛介绍 -->
                <div class="event_detail mb20">
                    <ul class="event_detail_ul">
						
                        <?php foreach($return['tournament']['data']['roundList'] as $key => $roundInfo){?>
                            <li<?php if($key==0){echo ' class="active"';}?>>
                               <?php echo $roundInfo['round_name'];?>（<?php echo count($matchList[$roundInfo['round_id']]);?>）
                            </li>
                        <?php }?>
							
                    </ul>
                    <div class="event_detail_content">
						
                        <?php foreach($return['tournament']['data']['roundList'] as $key => $roundInfo){?>
                            <div class="event_detail_div <?php if($key==0){echo ' active';}?>">
                                <div class="scroll">
                                    <ul class="event_detail_item">
                                        <?php if(count($matchList[$roundInfo['round_id']])>0){ 
										//按时间倒序排列
										array_multisort(array_column($matchList[$roundInfo['round_id']],"start_time"),SORT_DESC,$matchList[$roundInfo['round_id']]);?>
                                        <?php foreach($matchList[$roundInfo['round_id']] as $matchInfo){?>
                                                <li>
													<?php if($game=='lol' || $game=='kpl') {   
												?>
													<div class="game3_game_item">
													<div class="game3_team1 fl">
														<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
															<div class="game3_team1_top clearfix">
																<div class="game3_team1_top_img fl">
																	<img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"
																	 class="imgauto" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
																</div>
																<span class="game3_team1_top_name fl"><?php echo $matchInfo['home_team_info']['team_name'];?></span>
															</div>
															<div class="game3_team1_bottom red">
																<div class="game3_team1_allplayer">
																	<?php $i=0;foreach($matchInfo['home_player_list']??[] as $playerInfo){$i++;?>
																		<div class="game3_team1_player">
																			<img  data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"  class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
																		</div>
																		<?php if($i>=5){break;}}?>
																</div>
																<div class="game3_team_players"><?php echo count($matchInfo['home_player_list']??[]);?></div>
															</div>
														</a>
													</div>
													<div class="game3_team2_vs fl">
														<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
															<div class="game3_team2_vs_top">
																<div class="bg_wr">
																	<div class="game3_team2_vs_bg">
																	</div>
																</div>
																<div class="time_over">
																	<p class="game3_team2_vs_time stop"><?php echo date("m-d H:i",strtotime($matchInfo['start_time']));?>·<?php echo generateMatchStatus($matchInfo['start_time']);?></p>
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
														<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
															<div class="game3_team1_top clearfix">
																<span class="game3_team1_top_name fl"><?php echo $matchInfo['away_team_info']['team_name'];?></span>
																<div class="game3_team1_top_img fl">
																	<img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" class="imgauto" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
																</div>
															</div>
															<div class="game3_team1_bottom red">
																<div class="game3_team1_allplayer">
																	<?php $i=0;foreach($matchInfo['away_player_list']??[] as $playerInfo){$i++;?>
																		<div class="game3_team1_player">
																			<img data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"   class="imgauto" alt="<?php echo $playerInfo['player_name'];?>">
																		</div>
																		<?php if($i>=5){break;}}?>
																</div>
																<div class="game3_team_players"><?php echo count($matchInfo['away_player_list']??[]);?></div>
															</div>
														</a>
													</div>
												</div>
												<?php }else{?>
													<div class="game3_game_item">
														<div class="game3_team1 fl">
															<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
																<div class="game3_team1_top clearfix">
																	<div class="game3_team1_top_img fl">
																		<img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  class="imgauto" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
																	</div>
																	<span class="game3_team1_top_name fl"><?php echo $matchInfo['home_team_info']['team_name'];?></span>
																</div>

															</a>
														</div>
														<div class="game3_team2_vs fl">
															<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
																<div class="game3_team2_vs_top">
																	<div class="bg_wr">
																		<div class="game3_team2_vs_bg">
																		</div>
																	</div>
																	<div class="time_over">
																		<p class="game3_team2_vs_time stop"><?php echo date("m-d H:i",strtotime($matchInfo['start_time']));?>·<?php echo generateMatchStatus($matchInfo['start_time']);?></p>
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
															<a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
																<div class="game3_team1_top clearfix">
																	<span class="game3_team1_top_name fl"><?php echo $matchInfo['away_team_info']['team_name'];?></span>
																	<div class="game3_team1_top_img fl">
																		<img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"   class="imgauto" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
																	</div>
																</div>
															   
															</a>
														</div>
													</div>
												<?php } ?>
												</li>
                                            <?php }?>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>
					
						
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
                        <?php if(count($return['tournament']['data']['teamList'])>0){?>
                        <?php foreach($return['tournament']['data']['teamList'] as $key => $teamInfo){
								if($game=='dota2'){$team_url="javascript:;";}else{$team_url=$config['site_url']."/teamdetail/".$teamInfo['tid'];};
							?>
                                <li <?php if($key==0){?> class="active col-xs-6" <?php }?>>
                                    <a href="<?php echo $team_url;?>">
                                        <div class="a1">
                                            <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" class="game_team_img">
                                        </div>
                                        <span><?php echo $teamInfo['team_name'];?></span>
                                    </a>
                                </li>
                        <?php }?>
                        <?php }else{?>
                        <?php }?>
                    </ul>
                </div>
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/news.png"  src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">相关资讯</span>
                        <a href="##" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
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
                                            <img class="imgauto"  data-original="<?php echo $information['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $information['title'];?>">
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
                <div class="hot_match mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/events.png"  src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>/tournamentList" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
                            <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>" >
									<img data-original="<?php echo $tournamentInfo['logo'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>"  alt="" class='imgauto1'>
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
                <img src="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" data-original="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" alt="扫码下载">
            </div>
        </div>
    </div>
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>
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