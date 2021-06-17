<?php
require_once "function/init.php";
$params = [
    "matchList"=>["page"=>1,"page_size"=>8,"recent"=>1,"source"=>$config['default_source'],"cacheWith"=>"currentPage","cache_time"=>86400],
    "tournamentList"=>["page"=>1,"page_size"=>4,"source"=>$config['default_source'],"cache_time"=>86400],
	"dota2TournamentList"=>["dataType"=>"tournamentList","page"=>1,"page_size"=>0,"game"=>'dota2',"source"=>$config['game_source']['dota2'] ?? $config['default_source'],"cache_time"=>86400],
    "defaultConfig"=>["keys"=>["contact","download_qr_code","sitemap","default_team_img","default_player_img","default_tournament_img","default_information_img","android_url","ios_url"],"fields"=>["name","key","value"],"site_id"=>$config['site_id']],
	"links"=>["page"=>1,"page_size"=>6,"site_id"=>$config['site_id']],
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
        ["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,site_time',"type"=>$config['informationType']['news'],"cache_time"=>86400*7];
    $params[$game."StraList"] =
        ["dataType"=>"informationList","site"=>$config['site_id'],"page"=>1,"page_size"=>10,"game"=>$game,"fields"=>'id,title,logo,site_time',"type"=>$config['informationType']['stra'],"cache_time"=>86400*7];
}
$return = curl_post($config['api_get'],json_encode($params),1);
$return['tournamentList']['data']=array_merge($return['tournamentList']['data'],$return['dota2TournamentList']['data']);
//文章类型
$newsTypeList = ["News","Stra"];
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
    <meta name="viewport" content="width=640, user-scalable=no, viewport-fit=cover">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $config['site_name'];?>-热门电竞战队赛事资讯网</title>
    <meta name=”Keywords” Content=”电竞赛事,电竞战队,电竞资讯″>
    <meta name="description" content="<?php echo $config['site_name'];?>提供专业电子竞技赛事、电竞战队、电竞资讯内容，专注于服务电竞玩家，致力于为电竞玩家提供电竞数据分析及解读">
    <?php renderHeaderJsCss($config,["index"]);?>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <div class="container clearfix">
                <div class="row">
                    <div class="logo"><a href="<?php echo $config['site_url'];?>">
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
            <div class="banner" style="background:url(<?php echo $config['site_url'];?>/images/banner.png) no-repeat center / cover;">
                <div class="button">
                    <a href="<?php echo $return['defaultConfig']['data']['ios_url']['value'];?>" target="_blank">
                    <div class="download_ios download">
                        <img src="<?php echo $config['site_url'];?>/images/ios.png" alt="">
                        <span>IOS下载</span>

                    </div>
                    </a>
                    <a href="<?php echo $return['defaultConfig']['data']['android_url']['value'];?>" target="_blank">
                    <div class="download_android download">
                        <img src="<?php echo $config['site_url'];?>/images/android.png" alt="">
                        <span>Android下载</span>
                    </div>
                    </a>
                </div>
            </div>
            <div class="game_match container">
                <div class="game_title row clearfix game_title_e">
                    <span class="title">热门赛事</span>
                    <div class="more">
                        <a href="<?php echo $config['site_url'];?>/match/">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <ul class="game_match_ul dn_wap">
                        <?php foreach($return['matchList']['data'] as $matchInfo){?>
                        <li class="col-md-3 col-xs-12">
                            <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                <div class="game_match_top">
                                    <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                    <span class="game_match_time"><?php echo date("m月d日 H:i",strtotime($matchInfo['start_time']));?></span>
                                </div>
                                <div class="game_match_bottom clearfix">
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                           <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" title="<?php echo $matchInfo['home_team_info']['team_name'];?>" />
                                            
                                        </div>
                                        <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                    </div>
                                    <div class="left center">
                                        <span> vs </span>
                                        <span><?php echo $config['game'][$matchInfo['game']];?></span>
                                    </div>
                                    <div class="left ov_1">
                                        <div class="game_match_img">
                                                <img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  title="<?php echo $matchInfo['away_team_info']['team_name'];?>" />
                                         
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
                                <a href="<?php echo $config['site_url'];?>/matchdetail/<?php echo $matchInfo['game'];?>-<?php echo $matchInfo['match_id'];?>">
                                    <div class="game_match_top">
                                        <span class="game_match_name"><?php echo $matchInfo['tournament_info']['tournament_name'];?></span>
                                        <span class="game_match_time"><?php echo date("m月d日 H:i",strtotime($matchInfo['start_time']));?></span>
                                    </div>
                                    <div class="game_match_bottom clearfix">
                                        <div class="left">
                                            <div class="game_match_img">
                                                <img data-original="<?php echo $matchInfo['home_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $matchInfo['home_team_info']['team_name'];?>">
                                            </div>
                                            <span><?php echo $matchInfo['home_team_info']['team_name'];?></span>
                                        </div>
                                        <div class="left center">
                                            <span> vs </span>
                                            <span><?php echo $config['game'][$matchInfo['game']];?></span>
                                        </div>
                                        <div class="left">
											<div class="game_match_img">
												<img data-original="<?php echo $matchInfo['away_team_info']['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>"  alt="<?php echo $matchInfo['away_team_info']['team_name'];?>">
											</div>
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

							<?php if(isset($return[$game.'TeamList']['data']) && count($return[$game.'TeamList']['data'])>0){ ?>
                                <div class="game_title clearfix game_team_e">
                                    <span class="title"><?php echo $game_name;?>热门战队</span>
                                    <div class="more">
                                        <a href="<?php echo $config['site_url'];?>/teamlist/<?php echo $game;?>/">
                                            <span>更多</span>
                                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            <ul class="game_team_list_detail">
                                <?php foreach ($return[$game."TeamList"]['data'] as $key => $teamInfo) {?>
                                <li class="<?php if($key == 0 && $game == $config['default_game']){echo "active ";}?> col-xs-6">
                                    <a href="<?php echo $config['site_url'];?>/teamdetail/<?php echo $teamInfo['tid'];?>">
                                        <div class="a1">
                                            <img data-original="<?php echo $teamInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_team_img']['value'];?><?php echo $config['default_oss_img_size']['teamList'];?>" alt="<?php echo $teamInfo['team_name'];?>" class="game_team_img">
                                        </div>
                                        <span><?php echo $teamInfo['team_name'];?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
							<?php }else{?>
								<div class="null">
									<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
								</div>
							<?php } ?>
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
                            <a href="<?php echo $config['site_url'];?>/playerlist/">
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
                            <span><?php echo $game_name;?></span>
                        </li>
                        <?php }?>
                    </ul>
                    <div class="hot_player_detail">
                        <?php foreach ($config['game'] as $game => $game_name){?>
                        <div class="hot_player_detail_div<?php if($game == $config['default_game']){echo ' active ';}?>">
							<?php if(isset($return[$game.'PlayerList']['data']) && count($return[$game.'PlayerList']['data'])>0){ ?>
                            <ul class="clearfix">
                                <?php foreach ($return[$game."PlayerList"]['data'] as $key => $playerInfo) {?>
                                <li <?php if($key == 0 && $game == $config['default_game']){echo ' originalclass="active"';}?>>
                                    <a href="<?php echo $config['site_url'];?>/playerdetail/<?php echo $playerInfo['pid'];?>">
                                        <div class="hot_player_img">
                                            <img  data-original="<?php echo $playerInfo['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_player_img']['value'];?><?php echo $config['default_oss_img_size']['playerList'];?>" alt="<?php echo $playerInfo['player_name'];?>">
                                        </div>
                                        <span><?php echo $playerInfo['player_name'];?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
							<?php }else{?>
								<div class="null">
									<img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
								</div>
							<?php } ?>
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
                                <a href="<?php echo $config['site_url'];?>/newslist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab1">
                            <ul class="clearfix news_dianjing1">
                                <li class="active"><span>综合</span></li>
                                <?php foreach($config['game'] as $game => $game_name){?>
                                <li><span><?php echo $game_name;?></span></li>
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
                                    <?php if(count($infoList['data'])>0){?>
                                        <?php foreach($infoList['data'] as $key => $info){?>
                                        <?php if($key==0){?>
                                                <div class="news_dianjing_top">
                                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_top_div">
                                                            <img data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                </div>
                                            <?php }?><?php }?>
                                        <div class="news_dianjing_mid">
                                            <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=1 && $key<=2){?>
                                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_mid_img">
                                                            <img data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                <?php }?><?php }?>
                                        </div>
                                        <div class="news_dianjing_news">
                                            <ul>
                                                <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=3){?>
                                                <li><a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <?php echo $info['title'];?>
                                                    </a></li>
                                                <?php }?><?php }?>
                                            </ul>
                                        </div>
                                        <?php }else{?>
                                    <div class="null">
                                        <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                    </div>
                                <?php }?>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 right">
                        <div class="game_title clearfix game_team_new">
                            <span class="title">游戏攻略</span>
                            <div class="more">
                                <a href="<?php echo $config['site_url'];?>/stralist/">
                                    <span>更多</span>
                                    <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="news_dianjing news_dianjing_tab2">
                            <ul class="clearfix news_dianjing2">
                                <li  class="active"><span>综合</span></li>
                                <?php foreach($config['game'] as $game => $game_name){?>
                                    <li ><span><?php echo $game_name;?></span></li>
                                    <?php }?>
                            </ul>
                            <div class="news_dianjing_list">

                            <?php $allGameList = array_keys($config['game']);
                                array_unshift($allGameList,"all");
                                foreach($allGameList as $game)
                                {
                                    $infoListKey = $game."StraList";
                                    $infoList = $return[$infoListKey];
                                    $gameName = $config["game"][$game]??"综合";
                                    ?>
                                    <div class="news_dianjing_detail<?php if($game=="all"){echo " active";}?>">

                                    <?php if(count($infoList['data'])>0){?>
                                        <?php foreach($infoList['data'] as $key => $info){?>
                                            <?php if($key==0){?>
                                                <div class="news_dianjing_top">
                                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_top_div">
                                                            <img data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                </div>
                                            <?php }?><?php }?>
                                        <div class="news_dianjing_mid">
                                            <?php foreach($infoList['data'] as $key => $info){?>
                                                <?php if($key>=1 && $key<=2){?>
                                                    <a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                        <div class="news_dianjing_mid_img">
                                                            <img data-original="<?php echo $info['logo'];?>" src="<?php echo $return['defaultConfig']['data']['default_information_img']['value'].$config['default_oss_img_size']['informationList'];?>"  alt="<?php echo $info['title'];?>">
                                                        </div>
                                                        <span><?php echo $info['title'];?></span>
                                                    </a>
                                                <?php }?><?php }?>
                                        </div>
                                        <div class="news_dianjing_news">
                                            <ul>
                                                <?php foreach($infoList['data'] as $key => $info){?>
                                                    <?php if($key>=3){?>
                                                        <li><a href="<?php echo $config['site_url'];?>/newsdetail/<?php echo $info['id'];?>">
                                                                <?php echo $info['title'];?>
                                                            </a></li>
                                                    <?php }?><?php }?>
                                            </ul>
                                        </div>

                                <?php }else{?>
                                    <div class="null">
                                        <img src="<?php echo $config['site_url'];?>/images/null.png" alt="">
                                    </div>
                                <?php }?>
                                    </div>
                                <?php } ?>
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
                        <a href="<?php echo $config['site_url'];?>/tournamentlist/">
                            <span>更多</span>
                            <img src="<?php echo $config['site_url'];?>/images/more.png" alt="">
                        </a>
                    </div>
                </div>
                <ul class="game_special_list">
                    <?php foreach($return['tournamentList']['data'] as $tournamentInfo){?>
                    <li class="col-md-3 col-xs-6">
                        <a href="<?php echo $config['site_url'];?>/tournamentdetail/<?php echo $tournamentInfo['game']."-".$tournamentInfo['tournament_id'];?>">
                            <div class="div_img">
                                <img data-original="<?php echo $tournamentInfo['logo'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>" src="<?php echo $return['defaultConfig']['data']['default_tournament_img']['value'];?><?php echo $config['default_oss_img_size']['tournamentList'];?>"  alt="<?php echo $tournamentInfo['tournament_name'];?>">
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
                <?php
				foreach($return['links']['data'] as $linksInfo)
				{   ?>
					<li><a href="<?php echo $linksInfo['url'];?>"><?php echo $linksInfo['name'];?></a></li>
				<?php }?>
            </ul>
<?php renderCertification();?>
        </div>
    </div>
	
	  <?php renderFooterJsCss($config,[],[]);?>

    <script type="text/javascript">
		
	
       /* $(function() {
            $('img.lazy').lazyload();
        });*/
        // var banner = $(".banner_img").height()
        // $('.banner_img img').load(function () {
        //     $(".banner").css("height", banner)
        // });
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
