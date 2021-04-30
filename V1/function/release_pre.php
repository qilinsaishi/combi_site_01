<?php
$command = "git checkout pre && git pull";
(exec($command, $return));
echo implode("\n", $return) . "\n";
unset($return);
$command = "cp config_pre.php config.php";
(exec($command, $return));
echo implode("\n", $return) . "\n";
unset($return);
//$command = "php ../sitemap.php";
//(exec($command,$return));
//echo implode("\n",$return)."\n";