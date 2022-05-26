<?php
namespace app\Utilities;
use \app\Utilities\Response;
class CacheUtility{
 protected static $chache_file ;
 protected static $chach_enabled = CACHE_ENABLED ;
 const EXPIRE_TIME = 3600 ; // 1 hour

 public static function init()
 {
     self::$chache_file =CACHE_DIR."/cache".md5($_SERVER['REQUEST_URI']).".json";
     if($_SERVER['REQUEST_METHOD']!='GET')
        SELF::$chach_enabled = 0;
 }
 public static function cache_exist(){
    
    return(file_exists(self::$chache_file) && (time()- self::EXPIRE_TIME) < filemtime(self::$chache_file));
 }

 public static function start()
 {
    self::init();
     if(!self::$chach_enabled)
        return ;
    if(self::cache_exist()){
        Response::setHeaders();
        readfile(self::$chache_file);
        exit();
    }
    ob_start();
 }

 public static function end()
 {
     if(!self::$chach_enabled)
     return;
     $chache_file = fopen(self::$chache_file , 'w');
     fwrite($chache_file,ob_get_contents());
     fclose($chache_file);
     //alternative solotion : file_put_contents(self::$chache_file,ob_get_contents());
     //send the out put browser
     ob_end_flush();    
 }
 
 public static function flush()
 {
     $files = glob(CACHE_DIR,"*"); // get all sile name
     foreach($files as $file){      
         if(is_file($file))
         unlink($file);
     }
 }
}