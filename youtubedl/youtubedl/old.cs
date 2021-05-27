//no read/wirte can't use this :,(

//public class JsonSettings
//{
//    public DateTimeOffset LastUpdateCheck { get; set; }
//    public string Location { get; set; }
//}

//public static void WriteSettings(DateTime LastUpdateCheck, string Location)
//{
//    string settingsFile = "Settings.json";
//    var jsonSettings = new JsonSettings
//    {
//        LastUpdateCheck = LastUpdateCheck,
//        Location = Location
//    };
//    string jsonString = System.Text.Json.JsonSerializer.Serialize<JsonSettings>(jsonSettings);
//    File.WriteAllText(settingsFile, jsonString);
//}

//public static JsonSettings ReadSettings()
//{
//    string settingsFile = "Settings.json";
//    var jsonString = File.ReadAllText(settingsFile);
//    JsonSettings jsonSettings = System.Text.Json.JsonSerializer.Deserialize<JsonSettings>(jsonString);
//    return jsonSettings;
//}

//public static void CheckForUpdate()
//{
//    System.Diagnostics.Process youtubedlUpdateProcess = new System.Diagnostics.Process();
//    youtubedlUpdateProcess.StartInfo.FileName = YouTubedlexe;
//    youtubedlUpdateProcess.StartInfo.Arguments = "-U";
//    youtubedlUpdateProcess.StartInfo.CreateNoWindow = true;
//    youtubedlUpdateProcess.StartInfo.UseShellExecute = false;
//    youtubedlUpdateProcess.Start();
//}

//using (StreamWriter sw = File.AppendText(@"urlLog.txt"))
//    sw.WriteLine(url);

//if (!File.Exists("Settings.json"))
//{
//    var LastUpdateCheck = DateTime.Now;
//    var Location = "";
//    WriteSettings(LastUpdateCheck, Location);
//    CheckForUpdate();
//}
//else
//{
//    JsonSettings settings = ReadSettings();
//    if (settings.LastUpdateCheck.Date <= DateTime.Now.Subtract(TimeSpan.FromDays(1)))
//    {
//        CheckForUpdate();
//    }
//}

//if (!String.IsNullOrEmpty(url))
//{
//    youtubedlargs = "--no-check-certificate --no-cache-dir --rm-cache-dir -f mp4[height<=?1080]/best[height<=?1080] --get-url " + url;
//}

//--no-check-certificate --no-cache-dir --rm-cache-dir -f mp4[height<=?720]/best[height<=?720] --get-url https://www.youtube.com/watch?v=dQw4w9WgXcQ

//System.Diagnostics.Process youtubedlProcess = new System.Diagnostics.Process();
//youtubedlProcess.StartInfo.UseShellExecute = false;
//youtubedlProcess.StartInfo.RedirectStandardOutput = true;
//youtubedlProcess.StartInfo.FileName = YouTubedlexe;
//youtubedlProcess.StartInfo.Arguments = youtubedlargs;
//youtubedlProcess.Start();
//StreamReader readerStd = youtubedlProcess.StandardOutput;
//string outputStd = readerStd.ReadToEnd();
//Console.WriteLine(outputStd);
//youtubedlProcess.WaitForExit();
//Environment.ExitCode = youtubedlProcess.ExitCode;

//var youtubedlargs = string.Join(" ", arguments.Skip(1));

//public static string YouTubedlexe = "youtube-dl-original.exe";
