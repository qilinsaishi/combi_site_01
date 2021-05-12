<?php
require_once "function/init.php";
$tid = $_GET['tid']??0;
if($tid<=0)
{
    render404($config);
}
$params = [
    "intergratedTeam"=>[$tid],
    "defaultConfig"=>["keys"=>["contact","sitemap","default_team_img","default_player_img"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
    "currentPage"=>["name"=>"team","site_id"=>$config['site_id']]
];
$return = curl_post($config['api_get'],json_encode($params),1);
if($return['intergratedTeam']['data']['description']!="")
{
    if(substr($return['intergratedTeam']['data']['description'],0,1)=='"' && substr($return['intergratedTeam']['data']['description'],-1)=='"')
    {
        $description =  html_entity_decode(json_decode($return['intergratedTeam']['data']['description'],true));

    }
    else
    {
        $description =  html_entity_decode($return['intergratedTeam']['data']['description']);

    }
}
else
{
    $description = "暂无";
}
if(count($return['intergratedTeam']['data']['aka'])>0){
	$return['intergratedTeam']['data']['aka']=implode(',',$return['intergratedTeam']['data']['aka']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $return['intergratedTeam']['data']['team_name'];?>电子竞技俱乐部_<?php echo $return['intergratedTeam']['data']['team_name'];?>战队_<?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部成员介绍-<?php echo $config['site_name'];?></title>
    <meta name="description" content="<?php echo strip_tags($return['intergratedTeam']['data']['description']);?>">
    <meta name=”Keywords” Content=”<?php echo $return['intergratedTeam']['data']['team_name'];?>电子竞技俱乐部,<?php
    if(substr_count($return['intergratedTeam']['data']['team_name'],"战队")==0){echo $return['intergratedTeam']['data']['team_name'].'战队,';}?><?php echo $return['intergratedTeam']['data']['team_name'];?>电竞俱乐部成员介绍″>
    <?php renderHeaderJsCss($config,["progress-bars","teamdetail"]);?>
    <!-- 这是本页面新增的css  teamdetail.css -->
 
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
            <div class="row">
                <!-- 战队介绍 -->
                <div class="team_title mb20 clearfix">
                    <div class="team_logo fl">
                        <div class="team_logo_img mauto">
                            <img class="imgauto" src="<?php echo $return['intergratedTeam']['data']['logo'];?>" alt="<?php echo $return['intergratedTeam']['data']['team_name'];?>">
                        </div>
                    </div>
                    <div class="team_explain fr">
                        <div class="team_explain_top clearfix">
                            <p class="name fl"><?php echo $return['intergratedTeam']['data']['team_name'];?></p>
                            <p class="classify fl">英雄链接</p>
                        </div>
                        <div class="team_explain_name clearfix">
                            <p class="clearfix fl">英文名：<span class="English_name fr"><?php echo $return['intergratedTeam']['data']['team_name'];?></span></p>
                            <p class="clearfix fl">别称：<span class="chinese_name fr"><?php echo $return['intergratedTeam']['data']['aka'] ?></span></p>
                        </div>
                        <div class="team_explain_bottom">
                           <?php echo $description;?>
                        </div>
                    </div>
                </div>
                <!-- 战队介绍 -->
                <!-- 队员介绍 -->
                <div class="team_member mb20">
                    <div class="team_member_top clearfix">
                        <div class="team_member_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_number.png" alt="">
                        </div>
                        <span class="fl team_number_name">WE战队成员</span>
                    </div>
                    <ul class="team_member_detail clearfix">
						 <?php
						  foreach($return['intergratedTeam']['data']['playerList'] as $playerInfo)
						  { if(strlen($playerInfo['logo']) >=10){
							  ?>
                        <li>
                            <a href="<?php echo $config['site_url']; ?>/playerlist/<?php echo $playerInfo['pid'];?>">
                                <div class="team_number_photo">
									<?php if(isset($return['defaultConfig']['data']['default_player_img'])){?>
                      <img lazyload="true" data-original="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" src="<?php echo $playerInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" title="<?php echo $playerInfo['player_name'];?>" />
                  <?php }else{?>
                      <img src="<?php echo $playerInfo['logo'];?>?x-oss-process=image/resize,m_lfit,h_100,w_100" title="<?php echo $playerInfo['player_name'];?>" />
                  <?php }?>
                                </div>
                                <span class="team_number_name"><?php echo $playerInfo['player_name']?></span>
                            </a>
                        </li>
                          <?php }}?>
                    </ul>
                </div>
                <!-- 队员介绍 -->
                <!-- 战队数据 -->
                <div class="team_data mb20">
                    <div class="team_data_top clearfix">
                        <div class="team_data_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_data.png" alt="">
                        </div>
                        <span class="fl team_data_name">WE战队基础数据</span>
                        <div class="team_data_frequency fr clearfix">
                            <p class="matches_number fl">比赛场次：<span>28场</span></p>
                            <p class="matches_rank fl">联赛排名：<span>第 1</span></p>
                        </div>
                    </div>
                    <div class="team_data_items clearfix">
                        <div class="data_left fl">
                            <div class="circle_left clearfix">
                                <div class="won_all third circle fl" data-num="0.75">
                                    <strong></strong>
                                </div>
                                <div class="circle_right fl">
                                    <div class="red">
                                        <div class="won_red circle" data-num="0.6">
                                        </div>
                                        <div class="red_explain">
                                            <span class="rate_number">69.2%</span>
                                            <span class="rate_explain">13场9胜4败</span>
                                            <span class="rate">红方胜率</span>
                                        </div>
                                    </div>
                                    <div class="blue">
                                        <div class="won_blue circle" data-num="0.9">
                                        </div>
                                        <div class="blue_explain">
                                            <span class="rate_number">66.7%</span>
                                            <span class="rate_explain">15场10胜5败</span>
                                            <span class="rate">蓝方胜率</span>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="data_right fr clearfix">
                            <div class="data_btn_all fl mb20">
                                <span>5.2</span>
                                <span>KDA·联赛第 1</span>
                            </div>
                            <div class="data_kill data_btn fl mb20">
                                <p>395[14.1]</p>
                                <p>击杀（场均）</p>
                                <p>联赛第<span>1</span></p>
                            </div>
                            <div class="data_death data_btn fl">
                                <p>269[9.6]</p>
                                <p>死亡（场均）</p>
                                <p>联赛第<span>15</span></p>
                            </div>
                            <div class="data_assists data_btn fl">
                                <p>1004[35.9]</p>
                                <p>助攻（场均）</p>
                                <p>联赛第<span>1</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 战队数据 -->
                <!-- 战队荣誉 -->
                <div class="team_honor mb20">
                    <div class="team_honor_top clearfix">
                        <div class="team_honor_img fl">
                            <img class="imgauto" src="<?php echo $config['site_url'];?>/images/team_honor.png" alt="">
                        </div>
                        <span class="fl team_honor_name">WE战队历史荣誉</span>
                    </div>
                    <div class="team_honor_detail">
                        <div class="honor_top clearfix">
                            <span>时间</span>
                            <span>荣誉/名次</span>
                            <span>赛事</span>
                            <span>赛况</span>
                        </div>
                        <ul class="honor_bottom">
						<?php
						  foreach($return['intergratedTeam']['data']['honor_list'] as $honorInfo)
						  {?>
                            <li>
                                <a href="javascript:;" class="clearfix">
                                    <div class="w25">
                                        <?php echo $honorInfo['match_time']?>
                                    </div>
                                    <div class="w25 max_span">
                                        <div class="honor_bottom_img1">
											
                                            <img class="imgauto" src="<?php echo $honorInfo['ranking_icon']?>" alt="">
                                        </div>
                                        <span><?php echo $honorInfo['ranking']?></span>
                                    </div>
                                    <div class="w25 max_span">
                                        <div class="honor_bottom_img2">
											<img class="imgauto" src="<?php echo $honorInfo['t_image']?>" alt="">
                                        </div>
                                        <span><?php echo $honorInfo['t_name']?></span>
                                    </div>
                                    <div class="w25">
                                        <div class="honor_bottom_img2">
                                            <img class="imgauto" src="<?php echo $honorInfo['team_a_image']?>" alt="<?php echo $honorInfo['team_name_a']?>">
                                        </div>
                                        <div class="honor_bottom_vs">
                                            <span class="red span_left"><?php echo $honorInfo['team_a_win']?></span>
                                            <div class="honor_bottom_img1">
                                                <img class="imgauto" src="<?php echo $config['site_url'];?>/images/game_detail_vs.png" alt="">
                                            </div>
                                            <span class="blue span_right"><?php echo $honorInfo['team_b_win']?></span>
                                        </div>
                                        <div class="honor_bottom_img2">
                                            <img class="imgauto" src="<?php echo $honorInfo['team_b_image']?>" alt="<?php echo $honorInfo['team_name_b']?>">
                                        </div>
                                    </div>
                                </a>
                            </li>
							<?php }?>
                            
                        </ul>
                    </div>
                </div>
                <!-- 战队荣誉 -->
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
    <?php renderFooterJsCss($config,[],["jquery.lineProgressbar","circle-progress.js"]);?>
   
   <script>

    var value = $('.won_all').data('num');
    $('.won_all.circle').circleProgress({
        value: value,
        size:208,
        lineCap:'round',
        fill: { gradient:['#FF6649'] },
        startAngle: -Math.PI / 4 * 2,
    }).on('circle-animation-progress', function(event, progress, stepValue) {
        $(this).find('strong').html(parseInt(100 * stepValue) + '<i>%</i><span>胜率</span>');
    });

    var value_red = $('.won_red').data('num');
    $('.won_red.circle').circleProgress({
        startAngle: -Math.PI / 4 * 2,
        size:94,
        value: value_red,
        lineCap: 'round',
        fill: { color: '#FF5C6A' }
    });

    var value_blue = $('.won_red').data('num');
    $('.won_blue.circle').circleProgress({
        startAngle: -Math.PI / 4 * 2,
        size:94,
        value: value_blue,
        lineCap: 'round',
        fill: { color: '#0C8DFC' }
    });
    </script>
</body>

</html>