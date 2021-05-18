<?php
    function mb_str_split($str,$split_length=1,$charset="UTF-8")
    {
        if (func_num_args() == 1) {
            return preg_split('/(?<!^)(?!$)/u', $str);
        }
        if ($split_length < 1) return false;
        $len = mb_strlen($str, $charset);
        $arr = array();
        for ($i = 0; $i < $len; $i += $split_length) {
            $s = mb_substr($str, $i, $split_length, $charset);
            $arr[] = $s;
        }
        return implode("",$arr);
    }
    function render_page_pagination($total_count,$page_size,$current_page,$url)
    {
        $domain='http://'.$_SERVER['SERVER_NAME'];
        $p = 5;
        $p2 = 2;
        $totalPage = ceil($total_count/$page_size);
        if($current_page>1)
        {
            echo '<a href="'.$url."/".($current_page-1).'" class="paging_pre"> <img src="'.$domain.'/images/esport_right.png" alt="" class="active img_transform"></a>';
        }
        if($totalPage<=$p+$p2)
        {
            for($i=1;$i<=$totalPage;$i++)
            {
                echo '<a '.(($i-$current_page)==0?'class="paging_num active"  ':'class="paging_num " ').'href="'.$url."/".$i.'">'.$i.'</a>';
            }
        }
        else
        {
            if($current_page<=($p-$p2))
            {
                for($i=1;$i<=$p;$i++)
                {
                    echo '<a '.(($i-$current_page)==0?'class="paging_num active"   ':'class="paging_num " ').' href="'.$url."/".$i.'">'.$i.'</a>';
                }
                echo '<a class="esport_more" href="'.$url."/".($current_page+$p).'"><img src="'.$domain.'/images/esport_more.png" alt=""></a>';
                for($i=$p2;$i>0;$i--)
                {
                    echo '<a class="paging_num" href="'.$url."/".($totalPage-$i).'">'.($totalPage-$i).'</a>';
                }
            }
            elseif($current_page<=($p))
            {
                for($i=1;$i<=($p+$p2);$i++)
                {
                    echo '<a '.(($i-$current_page)==0?'class="paging_num active"  ':'class="paging_num " ').' href="'.$url."/".$i.'">'.$i.'</a>';
                }
                echo '<a class="esport_more" href="'.$url."/".($current_page+$p).'"><img src="'.$domain.'/images/esport_more.png" alt=""></a>';
                for($i=$p2;$i>0;$i--)
                {
                    echo '<a class="paging_num" href="'.$url."/".($totalPage-$i).'">'.($totalPage-$i).'</a>';
                }
            }
            elseif($current_page>$p && $current_page<($totalPage-$p))
            {
                for($i=1;$i<=1;$i++)
                {
                    echo '<a class="paging_num" href="'.$url."/".$i.'">'.$i.'</a>';
                }
                echo '<a class="esport_more" href="'.$url."/".($current_page-$p).'"><img src="'.$domain.'/images/esport_more.png" alt=""></a>';
                for($i=$current_page-2;$i<=$current_page+2;$i++)
                {
                    echo '<a '.(($i-$current_page)==0?'class="paging_num active"  ':'class="paging_num "').' href="'.$url."/".$i.'">'.$i.'</a>';
                }
                echo '<a class="esport_more" href="'.$url."/".($current_page+$p).'"><img src="'.$domain.'/images/esport_more.png" alt=""></a>';
                for($i=$p2;$i>0;$i--)
                {
                    echo '<a class="paging_num" href="'.$url."/".($totalPage-$i).'">'.($totalPage-$i).'</a>';
                }
            }
            elseif($current_page>=($totalPage-$p))
            {
                for($i=1;$i<=1;$i++)
                {
                    echo '<a class="paging_num" href="'.$url."/".$i.'">'.$i.'</a>';
                }
                if($totalPage-$p != 1)
                {
                    echo '<a class="paging_num" href="'.$url."/".($current_page-$p).'">...</a>';
                }
                for($i=$p;$i>0;$i--)
                {
                    echo '<a '.(($totalPage-$i-$current_page)==0?'class="paging_num active"  ':'class="paging_num "').' href="'.$url."/".($totalPage-$i).'">'.($totalPage-$i).'</a>';
                }
            }
        }
        if($current_page<$totalPage)
        {
            echo '<a href="'.$url."/".($current_page+1).'" class="paging_next"><img src="'.$domain.'/images/esport_right.png" alt="" class="active "></a>';
        }
    }
    function processCache($cacheConfig,$dataType,$params=[])
    {
        print_R($cacheConfig);
        die();
    }
    function sensitive($list, $string){
        $count = 0; //违规词的个数
        $sensitiveWord = '';  //违规词
        $stringAfter = $string;  //替换后的内容
        $pattern = "/".implode("|",$list)."/i"; //定义正则表达式
        if(preg_match_all($pattern, $string, $matches)){ //匹配到了结果
            $patternList = $matches[0];  //匹配到的数组
            $count = count($patternList);
            $sensitiveWord = implode(',', $patternList); //敏感词数组转字符串
            $replaceArray = array_combine($patternList,array_fill(0,count($patternList),'*')); //把匹配到的数组进行合并，替换使用
            $stringAfter = strtr($string, $replaceArray); //结果替换
        }
        $log = "原句为 [ {$string} ]<br/>";
        if($count==0){
            $log .= "暂未匹配到敏感词！";
        }else{
            $log .= "匹配到 [ {$count} ]个敏感词：[ {$sensitiveWord} ]<br/>".
                "替换后为：[ {$stringAfter} ]";
        }
        return $log;
    }
    function generateNav($config,$current = "index")
    {
        $navList = $config['navList'];
        foreach($navList as $key => $value)
        {
            if($key == $current)
            {
                echo '<li class="active"><a href="'.$config['site_url'].'/'.$value['url'].'">'.$value['name'].'</a></li>';
            }
            else
            {
                echo '<li><a href="'.$config['site_url'].'/'.$value['url'].'">'.$value['name'].'</a></li>';
            }
        }
        return;
    }
    function renderHeaderJsCss($config,$customCss = [])
    {
        $version=time();
        echo '<link rel="stylesheet" href="'.$config['site_url'].'/css/bootstrap.css" type="text/css" />';
        echo '<link rel="stylesheet" href="'.$config['site_url'].'/css/reset.css?v='.$version.'" type="text/css" />';
        echo '<link rel="stylesheet" href="'.$config['site_url'].'/css/headerfooter.css" type="text/css" />';
        foreach($customCss as $file)
        {
            if(trim($file)!="")
            {
                echo '<link rel="stylesheet" href="'.$config['site_url'].'/css/'.$file.'.css?v='.$version.'" type="text/css" />';
            }
        }
        echo '<script src="'.$config['site_url'].'/js/jquery.min.js" type="text/javascript"></script>';
        echo '<script src="'.$config['site_url'].'/js/lazyload.js" type="text/javascript"></script>';
        echo '<script src="'.$config['site_url'].'/js/flexible.js" type="text/javascript"></script>';
    }
    function renderFooterJsCss($config,$customCss = [],$customJs = [])
    {
        foreach($customCss as $file)
        {
            if(trim($file)!="")
            {
                echo '<link rel="stylesheet" href="'.$config['site_url'].'/css/'.$file.'.css" type="text/css" />';
            }
        }
        foreach($customJs as $file)
        {
            if(trim($file)!="")
            {
                echo '<link rel="stylesheet" href="'.$config['site_url'].'/js/'.$file.'.js" type="text/javascript" />';
            }
        }
        echo '<script src="'.$config['site_url'].'/js/bootstrap.js" type="text/javascript"></script>';
        echo '<script src="'.$config['site_url'].'/js/index.js" type="text/javascript"></script>';
    }
    function renderCertification()
    {
        echo '<div class="container">网络文化经营许可证：琼网文〔2015〕2197-011号     <a style="color:white;padding:1em;" href="https://beian.miit.gov.cn/#/Integrated/index">琼ICP备19001306号-4</a></div>';
    }
    function str_replace_limit($search, $replace, $subject, $limit=-1){
        if(is_array($search)){
            foreach($search as $k=>$v){
                $search[$k] = '`'. preg_quote($search[$k], '`'). '`';
            }
        }else{
            $search = '`'. preg_quote($search, '`'). '`';
        }
        return preg_replace($search, $replace, $subject, $limit);
    }
    function render404($config)
    {
        header('location:'.$config['site_url'] . '/' . '404');
        exit;
        return true;
    }
    function  replace_html_tag( $string ,  $tagname  = "<img><br>"){
        $string = html_entity_decode($string);
        $string = strip_tags($string,$tagname); // 保留 <span>标签
        return $string;
    }
    function checkJson($data = "")
    {
        if(substr($data,0,1)=='"' && substr($data,-1) =='"')
        {
            return json_decode($data,true);
        }
        else
        {
            return $data;
        }
    }
    //生成日历所用的日期范围
    function generateCalendarDateRange($currentDate,$type="month")
    {
        $return = ["startDate"=>$currentDate,"endDate"=>$currentDate];
        if($type=="month")
        {
            $monthStart = date("Y-m-01",strtotime($currentDate));$monthStartDay = date("w",strtotime($monthStart));
            $monthEnd = date("Y-m-t",strtotime($currentDate));$monthEndDay = date("w",strtotime($monthEnd));
            $return['startDate'] = date("Y-m-d",strtotime($monthStart)-(($monthStartDay==0)?6:($monthStartDay-1))*86400);
            $return['endDate'] = date("Y-m-d",strtotime($monthEnd)+(($monthEndDay==0)?0:(7-$monthEndDay))*86400);
        }
        elseif($type=="week")
        {
            $currentDay = date("w",strtotime($currentDate));
            $return['startDate'] = $currentDay==0?date("Y-m-d",(strtotime($currentDate)-6*86400)):date("Y-m-d",strtotime($currentDate)-($currentDay-1)*86400);
            $return['endDate'] = date("Y-m-d",strtotime($return['startDate'])+6*86400);
        }
        return $return;
    }
    function generateMatchStatus($start_time)
    {
        $currentTime = time();
        $start_time = strtotime($currentTime);
        if($currentTime<$start_time)
        {
            $match_status = "未开始";
        }
        elseif(($currentTime-$start_time)<=3*3600)
        {
            $match_status = "进行中";
        }
        else
        {
            $match_status = "已结束";
        }
        return $match_status;
    }


?>
