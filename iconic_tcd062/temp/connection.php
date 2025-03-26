<?php
/* 
Template Name: dbCheck 
*/  
$dbname = '2m5l9_ecapo';
$dbuser = '2m5l9_ecapo';
$dbpass = 'sh0-s19y^1Sa';
$dbhost = 'mysql14.onamae.ne.jp';

$connect = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
mysqli_select_db($connect, $dbname) or die("Could not open the db '$dbname'");

$test_query = "SHOW TABLES FROM $dbname";
$result = mysqli_query($connect, $test_query);

$tblCnt = 0;
while($tbl = mysqli_fetch_array($result)) {
  $tblCnt++;
}

if (!$tblCnt) {
  echo "There are no tables<br />\n";
} else {
  echo "There are $tblCnt tables<br />\n";
}