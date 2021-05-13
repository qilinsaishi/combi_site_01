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
    "tournamentList"=>["page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cache_time"=>86400],
    "allNewsList" =>
        ["dataType"=>"informationList","page"=>("all"==$currentGame)?$page:1,"page_size"=>$pageSize,"game"=>array_keys($config['game']),"fields"=>'id,title,logo,site_time,content',"type"=>$config['informationType'][$type],"cache_time"=>86400*7],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "currentPage"=>["name"=>"newsList","game"=>$currentGame,"page"=>$page,"site_id"=>$config['site_id']]
];
//依次加入所有游戏
foreach ($config['game'] as $game => $gameName)
{
    $params[$game."NewsList"] =
        ["dataType"=>"informationList","page"=>($currentGame==$game)?$page:1,"page_size"=>$pageSize,"game"=>$game,"fields"=>'id,title,logo,site_time,content',"type"=>$config['informationType'][$type],"cache_time"=>86400*7];
}
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
                            <a href="##">
                                全部
                            </a>
                        </li>
                        <?php foreach($config['game'] as $game => $game_name){?>
                            <li class="<?php if($currentGame==$game) {echo 'active';}?>">
                                <a href="##">
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
                                                                <img class="imgauto" src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php }?>
                                                <div class="paging">
                                                    <?php render_page_pagination($return[$game.'NewsList']['count'],$pageSize,$params[$game."NewsList"]['page'],$config['site_url']."/newslist/".$game); ?>
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
                                <a href="<?php echo $config['site_url'];?>\tournamentList">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <ul class="game_match_detail">
                            <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>\tournament\<?php echo $tournamentInfo['tournament_id'];?>" style="background-image:url('<?php echo $tournamentInfo['logo'];?>')">
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
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
                <li><a href="##">凤凰电竞</a></li>
            </ul>
            <p>Copyright © 2021 www.qilindianjing.com</p>
            <p>网站内容来源于网络，如果侵犯您的权益请联系删除</p>
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