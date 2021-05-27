using System;
using System.Net;

namespace youtubedl
{
    class Program
    {
        static void Main(string[] args)
        {
            var url = "";
            string[] arguments = Environment.GetCommandLineArgs();
            foreach (string arg in arguments)
            {
                if (arg.Length >= 4 && string.Equals(arg.Substring(0, 4), "http", StringComparison.OrdinalIgnoreCase))
                {
                    url = arg;
                }
            }
            using (WebClient wc = new WebClient())
            {
                if (!String.IsNullOrEmpty(url))
                {
                    var json = wc.DownloadString("http://localhost/VRCYoutubedl.php?url=" + url);
                    Console.WriteLine(json);
                }
            }
        }
    }
}