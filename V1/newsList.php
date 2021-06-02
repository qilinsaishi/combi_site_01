<?php
require_once "function/init.php";
$pageSize = 20;
$page = $_GET['page']??1;
$currentGame = $_GET['game']??'all';
$type = $_GET['type']??"news";
if($page==''){
    $page=1;
}
$params = [
    "tournamentList"=>["page"=>1,"page_size"=>2,"source"=>$config['default_source'],"cache_time"=>86400],
    "allNewsList" =>
        ["dataType"=>"informationList","site"=>$config['site_id'],"page"=>("all"==$currentGame)?$page:1,"page_size"=>$pageSize,"game"=>array_keys($config['game']),"fields"=>'id,title,logo,site_time,content',"type"=>$config['informationType'][$type],"cache_time"=>86400*7],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img","default_tournament_img","default_information_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"newsList","game"=>$currentGame,"page"=>$page,"site_id"=>$config['site_id']]
];
//依次加入所有游戏
foreach ($config['game'] as $game => $gameName)
{
    $params[$game."NewsList"] =
        ["dataType"=>"informationList","site"=>$config['site_id'],"page"=>($currentGame==$game)?$page:1,"page_size"=>$pageSize,"game"=>$game,"fields"=>'id,title,logo,site_time,content',"type"=>$config['informationType'][$type],"cache_time"=>86400*7];
}
$return = curl_post($config['api_get'],json_encode($params),1);
$params2 = [
    "tournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>1,"game"=>'dota2',"source"=>$config['game_source']['dota2'] ?? $config['default_source'],"cache_time"=>86400],
];
$return2 = curl_post($config['api_get'],json_encode($params2),1);

$return['tournamentList']['data']=array_merge($return['tournamentList']['data'],$return2['tournamentList']['data']);
unset($return2['tournamentList']);


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
    <title><?php if($currentGame=="all"){?><?php echo $type=="news"?"电竞资讯":"游戏攻略";?>_电子竞技<?php echo $type=="news"?"赛事新闻":"游戏攻略";?>-<?php echo $config['site_name'];?><?php }else{?><?php echo $config['game'][$currentGame];?><?php echo $type=="news"?"电竞资讯":"攻略";?>_<?php echo $config['game'][$currentGame];?><?php echo $type=="news"?"电子竞技赛事新闻":"游戏攻略";?>-<?php echo $config['site_name'];?><?php } ?></title>
    <meta name=”Keywords” Content=”<?php if($currentGame=="all"){?><?php echo $type=="news"?"电竞资讯,电子竞技新闻,电竞赛事新闻":"电竞游戏攻略,游戏攻略";?><?php }else{?><?php echo $config['game'][$currentGame];?><?php echo $type=="news"?"电竞资讯":"攻略";?>,<?php echo $config['game'][$currentGame];?><?php echo $type=="news"?"电子竞技新闻":"游戏攻略";?>,<?php echo $config['game'][$currentGame];?><?php echo $type=="news"?"电竞赛事新闻":"上分技巧";?><?php } ?>″>
    <meta name="description" content="<?php if($currentGame=="all"){?><?php echo $config['site_name'];?><?php echo $type=="news"?"提供电竞热门资讯,了解最新电竞新闻,掌握电子竞技赛事资讯,请关注":"提供游戏攻略,了解最新游戏攻略,掌握电子竞技游戏攻略,请关注";?><?php echo $config['site_name'];?><?php }else{?><?php echo $config['site_name'];?><?php echo $type=="news"?"提供".$config['game'][$currentGame]."电竞热门资讯,了解最新".$config['game'][$currentGame]."电竞新闻,掌握".$config['game'][$currentGame]."电子竞技赛事资讯,请关注":"提供".$config['game'][$currentGame]."游戏攻略,了解最新,".$config['game'][$currentGame]."上分技巧,掌握".$config['game'][$currentGame]."游戏攻略,请关";?><?php echo $config['site_name'];?><?php } ?>">

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
                            <?php generateNav($config,$type);?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left news fl">
                    <ul class="esports_ul clearfix">
                        <li class="<?php if($currentGame=='all') {echo 'active';}?>">
                            <a href="<?php echo $config['site_url']?>/<?php echo $type;?>list/all/<?php echo $params["allNewsList"]['page'];?>">
                                全部
                            </a>
                        </li>
                        <?php foreach($config['game'] as $game => $game_name){?>
                            <li class="<?php if($currentGame==$game) {echo 'active';}?>">
                                <a href="<?php echo $config['site_url']?>/<?php echo $type;?>list/<?php echo $game;?>/<?php echo $params[$game."NewsList"]['page'];?>">
                                    <?php echo $game_name;?>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                    <div class="news_detail">
                        <?php
                        $allGameList = array_keys($config['game']);
                                array_unshift($allGameList,"all");
                                foreach($allGameList as $game){?>
                                    <div class="news_detail_item <?php if($game == $currentGame){?>active<?php } ?> ">
                                        <ul class="news_item">
                                            <?php if(count($return[$game."NewsList"]['data'])>0){foreach($return[$game."NewsList"]['data']??[] as $info){?>
                                                <li>
                                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <div class="news_content">
                                                            <div class="news_explain have_img">
                                                                <p class="news_title">
                                                                    <?php echo $info['title'];?>
                                                                </p>
                                                                <div class="news_explain_content">
                                                                    <?php echo $info['content'];?>
                                                                </div>
                                                            </div>
                                                            <div class="news_img">
                                                                <img class="imgauto" data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php }?>
                                                <div class="paging">
                                                    <?php render_page_pagination($return[$game.'NewsList']['count'],$pageSize,$params[$game."NewsList"]['page'],$config['site_url']."/".$type."list/".$game); ?>
                                                </div>
                                            <?php }else{?>
                                                <!-- 暂无内容 -->
                                                <div class="null">
                                                    <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                                    <span>暂无内容</span>
                                                </div>
                                                <!-- 暂无内容 -->
                                            <?php }?>
                                        </ul>

                                    </div>
                                <?php }?>

                    </div>
                </div>
                <div class="game_right">
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
									 <img  data-original="<?php echo $tournamentInfo['logo'].$config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'].$config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>" >
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
                                            <img data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"   alt="<?php echo $playerInfo['player_name'];?>" class="imgauto">
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
		<div class="suspension_img">
			<img src="<?php echo $config['site_url'];?>/images/suspension.png" alt="">
		</div>
		<div class="qrcode">
			<div class="qrcode_img">
				<img src="<?php echo $config['site_url'];?>/images/qrcode.png" alt="">
			</div>
		</div>
	</div>
    <?php renderFooterJsCss($config,[],[]);?>
    <script>
        $(".esports_ul").on("click","li",function(){
            $(".esports_ul li").removeClass("active");
            $(this).addClass("active");
            $(this).parents(".news").find(".news_detail").find(".news_detail_item").removeClass("active").eq($(this).index()).addClass("active")
            // $(this).parents(".game_detail_item5").find(".vs_data2").find(".vs_data2_item").removeClass("active").eq($(this).index()).addClass("active")
        })
    </script>
</body>

</html>