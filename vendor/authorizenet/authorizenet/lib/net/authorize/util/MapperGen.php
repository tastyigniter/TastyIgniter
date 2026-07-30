<?php
require 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml as YamlLib;

	$classes = array();
	$dir = __DIR__ . "/../api/yml/v1/";
	$files = scandir($dir);
		foreach ($files as $file) {
			// echo "filename:" . $file . "\n";
			// Elementing the ..
			if($file != "." && $file != ".." ){
				$value = YamlLib::parseFile($dir.$file);
				//var_dump($value);
				//array_push($classes, $value);
				//var_dump($classes);
				//echo $value['net\authorize\api\contract\v1\ANetApiRequestType']['properties']['merchantAuthentication']['type']."\n";
				$key = key($value);
				$classes[$key] = $value[$key];
				//break;
			}
		}
		file_put_contents(__DIR__ ."/classes.json",json_encode($classes));
		# array.json => {"a":1,"b":2,"c":3,"d":4,"e":5}
		$classes2 = json_decode(file_get_contents(__DIR__ ."/classes.json"), true);
		//Validate the JSON
		if($classes === $classes2) # => true
		{
			echo "JSON Created out of XML Successfully! - ".__DIR__ ."/classes.json\n";
		}

// class MapperGen{
// 	private $classes = array();
// 	private $dir = __DIR__ . "/../../yml/v1/";

// 	private function __construct() {
// 		$files = scandir($this->dir);
// 		foreach ($files as $file) {
// 			// echo "filename:" . $file . "\n";
// 			// Elementing the ..
// 			if($file != "." && $file != ".." ){
// 				$value = Yaml::parseFile($this->dir.$file);
// 				//var_dump($value);
// 				//array_push($classes, $value);
// 				//var_dump($classes);
// 				//echo $value['net\authorize\api\contract\v1\ANetApiRequestType']['properties']['merchantAuthentication']['type']."\n";
// 				$key = key($value);
// 				$this->classes[$key] = $value[$key];
// 				//break;
// 			}
// 		}
// 	}

//     public static function Instance()
//     {
//         static $inst = null;
//         if ($inst === null) {
//             $inst = new Mapper();
//         }
//         return $inst;
//     }

// 	public function generateFile(){
// 		file_put_contents("array.json",json_encode($classes));
// 		# array.json => {"a":1,"b":2,"c":3,"d":4,"e":5}
// 		$classes2 = json_decode(file_get_contents('array.json'), true);
// 		if($classes === $classes2) # => true
// 		{
// 			echo "All Good!";
// 		}
// 	}

?>
