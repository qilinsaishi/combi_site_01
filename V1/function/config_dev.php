<?php

$base_config = [
    'site_name'=>"电竞人",
    'api_url'=>'http://lol_api.querylist.cn',//api站点URL
    'site_url'=>'http://info.combi_01_info.com',//本站URl
    'game'=>["lol"=>"英雄联盟","kpl"=>"王者荣耀","dota2"=>"DOTA2"],
	'game_source'=>['dota2'=>'shangniu'],
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
		"heroList"=>'?x-oss-process=image/resize,m_lfit,h_100,w_100',
		"informationList"=>'?x-oss-process=image/resize,m_lfit,h_74,w_120',
        "qr_code"=>'?x-oss-process=image/resize,m_lfit,h_200,h_200',
    ],
    'ti10'=>[
        'keyword'=>["TI10","DOTA2国际邀请赛","ti10","Ti10"],
        'event_name'=>"Ti10国际邀请赛",
        'game'=>"dota2",
        'ti9_ranking'=>["eg"=>1322,"ig"=>1321,"psg/lgd"=>1316,"quincy crew"=>1317,"vp"=>1318,"t1"=>1315,"secret"=>1323,"vg"=>1324,"aster"=>1312,"alliance"=>1320,"bc"=>1313,"tp"=>1311,"team spirit"=>1305,'sg'=>1297]
    ],
    's11'=>[
        'event_name'=>"S11全球总决赛",
        'game'=>"lol",
        'history' =>
            [
                '2020'=>['event_name'=>'S10',"date"=>'2020年10月31日','location'=>'中国·上海浦东足球场','tid'=>186,'team_name'=>"Damwon Gaming",'district'=>"LCK"],
                '2019'=>['event_name'=>'S9',"date"=>'2019年11月10日','location'=>'法国·巴黎雅高酒店竞技场','tid'=>233,'team_name'=>"FunPlus Phoenix",'district'=>"LPL"],
                '2018'=>['event_name'=>'S8',"date"=>'2018年11月3日','location'=>'韩国·仁川文鹤体育场','tid'=>231,'team_name'=>"Invictus Gaming",'district'=>"LCK"],
                '2017'=>['event_name'=>'S7',"date"=>'2017年11月4日','location'=>'中国·北京国家体育场','tid'=>185,'team_name'=>"Samsung Galaxy",'district'=>"LCK"],
                '2016'=>['event_name'=>'S6',"date"=>'2016年10月29日','location'=>'美国·洛杉矶斯台普斯中心','tid'=>184,'team_name'=>"SKTelecom T1",'district'=>"LCK"],
                '2015'=>['event_name'=>'S5',"date"=>'2015年10月31日','location'=>'德国·柏林梅赛德斯奔驰体育场','tid'=>184,'team_name'=>"SKTelecom T1",'district'=>"LCK"],
                '2014'=>['event_name'=>'S4',"date"=>'2014年10月19日','location'=>'韩国·首尔上岩世界杯体育场','tid'=>0,'team_name'=>"Samsung White",'district'=>"LCK"],
                '2013'=>['event_name'=>'S3',"date"=>'2013年10月5日','location'=>'美国·洛杉矶 斯台普斯中心','tid'=>184,'team_name'=>"SKTelecom T1",'district'=>"LCK"],
                '2012'=>['event_name'=>'S2',"date"=>'2012年10月14日','location'=>'美国·南加州 盖伦中心','tid'=>0,'team_name'=>"Taipei Assassins",'district'=>"LMS"],
                '2011'=>['event_name'=>'S1',"date"=>'2011年6月20日','location'=>'瑞典·Dreamhack展会','tid'=>190,'team_name'=>"Fnatic team",'district'=>"LCS.EU"],
            ],
        'teamList'=>["BLG"=>226,"EDG"=>237,"FPX"=>233,"IG"=>231,"北京JDG"=>232,"杭州LGD"=>225,"苏州LNG"=>228,"OMG"=>222,"RA"=>229,"RNG"=>234,"RW"=>221,"SN"=>236,"TES"=>235,"TT"=>223,"UP"=>224,"深圳V5"=>227,"西安WE"=>230],
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
        'tournament'=>['url'=>"tournamentlist/","name"=>"赛事专题",
            'sub'=>[
                't10'=>['url'=>"t10","name"=>"Ti10","hot"=>1,"highlight"=>"ti10Box"],
                's11'=>['url'=>"s11","name"=>"S11"],
            ]
        ],
    ]
];
return array_merge($base_config,$additional_config);