<?php
class Utils {

	public static function makeFileNameMeaningful($fileName) {
		$str = pathinfo($fileName, PATHINFO_FILENAME);
		$str = preg_replace('/[-_ ]+/', ' ', $str);
		return ucwords($str);
	} // makeFileNameMeaningful  
        // Function for basic field validation (present and neither empty nor only white space
        public static function IsNullOrEmptyString($question){
                return (!isset($question) || trim($question)==='');
        }
}//end of class

//echo Utils::makeFileNameMeaningful("Deepak singh_SAP_BASIS-Hello   World!") . "\n";
?>
