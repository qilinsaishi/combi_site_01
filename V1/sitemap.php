<?php
require_once "function/init.php";

$urlList = [];
foreach($config['navList'] as $nav)
{
    $urlList[] = $config['site_url']."/".$nav['url'];
    if(isset($nav['sub']) && count($nav['sub']))
    {
        foreach($nav['sub'] as $sub)
        {
            $urlList[] = $config['site_url']."/".$sub['url'];
        }
    }
}
$data = [
    "site_id"=>$config['site_id'],
];
$return = curl_post($config['api_sitemap'],json_encode($data),1);
if(isset($return)){
    foreach($return as $type => $detail)
    {
        foreach($detail as $key)
        {
            $urlList[] = $config['site_url']."/".$type."/".$key;
        }
    }
}

$return = [];
$return[] = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset>\n";

foreach($urlList as $url)
{
    $priority = ($url==$config['site_url'].'/')?1:0.8;
    $return[] = "<url>\n<loc>".$url."</loc>\n<lastmod>".date('Y-m-d')."</lastmod>\n<changefreq>daily</changefreq>\n<priority>".$priority."</priority>\n</url>\n";
}
$return[] = '</urlset>';
$myfile = fopen(dirname(__FILE__)."/sitemap.xml", "w") or die("Unable to open file!");
$txt = implode($return);
fwrite($myfile, $txt);
fclose($myfile);
?>
