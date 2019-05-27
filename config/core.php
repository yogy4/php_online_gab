<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// set url 
$home_url = "http://nama_url/";

// halaman diberikan dalam parameter url, default halaman adalah satu
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set jumlah record per halaman

$records_per_page = 5;
// jumlah untuk klausa limit  
$from_record_num = ($records_per_page * $page) - $records_per_page;

date_default_timezone_set('Asia/Jakarta');
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.com";
// untuk $iat dan $nbf harus diset $iat < $nbf
$iat = 1356999524;
$nbf = 1357000000;