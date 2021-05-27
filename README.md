# VRChat YouTube-dl stub

Use a local webserver as a file cache for YouTube videos with VRChat.

To install edit `Program.cs` to point to your websserver IP address, overwrite `C:\Users\cmcoo\AppData\LocalLow\VRChat\VRChat\Tools\youtube-dl.exe` with build and set `youtube-dl.exe` as readonly to stop VRChat from replacing it.

Put `VRCYoutubedl.php` on your webserver in the directory/parent directory that contains the videos.
