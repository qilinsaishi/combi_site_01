<?php
require_once "function/init.php";
$currentGame = $_GET['game']??'all';

if($currentGame=="")
{
    $currentGame = "all";
}
$params = [
    "tournamentList"=>["page"=>1,"page_size"=>1000,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
	"dota2TournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>1000,"source"=>$config['game_source']['dota2'] ?? $config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>8,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"tournamentList","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
$tournamentList = [];
$tournamentList["all"] = [];
foreach($config['game'] as $game => $game_name)
{
    $tournamentList[$game] = [];
}
foreach($return['tournamentList']['data'] as $tournamentInfo)
{	if($tournamentInfo['game']!='dota2')
	{
		$tournamentList[$tournamentInfo['game']][] = $tournamentInfo;
	}
    
}
foreach($return['dota2TournamentList']['data'] as $tournamentInfo2)
{	
	$tournamentList[$tournamentInfo2['game']][] = $tournamentInfo2;
}
foreach($tournamentList as $game => $t_list)
{
	foreach($t_list as $tournament)
	{
	
		$tournamentList["all"][] = $tournament;
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
    <title><?php if($currentGame=="all"){?>电竞热门赛事_电子竞技比赛-<?php }else{?><?php echo $config['game'][$currentGame];?>热门赛事_<?php echo $config['game'][$currentGame];?>电子竞技比赛-<?php }?><?php echo $config['site_name'];?></title>
    <meta name="Keywords" content="<?php if($currentGame=="all"){?>电竞热门比赛,电竞热门赛事,电竞赛事大全<?php }else{?><?php echo $config['game'][$currentGame];?>热门比赛,<?php echo $config['game'][$currentGame];?>热门赛事, <?php echo $config['game'][$currentGame];?>电竞赛事大全<?php } ?>">
    <meta name="description" content="<?php if($currentGame=="all"){?>提供电竞热门比赛，了解最新电竞赛事，掌握大型电子竞技比赛，请关注<?php }else{?>提供<?php echo $config['game'][$currentGame];?>热门比赛，了解最新<?php echo $config['game'][$currentGame];?>电竞赛事，掌握大型<?php echo $config['game'][$currentGame];?>电子竞技比赛，请关注<?php } ?><?php echo $config['site_name'];?>">
    <?php renderHeaderJsCss($config,["right","events"]);?>
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
                            <?php generateNav($config,"tournament");?>
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
                <?php if($currentGame!="all"){?>
                    <?php echo $config['game'][$currentGame];?>赛事列表
                <?php }else{?>
                    <span>赛事列表</span>
                <?php }?>
            </div>
        </div>

        <div class="container">
            <div class="row clearfix">
                <div class="game_left events fl">
                    <ul class="esports_ul clearfix">
                        <li<?php if($currentGame=="all"){?> class="active"<?php }?>>
                            <a href="<?php echo $config['site_url'];?>/tournamentlist/all">
                                全部
                            </a>
                        </li>
                        <?php foreach($config['game'] as $game => $game_name){?>
                            <li <?php if($currentGame==$game){?> class="active"<?php }?>>
                                <a href="<?php echo $config['site_url'];?>/tournamentlist/<?php echo $game;?>">
                                    <?php echo $game_name;?>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                    <div class="events_d">
                        <?php foreach($tournamentList as $game => $List){?>
                            <div class="events_ditem <?php if($game ==$currentGame){echo 'active';}?>">
                                <?php if(count($List)>0){?>
                                <ul class="events_ul clearfix">
                                    <?php foreach($List as $tournamentInfo){?>
                                        <li>
                                            <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>">
                                                <div class="events_img">
                                                    <img class="imgauto1" data-original="<?php echo $tournamentInfo['logo'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>" >
                                                </div>
                                                <span><?php echo $tournamentInfo['tournament_name'];?></span>
                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                                <?php }else{?>
                                <!-- 暂无内容 -->
                                <div class="null">
                                    <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                    <span>暂无内容</span>
                                </div>
                                <!-- 暂无内容 -->
                                <?php }?>


                            </div>
                        <?php }?>

                        </div>

                </div>
                <div class="game_right">
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
<script>
    $(".esports_ul").on("click","li",function(){
        $(".esports_ul li").removeClass("active");
        $(this).addClass("active");
        $(this).parents(".events").find(".events_d").find(".events_ditem").removeClass("active").eq($(this).index()).addClass("active")
    })
</script>
</html>