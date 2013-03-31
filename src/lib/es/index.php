<?php

 require_once('../php-commons/log.php');
 require_once('../php-commons/utils.php');
 
 $ES_ENDPOINT = "http://54.251.251.101:9200/";
 $ES_INDEX = "rdb/";
 $ES_TYPE = "candidate/";

 $sns_message_json = json_decode($HTTP_RAW_POST_DATA);
 $data = json_decode($sns_message_json->{'Message'});
 $docKey = $data->{'key'};
 $docUrl = $data->{'url'};
 $docFName = $data->{'name'};

 if(Utils::isNullOrEmptyString($docKey) || 
 	Utils::isNullOrEmptyString($docUrl))
 {
 	$log->logError("SNS passed a message without key or Url");	
 	exit(0);
 }
    
 $log->logDebug("SNS message received with key {$docKey}, {$docFName} and url {$docUrl}. Submitting to index.");

 $content = file_get_contents($docUrl);

 if($content === false || Utils::isNullOrEmptyString($content))
 {
   	$log->logError("Unable to fetch contents of doc from Url or empty document");
  	//we still exit peacefully. program doesnt exit in error.
  	exit(0);	
 }

 $encoded_content = base64_encode($content);
 $request_json = json_encode(array(
 		'file' => $encoded_content,
 		'url' => $docUrl,
 		'key'=> $docKey,
 		'filename' => $docFName
 	));
 $esEndpoint = curl_init("{$ES_ENDPOINT}{$ES_INDEX}{$ES_TYPE}{$docKey}");
 curl_setopt_array($esEndpoint, array(
    CURLOPT_POST => TRUE,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    CURLOPT_POSTFIELDS => $request_json,
    CURLOPT_RETURNTRANSFER => TRUE
 ));
 $response = curl_exec($esEndpoint);
 if (curl_errno($esEndpoint)) {
        $log->logError(curl_error($esEndpoint));
        exit(0);
 } 
 curl_close($esEndpoint);
 $log->logDebug("Request sent to elasticsearch @ {$ES_ENDPOINT} ...");
 $responseArr = json_decode($response);
 if($responseArr->{'ok'} && $responseArr->{'_id'} == $docKey)
 	$log->logDebug("Successfully indexed document with id = {$docKey}.");
 else
 	$log->logError("Problem indexing. Document with key - {$docKey} NOT INDEXED.");
 print_r($response);
?>

