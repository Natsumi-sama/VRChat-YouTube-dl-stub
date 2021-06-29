<?php
chdir('./mog422'); //Directory containing videos
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
} else if (substr($url, 0, 34) == "https://jd.pypy.moe/api/v1/videos/") {
    $file = substr($url, 34, strlen($url));
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
if ($newURL) {
    echo $newURL;
} else {
    $shell_output = shell_exec("/usr/bin/youtube-dl -f 'mp4[height<=?1080]/best[height<=?1080]' --get-url " . escapeshellarg($url) . " 2>&1");
    print_r($shell_output);
}
?>
