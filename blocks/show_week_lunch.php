<?php

/*-----------function區--------------*/
//第一個參數是指定日期，第二個參數是往前或往後的日數 
function main_func($g_date="",$days="0"){
// main

//變數
global $xoopsDB,$weeks_arr,$xoopsModuleConfig,$weeks;


// 日期的取得
if(empty($g_date)){
  $g_date = date("Y-m-d");
  $week_days = date("w");
  $week_day = GetdayAdd($g_date ,-$week_days);
}else{
  $d = DtoAr($g_date);
  $week_days = date("w",mktime(0,0,0,$d[m],$d[d],$d[y]));
  $days = $days - $week_days;
  $week_day = GetdayAdd($g_date ,$days);
}


//週次的變數處理
//學期初，學期末，同週都算
//學期初，那個星期的第一天 
  $d = DtoAr($xoopsModuleConfig['date_b']);
  $week_days = date("w",mktime(0,0,0,$d[m],$d[d],$d[y]));
  $seme_week_day = GetdayAdd($xoopsModuleConfig['date_b'] ,-$week_days);
if(($week_day >= $seme_week_day) & ($week_day <= $xoopsModuleConfig['date_e'])){
  $weeks = weeks_ok($seme_week_day,$week_day);
  $weeks_show = _MD_LUNCH_S1."".Num2CNum($weeks).""._MD_LUNCH_SW; 
}else{
  $weeks = ""; 
  $weeks_show = "";
}

//選週次  日期 ( 年-月-日)
$main="<table>
  <tr>
    <td width='50%' align='center'>
  <a href='$_SERVER[PHP_SELF]?d_date={$week_day}&add_days=-14'><img src='".XOOPS_URL."/modules/tad_lunch/images/2leftarrow.png' title="._MD_LUNCH_L2W." alt="._MD_LUNCH_L2W." width='20' height='15' border='0'></a>
  <a href='$_SERVER[PHP_SELF]?d_date={$week_day}&add_days=-7'><img src='".XOOPS_URL."/modules/tad_lunch/images/1leftarrow.png' title="._MD_LUNCH_L1W." alt="._MD_LUNCH_L1W." width='20' height='15' border='0'></a> 
  <strong><font size='4'>"._MD_LUNCH_TITLEW."</font></strong>
  <a href='$_SERVER[PHP_SELF]?d_date={$week_day}&add_days=7'><img src='".XOOPS_URL."/modules/tad_lunch/images/1rightarrow.png' title="._MD_LUNCH_N1W." alt="._MD_LUNCH_N1W." width='20' height='15' border='0'></a>
  <a href='$_SERVER[PHP_SELF]?d_date={$week_day}&add_days=14'><img src='".XOOPS_URL."/modules/tad_lunch/images/2rightarrow.png' title="._MD_LUNCH_N2W." alt="._MD_LUNCH_N2W." width='20' height='15' border='0'></a>
    </td>
    <td width='50%' align='center'>
  ";

// 選 日期 ( 年-月-日)
$main.= select_date_form();
      
$main.="</td>
  </tr>
  ";


//取得日期的矩陣函數 
$d_ar = DtoAr($week_day);


//table
//前半部 
$main.="
<table border='5' cellpadding='1' cellspacing='1' bgcolor='#99FF00'>
  <tr>
    <td colspan='8' align='center'>".Num2CNum(get_gc_year($d_ar))." "._MD_LUNCH_SY." "._MD_LUNCH_S1." ".Num2CNum(get_gc_seme($d_ar))." ". _MD_LUNCH_S2." ".$weeks_show."</td>
  </tr>
  <tr>
  ";

//取得日期 
$main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DAY."</td>";
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);
  $main.="<td align='center' bgcolor='#FFFFFF'>".Num2CNum((int)$d[m])." "._MD_LUNCH_M." ".Num2CNum((int)$d[d])." "._MD_LUNCH_D."</td>";
}; 

//換行 
$main.="</tr><tr>";

//列出星期 
$main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_WEEKN."</td>";
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);
  $main.="<td align='center' bgcolor='#FFFFFF'>".$weeks_arr[$i]."</td>";
};
//星期(該行)結束 
$main.="</tr>"; 

// (body) 食譜內容
//顯示一週的菜單 
//從資料庫抓出資料 
$sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates between '{$week_day}' and date_add('{$week_day}', interval 6 day)";
$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
while($wd=$xoopsDB->fetchArray($result)){
  $wid = $wd[week];
  $food[$wid]=$wd;
}
//判斷哪些欄位是否顯示，1 代表是，0 代表否 
//預設不顯示 
$staple_YESNO = 0;
$dish_YESNO = 0;
$soup_YESNO = 0;
$fruit_YESNO = 0;
$rem_YESNO = 0;
for($i = 0 ; $i < 7 ; $i++){ 
  if(!empty($food[$i]["staple"])){
    $staple_YESNO = 1;
  }
  if(!empty($food[$i]["dish1"])||!empty($food[$i]["dish2"])||!empty($food[$i]["dish3"])||!empty($food[$i]["dish4"])||!empty($food[$i]["dish5"])){
    $dish_YESNO = 1;
  }
  if(!empty($food[$i]["soup"])){
    $soup_YESNO = 1;
  }
  if(!empty($food[$i]["fruit"])){
    $fruit_YESNO = 1;
  }
  if(!empty($food[$i]["rem"])){
    $rem_YESNO = 1;
  }
} 
// show 菜單 
if($staple_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DISH_MAIN."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["staple"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>".$food[$i]["staple"]."</td>";
    }
  }
//換行 
  $main.="</tr><tr>";  
}
if($dish_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DISH_DISH."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["dish1"])&&empty($food[$i]["dish2"])&&empty($food[$i]["dish3"])&&empty($food[$i]["dish4"])&&empty($food[$i]["dish5"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>";
      if(empty($food[$i]["dish1"])){
        $main.="";
      }else{
        $main.=$food[$i]["dish1"]."<br>";
      }
      if(empty($food[$i]["dish2"])){
        $main.="";
      }else{
        $main.=$food[$i]["dish2"]."<br>";
      }
      if(empty($food[$i]["dish3"])){
        $main.="";
      }else{
        $main.=$food[$i]["dish3"]."<br>";
      }
      if(empty($food[$i]["dish4"])){
        $main.="";
      }else{
        $main.=$food[$i]["dish4"]."<br>";
      }
      if(empty($food[$i]["dish5"])){
        $main.="";
      }else{
        $main.=$food[$i]["dish5"]."<br>";
      }
    }
  }
//換行 
  $main.="</tr><tr>";  
}
if($soup_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DISH_SOUP."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["soup"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>".$food[$i]["soup"]."</td>";
    }
  }
//換行 
  $main.="</tr><tr>";  
}
if($fruit_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DISH_FRUIT."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["fruit"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>".$food[$i]["fruit"]."</td>";
    }
  }
//換行 
  $main.="</tr><tr>";  
}
if($rem_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MB_LUNCH_DISH_REM."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["rem"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>".$food[$i]["rem"]."</td>";
    }
  }
//換行 
  $main.="</tr><tr>";  
}

//後半部 
$main.="</table>";

return $main;
}


function show_week(){
//宣告 
/*-----------引入檔案區--------------*/

include_once XOOPS_ROOT_PATH."/mainfile.php";

//變數
global $xoopsDB,$weeks_arr;

//引入本模組的共同function檔案

include_once XOOPS_ROOT_PATH."/modules/tad_lunch/function.php";



//定義變數


//定義矩陣
$weeks_arr = array(
    "0"=>_MD_LUNCH_WEEK0 ,
    "1"=>_MD_LUNCH_WEEK1 ,
    "2"=>_MD_LUNCH_WEEK2 ,
    "3"=>_MD_LUNCH_WEEK3 ,
    "4"=>_MD_LUNCH_WEEK4 ,
    "5"=>_MD_LUNCH_WEEK5 ,
    "6"=>_MD_LUNCH_WEEK6 
);

//週次的變數
$weeks = "";


/*-----------執行動作判斷區--------------*/

	show_main($_REQUEST['d_date'],$_REQUEST['add_days']);


/*-----------秀出結果區--------------*/
  $block['show']=$main;
  return $block;
}
?>

