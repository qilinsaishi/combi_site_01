<?php
require_once "function/init.php";
$params = [
    "matchList"=>["page"=>1,"page_size"=>8,"source"=>"scoregg","cacheWith"=>"currentPage","cache_time"=>86400],
    "tournamentList"=>["page"=>1,"page_size"=>4,"source"=>"scoregg","cacheWith"=>"currentPage","cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "currentPage"=>["name"=>"index","site_id"=>$config['site_id']]
];
//依次加入所有游戏
foreach ($config['game'] as $game => $gameName)
{
    $params[$game."TeamList"] =
        ["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>14,"game"=>$game,"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7];
    $params[$game."PlayerList"] =
        ["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>16,"game"=>$game,"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7];
    $params[$game."NewsList"] =
        ["dataType"=>"informationList","page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7];
    $params[$game."StraList"] =
        ["dataType"=>"informationList","page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,site_time',"type"=>$config['informationType']['stra'],"cache_time"=>86400*7];
}
$return = curl_post($config['api_get'],json_encode($params),1);
//文章类型
$newsTypeList = ["News"];
//返回值键名数组
$keyList = array_keys($return);
foreach($newsTypeList as $newsType)
{
    $Newlist = [];
    //循环挑出指定后缀的，组合到一起
    foreach($keyList as $key)
    {
        if(substr($key,-1*strlen($newsType."List")) == $newsType."List")
        {
            $Newlist = array_merge($Newlist,$return[$key]['data']);
        }
    }
    //根据发布日期倒序，获取前十个
    array_multisort(array_column($Newlist,"site_time"),SORT_DESC,$Newlist);
    //保存
    $return["all".$newsType."List"] = ["data"=>array_slice($Newlist,0,10)];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>Document</title>
    <?php renderHeaderJsCss($config,["index"]);?>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="index.html">
                        <img src="<?php echo $config['site_url'];?>/images/logo.png"></a>
                        <!-- <img src="<?php echo $config['site_url'];?>/images/logo@2x.png" alt=""> -->
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                        <ul class="clearfix">
                            <?php generateNav($config,"index");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg1">
            <div class="banner">
                <div class="banner_img">
                    <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="" class="">
                </div>
                <div class="button">
                    <div class="download_ios download">
                        <img src="<?php echo $config['site_url'];?>/images/ios.png" alt="">
                        <span>IOS下载</span>
                    </div>
                    <div class="download_android download">
                        <img src="<?php echo $config['site_url'];?>/images/android.png" alt="">
                        <span>Android下载</span>
                    </div>
                </div>
            </div>
            <div class="game_match container">
                <div class="game_title row clearfix game_title_e">
                    <span class="title">热门赛事</span>
                    <div class="more">
                        <a href="<?php echo $config['site_url'];?>/matchList">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <ul class="game_match_ul dn_wap">
                        <?php foreach($return['matchList']['data'] as $matchInfo){?>
                        <li class="col-md-3 col-xs-12">
                            <a href="<?php echo $config['site_url'];?>/matchDetail/<?php echo $matchInfo['match_id'];?>">
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
                                        <span><?php echo $config['game'][$matchInfo['game']];?></span>
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
                    <ul class="game_match_ul dn_pc">
                        <?php $i=0;foreach($return['matchList']['data'] as $matchInfo){if($i<2){?>
                            <li class="col-md-3 col-xs-12 col-sm-6">
                                <a href="##">
                                    <div class="game_match_top">
                                        <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                        <span class="game_match_time"><?php echo date("m月d日 H:i",strtotime($matchInfo['start_time'])+$config['hour_lag']*3600);?></span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left">
                                            <div class="game_match_img">
                                                <img src="<?php echo $matchInfo['home_team_info']['logo'];?>" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
                                            </div>
                                            <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                        </div>
                                        <div class="left center">
                                            <span>VS</span>
                                            <span><?php echo $config['game'][$matchInfo['game']];?></span>
                                        </div>
                                        <div class="left">
                                            <img src="<?php echo $matchInfo['away_team_info']['logo'];?>" alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
                                            <span><?php echo $matchInfo['away_team_info']['team_name'];?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php $i++;}}?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="game_team">
            <div class="container">
                <div class="game_team_title">
                    <img src="<?php echo $config['site_url'];?>/images/dot.png" alt="">
                    <span>热门战队</span>
                    <img src="<?php echo $config['site_url'];?>/images/dot.png" alt="" class="rotate">
                </div>
                <div class="row">
                    <div class="game_team_list">
                        <?php foreach($config['game'] as $game => $game_name){?>
                        <div class="game_team_div<?php if($game == $config['default_game']){echo " active ";}?>">
                            <div class="game_title clearfix game_team_e">
                                <span class="title"><?php echo $game_name;?>热门战队</span>
                                <div class="more">
                                    <a href="<?php echo $config['site_url'];?>/teamList">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_team_list_detail">
                                <?php foreach ($return[$game."TeamList"]['data'] as $key => $teamInfo) {?>
                                <li class="<?php if($key == 0 && $game == $config['default_game']){echo "active ";}?> col-xs-6">
                                    <a href="<?php echo $config['site_url'];?>/teamDetail/<?php echo $teamInfo['tid'];?>">
                                        <div class="a1">
                                            <img src="<?php echo $teamInfo['logo'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
                                        </div>
                                        <span><?php echo $teamInfo['team_name'];?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php }?>
                    </div>
                    <ul class="game_fenlei clearfix">
                        <?php foreach($config['game'] as $game => $game_name){?>

                        <li class="<?php if($game == $config['default_game']){echo "active";}else{echo "a1";}?>">
                            <div class="tab1">
                                <img src="<?php echo $config['site_url'];?>/images/tab1.png" alt="">
                            </div>
                            <div class="game_fenlei_container">
                                <div class="game_fenlei_div">
                                    <img src="<?php echo $config['site_url'];?>/images/<?php echo $game;?>_white.png" alt="" class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/<?php echo $game;?>_orange.png" alt="" class="a2">
                                </div>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hot_player">
            <div class="container">
                <div class="row">
                    <div class="game_title clearfix game_team_hot">
                        <span class="title">热门选手</span>
                        <div class="more">
                            <a href="##">
                                <span>更多</span>
                                <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <ul class="hot_player_list clearfix">
                        <?php foreach ($config['game'] as $game => $game_name){?>
                        <li <?php if($game == $config['default_game']){echo 'class="active"';}?>>
                            <a href="##"><?php echo $game_name;?></a>
                        </li>
                        <?php }?>
                    </ul>
                    <div class="hot_player_detail">
                        <?php foreach ($config['game'] as $game => $game_name){?>
                        <div class="hot_player_detail_div<?php if($game == $config['default_game']){echo ' active ';}?>">
                            <ul class="clearfix">
                                <?php foreach ($return[$game."PlayerList"]['data'] as $key => $playerInfo) {?>
                                <li <?php if($key == 0 && $game == $config['default_game']){echo ' class="active"';}?>>
                                    <a href="<?php echo $config['site_url'];?>/playerDetail/<?php echo $playerInfo['pid'];?>">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $playerInfo['logo'];?>" alt="<?php echo $playerInfo['player_name'];?>">
                                        </div>
                                        <span><?php echo $playerInfo['player_name'];?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12 left">
                        <div class="game_title clearfix game_team_new">
                            <span class="title">电竞资讯</span>
                            <div class="more">
                                <a href="<?php echo $config['site_url'];?>/newsList">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab1">
                            <ul class="clearfix news_dianjing1">
                                <li class="active"><a href="##">综合</a></li>
                                <?php foreach($config['game'] as $game => $game_name){?>
                                <li><a href="##"><?php echo $game_name;?></a></li>
                                <?php }?>
                            </ul>
                            <div class="news_dianjing_list">
                                <?php $allGameList = array_keys($config['game']);
                                array_unshift($allGameList,"all");
                                foreach($allGameList as $game)
                                {
                                    $infoListKey = $game."NewsList";
                                    $infoList = $return[$infoListKey];
                                    $gameName = $config["game"][$game]??"综合";
                                    ?>
                                    <div class="news_dianjing_detail<?php if($game=="all"){echo " active";}?>">
                                        <?php foreach($infoList['data'] as $key => $info){?>
                                        <?php if($key==0){?>
                                                <div class="news_dianjing_top">
                                                    <a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_top_div">
                                                            <img src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                </div>
                                            <?php }?><?php }?>
                                        <div class="news_dianjing_mid">
                                            <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=1 && $key<=2){?>
                                                    <a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_mid_img">
                                                            <img src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                <?php }?><?php }?>
                                        </div>
                                        <div class="news_dianjing_news">
                                            <ul>
                                                <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=3){?>
                                                <li><a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                        <?php echo $info['title'];?>
                                                    </a></li>
                                                <?php }?><?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 right">
                        <div class="game_title clearfix game_team_new">
                            <span class="title">游戏攻略</span>
                            <div class="more">
                                <a href="<?php echo $config['site_url'];?>/straList">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab2">
                            <ul class="clearfix news_dianjing2">
                                <?php $i = 1;foreach($config['game'] as $game => $game_name){?>
                                    <li <?php if($i==1){echo ' class="active"';}?>><a href="##"><?php echo $game_name;?></a></li>
                                <?php $i++;}?>
                            </ul>
                            <div class="news_dianjing_list">
                                <?php $allGameList = array_keys($config['game']);
                                foreach($allGameList as $key => $game)
                                {
                                    $infoListKey = $game."StraList";
                                    $infoList = $return[$infoListKey];
                                    //$gameName = $config["game"][$game]??"综合";
                                    ?>
                                    <div class="news_dianjing_detail<?php if($key==0){echo ' active';}?>">
                                        <?php foreach($infoList['data'] as $key => $info){?>
                                            <?php if($key==0){?>
                                                <div class="news_dianjing_top">
                                                    <a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_top_div">
                                                            <img src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                </div>
                                            <?php }?><?php }?>
                                        <div class="news_dianjing_mid">
                                            <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=1 && $key<=2){?>
                                                    <a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_mid_img">
                                                            <img src="<?php echo $info['logo'];?>" alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                <?php }?><?php }?>
                                        </div>
                                        <div class="news_dianjing_news">
                                            <ul>
                                                <?php foreach($infoList['data'] as $key => $info){?>
                                                    <?php if($key>=3){?>
                                                        <li><a href="<?php echo $config['site_url'];?>\newsDetail\<?php echo $info['id'];?>">
                                                                <?php echo $info['title'];?>
                                                            </a></li>
                                                    <?php }?><?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="game_special container">
            <div class="row">
                <div class="game_title clearfix game_team_special">
                    <span class="title">赛事专题</span>
                    <div class="more">
                        <a href="<?php echo $config['site_url'];?>\tournamentList">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <ul class="game_special_list">
                    <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                    <li class="col-md-3 col-xs-6">
                        <a href="<?php echo $config['site_url'];?>\tournament\<?php echo $tournamentInfo['tournament_id'];?>">
                            <div class="div_img">
                                <img src="<?php echo $tournamentInfo['logo'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>">
                                <span><?php echo $tournamentInfo['tournament_name'];?></span>
                            </div>
                        </a>
                    </li>
                    <?php }?>
                </ul>
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
    <?php renderFooterJsCss($config);?>

    <script type="text/javascript">
        $(function() {
            $('img.lazy').lazyload();
        });
        var banner = $(".banner_img").height()
        $('.banner_img img').load(function () {
            $(".banner").css("height", banner)
        });
        //banner消失
        function slideup(){ 
            $(".banner").slideUp();
        } 
        var t1 = window.setTimeout(slideup,3000); 
        
    </script>
    <script>
        // 热门战队tab切换
        $(".game_fenlei").on("click",'li',function(){
            $(".game_fenlei li").removeClass("active").eq($(this).index()).addClass("active");
            $(".game_team_div").removeClass("active").eq($(this).index()).addClass("active");
        })
        $(".hot_player_list").on("click",'li',function(){
            $(".hot_player_list li").removeClass("active").eq($(this).index()).addClass("active");
            $(".hot_player_detail_div").removeClass("active").eq($(this).index()).addClass("active");
        })
        $(".news_dianjing1").on("click",'li',function(){
            $(".news_dianjing1 li").removeClass("active").eq($(this).index()).addClass("active");
            $(".news_dianjing_tab1 .news_dianjing_detail").removeClass("active").eq($(this).index()).addClass("active");
        })
        $(".news_dianjing2").on("click",'li',function(){
            $(".news_dianjing2 li").removeClass("active").eq($(this).index()).addClass("active");
            $(".news_dianjing_tab2 .news_dianjing_detail").removeClass("active").eq($(this).index()).addClass("active");
        })
    </script>
</body>

</html>