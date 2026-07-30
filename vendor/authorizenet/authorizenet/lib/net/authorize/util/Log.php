<?php
namespace net\authorize\util;

use net\authorize\util\ANetSensitiveFields;

define ("ANET_LOG_FILES_APPEND",true);

define("ANET_LOG_DEBUG_PREFIX","DEBUG");
define("ANET_LOG_INFO_PREFIX","INFO");
define("ANET_LOG_WARN_PREFIX","WARN");
define("ANET_LOG_ERROR_PREFIX","ERROR");

//log levels
define('ANET_LOG_DEBUG',1);
define("ANET_LOG_INFO",2);
define("ANET_LOG_WARN",3);
define("ANET_LOG_ERROR",4);

//set level
define("ANET_LOG_LEVEL",ANET_LOG_DEBUG);

/**
 * A class to implement logging.
 *
 * @package    AuthorizeNet
 * @subpackage net\authorize\util
 */

class Log
{
    private $sensitiveXmlTags = NULL;
    private $logFile = '';
    private $logLevel = ANET_LOG_LEVEL;
	
	/**
	* Takes a regex pattern (string) as argument and adds the forward slash delimiter.
	* Also adds the u flag to enable Unicode mode regex.
	*
	* @param string $regexPattern
	*
	* @return string
	*/
	private function addDelimiterFwdSlash($regexPattern)
	{
		return '/'.$regexPattern.'/u';
	}
	
	/**
	* Takes an xml as string and masks the sensitive fields.
	*
	* @param string $rawString		The xml as a string.
	*
	* @return string 		The xml as a string after masking sensitive fields
	*/
    private function maskSensitiveXmlString($rawString){
        $patterns=array();
        $replacements=array();
		
        foreach ($this->sensitiveXmlTags as $i => $sensitiveTag){
            $tag = $sensitiveTag->tagName;
            $inputPattern = "(.+)"; //no need to mask null data
            $inputReplacement = "xxxx";

            if(trim($sensitiveTag->pattern)) {
                $inputPattern = $sensitiveTag->pattern;
            }
            $pattern = "<" . $tag . ">(?:.*)". $inputPattern ."(?:.*)<\/" . $tag . ">";
			$pattern = $this->addDelimiterFwdSlash($pattern);

            if(trim($sensitiveTag->replacement)) {
                $inputReplacement = $sensitiveTag->replacement;
            }
            $replacement = "<" . $tag . ">" . $inputReplacement . "</" . $tag . ">";

            $patterns [$i] = $pattern;
            $replacements[$i]  = $replacement;
        }
        $maskedString = preg_replace($patterns, $replacements, $rawString);
        return $maskedString;
    }

    /**
     * Takes a string and masks credit card regex matching parts.
     *
     * @param string $rawString		The string.
     *
     * @return string 		The string after masking credit card regex matching parts.
     */
    private function maskCreditCards($rawString){
        $patterns=array();
        $replacements=array();

        foreach ($this->sensitiveStringRegexes as $i => $creditCardRegex){
            $pattern = $creditCardRegex;
			$pattern = $this->addDelimiterFwdSlash($pattern);

            $replacement = "xxxx";
            $patterns [$i] = $pattern;
            $replacements[$i]  = $replacement;
        }
        $maskedString = preg_replace($patterns, $replacements, $rawString);
        return $maskedString;
    }
	
	/**
	* Object data masking related functions START
	*/
	
	/**
	* private function getPropertiesInclBase($reflClass).
	* 
	* Receives a ReflectionObject, ...
	* iteratively fetches the properties of the object (including from the base classes up the hierarchy), ...
	* collects them in an array of ReflectionProperty and returns the array.
	*
	* @param ReflectionObject $reflClass
	*
	* @return \ReflectionProperty[]
	*/
	private function getPropertiesInclBase($reflClass)
	{
		$properties = array();
		try {
			do {
				$curClassPropList = $reflClass->getProperties();
				foreach ($curClassPropList as $p) {
					$p->setAccessible(true);
				}
				$properties = array_merge($curClassPropList, $properties);
			} while ($reflClass = $reflClass->getParentClass());
		} catch (\ReflectionException $e) { }
		return $properties;
	}
	
	/**
	* private function checkPropertyAndMask($prop, $obj).
	* 
	* Receives a ReflectionProperty and an object, and returns a masked object if the ReflectionProperty corresponds to a sensitive field, else returns false.
	*
	* @param ReflectionProperty $prop
	* @param object $obj
	*
	* @return string|bool
	*/
	private function checkPropertyAndMask($prop, $obj){
		foreach($this->sensitiveXmlTags as $i => $sensitiveField)
		{
			$inputPattern = "(.+)";
			$inputReplacement = "xxxx";

            if(trim($sensitiveField->pattern)) {
                $inputPattern = $sensitiveField->pattern;
            }
			$inputPattern = $this->addDelimiterFwdSlash($inputPattern);
			
            if(trim($sensitiveField->replacement)) {
                $inputReplacement = $sensitiveField->replacement;
            }
			
			if(strcmp($prop->getName(),$sensitiveField->tagName)==0)
			{
				$prop->setValue($obj,preg_replace($inputPattern,$inputReplacement,$prop->getValue($obj)));
				return $prop->getValue($obj);
			}
		}
		return false;
	}
	
	/**
	* called by getMasked() to mask sensitive fields of an object.
	*
	* @param object $obj
	*
	* @return object
	*/
    private function maskSensitiveProperties ($obj)
    {
		// first retrieve all properties of the passed object
        $reflectObj = new \ReflectionObject($obj);
        $props = $this->getPropertiesInclBase($reflectObj);

		// for composite property recursively execute; for scalars, do a check and mask
        foreach($props as $i => $prop){
			$propValue=$prop->getValue($obj);
			
			// for object and arrays, recursively call for inner elements
			if(is_object($propValue)){
				$prop->setValue($obj, $this->maskSensitiveProperties($propValue));
            }
			else if(is_array($propValue)){
				$newVals=array();
				foreach($propValue as $i=>$arrEle)
				{
					$newVals[]=$this->maskSensitiveProperties($arrEle);
				}
				$prop->setValue($obj, $newVals);
            }
			// else check if the property represents a sensitive field. If so, mask.
            else{
				$res=$this->checkPropertyAndMask($prop, $obj);
				if($res)
					$prop->setValue($obj, $res);
            }
        }
		
        return $obj;
    }
	
	/**
	* Object data masking related functions END
	*/
	
	/**
	* private function getMasked($raw).
	*
	* called by log()
	*
	* @param mixed $raw
	*
	* @return string
	*/
    private function getMasked($raw)
    { //always returns string
        $messageType = gettype($raw);
        $message="";
        if($messageType == "object"){
			$obj = unserialize(serialize($raw)); // deep copying the object
			$message = print_r($this->maskSensitiveProperties($obj), true); //object to string
        }
        else if($messageType == "array"){
            $copyArray = unserialize(serialize($raw));
            foreach($copyArray as $i => $element){
                $copyArray[$i] = $this->getMasked($element);
            }
            $message = print_r($copyArray, true); // returns string
        }
        else { //$messageType == "string")
            $primtiveTypeAsString = strval($raw);

            $maskedXml = $primtiveTypeAsString;
            if($messageType == "string") {
                $maskedXml = $this->maskSensitiveXmlString($primtiveTypeAsString);
            }
            //mask credit card numbers
            $message = $this->maskCreditCards($maskedXml);
        }
        return $message;
    }
	
	private function log($logLevelPrefix, $logMessage, $flags){
        if (!$this->logFile) return;
        //masking
        $logMessage = $this->getMasked($logMessage);

        //debug_backtrace
        $fileName = 'n/a';
        $methodName = 'n/a';
        $lineNumber = 'n/a';
        $debugTrace = debug_backtrace();
        if (isset($debugTrace[1])) {
            $fileName = $debugTrace[1]['file'] ? $debugTrace[1]['file'] : 'n/a';
            $lineNumber = $debugTrace[1]['line'] ? $debugTrace[1]['line'] : 'n/a';
        }
        if (isset($debugTrace[2])) $methodName = $debugTrace[2]['function'] ? $debugTrace[2]['function'] : 'n/a';

        //Add timestamp, log level, method, file, line
        $logString = sprintf("\n %s %s : [%s] (%s : %s) - %s", \net\authorize\util\Helpers::now(), $logLevelPrefix,
            $methodName, $fileName, $lineNumber, $logMessage);
        file_put_contents($this->logFile, $logString, $flags);
    }
	
    public function debug($logMessage, $flags=FILE_APPEND)
    {
        if(ANET_LOG_DEBUG >= $this->logLevel){
            $this->log(ANET_LOG_DEBUG_PREFIX, $logMessage,$flags);
        }
    }
	
    public function info($logMessage, $flags=FILE_APPEND){
        if(ANET_LOG_INFO >= $this->logLevel) {
            $this->log(ANET_LOG_INFO_PREFIX, $logMessage,$flags);
        }
    }
	
	public function warn($logMessage, $flags=FILE_APPEND){
        if(ANET_LOG_WARN >= $this->logLevel) {
            $this->log(ANET_LOG_WARN_PREFIX, $logMessage,$flags);
        }
    }
	
    public function error($logMessage, $flags=FILE_APPEND){
        if(ANET_LOG_ERROR >= $this->logLevel) {
            $this->log(ANET_LOG_ERROR_PREFIX, $logMessage,$flags);
        }
    }
	
	private function logFormat($logLevelPrefix, $format, $objects, $flags){
        try {
            foreach($objects as $i => $testObject){
                $objects[$i] = $this->getMasked($testObject);
            }
            $logMessage = vsprintf($format, $objects);
            $this->log($logLevelPrefix, $logMessage, $flags);
        }
        catch(\Exception $e){
            $this->debug("Incorrect log message format: " . $e->getMessage());
        }
    }
	
	public function debugFormat($format, $args=array(),  $flags=FILE_APPEND)
    {
        if(ANET_LOG_DEBUG >= $this->logLevel){
            $this->logFormat(ANET_LOG_DEBUG_PREFIX, $format, $args , $flags);
        }
    }
	
	public function infoFormat($format, $args=array(),  $flags=FILE_APPEND){
        if(ANET_LOG_INFO >= $this->logLevel) {
            $this->logFormat(ANET_LOG_INFO_PREFIX, $format, $args , $flags);
        }
    }
	
	public function warnFormat($format, $args=array(),  $flags=FILE_APPEND){
        if(ANET_LOG_WARN >= $this->logLevel) {
            $this->logFormat(ANET_LOG_WARN_PREFIX, $format, $args , $flags);
        }
    }
	
    public function errorFormat($format, $args=array(),  $flags=FILE_APPEND){
        if(ANET_LOG_ERROR >= $this->logLevel) {
			$this->logFormat(ANET_LOG_ERROR_PREFIX, $format, $args , $flags);
        }
    }

    /**
     * @param string $logLevel
     * possible values = ANET_LOG_DEBUG, ANET_LOG_INFO, ANET_LOG_WARN, ANET_LOG_ERROR
     */
    public function setLogLevel($logLevel){
        $this->logLevel = $logLevel;
    }

    /**
     * @return string
     */
    public function getLogLevel(){
        return $this->logLevel;
    }

    /**
     * @param string $logFile
     */
    public function setLogFile($logFile){
        $this->logFile = $logFile;
    }

    /**
     * @return string
     */
    public function getLogFile(){
        return $this->logFile;
    }
	
    public function __construct(){
        $this->sensitiveXmlTags = ANetSensitiveFields::getSensitiveXmlTags();
        $this->sensitiveStringRegexes = ANetSensitiveFields::getSensitiveStringRegexes();
    }
}
?>
