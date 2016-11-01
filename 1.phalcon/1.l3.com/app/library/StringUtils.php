<?php
namespace MyApp;
class StringUtils {
	public static function replaceHTMLTag($str, $strReplace = ""){
		$strStripTag = strip_tags($str);
		if($strReplace != ""){
			return str_replace($strReplace,"",$strStripTag);
		}
		return $strStripTag;
	}
}