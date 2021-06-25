<?php

require_once "function/init.php";

$h = date("H");
echo "currentHour:" . $h . "\n";
if (!in_array($h, [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 23])) {
    die();
}
$urlList = [];
if ($h == 23) {
    $data = [
        "site_id" => $config['site_id'],
    ];
} else {
    $data = [
        "site_id" => $config['site_id'],
        "recent" => 7200,
    ];
}
$return = curl_post($config['api_sitemap'], json_encode($data), 1);
foreach($return as $type => $detail)
{
    foreach ($detail as $key)
    {
        $urlList[] = $config['site_url'] . "/" . $type . "/" . $key;
    }
}
$page = 1;
$i = 1;
$page_size = 100;
$t = [];
foreach ($urlList as $url) {
    $t[] = $url;
    echo "toPush:" . $i . "," . $url . "\n";
    $i++;
    if ($i > $page_size) {
        $push = push2Baidu($t, $config);
        $page_size = min($push["remain"] ?? 0, $page_size);
        if ($page_size == 0) {
            break;
        }
        $i = 1;
        $page++;
        $t = [];
    }
}
if (count($t) > 0) {
    push2Baidu($t, $config);
}
function push2Baidu($urls, $config)
{
    if (count($urls) > 0) {
        $url = explode('//', $config['site_url']);
        $api = 'http://data.zz.baidu.com/urls?site=' . $url[1] . '&token=' . $config['baidu_token'];
        $api = htmlspecialchars_decode($api);
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
    } else {
        $result = json_encode(["empty"]);
    }
    $result = json_decode($result, true);
    print_R($result);
    return $result;
}

