using System.Net;

namespace youtubedl;

internal static class Program
{
    private static string _logFilePath = string.Empty;

    private static void WriteLog(string message)
    {
        using var sw = new StreamWriter(_logFilePath, true);
        sw.WriteLine($"{DateTime.Now:yyyy-MM-dd HH:mm:ss} {message}");
    }
    
    private static void Main(string[] args)
    {
        _logFilePath = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) + "Low", @"VRChat\VRChat\Tools", "ytdl.log");
        WriteLog("Starting with args: " + string.Join(" ", args));
        var url = string.Empty;
        var avPro = true;
        var arguments = Environment.GetCommandLineArgs();
        foreach (var arg in arguments)
        {
            if (arg.Contains("[protocol^=http]"))
            {
                avPro = false;
                continue;
            }
            
            if (!arg.StartsWith("http", StringComparison.OrdinalIgnoreCase))
                continue;
            
            url = arg;
            break;
        }
        
        WriteLog($"AVPro: {avPro}");

        if (string.IsNullOrEmpty(url))
        {
            WriteLog("[Error] No URL found in arguments");
            return;
        }

        try
        {
            using var httpClient = new HttpClient();
            var inputUrl = Uri.EscapeDataString(url);
            var output = httpClient.GetStringAsync($"https://localhost/VRCYoutubedl.php?avpro={avPro}&url={inputUrl}").Result;
            WriteLog("Response: " + output);
            Console.WriteLine(output);
            if (!output.Trim().StartsWith("http"))
            {
                Environment.ExitCode = 1;
            }
        }
        catch (Exception ex)
        {
            WriteLog("[Error] " + ex.Message);
            Environment.ExitCode = 1;
        }
    }
}