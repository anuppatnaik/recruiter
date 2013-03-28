<?php
/*
 * jQuery File Upload Plugin Server PHP for S3 Amazon
 *
 * Copyright 2012, Roberto Colonello
 * http://www.parsec.it
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
 
require_once '../aws-sdk-for-php/sdk.class.php';
require_once '../php-commons/uuid.php';
require_once '../php-commons/utils.php';

$s3 = new AmazonS3();
$sns = new AmazonSNS();
$sns->set_region(AmazonSNS::REGION_APAC_SE1);

function getFileInfo($bucket, $fileName, $key = null, $meaningfulName = null) {
    global $s3;
    global $sns;
    $fileArray = "";
    $size = $s3->get_object_filesize($bucket, $fileName);
    $furl = "http://" . $bucket . ".s3.amazonaws.com/" . $fileName;
    $fileArray['name'] = $fileName;
    $fileArray['size'] = $size;
    $fileArray['url'] = $furl;
    $fileArray['thumbnail'] = $furl;
    $fileArray['delete_url'] = "/lib/s3/";
    $fileArray['delete_type'] = "DELETE";

    if($meaningfulName !== null)
        $fileArray['name'] = $meaningfulName;
    $fileArray['key'] = $key;
    return $fileArray;
}

function getListOfContents($bucket, $prefix="") {
    global $s3;
    global $sns;

    if ($prefix=="") {
      $contents = $s3->get_object_list($bucket);
    } else {
    	$contents = $s3->get_object_list($bucket, array("prefix" => $prefix));
    }
    $resultArray = "";
    for ($i = 0;$i < count($contents);$i++) {
        $resultArray[] = getFileInfo($bucket, $contents[$i]);
    }
    return $resultArray;
}

function uploadFiles($bucket, $prefix="") {
    global $s3;
    global $sns;
    
    //upload complete topic
    $topic = "arn:aws:sns:ap-southeast-1:242694654171:resume-upload-complete";

    if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
        return "";
    }
    $upload = isset($_FILES['files']) ? $_FILES['files'] : null;
    $info = array();
    if ($upload && is_array($upload['tmp_name'])) {
        foreach($upload['tmp_name'] as $index => $value) {
            //UUID used as key to store resume file in s3. this code 
            //repeats in else as well. 
            $uuid = UUID::v4();
            $fileTempName = $upload['tmp_name'][$index];
            $fileName = (isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index]);
            $fileName = $prefix.str_replace(" ", "_", $fileName);
            //adding extension to the uuid is important for google viewer to read the document correctly
            //uuid followed by file extn
            $uuid_key = $uuid . "." . pathinfo($fileName, PATHINFO_EXTENSION);
            $response = $s3->create_object($bucket, $uuid_key, array('fileUpload' => $fileTempName, 'acl' => AmazonS3::ACL_PUBLIC, 'meta' => array('keywords' => 'resume'),));
            if ($response->isOK()) {
                $fileInfo = getFileInfo($bucket, $uuid_key, $uuid, Utils::makeFileNameMeaningful($fileName));
                $info[] = $fileInfo;
                $sns_response = $sns->publish($topic, json_encode($fileInfo));
                if(!$sns_response->isOK()) {
                    error_log("HTTP Status: " . $sns_response->status . ", Error Code: " . $sns_response->body->Error->Code
. ", Message: " . $sns_response->body->Error->Message);
                }
            } else {
                error_log("HTTP Status: " . $response->status . ", Error Code: " . $response->body->Error->Code
. ", Message: " . $response->body->Error->Message);
            }
        } // foreach
    } else {
        if ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            $uuid = UUID::v4();
            $fileTempName = $upload['tmp_name'];
            $fileName = (isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $upload['name']);
            $fileName =  $prefix.str_replace(" ", "_", $fileName);
            //uuid followed by file extn
            $uuid_key = $uuid . "." . pathinfo($fileName, PATHINFO_EXTENSION);
            $response = $s3->create_object($bucket, $uuid_key, array('fileUpload' => $fileTempName, 'acl' => AmazonS3::ACL_PUBLIC, 'meta' => array('keywords' => 'resume'),));
            if ($response->isOK()) {
                $fileInfo = getFileInfo($bucket, $uuid_key, $uuid, Utils::makeFileNameMeaningful($fileName));
                $info[] = $fileInfo;
                $sns_response = $sns->publish($topic, json_encode($fileInfo));
                if(!$sns_response->isOK()) {
                    error_log("HTTP Status: " . $sns_response->status . ", Error Code: " . $sns_response->body->Error->Code
. ", Message: " . $sns_response->body->Error->Message);
                }
            } else {
                error_log("HTTP Status: " . $response->status . ", Error Code: " . $response->body->Error->Code
. ", Message: " . $response->body->Error->Message);
                
            }
        }
    }
    header('Vary: Accept');
    $json = json_encode($info);
    $redirect = isset($_REQUEST['redirect']) ? stripslashes($_REQUEST['redirect']) : null;
    if ($redirect) {
        header('Location: ' . sprintf($redirect, rawurlencode($json)));
        return;
    }
    if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-type: application/json');
    } else {
        header('Content-type: text/plain');
    }
    return $info;
}

function deleteFiles($bucket) {
    global $s3;
    global $sns; 

    $file_name = isset($_REQUEST['file']) ? basename(stripslashes($_REQUEST['file'])) : null;
    $s3->delete_object($bucket, $file_name);
    $success = "";
    
    header('Content-type: application/json');
    return $success;
}
?>
