# VRChat YouTube-dl stub

Use a local web server as a file cache for YouTube videos with VRChat.

VRChat only uses YouTube-dl to return the raw mp4 video URL, so you can replace YouTube-dl with your own to return your own custom URL. A caveat of this is that you will need to update your own version of YouTube-dl the included Windows php script will auto update YouTube-dl every 3 days, for Linux you will need to do that yourself with whatever package manager you use.

Also you will need to set your YouTube-dl exe as read only otherwise the game with think it's out of date and overwrite it on startup.

To install edit `Program.cs` to point to your web servers IP address then compile the exe, overwrite `%AppData%\..\LocalLow\VRChat\VRChat\Tools\yt-dlp.exe` with the built exe and set `yt-dlp.exe` as readonly to stop VRChat from replacing it.

Put `VRCYoutubedl.php` on your web server in the directory/parent directory that contains the videos.
