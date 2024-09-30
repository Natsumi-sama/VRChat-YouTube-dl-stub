<?php
if (!isset($_GET['url']) ||
    !isset($_GET['avpro'])) {
    header("HTTP/1.0 404 Not Found");
    echo("404");
    die();
}
$url = $_GET['url'];
$avPro = $_GET['avpro'];

// add line to log file with date
$log = fopen("myAccessLog.log", "a");
fwrite($log, date("Y-m-d H:i:s") . " " . $url . "\n");
fclose($log);

function isYouTubeURL($url) {
    $parsedUrl = parse_url($url);
    $hostname = $parsedUrl['host'];

    $youtubeDomains = ['youtube.com', 'www.youtube.com', 'youtu.be'];
    foreach ($youtubeDomains as $domain) {
        if (strpos($hostname, $domain) !== false) {
            return true;
        }
    }
    return false;
}

$file = "";
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
if (substr($url, 0, 23) == "http://storage.llss.io/") {
    $file = substr($url, 23, strlen($url));
} else if (substr($url, 0, 33) == "http://jd.pypy.moe/api/v1/videos/") {
    // HEAD request to get filename
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    $location = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $path = parse_url($location, PHP_URL_PATH);
    curl_close($ch);
    $file = basename($path);
    
} else if (substr($url, 0, 29) == "https://zuwaii.b-cdn.net/api/") {
    $file = substr($url, 29, strlen($url));
} else if ($matches) {
    $file = "$matches[0].mp4";
}

if ($file) {
    $dirs = array_filter(glob("*"), 'is_dir');
    $dirs = array_reverse($dirs); // 1080p folder first
    foreach ($dirs as $dir) {
        if (file_exists("$dir/$file")) {
            echo "https://qwertyuiop.nz/pypy/$dir/$file";
            return;
        }
    }
}

// if url contains "results?" then it's a search
if (strpos($url, "results?") !== false) {
    echo $url;
    die();
}

// $shell_output = shell_exec("/usr/bin/youtube-dl --no-playlist --cookies 'cookies.txt' -f 'mp4[vcodec!*=av01][height<=?1080]' --get-url " . escapeshellarg($url) . " 2>&1");

// pipx install yt-dlp[curl_cffi]
// impersonate safari only for youtube
$ytdlp_path = "/srv/http/.local/bin/yt-dlp";
if ($avPro == "true" || $avPro == "True") {
    if (isYouTubeURL($url)) {
        $shell_command = $ytdlp_path . " -4 -f '(mp4/best)[height<=?1080][height>=?64][width>=?64]' --impersonate='safari' --extractor-args='youtube:player_client=mediaconnect' --no-playlist --no-warnings --get-url ";
    } else {
        $shell_command = $ytdlp_path . " -4 -f '(mp4/best)[height<=?1080][height>=?64][width>=?64]' --no-playlist --no-warnings --get-url ";
    }
} else {
    $shell_command = $ytdlp_path . " -4 -f '(mp4/best)[vcodec!=av01][vcodec!=vp9.2][height<=?1080][height>=?64][width>=?64][protocol^=http]' --no-playlist --no-warnings --get-url ";
}
$shell_output = shell_exec($shell_command . escapeshellarg($url) . " 2>&1");
if ((substr($shell_output, 0, 9) == "WARNING: ") ||
    (substr($shell_output, 0, 7) == "ERROR: ")) {
    echo $url;
} else {
    print_r($shell_output);
}
?>