<?php
require __DIR__ . '/vendor/autoload.php';
use App\Database;
use App\Session;
use Intervention\Image\ImageManagerStatic as Image;
$conn = new Database();
$userinfo = Session::user();
if(!$userinfo){
	header("location: login.php");
}