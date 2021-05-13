<?php
require_once "function/init.php";
$info['page']['page_size'] = 30;
$page = $_GET['page']??1;
$currentGame = $_GET['game']??'all';
//echo $page."-".$currentGame;die();
if($page==''){
    $page=1;
}
$params = [
    "allTeamList"=>["dataType"=>"intergratedTeamList","page"=>($currentGame=="all")?$page:1,"page_size"=>$info['page']['page_size'],"fields"=>'tid,team_name,logo',"game"=>array_keys($config['game']),"cacheWith"=>"currentPage","cache_time"=>0],
    "hotNewsList"=>["dataType"=>"informationList","page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$config['game'],"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "recentMatchList"=>["dataType"=>"matchList","page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"team","site_id"=>$config['site_id']]
];
//依次加入所有游戏

foreach ($config['game'] as $game => $gameName)
{
    $params[$game."TeamList"] =
        ["dataType"=>"intergratedTeamList","page"=>($currentGame==$game)?$page:1,"page_size"=>$info['page']['page_size'],"game"=>$game,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>0];
}
$return = curl_post($config['api_get'],json_encode($params),1);
$allGameList = array_keys($config['game']);
array_unshift($allGameList,"all");
$keyList = array_keys($return);

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
    <?php renderHeaderJsCss($config,["progress-bars","game","right","team"]);?>

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
            <div class="row clearfix">
				<!--游戏列表-->
                <div class="game_left esports fl">
                    <ul class="esports_ul clearfix">
                        <li <?php if($currentGame== 'all'){echo 'class="active "';}?> >
                            <a href="javascript:;">
                                全部
                            </a>
                        </li>
						 <?php foreach($config['game'] as $game => $game_name){?>
                        <li <?php if($currentGame == $game){echo 'class="active "';}?>>
                            <a href="javascript:;">
                                <?php echo $game_name;?>
                            </a>
                        </li>
                        
						<?php }?>
                    </ul>
                    <div class="esports_detail">
						
                        <?php foreach($allGameList as $key => $game){?>
                            <div class="esports_item <?php echo $game;?> <?php if($game==$currentGame){echo 'active';}?>" >
                                <ul class="game_team_list_detail">
                                    <?php
                                    foreach($return[$game.'TeamList']['data'] as $teamInfo)
                                    {   ?>
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
                                <div class="paging">
                                    <?php render_page_pagination($return[$game.'TeamList']['count'],$info['page']['page_size'],$params[$game."TeamList"]['page'],$config['site_url']."/teamlist/".$game); ?>

                                </div>
                            </div>
                        <?php }?>
						
                    </div>
                </div>
				<!--游戏列表-->
				<!--右边近期赛事-->
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
                                <a href="<?php echo $config['site_url'];?>/matchlist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_match_ul">
							 <?php foreach($return['recentMatchList']['data'] as $matchInfo){?>
                            <li class="col-md-12 col-xs-12">
                                <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['match_id'];?>">
                                    <div class="game_match_top">
                                        <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                        <span class="game_match_time"><?php echo date("m月d日 H:i",strtotime($matchInfo['start_time'])+$config['hour_lag']*3600);?></span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <?php if(isset($return['defaultConfig']['data']['default_team_img'])){?>
                                                <img class="lazy-load" data-original="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?>" src="<?php echo $matchInfo['home_team_info']['logo'];?>" title="<?php echo $matchInfo['home_team_info']['team_name'];?>" />
                                            <?php }else{?>
                                                <img src="<?php echo $matchInfo['home_team_info']['logo'];?>" title="<?php echo $matchInfo['home_team_info']['team_name'];?>" />
                                            <?php }?>
                                            </div>
                                            <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                        </div>
                                        <div class="left center">
                                            <span>VS</span>
                                            <span><?php echo $config['game'][$matchInfo['game']]  ?></span>
                                        </div>
                                        <div class="left ov_1">
                                            <div class="game_match_img">
                                                <?php if(isset($return['defaultConfig']['data']['default_team_img'])){?>
                                                <img class="lazy-load" data-original="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?>" src="<?php echo $matchInfo['away_team_info']['logo'];?>" title="<?php echo $matchInfo['away_team_info']['team_name'];?>" />
                                            <?php }else{?>
                                                <img src="<?php echo $matchInfo['away_team_info']['logo'];?>" title="<?php echo $matchInfo['away_team_info']['team_name'];?>" />
                                            <?php }?>     
                                            </div>
                                            <span><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
							<?php }?>
                            
                        </ul>
                    </div>
					<!--右边近期赛事-->
					<!--右边热门选手-->
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
					<!--右边热门选手-->
					<!--右边热门资讯-->
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
					<!--右边热门资讯-->
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
            <p>Copyright © 2021 www.qilindianjing.com</p>
            <p>网站内容来源于网络，如果侵犯您的权益请联系删除</p>
        </div>
    </div>
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>

    <script>
        $(".esports_ul").on("click","li",function(){
            $(".esports_ul li").removeClass("active");
            $(this).addClass("active");
            $(this).parents(".esports").find(".esports_detail").find(".esports_item").removeClass("active").eq($(this).index()).addClass("active")
            // $(this).parents(".game_detail_item5").find(".vs_data2").find(".vs_data2_item").removeClass("active").eq($(this).index()).addClass("active")
        })
    </script>
</body>

</html>