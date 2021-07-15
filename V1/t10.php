<!DOCTYPE html>
<?php
require_once "function/init.php";
$rankingList = array_unique(array_values($config['ti10']['ti9_ranking']));
$params=[
    "connectInfo"=>["dataType"=>"keywordMapList","fields"=>"content_id","source_type"=>"another","word"=>$config['ti10']['keyword'],"page_size"=>10,"content_type"=>"information","list"=>["page_size"=>10,"fields"=>"id,title,create_time,logo"]],
    "teamList"=>["dataType"=>"intergratedTeamList","page"=>1,"page_size"=>30,"game"=>"dota2","fields"=>'tid,team_name,logo',"cache_time"=>86400*7],
    "dota2TournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>4,"game"=>$config['ti10']['game'],"source"=>$config['game_source'][$config['ti10']['game']] ?? $config['default_source'],"cache_time"=>86400],
    "tournamentList"=>["page"=>1,"page_size"=>2,"source"=>$config['default_source'],"cache_time"=>86400],
    "links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","bounas_pool","default_tournament_img","t10_title","t10_keywords","t10_desc"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
    "ti9teamList"=>["dataType"=>"intergratedTeamList","tid"=>$rankingList,"page"=>1,"page_size"=>30,"game"=>"dota2","fields"=>'tid,team_name,logo',"cache_time"=>86400*7],
];
$return = curl_post($config['api_get'],json_encode($params),1);
//$return['teamList']['data'] = [];
$return['dota2TournamentList']['data']=array_merge($return['dota2TournamentList']['data'],$return['tournamentList']['data']);
$return['dota2TournamentList']['data'] = array_slice($return['dota2TournamentList']['data'],0,4);
$bounas_pool = explode(",",$return["defaultConfig"]["data"]["bounas_pool"]['value']);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <?php renderHeaderJsCss($config,["newevents","events","../fonts/iconfont"]);?>

</head>
<body>
    <div class="wrapper">
        <div class="header">    <title><?php echo str_replace("#site_name#",$config['site_name'],$return['defaultConfig']['data']['t10_title']['value']);?></title>
            <meta name=”Keywords” Content="<?php echo $return['defaultConfig']['data']['t10_keywords']['value'];?>">
            <meta name="description" content="<?php echo str_replace("#site_name#",$config['site_name'],$return['defaultConfig']['data']['t10_desc']['value']);?>">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="<?php echo $config['site_url'];?>">
                            <img  src="<?php echo $config['site_url'];?>/images/logo.png" data-original="<?php echo $config['site_url'];?>/images/logo.png"></a>
                    </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <div class="nav">
                            <?php generateNav($config,"tournament");?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row events_top">
                <!-- 比赛介绍 -->
                <div class="team_title mb20 clearfix schedule">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/dota2_logo.png" src="<?php echo $config['site_url'];?>/images/dota2_logo.png" alt="">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <h1 class="name fl">Ti10 Dota2国际邀请赛</h1>
                            <p class="classify fl">DOTA2</p>
                            <!--<p class="classify fl"><?php echo $config['game'][$config['ti10']['game']];?></p>-->
                        </div>
                        <div class="team_explain_bottom">
                            <p>
                                DOTA2国际邀请赛，The International DOTA2
                                Championships。简称Ti，创立于2011年，是一个全球性的电子竞技赛事，每年一届，由ValveCorporation（V社）主办,奖杯为V社特制冠军盾牌，每一届冠军队伍及人员将记录在游戏泉水的冠军盾中。
                            </p>
                            <p>
                                <span>TI10国际邀请赛时间：</span>10月7日至10月10日举办小组赛，10月12日至10月17日举办正式比赛，举办地点将位于罗马尼亚首都布加勒斯特Arena Nationala体育馆。
                            </p>
                            <p>
                                <span>TI10国际邀请赛奖金：</span>本届ti10国际邀请赛奖金池高达<span><?php echo $bounas_pool[0];?>美金（约合人民币2.5亿元）</span>
                            </p>
                        </div>
                    </div>
                    <div class="left_bg">
                        <img  data-original="<?php echo $config['site_url'];?>/images/events_topbg.png" src="<?php echo $config['site_url'];?>/images/events_topbg.png" alt="">
                    </div>
                    <div class="right_bg">
                        <img data-original="<?php echo $config['site_url'];?>/images/events_topbg.png" src="<?php echo $config['site_url'];?>/images/events_topbg.png" alt="">
                    </div>
                </div>
                <!-- 比赛介绍 -->
                <!-- 赛制 -->
                <div class="format mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/format_icon.png" src="<?php echo $config['site_url'];?>/images/format_icon.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['ti10']['event_name'];?>赛制</h2>
                    </div>
                    <div class="format_detail">
                        <p class="format_p">地区预选赛赛制</p>
                        <div class="format_div">
                            <p><span>小组赛：</span>进行组内BO1单循环积分赛，第1-4名晋级淘汰赛，第5-8名直接淘汰</p>
                            <p><span>淘汰赛：</span>4支战队进行双败淘汰赛除总决赛BO5，其余均为BO3，第一名晋级主赛事</p>
                        </div>
                        <p class="format_p">主赛事赛制</p>
                        <div class="format_div format_div1">
                            <p><span>小组赛：</span>共18支战队分为2组（每组9支），进行小组循环积分赛，获胜得2分，平得1分，负得0分，每组排名末位战队被淘汰。</p>
                            <p><span>淘汰赛：</span>双败淘汰制，每组1-4名进入主赛事胜者组，5-8名进入败者组，败者组第一轮为BO1，决赛为BO5，其余比赛均为BO3
                            </p>
                        </div>
                    </div>
                </div>
                <!-- 赛制 -->
                <div class="mb20 team_news">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto"  data-original="<?php echo $config['site_url'];?>/images/news.png" src="<?php echo $config['site_url'];?>/images/news.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['ti10']['event_name'];?>最新资讯</h2>
                        <a href="<?php echo $config['site_url']."/newslist/".$config['ti10']['game']."/";?>" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="team_news_mid">
                        <ul class="team_news_mid_ul clearfix">
                            <?php foreach($return['connectInfo']['data'] as $key => $info){if($key<=3){?>
                            <li>
                                <a href="<?php echo $config["site_url"]."/newsdetail/".$info['id'];?>">
                                    <div class="team_news_img">
                                        <div class="img">
                                            <img class="imgauto" data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                        </div>
                                        <p><?php echo $info['title'];?></p>
                                    </div>
                                </a>
                            </li>
                            <?php }}?>
                        </ul>
                    </div>
                    <div class="team_news_bot">
                        <ul class="team_news_bot_ul clearfix">
                            <?php foreach($return['connectInfo']['data'] as $key => $info){if($key>3){?>
                                <li class="fl">
                                    <a href="<?php echo $config["site_url"]."/newsdetail/".$info['id'];?>">
                                        <?php echo $info['title'];?>
                                    </a>
                                </li>
                            <?php }}?>
                        </ul>
                    </div>
                </div>
                <?php if(count($return['teamList']['data'])>0){?>
                    <div class="hot_team mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/hots.png" src="<?php echo $config['site_url'];?>/images/hots.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['ti10']['event_name'];?>参赛队伍</h2>
                    </div>
                    <ul class="dota2_teams clearfix">
                        <?php foreach($return['teamList']['data'] as $key => $teamInfo){?>
                            <li class="col-xs-2">
                                <a href="<?php echo $config["site_url"]."/teamdetail/".$teamInfo['tid'];?>">
                                    <div class="a1">
                                        <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
                                    </div>
                                </a>
                            </li>
                        <?php }?>
                    </ul>

                </div>
                <?php }?>
                <div class="prizePool mb20">
                    <h2 class="title"><?php echo $config['ti10']['event_name'];?>奖金池</h2>
                    <div class="m_wrapper">

                    </div>
                    <!-- <div class="money">
                        <i>$</i>
                        <span>4</span>
                        <span>5</span>
                        <span>,</span>
                        <span>2</span>
                        <span>3</span>
                        <span>1</span>
                        <span>,</span>
                        <span>6</span>
                        <span>9</span>
                        <span>2</span>
                    </div> -->
                    <!-- <div class="money">
                        <i>$</i>
                    </div> -->
                    <div class="champion">
                        <?php $bounas = $bounas_pool[1];
                        $bounas = explode("|",$bounas);?>
                        <p>$<?php echo number_format($bounas[0]);?></p>
                        <span><?php echo $bounas[1];?>&nbsp;|&nbsp;<?php echo $bounas[2];?>%</span>
                    </div>
                    <div class="other clearfix">
                        <?php foreach($bounas_pool as $key => $bounas){if($key>1 && $key<=4){
                            $bounas = explode("|",$bounas);
                            ?>
                            <div class=" other_div other_mr">
                                <p>$<?php echo number_format($bounas[0]);?></p>
                                <span><?php echo $bounas[1];?>&nbsp;|&nbsp;<?php echo $bounas[2];?>%</span>
                            </div>
                        <?php }}?>
                    </div>
                    <div class="others">
                        <?php foreach($bounas_pool as $key => $bounas){if($key>4){
                            $bounas = explode("|",$bounas);?>
                            <div class="others_div">
                                <p>$<?php echo number_format($bounas[0]);?></p>
                                <span><?php echo $bounas[1];?>&nbsp;|&nbsp;<?php echo $bounas[2];?>%</span>
                            </div>
                        <?php }}?>
                    </div>
                </div>
                <?php if(count($return['ti9teamList']['data'])>0){?>
                <div class="thumbsUp mb20">
                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/ranking.png" src="<?php echo $config['site_url'];?>/images/ranking.png" alt="">
                        </div>
                        <h2 class="fl team_pbu_name"><?php echo $config['ti10']['event_name'];?>冠军预测</h2>
                    </div>
                    <div class="clearfix thumbs">
                        <div class="top_three fl clearfix dn_wap">
                            <?php $teamInfo = $return['ti9teamList']['data'][0];?>
                            <div class="top_one fl">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="team">
                                        <img src="<?php echo $teamInfo['logo'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $teamInfo['team_name'];?>">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbstop.png" src="<?php echo $config['site_url'];?>/images/thumbstop.png" alt="" class="thumbstop">
                                    </div>
                                    <p class="top_name"><?php echo $teamInfo['team_name'];?></p>
                                </a>
                                    <div id="btn1">
                                        <div class="btn1">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                            </div>
                            <div class="top_right fl">
                                <?php $teamInfo = $return['ti9teamList']['data'][1];?>
                                <div class="top_two">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="team">
                                        <img src="<?php echo $teamInfo['logo'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="top_twoimg">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbstwo.png" src="<?php echo $config['site_url'];?>/images/thumbstwo.png" alt="" class="thumbstwo">
                                    </div>
                                    <p class="two_name"><?php echo $teamInfo['team_name'];?></p>
                                </a>
                                    <div id="btn2">
                                        <div class="btn2">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                            </div>
                                <?php $teamInfo = $return['ti9teamList']['data'][2];?>
                                <div class="top_thre">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>" class="clearfix">
                                    <div class="fl team">
                                        <img data-original="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_80,w_80" src="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_80,w_80" alt="<?php echo $teamInfo['team_name'];?>" class="top_threeimg">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbsthree.png"  src="<?php echo $config['site_url'];?>/images/thumbsthree.png" alt="" class="thumbsthree">
                                    </div>
                                </a>
                                    <div class="fl three_detali">
                                        <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>" class="clearfix">
                                        <p class="thre_name"><?php echo $teamInfo['team_name'];?></p>
                                        </a>
                                        <div id="btn3">
                                            <div class="btn3">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="dn_pc top_threes">
                            <?php $teamInfo = $return['ti9teamList']['data'][1];?>
                            <div class="top_two">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="team">
                                        <img data-original="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_80,w_80"  src="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_80,w_80" alt="<?php echo $teamInfo['team_name'];?>" class="top_twoimg">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbstwo.png" src="<?php echo $config['site_url'];?>/images/thumbstwo.png" alt="" class="thumbstwo">
                                    </div>
                                    <p class="two_name"><?php echo $teamInfo['team_name'];?></p>
                                </a>
                                <div id="btn2_1">
                                        <div class="btn2">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                            </div>
                            <?php $teamInfo = $return['ti9teamList']['data'][0];?>
                            <div class="top_one">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="team">
                                        <img data-original="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_58,w_58" src="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_58,w_58" alt="<?php echo $teamInfo['team_name'];?>" class="top_oneimg">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbstop.png" src="<?php echo $config['site_url'];?>/images/thumbstop.png" alt="" class="thumbstop">
                                    </div>
                                    <p class="top_name"><?php echo $teamInfo['team_name'];?></p>
                                </a>
                                <div id="btn1_1">
                                        <div class="btn1">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                            </div>
                            <?php $teamInfo = $return['ti9teamList']['data'][2];?>
                            <div class="top_three">
                                <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                    <div class="team">
                                        <img  data-original="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_58,w_58" src="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_58,w_58" alt="<?php echo $teamInfo['team_name'];?>" class="top_twoimg">
                                        <img data-original="<?php echo $config['site_url'];?>/images/thumbsthree.png" src="<?php echo $config['site_url'];?>/images/thumbsthree.png" alt="" class="thumbstwo">
                                    </div>
                                    <p class="two_name"><?php echo $teamInfo['team_name'];?></p>
                                </a>
                                <div id="btn3_1">
                                        <div class="btn3">
                                            <i class="iconfont icon-dianzan i"></i>
                                        </div>
                                        <p class="likes">100</p>
                                    </div>
                            </div>
                        </div>
                        <div class="fr thumb_others">
                            <ul>
                                <?php foreach($return['ti9teamList']['data'] as $key => $teamInfo){if($key>=3){?>
                                <li class="clearfix">
                                        <span class="ranking_span"><?php echo $key+1;?></span>
                                        <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                        <div class="thumb_others_img">
                                            <img  data-original="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_54,w_54"  src="<?php echo $teamInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_54,w_54" alt="<?php echo $teamInfo['team_name'];?>">
                                        </div>
                                        <span class="thumb_others_name"><?php echo $teamInfo['team_name'];?></span>
                                        </a>
                                        <div id="btn4" class="btn_others">
                                            <div class="btn4">
                                                <i class="iconfont icon-dianzan i"></i>
                                            </div>
                                            <p class="likes">100</p>
                                        </div>
                                </li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php }?>

                <div class="hot_match mb20">

                    <div class="team_pub_top clearfix">
                        <div class="team_pub_img fl">
                            <img class="imgauto" data-original="<?php echo $config['site_url'];?>/images/events.png"  src="<?php echo $config['site_url'];?>/images/events.png" alt="">
                        </div>
                        <span class="fl team_pbu_name">热门赛事</span>
                        <a href="<?php echo $config['site_url'];?>/tournamentlist/<?php echo $config['ti10']['game'];?>" class="team_pub_more fr">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" data-original="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                    <div class="hot_match_bot">
                        <ul class="clearfix">
                            <?php foreach($return['dota2TournamentList']['data'] as $key => $tournamentInfo){?>
                                <li>
                                    <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>">
                                        <img data-original="<?php echo $tournamentInfo['logo'].$config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'].$config['default_oss_img_size']['tournamentList'];?>" alt="<?php echo $tournamentInfo['tournament_name'];?>" class="imgauto1">
                                        <span><?php echo $tournamentInfo['tournament_name'];?></span>
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
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar"]);?>


    <!-- 金额js -->
    <script>
        var a = '<?php echo number_format($bounas_pool[0])?>';
        // Number.prototype.reverse = function(){
        //      var s = this.toString();
        //      var a = [];
        //      for(var i=0;i<9;i++){
        //       a.unshift(s[i]);
        //      }
        //      return a.join("");
        //     }
        //    var n =  a.reverse()
        //    console.log(n.toString().split(""))
        // console.log(a.split('').map(Number))
        var money = a.split('')
        var html = ''
        html += '<div class="money">' + '<i>$</i>'
        for (var i = 0; i < money.length; i++) {
            html += '<span>' + money[i] + '</span>'
        }
        html += '</div>'
        $(".m_wrapper").html(html)
    </script>
    <script type="text/javascript">
            (function ($) {
                $.extend({
                    tipsBox: function (options) {
                        options = $.extend({
                            obj: null,  //jq对象，要在那个html标签上显示
                            str: "+1",  //字符串，要显示的内容;也可以传一段html，如: "<b style='font-family:Microsoft YaHei;'>+1</b>"
                            startSize: "12px",  //动画开始的文字大小
                            endSize: "30px",    //动画结束的文字大小
                            interval: 600,  //动画时间间隔
                            color: "red",    //文字颜色
                            callback: function () { }    //回调函数
                        }, options);
                        $("body").append("<span class='num'>" + options.str + "</span>");
                        var box = $(".num");
                        var left = options.obj.offset().left + options.obj.width() / 2;
                        var top = options.obj.offset().top - options.obj.height();
                        box.css({
                            "position": "absolute",
                            "left": left + "px",
                            "top": top + "px",
                            "z-index": 9999,
                            "font-size": options.startSize,
                            "line-height": options.endSize,
                            "color": options.color
                        });
                        box.animate({
                            "font-size": options.endSize,
                            "opacity": "0",
                            "top": top - parseInt(options.endSize) + "px"
                        }, options.interval, function () {
                            box.remove();
                            options.callback();
                        });
                    }
                });
            })(jQuery);

        function niceIn(prop) {
            prop.find('.i').addClass('niceIn');
            setTimeout(function () {
                prop.find('.i').removeClass('niceIn');
            }, 1000);
        }
            var thumbs = 1000000;
            var thumb1 = Math.floor(Math.random() * 5000 + 1)
            var first = 1000000 + thumb1;
            var second = 1000000 - thumb1;
            var arr1 = new Array();
            arr1.push(first,second);
            for(var i = 2; i < $('.likes').length; i++){
                arr1[i] = second - thumb1;
                second = arr1[i];
                thumb1 = Math.floor(Math.random() * 100000 + 1)
            }
            for (var i = 0; i < arr1.length; i++) {
                $('.likes').eq(i).text(arr1[i])
            }
            $(".i").click(function () {
            var num = $(this).parent().next().text()
            num++;
            $(this).parent().next().text(num);
        });
        $(function () {
            $("#btn1 .btn1").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn2 .btn2").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn3 .btn3").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn1_1 .btn1").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn2_1 .btn2").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(function () {
            $("#btn3_1 .btn3").click(function () {
                $.tipsBox({
                    obj: $(this),
                    str: "+1",
                    callback: function () {
                    }
                });
                niceIn($(this));
            });
        });
        $(document).ready(function (index) {
            $(".thumb_others ul li").each(function (index) {
                var _this = $(this).find('a').find('.btn_others').find('.btn4')
                _this.click(function () {
                    $.tipsBox({
                        obj: _this,
                        str: "+1",
                        callback: function () {
                        }
                    });
                    niceIn(_this);
                });
            });
        });
    </script>

</body>

</html>