<?php
    //$config = require_once "config.php";
    //$api_root = "/lol/get";
    // $url = $config['api_url'].$api_root;
     function curl_post($url,$data,$json = 1)
     {
         $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $res = curl_exec($curl);
        curl_close($curl);
        if($json == 1)
        {
            $result = json_decode($res, true);
        }
        else
        {
            $result = $res;
        }
        return $result;
    }
