<?php

$base_config = [
    'site_name'=>"电竞人",
	'api_url'=>'http://api02.qilindianjing.com',//api站点URL
    'site_url'=>'https://www.qilindianjing.com',//本站URl
    'game'=>["lol"=>"英雄联盟","kpl"=>"王者荣耀","dota2"=>"DOTA2"],
    'default_game' => "lol",
    'site_id'=>5,
    'default_source'=>"scoregg",
    'informationType'=>["news"=>[1,2,3,5,6,7],"stra"=>[4]],
    'baidu_token'=>'WGi6okVpl9ij8Gc3',
    'hour_lag'=>0,
	'default_oss_img_size'=>[
		"teamList"=>'?x-oss-process=image/resize,m_lfit,h_100,w_100',
		"playerList"=>'?x-oss-process=image/resize,m_lfit,h_100,w_100',
        "tournamentList"=>'?x-oss-process=image/resize,m_lfit,h_130,w_130',
    ]
];

$additional_config = [
    // 'site_description'=> $base_config['site_name'].'致力于服务广大'.$base_config['game_name'].'玩家，为'.$base_config['game_name'].'玩家提供丰富的'.$base_config['game_name'].'游戏攻略、'.$base_config['game_name'].'电子竞技赛事资讯、数据分析及内容解读。',
    'api_get' => $base_config['api_url']."/get",
    'api_sitemap' => $base_config['api_url']."/sitemap",
    'navList' => ['index'=>['url'=>"","name"=>"首页"],
        'game'=>['url'=>"match/","name"=>"赛事赛程"],
        'team'=>['url'=>"teamlist/","name"=>"电竞战队"],
        'player'=>['url'=>"playerlist/","name"=>"电竞选手"],
        'news'=>['url'=>"newslist/","name"=>"电竞资讯"],
        'stra'=>['url'=>"stralist/","name"=>"游戏攻略"],
        'tournament'=>['url'=>"tournamentlist/","name"=>"赛事专题"],
    ]
];
return array_merge($base_config,$additional_config);