<?php

try{
	//　MySQL接続情報　//
	$dbname = 'seminar';
	$host = '172.16.1.43';
	$user = 'jmadmin';
	$pass = 'Mastersec@1';
	// cookie保存パス
	$path = '/pl/qanda/';
	
//	$toptitle = '　情報共有ライブラリ';

	date_default_timezone_set('Asia/Tokyo');

	//　PDOオブジェクト生成　//
	$dbh = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$user,$pass);
	$flag = 'ok';
	
} catch (PDOException $e){
	$word = 'error';
	$mode = 'error';
	$flag = 'err';
	echo $e;
}


?>
