<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    
    $filename = "log.html";
     
    $fileContent = file_get_contents($filename);
    
    $string = "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>";

    file_put_contents($filename, $string . $fileContent);
    #
    #$cache_new = "Prepend this"; // this gets prepended
    #$file = "file.dat"; // the file to which $cache_new gets prepended
    #
    #$handle = fopen($file, "r+");
    #$len = strlen($cache_new);
    #$final_len = filesize($file) + $len;
    #$cache_old = fread($handle, $len);
    #rewind($handle);
    #$i = 1;
    #while (ftell($handle) < $final_len) {
    #    fwrite($handle, $cache_new);
    #    $cache_new = $cache_old;
    #    $cache_old = fread($handle, $len);
    #    fseek($handle, $i * $len);
    #    $i++;
    #}
    
    
    #$fp = fopen("log.html", 'a');
    #fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    #fclose($fp);
    
    
}
?>