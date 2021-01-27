<?php
//error_reporting(0);
require 'aws/autoloader.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

 $access="AKIAVVGYK2ETP3MS5PNI";
 $secret="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";
$bucket="international-radio";
$s3Client = S3Client::factory(array(    
            'credentials' => array(
            'key' => "AKIAVVGYK2ETP3MS5PNI",
            'secret'  => "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"
        ),
	    'version' => 'latest',
		'region' =>'ap-south-1'));
  $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region'  => 'ap-south-1',
        'credentials' => array(
            'key' => "AKIAVVGYK2ETP3MS5PNI",
            'secret'  => "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"
        )
    ]);


$keyname= "international-radio/Thumbnail/Ghanta singh-270x270-fab.jpg";
$result = $s3->listObjects(array(
    'Bucket' => $bucket,
'key'=> $keyname
));
$contents=$result['Contents'];
foreach($contents as $content){
    echo $content['Key'].'<br/>';
}
//echo '<pre>';
 //print_r($contents);
 //echo '</pre>';
//header("Content-Type:{$result['ContentType']}");
//foreach ($result['Contents'] as $object){
//	echo $object['key'];
//}

?>