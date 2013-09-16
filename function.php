<?php
//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";


/* 資料取得功能 */

//取得學年，輸入為矩陣 
function get_gc_year($dar=""){
  $gc_year=($dar[m]>=8)?$dar[y]-1911:($dar[y]-1911)-1;
	return $gc_year;
}

//取得學期，輸入為矩陣 
function get_gc_seme($dar=""){
 	$gc_seme=($dar[m]>=8 or $dar[m]<=1)?1:2;
	return $gc_seme;
}


//時間函數 

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

//取得日期的矩陣函數 
function ChtoD($dday="", $st="-") {
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

//矩陣分別取得年、月、日 d[y],d[m],d[d]
function DtoAr($dday="", $st="-") {
  if (!$dday) //使用預設日期
  $dday = date("Y-m-j");
  //把西元日期改為矩陣分別取得年、月、日  $st為分隔符號
  
//  echo $dday;
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
	 if($i == 0)
	   $j = 'y';
	 if($i == 1)
	   $j = 'm';
	 if($i == 2)
	   $j = 'd';
	   
  	$d[$j] =$tok ;

		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	return $d ;
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


//取得週數
//在範圍外的值(以學期為主)，傳回值為0，以星期日為每週的第一天 ，第一週為起始週 
function weeks_ok($date_b="" ,$date_e=""){
  if(!empty($date_b) && !empty($date_e)){
    $d_b = DtoAr($date_b);
    $d_e = DtoAr($date_e);
    if(($d_b > $d_e) || (($d_e[y]-$d_b[y]) > 1) ){
		  redirect_header($_SERVER['PHP_SELF'],2,_MD_HB_ERROR_WEEKS);
    }elseif($d_b[y] == $d_e[y]){
      $week_days = date("w", mktime(0, 0, 0, 01, 01, $d_b[y]));
      
      $weeks_1 = ceil((date("z", mktime(0, 0, 0, $d_b[m], $d_b[d], $d_b[y])) + $week_days + 1 )/7);
      $weeks_2 = ceil((date("z", mktime(0, 0, 0, $d_e[m], $d_e[d], $d_e[y])) + $week_days + 1 )/7);      

      $weeks = $weeks_2 - $weeks_1 + 1;
      
    }else{
      $week_days = date("w", mktime(0, 0, 0, 01, 01, $d_b[y]));
      
      $weeks_1 = ceil((date("z", mktime(0, 0, 0, $d_b[m], $d_b[d], $d_b[y])) + $week_days + 1 )/7);

      $weeks_days_end = date("z", mktime(0, 0, 0, 12, 31, $d_b[y])) + $week_days + 1 ;
      $weeks_2 = ceil((date("z", mktime(0, 0, 0, $d_e[m], $d_e[d], $d_e[y])) + $weeks_days_end + 1 )/7);
      
      $weeks = $weeks_2 - $weeks_1 + 1;
    }
  }
return $weeks;
}


/* -------------------------------------------------- *)
(* Num2CNum  將阿拉伯數字轉成中文數字字串
(* 使用示例:
(*   Num2CNum(10002.34) ==> 一萬零二點三四
(*
(* Author: Wolfgang Chien <wolfgang@ms2.hinet.net>
(* Date: 1996/08/04
(* Update Date:
(* -------------------------------------------------- */

// (* 將字串反向, 例如: 傳入 '1234', 傳回 '4321' *)
function ConvertStr($sBeConvert){
	$tt = '';
	for ($x = strlen($sBeConvert)-1;$x>=0; $x--)
		$tt .= substr($sBeConvert,$x,1);
	return $tt;
} 

function Num2CNum($dblArabic,$ChineseNumeric='') {
  $encoding="UTF-8";
  	
	if ($ChineseNumeric=='')
		$ChineseNumeric = _MD_N2CN_NUMS;
  	$result = "";
	$bInZero = True;
	$sArabic = $dblArabic;
	if (substr($sArabic,0,1) == '-'){
		$bMinus = True;
		$sArabic = substr($sArabic, 1, 254);
	}
	else
		$bMinus = False;
	
	$iPosOfDecimalPoint = strpos($sArabic,'.');  //(* 取得小數點的位置 *)
 	
  //(* 先處理整數的部分 *)
	if ($iPosOfDecimalPoint == 0)
		$sIntArabic = ConvertStr($sArabic);
	else
		$sIntArabic = ConvertStr(substr($sArabic, 0, $iPosOfDecimalPoint));
	
  //(* 從個位數起以每四位數為一小節 *)
	
	for ($iSection = 0 ; $iSection<= intval((strlen($sIntArabic)-1)/4);$iSection++) {
		$sSectionArabic = substr($sIntArabic, $iSection * 4 , 4);
		$sSection = '';	
    		
  		//  (* 以下的 i 控制: 個十百千位四個位數 *)
		for ($i=0;$i< strlen($sSectionArabic);$i++){
			$iDigit = Ord(substr($sSectionArabic,$i,1)) - 48;
			
			if ($iDigit == 0) {
			//(* 1. 避免 '零' 的重覆出現 *)
			//(* 2. 個位數的 0 不必轉成 '零' *)
        			if (!$bInZero and $i != 0)
					$sSection = _MD_N2CN_REZO.$sSection;
				$bInZero = True;
			}
			else {

				switch ($i) {
					case 1: $sSection = _MD_N2CN_TEN.$sSection;
					break;
					case 2: $sSection = _MD_N2CN_HUND.$sSection;
					break;
					case 3: $sSection = _MD_N2CN_THOU.$sSection;
					break;
				}

//  判斷 UTF-8 ? BIG5 ?			
//				$sSection = substr($ChineseNumeric, 2 * $iDigit, 2).$sSection;
/*			  if ( true === mb_check_encoding ( $ChineseNumeric, $encoding ) ){
			  // UTF-8 is 3 byts
          $sSection = substr($ChineseNumeric, 3 * $iDigit, 3).$sSection;
        }
        else{
        // BIG5 is 2 bytes
          $sSection = substr($ChineseNumeric, 2 * $iDigit, 2).$sSection;
        }

  */

				$bInZero = False;
			}
		}
		
   		//(* 加上該小節的位數 *)
    		
		if (strLen($sSection) == 0) {
			if (strLen($result) > 0 and substr($result, 0, 2) != _MD_N2CN_REZO)
				$result = _MD_N2CN_REZO.$result;
		}
			
		else {
			switch ($iSection) {
				case 0: $result = $sSection;
				break;
				case 1: $result = $sSection . _MD_N2CN_TENTHOU . $result;
				break;
				case 2: $result = $sSection . _MD_N2CN_HUNDTHOU . $result;
				break;
				case 3: $result = $sSection . _MD_N2CN_MIL . $result;
				break;
			}
					
		}
		 
	}
	

	
   //(* 處理小數點右邊的部分 *)
	if ($iPosOfDecimalPoint > 0 ) {
		
		$result .= _MD_N2CN_DOT;
		for ($i = $iPosOfDecimalPoint +1;$i <strLen($sArabic);$i++) {
			$iDigit = Ord(substr($sArabic,$i,1)) - 48;
			$result .= substr($ChineseNumeric, 2 * $iDigit , 2);
		}

	}

  //(* 其他例外狀況的處理 *)
	if (strLen($result) == 0)
		$result = _MD_N2CN_REZO;
	if (substr($result, 0, 4) == _MD_N2CN_ONETEN)
		$result = substr($result, 2, 254);

	if (substr($result, 0, 2) == _MD_N2CN_REZO)
		$result = _MD_N2CN_REZO .$result;

  //(* 是否為負數 *)
	if ($bMinus)
		$result = _MD_N2CN_MIU .$result;
		
	return $result; 
}


function select_date_form($date){

  if(empty($date))$date = date("Y-m-d"); 
   
  $main="
  <script type='text/javascript' src='".TADTOOLS_URL."/My97DatePicker/WdatePicker.js'></script>
  <form method='post' action='{$_SERVER['PHP_SELF']}'>
    <div class='controls controls-row'>
    <input type='text' name='d_date' class='span4' value='{$date}' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\">
    
    <button type='submit' class='btn btn-info'>"._MD_LUNCH_CHANGE_SUBMIT."</button>
    </div>
  </form>
  ";

return $main;
} 


/* 其他 */

//進行權限判斷
function chk_power($gperm_name="",$gperm_itemid=""){
	global $xoopsUser,$xoopsModule;
	if(empty($gperm_name) or empty($gperm_itemid)){
		redirect_header($_SERVER['PHP_SELF'],5,_MD_HB_CANT_GET_POWER);
	}
	//看使用者是屬於什麼群組
	if(empty($xoopsUser)){
		$groups_id_arr=array(3);
	}else{
  	$groups_id_arr =& $xoopsUser->getGroups();
  }
  //解析每個群組
  foreach($groups_id_arr as $gperm_groupid){
		//指定細部權限小群組名稱
		$gperm_modid=$xoopsModule->mid();
		$gperm_handler =&xoops_gethandler('groupperm');
		$CR=$gperm_handler->checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid);
		if($CR) {
			$IhaveRight="1";
			return true;
		}
	}
  return false;
}







// show 菜單材料
function show_dish($g_date){
//變數
global $xoopsDB;
$main="";

  $sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates = '{$g_date}'";
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  if($food=$xoopsDB->fetchArray($result)){
// 項目 
   $main.="<tr style='font-size:12px;'>
        <td>"._MD_LUNCH_DISH_DISH."</td><td>"._MD_LUNCH_ITEM_1."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_2."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_3."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_4."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_5."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_6."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_7."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_8."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_9."</td><td>"._MD_LUNCH_NUMBER."</td><td>"._MD_LUNCH_ITEM_10."</td><td>"._MD_LUNCH_NUMBER."</td>
        </tr>";
    if(!empty($food["staple_sn"])){
      $main.=show_dish_items($food["staple_sn"],$food["numbers"]);
    }
    if(!empty($food["dish1_sn"])){
      $main.=show_dish_items($food["dish1_sn"],$food["numbers"]);
    }
    if(!empty($food["dish2_sn"])){
      $main.=show_dish_items($food["dish2_sn"],$food["numbers"]);
    }
    if(!empty($food["dish3_sn"])){
      $main.=show_dish_items($food["dish3_sn"],$food["numbers"]);
    }
    if(!empty($food["dish4_sn"])){
      $main.=show_dish_items($food["dish4_sn"],$food["numbers"]);
    }
    if(!empty($food["dish5_sn"])){
      $main.=show_dish_items($food["dish5_sn"],$food["numbers"]);
    }
    if(!empty($food["soup_sn"])){
      $main.=show_dish_items($food["soup_sn"],$food["numbers"]);
    }
    if(!empty($food["fruit_sn"])){
      $main.=show_dish_items($food["fruit_sn"],$food["numbers"]);
    }
    if(!empty($food["rem_sn"])){
      $main.=show_dish_items($food["rem_sn"],$food["numbers"]);
    }
  }
  return $main;
} 


// show 菜單材料 子項 
function show_dish_items($id, $num){
//變數
global $xoopsDB;

  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$id}'";
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  $food=$xoopsDB->fetchArray($result);
  $main.="<tr style='font-size:12px;'>
        <td>".$food[dish]."</td><td>".$food[item_name_1]."</td><td>".($food[item_number_1]*$num/100).$food[item_unit_1]."</td><td>".$food[item_name_2]."</td><td>".($food[item_number_2]*$num/100).$food[item_unit_2]."</td><td>".$food[item_name_3]."</td><td>".($food[item_number_3]*$num/100).$food[item_unit_3]."</td><td>".$food[item_name_4]."</td><td>".($food[item_number_4]*$num/100).$food[item_unit_4]."</td><td>".$food[item_name_5]."</td><td>".($food[item_number_5]*$num/100).$food[item_unit_5]."</td><td>".$food[item_name_6]."</td><td>".($food[item_number_6]*$num/100).$food[item_unit_6]."</td><td>".$food[item_name_7]."</td><td>".($food[item_number_7]*$num/100).$food[item_unit_7]."</td><td>".$food[item_name_8]."</td><td>".($food[item_number_8]*$num/100).$food[item_unit_8]."</td><td>".$food[item_name_9]."</td><td>".($food[item_number_9]*$num/100).$food[item_unit_9]."</td><td>".$food[item_name_10]."</td><td>".($food[item_number_10]*$num/100).$food[item_unit_10]."</td>
        </tr>";

  return $main;
}


function print_content( $content ="" ){
	//以串流方式送出  ooo.sxw
	if(strpos($_SERVER['HTTP_USER_AGENT'] , 'MSIE') || strpos($_SERVER['HTTP_USER_AGENT'] , 'Opera')) $mimeType="application/x-download";
	elseif($file_extname=="odt") $mimeType="application/vnd.oasis.opendocument.text";
	else $mimeType="application/vnd.sun.xml.writer";
	header("Content-disposition:  attachment;  filename=$filename");
	header("Content-type:  $mimeType ");

	echo  $content;

	exit;
	return;
}


?> 