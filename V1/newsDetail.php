<?php
require_once "function/init.php";
$id = $_GET['id']??1;
$params = [
    "information"=>[$id],
    "tournamentList"=>["page"=>1,"page_size"=>3,"source"=>$config['default_source'],"cache_time"=>86400],
//   "allNewsList" =>
//        ["dataType"=>"informationList","page"=>("all"==$currentGame)?$page:1,"page_size"=>$pageSize,"game"=>array_keys($config['game']),"fields"=>'id,title,logo,site_time,content',"type"=>$config['informationType'][$type],"cache_time"=>86400*7],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>9,"game"=>$config['game'],"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>9,"game"=>$config['game'],"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "currentPage"=>["name"=>"newsDetail","id"=>$id,"site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
$currentType = in_array($return['information']['data']['type'],$config['informationType']["stra"])?"stra":"news";
$params2 = [
    "recentInformationList"=>["dataType"=>"informationList","page"=>1,"page_size"=>8,"game"=>$config['game'],"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7]
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
                            <span>教学</span>
                            <span>标签</span>
                            <span>好几个字的标签</span>
                            <span>教学</span>
                            <span>标签</span>
                            <span>好几个字的标签</span>
                            <span>教学</span>
                            <span>标签</span>
                            <span>好几个字的标签</span>
                        </div>
                        <div class="news_top_content">
                            <?php echo $return['information']['data']['content'];?>
                        </div>
                    </div>
                    <div class="news_detail">
                        <div class="team_pub_top clearfix">
                            <div class="team_pub_img fl">
                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                            </div>
                            <span class="fl team_pbu_name">相关资讯</span>
                        </div>
                        <div class="news_detail_item active">
                            <ul class="news_item">
                                <li>
                                    <a href="##">
                                    <div class="news_content">
                                        <div class="news_explain have_img">
                                            <p class="news_title">
                                                玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门
                                            </p>
                                            <div class="news_explain_content">
                                                玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            </div>
                                        </div>
                                        <div class="news_img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                    </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                    <div class="news_content">
                                        <div class="news_explain have_img">
                                            <p class="news_title">
                                                玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门
                                            </p>
                                            <div class="news_explain_content">
                                                玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            </div>
                                        </div>
                                        <div class="news_img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                    </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                    <div class="news_content">
                                        <div class="news_explain have_img">
                                            <p class="news_title">
                                                玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门玄策怎么玩，三分钟带你入门
                                            </p>
                                            <div class="news_explain_content">
                                                玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            </div>
                                        </div>
                                        <div class="news_img">
                                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                        </div>
                                    </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                    <div class="news_content">
                                        <div class="news_explain">
                                            <p class="news_title">
                                                玄策怎么玩，三分钟带你入门
                                            </p>
                                            <div class="news_explain_content">
                                                玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                    <div class="news_content">
                                        <div class="news_explain">
                                            <p class="news_title">
                                                玄策怎么玩，三分钟带你入门
                                            </p>
                                            <div class="news_explain_content">
                                                玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            玄策是一个收割型刺客，一级可以刷buff二级边路蹲一波，位置合适可以利用勾吻推小连招配合队友或者防御塔拿下一血，之后快速刷中路河道蟹，清小野和其余野区，四
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- 暂无内容 -->
                        <div class="null">
                            <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                            <span>暂无内容</span>
                        </div>
                        <!-- 暂无内容 -->
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
</body>

</html>