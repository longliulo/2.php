<?php
namespace MyApp;
class Link
{
    public static function incrementalHash($len = 5) {
          $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
          $base = strlen($charset);
          $result = '';
           $arr = explode(' ', microtime());
          $now1 = explode(".",$arr[0]);
          $now = $now1[1];
          while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
          }
          return substr($result, -$len).$now1[1];
    }

    private static function  permalink ($str, $replacement = '-') {
        $str = trim($str);
        $str = preg_replace("/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/", 'a', $str);
        $str = preg_replace("/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/", 'e', $str);
        $str = preg_replace("/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/", 'i', $str);
        $str = preg_replace("/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/", 'o', $str);
        $str = preg_replace("/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/", 'u', $str);
        $str = preg_replace("/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/", 'y', $str);
        $str = preg_replace("/đ|Đ/", 'd', $str);
        $str = preg_replace("/ç/", "c", $str);
        $str = preg_replace("/ñ/", "n", $str);
        $str = preg_replace("/ä|æ/", "ae", $str);
        $str = preg_replace("/ö/", "oe", $str);
        $str = preg_replace("/ü/", "ue", $str);
        $str = preg_replace("/Ä/", "Ae", $str);
        $str = preg_replace("/Ü/", "Ue", $str);
        $str = preg_replace("/Ö/", "Oe", $str);
        $str = preg_replace("/ß/", "ss", $str);
        $str = preg_replace("/ß/", "ss", $str);
        $str = preg_replace("/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu", "", $str);
        $str = preg_replace("/\s+/", " ", $str);
        $str = trim($str);
        $str = str_replace(" ", $replacement, $str);
        return strtolower($str);
    }
    public static function getLink($name) {
        $shortName = self::permalink($name);
        $randomChar = substr(self::incrementalHash(5),5);
        return $shortName."-".$randomChar;
    }

    public static function getSlugLink($name, $extension = "") {
        $shortName = self::permalink($name);
        //$randomChar = substr($this->incrementalHash(5),5);
        return $shortName .  $extension;
    }
}
?>