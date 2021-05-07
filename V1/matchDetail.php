<?php
require_once "function/init.php";
$match_id = $_GET['match_id']??0;
echo $match_id;die();
$params = [
    "matchDetail"=>["source"=>$config['default_source'],"match_id"=>$match_id,"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>1],
    "currentPage"=>["name"=>"matchDetail","match_id"=>$match_id,"source"=>$config['default_source'],"site_id"=>$config['site_id']]
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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>赛事赛程</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/reset.css">
    <script src="./js/flexible.js"></script>
    <link rel="stylesheet" href="./css/headerfooter.css">
    <link rel="stylesheet" href="./css/game.css">
    <link rel="stylesheet" href="./css/jquery.lineProgressbar.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="index.html">
                        <img src="./images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                        <ul class="clearfix">
                            <li><a href="index.html">首页</a></li>
                            <li class="active"><a href="##">赛事赛程</a></li>
                            <li><a href="##">电竞战队</a></li>
                            <li><a href="##">电竞选手</a></li>
                            <li class="on"><a href="##">电竞资讯</a></li>
                            <li><a href="">游戏攻略</a></li>
                            <li><a href="##">赛事专题</a></li>
                            <li class="on"><a href="##">电竞资讯</a></li>
                            <li><a href="">游戏攻略</a></li>
                            <li><a href="##">赛事专题</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="game_left">
                    <div class="game_title">
                        <div class="game_title_top">
                            <div class="game_team1">
                                <div class="game_team1_img">
                                    <img src="./images/game_teaml.png" alt="">
                                </div>
                                <span>WE</span>
                            </div>
                            <div class="game_type">
                                <span class="span1">英雄联盟</span>
                                <span class="span2">2021 KPL 春季赛</span>
                                <div class="game_vs">
                                    <span class="span1">2</span>
                                    <img src="./images/vs.png" alt="">
                                    <span class="span2">1</span>
                                </div>
                                <p>2021.04.26 18:00·已结束</p>
                            </div>
                            <div class="game_team1">
                                <div class="game_team1_img">
                                    <img src="./images/game_teaml.png" alt="">
                                </div>
                                <span>WE</span>
                            </div>
                        </div>
                        <div class="game_team_depiction">
                            <p>TeamWE是一家中国电子竞技俱乐部，成立于2005年4月21日，是TeamWE是一家中国电子竞技俱乐部，成立于2005年4月21日，是</p>
                            <p>SV电子竞技俱乐部于2016年11月成立。SuperValiant译为超级勇猛...SV电子竞技俱乐部于2016年11月成立。SuperValiant译为超级勇猛...</p>
                        </div>
                        <img src="./images/more.png" alt="" class="game_title_more">
                    </div>
                    <div class="game_detail">
                        <ul class="game_detail_ul">
                            <li class="active">
                                <a href="##">
                                    <div class="game_detail_img1">
                                        <img src="./images/game_detail1.png" alt="">
                                    </div>
                                    <span>GAME 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_detail_img1">
                                        <img src="./images/game_detial2.png" alt="">
                                    </div>
                                    <span>GAME 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="##">
                                    <div class="game_detail_img1">
                                        <img src="./images/game_detail1.png" alt="">
                                    </div>
                                    <span>GAME 3</span>
                                </a>
                            </li>
                        </ul>
                        <div class="game_detail_div">
                            <div class="game_detail_div_item">
                                <div class="game_detail_div_item1">
                                    <div class="left">
                                        <div class="imgwidth40 imgheight40">
                                            <img src="./images/game_detail1.png" alt="" class="imgauto">
                                        </div>
                                        <span>WE</span>
                                        <div class="imgwidth30 imgheight30">
                                            <img src="./images/victory.png" alt="" class="imgauto">
                                        </div>
                                    </div>
                                    <div class="center">
                                        <span class="game_detail_line1"></span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="fz font_color_r">95</span>
                                        <div class="img_game_detail_vs">
                                            <img src="./images/game_detail_vs.png" alt="" class="imgauto">
                                        </div>
                                        <span class="fz font_color_b">72</span>
                                        <span class="game_detail_circle1"></span>
                                        <span class="game_detail_line1"></span>
                                    </div>
                                    <div class="left right">
                                        <div class="imgwidth40 imgheight40">
                                            <img src="./images/game_detail1.png" alt="" class="imgauto">
                                        </div>
                                        <span>WE</span>
                                    </div>
                                </div>
                                <div class="game_detail_div_item2">
                                    <div class="game_detail_div_item2_left">
                                        <div class="game_detail_div_item2_img">
                                            <img src="./images/player1.png" alt="" class="imgauto">
                                        </div>
                                        <div class="game_detail_div_item2_word">
                                            <span class="span1">MVP</span>
                                            <span class="span2">jiejie</span>
                                        </div>
                                        <div class="arrow-up"></div>
                                    </div>
                                    <div class="game_detail_div_item2_right">
                                        <div class="arrow-down"></div>
                                        <div class="game_detail_div_item2_word">
                                            <span class="span1">背锅侠</span>
                                            <span class="span2">Cryin</span>
                                        </div>
                                        <div class="game_detail_div_item2_img">
                                            <img src="./images/player1.png" alt="" class="imgauto">
                                        </div>
                                    </div>
                                </div>
                                <div class="game_detail_div_item3">
                                    <div class="game_detail_div_item3_top">
                                        <div class="left">
                                            <div class="left_img">
                                                <img src="./images/gold_coin.png" alt="" class="imgauto">
                                            </div>
                                            <span>95.71k</span>
                                        </div>
                                        <p>28:16</p>
                                        <div class="left">
                                            <span>67k</span>
                                            <div class="left_img">
                                                <img src="./images/gold_coin.png" alt="" class="imgauto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pk-detail-con">
                                        <div class="progress" >
                                          <div class="progress-bar" style="width: 58%;">
                                            <i class="lightning"></i>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="game_detail_div1_item3">
                                        <div class="left">
                                            <div class="img1">
                                                <img src="./images/kpl_dalong.png" alt="" class="autoimg">
                                            </div>
                                            <span>1</span>
                                            <div class="img1">
                                                <img src="./images/kpl_xiaolong.png" alt="" class="autoimg">
                                            </div>
                                            <span>3</span>
                                            <div class="img1 img2">
                                                <img src="./images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span>1</span>
                                        </div>
                                        <div class="left right">
                                            <div class="img1">
                                                <img src="./images/kpl_dalong.png" alt="" class="autoimg">
                                            </div>
                                            <span>2</span>
                                            <div class="img1">
                                                <img src="./images/kpl_xiaolong.png" alt="" class="autoimg">
                                            </div>
                                            <span>3</span>
                                            <div class="img1 img2">
                                                <img src="./images/kpl_ta.png" alt="" class="autoimg">
                                            </div>
                                            <span>0</span>
                                        </div>
                                    </div>
                                    <div class="line2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="game_right">
                
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
    <script src="./js/jquery.min.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/jquery.lineProgressbar.js"></script> 
    <script>
        $('#progressbar2').LineProgressbar({
				percentage: 58,
				fillBackgroundColor: '#1abc9c'
			});
            $('#progressbar1').LineProgressbar({
				percentage: 30,
				fillBackgroundColor: '#1abc9c'
			});
    </script>
</body>
</html>