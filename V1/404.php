<?php
require_once "function/init.php";
$params = [
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img","default_skills_img","default_fuwen_img","default_information_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "hotNewsList"=>["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>6,"game"=>array_keys($config['game']),"fields"=>'id,title,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7],
    "hotTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>4,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "hotPlayerList"=>["dataType"=>"intergratedPlayerList","page"=>1,"page_size"=>4,"game"=>array_keys($config['game']),"rand"=>1,"fields"=>'pid,player_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"404","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title>404-<?php echo $config['site_name'];?></title>
    <?php renderHeaderJsCss($config,["404"]);?>
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
                        <ul class="clearfix">
                            <?php generateNav($config,"index");?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="img404">
                    <img src="<?php echo $config['site_url'];?>/images/404.png" alt="">
                </div>
                <div class="div404">
                    <span class="not_find">啊，页面找不到了&nbsp;&nbsp;>_<</span>
                    <span class="return">返回首页</span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- 热门战队 -->
                <div class="hot_team mb20 col-md-6">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门战队</span>
                    </div>
                    <ul class="game_team_list_detail">
                        <?php foreach($return['hotTeamList']['data'] as $teamInfo){?>
                            <li class="col-md-3 col-xs-3">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="a1">
                                        <img class="game_team_img" data-original="<?php echo $teamInfo['logo'];?><?php echo $config['default_oss_img_size']['teamList'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"   alt="<?php echo $teamInfo['team_name'];?>">

                                    </div>
                                    <span><?php echo $teamInfo['team_name'];?></span>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <!-- 热门战队 -->
                <!-- 队员介绍 -->
                <div class="team_member mb20 col-md-6">
                    <div class="team_member_top clearfix">
                        <div class="team_member_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_number.png" alt="">
                        </div>
                        <span class="fl team_number_name">热门成员</span>
                    </div>
                    <ul class="team_member_detail clearfix">
                        <?php foreach($return['hotPlayerList']['data'] as $key => $playerInfo){?>
                            <li class="col-md-3 col-xs-3">
                                <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                    <div class="team_number_photo">
                                        <img data-original="<?php echo $playerInfo['logo'];?><?php echo $config['default_oss_img_size']['playerList'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>"   alt="<?php echo $playerInfo['player_name'];?>">
                                    </div>
                                    <span class="team_number_name"><?php echo $playerInfo['player_name'];?></span>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <!-- 队员介绍 -->
              
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- 战队资讯 -->
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门资讯</span>
                        <a href="<?php echo $config['site_url'];?>/newslist/" class="team_pub_more fr">
                            <span>更多</span>
                        </a>
                    </div>
                    <div class="team_news_bot">
                        <ul class="team_news_bot_ul clearfix">
                            <?php foreach($return['hotNewsList']['data'] as $key => $info){?>
                                <li class="fl">
                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>"><?php echo $info['title'];?></a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <!-- 战队资讯 -->
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
    <?php renderFooterJsCss($config);?>
</body>

</html>