<?php
require_once "function/init.php";
$id = $_GET['id']??1;
$params = [
    "information"=>[$id],
    "tournamentList"=>["page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cache_time"=>86400],
	"hotTournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>0,"source"=>$config['game_source']['dota2'] ?? $config['default_source'],"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img","default_information_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"newsDetail","id"=>$id,"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
if(!isset($return["information"]['data']['id']))
{
    render404($config);
}
$return["information"]['data']['keywords_list'] = json_decode($return["information"]['data']['keywords_list'],true);
$return["information"]['data']['scws_list'] = json_decode($return["information"]['data']['scws_list'],true);
$return["information"]['data']['5118_word_list'] = json_decode($return["information"]['data']['5118_word_list'],true)??[];
$return["information"]['data']['baidu_word_list'] = json_decode($return["information"]['data']['baidu_word_list'],true)??[];
if(isset($return["information"]['data']['keywords_list']['player']) && count($return["information"]['data']['keywords_list']['player'])>0)
{
    $playerIds = array_column($return["information"]['data']['keywords_list']['player'],"id");
}
if(isset($return["information"]['data']['keywords_list']['team']) && count($return["information"]['data']['keywords_list']['team'])>0)
{
    $teamIds = array_column($return["information"]['data']['keywords_list']['team'],"id");
}
$ids = array_keys($return["information"]['data']['baidu_word_list']);
$ids = count($ids)>0?implode(",",$ids):"0";
$currentType = in_array($return['information']['data']['type'],$config['informationType']["stra"])?"stra":"news";
$params2 = [
    "ConnectInformationList"=>["dataType"=>"baiduInformaitonList","site"=>$config['site_id'],"ids"=>$ids,"game"=>array_keys($config['game']),"page"=>1,"page_size"=>5,"type"=>implode(",",$config['informationType'][$currentType]),"fields"=>"id,title,site_time","expect_id"=>$id],
    "recentInformationList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType'][$currentType],"cache_time"=>86400*7],
];
if(isset($return["information"]['data']['keywords_list']['player']) && count($return["information"]['data']['keywords_list']['player'])>0)
{
    $playerIds = array_column($return["information"]['data']['keywords_list']['player'],"id");
    $params2["keywordPlayerList"] = ["dataType"=>"intergratedPlayerListByPlayer","ids"=>$playerIds,"game"=>$return['information']['data']['game'],"page"=>1,"page_size"=>1000,"fields"=>"pid,player_name,logo"];
}
if(isset($return["information"]['data']['keywords_list']['team']) && count($return["information"]['data']['keywords_list']['team'])>0)
{
    $teamIds = array_column($return["information"]['data']['keywords_list']['team'],"id");
    $params2["keywordTeamList"] = ["dataType"=>"intergratedTeamListByTeam","ids"=>$teamIds,"game"=>$return['information']['data']['game'],"page"=>1,"page_size"=>1000,"fields"=>"tid,team_name,logo"];
}
$return2 = curl_post($config['api_get'],json_encode($params2),1);
$return['tournamentList']['data']=array_merge($return['tournamentList']['data'],$return['hotTournamentList']['data']);
$return['information']['data']['content'] = html_entity_decode($return['information']['data']['content']);
$return['information']['data']['content'] = str_replace("&nbsp;"," ",$return['information']['data']['content']);
if(isset($return2["keywordPlayerList"]['data']) && count($return2["keywordPlayerList"]['data'])>0)
{
    $keywordList = array_combine(array_column($return["information"]['data']['keywords_list']['player'],"id"),array_keys($return["information"]['data']['keywords_list']['player']));
    $i=0;
    foreach($return2["keywordPlayerList"]['data'] as $player_id => $player_info)
    {
        $player_url = $config['site_url']."/playerdetail/".$player_info['pid'];
        $return['information']['data']['content'] = str_replace_limit($keywordList[$player_id],"<a href='".$player_url."'>".$keywordList[$player_id]."</a>",$return['information']['data']['content'],1);
        $i++;if($i>=5){break;}
    }
}
if(isset($return2["keywordTeamList"]['data']) && count($return2["keywordTeamList"]['data'])>0)
{
    $keywordList = array_combine(array_column($return["information"]['data']['keywords_list']['team'],"id"),array_keys($return["information"]['data']['keywords_list']['team']));
    $i=0;
    foreach($return2["keywordTeamList"]['data'] as $team_id => $team_info)
    {
        $team_url = $config['site_url']."/teamdetail/".$team_info['tid'];
        $return['information']['data']['content'] = str_replace_limit($keywordList[$team_id],"<a href='".$team_url."'>".$keywordList[$team_id]."</a>",$return['information']['data']['content'],1);
        $i++;if($i>=5){break;}
    }
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
    <title><?php echo $return['information']['data']['title']?>_<?php echo $config['game'][$return['information']['data']['game']];?><?php echo $currentType=="news"?"电竞资讯":"游戏攻略"; ?>-<?php echo $config['site_name'];?></title>
    <?php renderHeaderJsCss($config,["right","news"]);?>
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
                            <?php generateNav($config,$currentType);?>
                        </ul>
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
                <a href="<?php echo $config['site_url'];?>/<?php echo $currentType;?>list/<?php echo $return['information']['data']['game'];?>/">
                    <?php echo  $config['game'][$return['information']['data']['game']]; ?>
                </a >
                >
                <span><?php echo $return['information']['data']['title'];?></span>
            </div></div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left news fl">
                    <div class="news_top">
                        <h1 class="title"><?php echo $return['information']['data']['title']?></h1>
                        <p class="news_time"><?php echo date("Y.m.d H:i:s",strtotime($return['information']['data']['site_time']));?></p>
                        <div class="news_top_content">
                            <?php echo html_entity_decode($return['information']['data']['content']);?>
                        </div>
                        <div class="news_label clearfix">
                            <?php $i=0;if(count($return["information"]['data']['baidu_word_list'])>0){ foreach($return["information"]['data']['baidu_word_list'] as $key => $word){?>
                                <span><?php echo $word['tag'];?></span>
                                <?php $i++;if($i==3){break;}}}?>
                        </div>
                    </div>
                    <div class="news_detail">
                        <div class="team_pub_top clearfix">
                            <div class="team_pub_img fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                            </div>
                            <span class="fl team_pbu_name">相关<?php echo $currentType=="news"?"资讯":"攻略";?></span>
                        </div>
                        <div class="news_detail_item active">
                            <ul class="news_item">
                                <?php if(is_array($return2["ConnectInformationList"]) && count($return2["ConnectInformationList"]['data'])>0){foreach($return2["ConnectInformationList"]['data'] as $connectInfo){?>
                                    <li>
                                        <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $connectInfo['id'];?>">
                                            <div class="news_content">
                                                <div class="news_explain have_img">
                                                    <p class="news_title">
                                                        <?php echo $connectInfo['title'];?>
                                                    </p>
                                                    <div class="news_explain_content">
                                                        <?php echo $connectInfo['content'];?>
                                                    </div>
                                                </div>
                                                <div class="news_img">
                                                    <img class="imgauto" data-original="<?php echo $connectInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $connectInfo['title'];?>">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php }}else{?>
                                    <!-- 暂无内容 -->
                                    <div class="null">
                                        <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                        <span>暂无内容</span>
                                    </div>
                                    <!-- 暂无内容 -->
                                <?php }?>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="game_right">
                    <div class="game_news">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                </div>
                                <span class="fl">热门<?php echo $currentType=="news"?"资讯":"攻略";?></span>
                            </div>
                            <div class="more fr">
                                <a href="<?php echo $config['site_url'];?>/<?php echo $currentType;?>list/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul>
                            <?php if(is_array($return2['recentInformationList'])){foreach($return2['recentInformationList']['data'] as $recentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $recentInfo['id'];?>"><?php echo $recentInfo['title'];?></a>
                                </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <div class="game_match">
                        <div class="title clearfix">
                            <div class="fl clearfix">
                                <div class="game_fire fl">
                                    <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_fire.png" alt="">
                                </div>
                                <span class="fl">最新赛事</span>
                            </div>
                            <div class="more fr">
                                <a href="<?php echo $config['site_url'];?>/tournamentlist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_match_detail">
                            <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>" >
									<img data-original="<?php echo $tournamentInfo['logo'].$config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'].$config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>">
                                        <span><?php echo $tournamentInfo['tournament_name'];?></span>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
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
                                            <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
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
	<div class="suspension">
        <div class="suspension_close">
            <img src="<?php echo $config['site_url'];?>/images/t_close.png" alt="">
        </div>
		<div class="suspension_img">
			<img src="<?php echo $config['site_url'];?>/images/suspension.png" alt="">
		</div>
		<div class="qrcode">
			<div class="qrcode_img">
				<img src="<?php echo $return['defaultConfig']['data']['download_qr_code']['value'].$config['default_oss_img_size']['qr_code'];?>" alt="扫码下载">
			</div>
		</div>
	</div>
    <?php renderFooterJsCss($config,[],[]);?>
</body>

</html>