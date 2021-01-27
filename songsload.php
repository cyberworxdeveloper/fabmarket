<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Aws S3</title>
  <meta charset="utf-8">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
 <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
  <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" type="text/css" href="styles/style.css" media="all">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body>
<?php

require '/home/fabmarket/aws/autoloader.php';

use Aws\S3\S3Client;

$pre = 'https://s3.console.aws.amazon.com/s3/object/international-radio/';
$suf = '?region=ap-south-1&tab=overview';

$s3 = S3Client::factory(array(
        'region'  => 'ap-south-1',
        'version' => 'latest',
        'credentials' => array('key'=>'AKIAVVGYK2ETP3MS5PNI',
                'secret'=>'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')
      ));

$bucket = 'international-radio';

//$dataList = [];
//print_r($allList[0]);
?>
<div class="container-fluid">
           <div class="row">
                    <div class="col-lg-12">
                       	<h1 class="page-header">
                           	Aws S3 Bucket View
                        	</h1>
                        	<ul id="myTab" class="nav nav-tabs">
                           <li>
                              	<a href="#home" data-toggle="tab">Music Shows</a>
                           </li>
			<li><a href="#a" data-toggle="tab">Celebrity Interviews</a></li>
			<li><a href="#b" data-toggle="tab">Celebrity Show</a></li>
			<li><a href="#c" data-toggle="tab">Drama</a></li>
			<li><a href="#d" data-toggle="tab">Imaging</a></li>
			<li><a href="#e" data-toggle="tab">Promos</a></li>
			<li><a href="#f" data-toggle="tab">RJ Talk Shows</a></li>
			<li><a href="#g" data-toggle="tab">Sparkerls</a></li>
			<li><a href="#h" data-toggle="tab">Star Bytes</a></li>
			<li><a href="#i" data-toggle="tab">Story Telling Shows</a></li>
			<li><a href="#j" data-toggle="tab">Thumbnail</a></li>
                       	</ul>
                       	<div id="myTabContent" class="tab-content">
                           	<div class="tab-pane fade in active" id="home">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="accordion">                                        
<?php 
$subdir = 'Music Shows';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  //array_push($dataList , $object['Key']);

  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
  $ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo "$x"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="a">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="ga">                                        
<?php 
$subdir = 'Celebrity Interviews';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
if($ind !=0)
{
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
}
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#ga" href="#<?php echo "$x"."a"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."a"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="b">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gb">                                        
<?php 
$subdir = 'Celebrity Show';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
if($ind !=0)
{
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
}
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gb" href="#<?php echo "$x"."b"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."b"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="c">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gc">                                        
<?php 
$subdir = 'Drama';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
if($ind !=0)
{
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
}
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gc" href="#<?php echo "$x"."c"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."c"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="d">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gd">                                        
<?php 
$subdir = 'Imaging';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
  $ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gd" href="#<?php echo "$x"."d"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."d"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="e">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="ge">                                        
<?php 
$subdir = 'Promos';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
if($ind !=0)
{
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
}
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#ge" href="#<?php echo "$x"."e"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."e"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="f">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gf">                                        
<?php 
$subdir = 'RJ Talk Shows';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
  $ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gf" href="#<?php echo "$x"."f"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."f"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="g">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gg">                                        
<?php 
$subdir = 'Sparkerls';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
  $ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gg" href="#<?php echo "$x"."g"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."g"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="h">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gh">                                        
<?php 
$subdir = 'Star Bytes';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
  $ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gh" href="#<?php echo "$x"."h"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."h"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="i">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gi">                                        
<?php 
$subdir = 'Story Telling Shows';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
if($ind !=0)
{
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
}
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gi" href="#<?php echo "$x"."i"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."i"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Play <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>
				<div class="tab-pane fade in active" id="j">
                              		<div class="content_accordion">
                                    		<div class="panel-group" id="gj">                                        
<?php 
$subdir = 'Thumbnail';

$objects = $s3->getIterator('ListObjects', array(
    "Bucket" => $bucket,
    "Prefix" => $subdir . '/'
));

$ind = 0;
$catList = [];
$maincats = [];
$allList = [];
$catname = "";

foreach ($objects as $object) {
  $name = explode("/",$object['Key']);
  if(in_array($name[1], $maincats)){
    array_push($catList , $object['Key']);
  }
  else{
    array_push($maincats, $name[1]);
    if(sizeof($catList) > 0)
      array_push($allList , $catList);
    $catList = [];
    $catname = $name[0];
    array_push($catList , $object['Key']);
  }
$ind++;
}
if(sizeof($catList) > 0)
  array_push($allList , $catList);

foreach($maincats as $x => $val) {
?>
              						<div class="panel panel-default">
                                            				<div class="panel-heading">
                                                				<h4 class="panel-title">
                                                    					<a data-toggle="collapse" data-parent="#gj" href="#<?php echo "$x"."j"; ?>"><?php echo "$val"; ?></a>
                                                				</h4>
                                            				</div>
              							<div id="<?php echo "$x"."j"; ?>" class="panel-collapse collapse">
<?php 
foreach($allList[$x] as $y => $val1) {
?>
                                                				<div class="panel-body">
                                                    					<p><?php echo "$val1     "; ?>
              										<a href="<?php echo "$pre" . str_replace(" ","%20",$val1) . "$suf"; ?>">
                											<button style="font-size:20px">Open <i class="fa fa-play"></i></button>
              										</a>
										</p>
                                                				</div>
<?php
}
?>
                                            				</div>
                                        			</div>
<?php
}
?>                                        
                                    		</div>
                             		</div>
                           	</div>

				
			</div>
               	</div>
	</div>
</div>
</body>
</html>
<?php
	//print_r($dataList);
?>