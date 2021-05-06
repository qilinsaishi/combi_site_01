<?php

$base_config = [
    'site_name'=>"70电竞",
    'api_url'=>'http://lol_api.querylist.cn',//api站点URL
    'site_url'=>'http://info.combi_01_info.com',//本站URl
    'game'=>["kpl"=>"王者荣耀","lol"=>"英雄联盟","dota2"=>"dota2"],
    'site_id'=>5,
    'source'=>"scoregg",
    'baidu_token'=>'WGi6okVpl9ij8Gc3'
];

$additional_config = [
    // 'site_description'=> $base_config['site_name'].'致力于服务广大'.$base_config['game_name'].'玩家，为'.$base_config['game_name'].'玩家提供丰富的'.$base_config['game_name'].'游戏攻略、'.$base_config['game_name'].'电子竞技赛事资讯、数据分析及内容解读。',
    'api_get' => $base_config['api_url']."/get",
    'api_sitemap' => $base_config['api_url']."/sitemap",
    'navList' => ['index'=>['url'=>"","name"=>"首页"],
        'game'=>['url'=>"schedule/","name"=>"赛事赛程"],
        'team'=>['url'=>"teamlist/","name"=>"电竞战队"],
        'player'=>['url'=>"playerlist/","name"=>"电竞选手"],
        'info'=>['url'=>"newslist/","name"=>"电竞资讯"],
        'stra'=>['url'=>"strategylist/","name"=>"游戏攻略"],
        'tournament'=>['url'=>"tournament/","name"=>"赛事专题"],
    ]
];
return array_merge($base_config,$additional_config);