<?php
date_default_timezone_set('UTC');
if (!isset($_GET['url'])) {
    header("HTTP/1.0 404 Not Found");
    echo("404");
    die();
}
$url = $_GET['url'];
$file = "";
$newURL = "";
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
if (substr($url, 0, 23) == "http://storage.llss.io/") {
    $file = substr($url, 23, strlen($url));
} else if ($matches) {
    $file = "$matches[0].mp4";
}
if ($file) {
    if (file_exists("$file")) {
        $newURL = "http://localhost/$file";
    } else {
        $dirs = array_filter(glob("*"), 'is_dir');
        foreach ($dirs as $dir) {
            if (file_exists("$dir/$file")) {
                $newURL = "http://localhost/$dir/$file";
            }
        }
    }
}

//check for YouTube-dl update every 3 days
$lastUpdateTime = "";
$time = time();
$lastUpdateFile = "..\bin\youtube-dl\lastUpdate.txt";
if (file_exists("$lastUpdateFile")) {
    $lastUpdateTime = file_get_contents($lastUpdateFile);
}
if ($lastUpdateTime <= $time - 259200) {
    file_put_contents($lastUpdateFile, $time);
    exec("start ..\bin\youtube-dl\youtube-dl.exe -U");
}

if ($newURL) {
    echo $newURL;
} else {
    $shell_output = exec("..\bin\youtube-dl\youtube-dl.exe -f \"mp4[height<=?1080]/best[height<=?1080]\" --get-url $url");
    print_r($shell_output);
}
?>
