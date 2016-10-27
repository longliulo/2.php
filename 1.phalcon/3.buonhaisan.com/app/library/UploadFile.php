<?php
namespace MyApp;
/**
 * Files component
 *
 */
use Phalcon\Http\Request\File;
use Phalcon\Image\Adapter\GD;
class UploadFile {
	
	public $maxsize = 1000;
	public $allowedImageExtensions = array("jpg", "jpeg", "gif", "png");
	
	public function isValidFileType($fileName) {
		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		if (in_array($extension, $this->allowedImageExtensions)) {
			return true;
		} 
		return false;
	}
	public function upload($path, $files) {
		$fileName = $this->randomFileName($files -> getExtension());
		$files -> moveTo($path.$fileName);
		return $path.$fileName;
	}
	
	public function uploadResize($path, $files, $width, $height) {
		$fileName = $this->randomFileName($files -> getExtension());
		$url = $path.$fileName;
		if($files -> moveTo($url)) {
			$image = new GD( __DIR__.'/../../public/'.$url);
			$image->resize($width, $height);
			$image->save();	
		}
		
		return $path.$fileName;
	}
	
	public function randomFileName($extension){
		$strTime = $this->incrementalHash();
		$name = $strTime . "." . $extension; 
		return $name;
	}
	function incrementalHash($len = 5){
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
	
}
?>