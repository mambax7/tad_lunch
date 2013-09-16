<?php
// 擷取 sfs3 的 函數庫 及增加 
// $Id: sfs_case_PLlib.php,v 1.10.4.1 2004/01/10 04:48:02 hami Exp $
// 取代 PLlib.php

/*
 * 函數庫
 * 作者
 * prolin  http://sy3es.tnc.edu.tw/~prolin 
 * hami    cik@mail.wpes.tcc.edu.tw
*/

//版本號
//$PLlib_VERSON = 2.0;
//$PLlib_DATE = "2001-10-1";



function DtoCh($dday="", $st="-") {
  if (!$dday) //使用預設日期
  $dday = date("Y-m-j");
  //把西元日期改為民國日期  $st為分隔符號
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	$d[0] = $d[0] - 1911 ;

	$cday = $d[0]."-".$d[1]."-".$d[2] ;
	return $cday ;
}

function ChtoD($dday, $st="-") {
  //把民國日期改為西元日期  $st為分隔符號
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	$d[0] = $d[0] + 1911 ;

	$cday = $d[0]."-".$d[1]."-".$d[2] ;
	return $cday ;
}

function Getday($dday ,$st="-") {
  //把西元日期中取得日期  $st為分隔符號
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
  //$d[0] = $d[0] - 1911 ;

  //轉為數字傳回
	return intval($d[2]) ;	
}	

function GetdayAdd($dday ,$dayn,$st="-") {
  //日期中加減日數
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	return date("Y-m-d",mktime(0,0,0,$d[1],$d[2] + $dayn,$d[0])) ;
}

?>
