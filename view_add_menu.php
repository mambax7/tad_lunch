<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_lunch_view_add_menu.html";
include_once XOOPS_ROOT_PATH."/header.php";

//使用權限 
if(!chk_power("tad_lunch","4"))redirect_header(XOOPS_URL,3,_MD_LUNCH_NO_POWER);


/*-----------function區--------------*/
//第一個參數是指定日期，第二個參數是往前或往後的日數 
function show_detail($g_date,$days="0"){
  global $xoopsDB,$weeks_arr,$xoopsModuleConfig,$xoopsTpl;

  $weeks = "";

  //日期的取得
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
    $weeks_show = _MD_LUNCH_S1."".$weeks.""._MD_LUNCH_SW; 
  }else{
    $weeks = ""; 
    $weeks_show = "";
  }
  
  $xoopsTpl->assign('week_day',$week_day);
  $xoopsTpl->assign('select_date_form',select_date_form());

  //取得日期的矩陣函數 
  $d_ar = DtoAr($week_day);
  
  $xoopsTpl->assign('get_gc_year',get_gc_year($d_ar));
  $xoopsTpl->assign('get_gc_seme',get_gc_seme($d_ar));


  //table 每日 ( 星期 ) 
  for($i = 0 ; $i < 7 ; $i++){
    $ddate = GetdayAdd($week_day ,$i);
    $d = DtoAr($ddate);
    
    $allmd[$i]['m']=$d['m'];
    $allmd[$i]['d']=$d['d'];
    $allmd[$i]['ddate']=$ddate;
    $allmd[$i]['week']=$weeks_arr[$i];
    //table 每日 body
    $allmd[$i]['show_dish']=show_dish($ddate);

  } 

  $xoopsTpl->assign('allmd',$allmd);
  $xoopsTpl->assign('show_dish',$show_dish);
}


/*-----------執行動作判斷區--------------*/
show_detail($_REQUEST['d_date'],$_REQUEST['add_days']);


/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;

$xoopsTpl->assign('content',$main);
include_once XOOPS_ROOT_PATH.'/footer.php';
?>