<?php
require_once "function/init.php";
$id = $_GET['id']??1;
$params = [
    "information"=>[$id],
    "tournamentList"=>["page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
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
$ids = array_column($return["information"]['data']['scws_list'],"keyword_id");
$ids = count($ids)>0?implode(",",$ids):"0";
$currentType = in_array($return['information']['data']['type'],$config['informationType']["stra"])?"stra":"news";
$params2 = [
    "ConnectInformationList"=>["dataType"=>"scwsInformaitonList","ids"=>$ids,"game"=>array_keys($config['game']),"page"=>1,"page_size"=>5,"type"=>implode(",",$config['informationType'][$currentType]),"fields"=>"id,title,site_time","expect_id"=>$id],
    "recentInformationList"=>["dataType"=>"informationList","page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType'][$currentType],"cache_time"=>86400*7]
];
$return2 = curl_post($config['api_get'],json_encode($params2),1);
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
    <?php renderHeaderJsCss($config,["right","news"]);?>
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
                            <?php generateNav($config,$currentType);?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left news fl">
                    <div class="news_top">
                        <p class="title"><?php echo $return['information']['data']['title']?></p>
                        <p class="news_time"><?php echo date("Y.m.d H:i:s",strtotime($return['information']['data']['site_time'])+$config['hour_lag']*3600);?></p>
                        <div class="news_label clearfix">
                            <?php if(count($return["information"]['data']['5118_word_list'])>0){foreach($return["information"]['data']['5118_word_list'] as $key => $word){?>
                                <span><?php echo $word;?></span>
                            <?php }}?>
                        </div>
                        <div class="news_top_content">
                            <?php echo html_entity_decode($return['information']['data']['content']);?>
                        </div>
                    </div>
                    <div class="news_detail">
                        <div class="team_pub_top clearfix">
                            <div class="team_pub_img fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                            </div>
                            <span class="fl team_pbu_name">相关<?php echo $currentType=="info"?"资讯":"攻略";?></span>
                        </div>
                        <div class="news_detail_item active">
                            <ul class="news_item">
                                <?php if(count($return2["ConnectInformationList"]['data'])>0){foreach($return2["ConnectInformationList"]['data'] as $connectInfo){?>
                                    <li>
                                        <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $connectInfo['content']['id'];?>">
                                            <div class="news_content">
                                                <div class="news_explain have_img">
                                                    <p class="news_title">
                                                        <?php echo $connectInfo['content']['title'];?>
                                                    </p>
                                                    <div class="news_explain_content">
                                                        <?php echo $connectInfo['content']['content'];?>
                                                    </div>
                                                </div>
                                                <div class="news_img">
                                                    <img class="imgauto" src="<?php echo $connectInfo['content']['logo'];?>" alt="<?php echo $connectInfo['content']['title'];?>">
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
                                <span class="fl">热门<?php echo $currentType=="info"?"资讯":"攻略";?></span>
                            </div>
                            <div class="more fr">
                                <a href="<?php echo $config['site_url'];?>/<?php echo $currentType;?>list/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul>
                            <?php foreach($return2['recentInformationList']['data'] as $recentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $recentInfo['id'];?>"><?php echo $recentInfo['title'];?></a>
                                </li>
                            <?php }?>
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
                                <a href="<?php echo $config['site_url'];?>/tournamentList">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_match_detail">
                            <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['tournament_id'];?>" style="background-image:url('<?php echo $tournamentInfo['logo'];?>')">
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
                                            <img src="<?php echo $teamInfo['logo'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
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
                                            <img src="<?php echo $playerInfo['logo'];?>" alt="<?php echo $playerInfo['player_name'];?>" class="imgauto">
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
    <?php renderFooterJsCss($config,[],[]);?>
</body>

</html>