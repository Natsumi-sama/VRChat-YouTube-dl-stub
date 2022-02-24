<?php
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
} else if (substr($url, 0, 33) == "http://jd.pypy.moe/api/v1/videos/") {
    $file = substr($url, 33, strlen($url));
} else if ($matches) {
    $file = "$matches[0].mp4";
}
if ($file) {
    $dirs = array_filter(glob("*"), 'is_dir');
    foreach ($dirs as $dir) {
        if (file_exists("$dir/$file")) {
            $newURL = "https://qwertyuiop.nz/pypy/$dir/$file";
        }
    }
}
if ($newURL) {
    echo $newURL;
} else {
    $shell_output = shell_exec("yt-dlp -f 'b[ext=mp4]' --no-playlist --no-warnings --get-url " . escapeshellarg($url) . " 2>&1");
    if (substr($shell_output, 0, 9) == "WARNING: ") {
        echo $url;
    } else {
        print_r($shell_output);
    }
}
?>
