<?php
require_once "function/init.php";
$params = [
    "lolTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>14,"game"=>"lol","rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "kplTeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>14,"game"=>"kpl","rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "dota2TeamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>14,"game"=>"dota2","rand"=>1,"fields"=>'tid,team_name,logo',"cacheWith"=>"currentPage","cache_time"=>86400*7],
    "currentPage"=>["name"=>"index","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
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
                        <a href="##">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <ul class="game_match_ul dn_wap">
                        <li class="col-md-3 col-xs-12">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛常规</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left ov_1">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>常规赛常规常规</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-12">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img2">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img1">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="game_match_ul dn_pc">
                        <li class="col-md-3 col-xs-12 col-sm-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛常规</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <div class="game_match_img">
                                            <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        </div>
                                        <span>常规赛常规常规</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>常规赛常规常规</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-md-3 col-xs-12 col-sm-6">
                            <a href="##">
                                <div class="game_match_top">
                                    <span class="game_match_name">常规赛</span>
                                    <span class="game_match_time">4月23日 14:00</span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="" class="t_p_img2">
                                        <span>SNS</span>
                                    </div>
                                    <div class="left center">
                                        <span>VS</span>
                                        <span>英雄联盟</span>
                                    </div>
                                    <div class="left">
                                        <img src="<?php echo $config['site_url'];?>/images/match.png" alt="">
                                        <span>ES.Y</span>
                                    </div>
                                </div>
                            </a>
                        </li>
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
                        <div class="game_team_div">
                            <div class="game_title clearfix game_team_e">
                                <span class="title">王者荣耀热门战队</span>
                                <div class="more">
                                    <a href="<?php echo $config['site_url'];?>/teamList">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_team_list_detail">
                                <li class="active col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="" class="game_team_img">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li class="col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="game_team_div active">
                            <div class="game_title clearfix game_team_e">
                                <span class="title">英雄联盟热门战队</span>
                                <div class="more">
                                    <a href="##">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_team_list_detail">
                                <li class="col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="" class="game_team_img">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li class="col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="game_team_div">
                            <div class="game_title clearfix game_team_e">
                                <span class="title">dot2热门战队</span>
                                <div class="more">
                                    <a href="##">
                                        <span>更多</span>
                                        <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <ul class="game_team_list_detail">
                                <li class="active col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="" class="game_team_img">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li class="col-xs-6">
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="a1">
                                            <img src="<?php echo $config['site_url'];?>/images/WElogo.png" alt="">
                                        </div>
                                        <span>WE</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <ul class="game_fenlei clearfix">
                        <li class="a1">
                            <div class="tab1">
                                <img src="<?php echo $config['site_url'];?>/images/tab1.png" alt="">
                            </div>
                            <div class="game_fenlei_container">
                                <div class="game_fenlei_div">
                                    <img src="<?php echo $config['site_url'];?>/images/wzry_white.png" alt="" class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/wzry_orange.png" alt="" class="a2">
                                </div>
                            </div>
                        </li>
                        <li class="active">
                            <div class="tab1">
                                <img src="<?php echo $config['site_url'];?>/images/tab1.png" alt="">
                            </div>
                            <div class="game_fenlei_container">
                                <div class="game_fenlei_div">
                                    <img src="<?php echo $config['site_url'];?>/images/LOL_white.png" alt="" class="a1">
                                    <img src="<?php echo $config['site_url'];?>/images/LOL_orange.png" alt="" class="a2">
                                </div>
                            </div>
                        </li>
                        <li class="a2">
                            <div class="tab1">
                                <img src="<?php echo $config['site_url'];?>/images/tab1.png" alt="">
                            </div>
                            <div class="game_fenlei_container">
                                <div class="game_fenlei_div">
                                   <img src="<?php echo $config['site_url'];?>/images/dota_white.png" alt="" class="a1">
                                   <img src="<?php echo $config['site_url'];?>/images/dota_orange.png" alt="" class="a2">
                                </div>
                            </div>
                        </li>
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
                        <li class="active">
                            <a href="##">英雄联盟</a>
                        </li>
                        <li>
                            <a href="##">王者荣耀</a>
                        </li>
                        <li>
                            <a href="##">DOTA2</a>
                        </li>
                    </ul>
                    <div class="hot_player_detail"> 
                        <div class="hot_player_detail_div active">
                            <ul class="clearfix">
                                <li class="active">
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="hot_player_detail_div">
                            <ul class="clearfix">
                                <li class="active">
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>1111</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="hot_player_detail_div">
                            <ul class="clearfix">
                                <li class="active">
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>3333</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>FoFo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="hot_player_img">
                                            <img src="<?php echo $config['site_url'];?>/images/player1.png" alt="">
                                        </div>
                                        <span>HuanFeng</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
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
                                <a href="##">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab1">
                            <ul class="clearfix news_dianjing1">
                                <li class="active"><a href="##">综合</a></li>
                                <li><a href="##">英雄联盟</a></li>
                                <li><a href="##">王者荣耀</a></li>
                                <li><a href="##">DOTA2</a></li>
                            </ul>
                            <div class="news_dianjing_list">
                                <div class="news_dianjing_detail active">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <div class="news_dianjing_top_div">
                                                <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                            </div>
                                            <span>2021 LCS春季赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛2222222</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛3333333</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛4444444</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 right">
                        <div class="game_title clearfix game_team_new">
                            <span class="title">游戏攻略</span>
                            <div class="more">
                                <a href="##">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab2">
                            <ul class="clearfix news_dianjing2">
                                <li class="active"><a href="##">英雄联盟</a></li>
                                <li><a href="##">王者荣耀</a></li>
                                <li><a href="##">DOTA2</a></li>
                            </ul>
                            <div class="news_dianjing_list">
                                <div class="news_dianjing_detail active">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛2222222</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛3333333</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="news_dianjing_detail">
                                    <div class="news_dianjing_top">
                                        <a href="##">
                                            <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            <span>2021 LCS春季赛4444444</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_mid">
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>竞燃杯｜企业电竞联赛</span>
                                        </a>
                                        <a href="##">
                                            <div class="news_dianjing_mid_img">
                                                <img src="<?php echo $config['site_url'];?>/images/game_team.png" alt="">
                                            </div>
                                            <span>CSGO精英对抗赛</span>
                                        </a>
                                    </div>
                                    <div class="news_dianjing_news">
                                        <ul>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                            <li><a href="##">英雄联盟｜11.7版本更新了什么 11.7版本更新内7版本更新了什么</a></li>
                                        </ul>
                                    </div>
                                </div>
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
                        <a href="##">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <ul class="game_special_list">
                    <li class="col-md-3 col-xs-6">
                        <a href="##">
                            <div class="div_img">
                                <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                <span>2021 LPL春季赛</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-md-3 col-xs-6">
                        <a href="##">
                            <div class="div_img">
                                <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                <span>2021 LPL春季赛</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-md-3 col-xs-6">
                        <a href="##">
                            <div class="div_img">
                                <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                <span>2021 LPL春季赛</span>
                            </div>
                        </a>
                    </li>
                    <li class="col-md-3 col-xs-6">
                        <a href="##">
                            <div class="div_img">
                                <img src="<?php echo $config['site_url'];?>/images/banner.png" alt="">
                                <span>2021 LPL春季赛</span>
                            </div>
                        </a>
                    </li>
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