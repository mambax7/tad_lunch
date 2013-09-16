<?php
/*-----------引入檔案區--------------*/
include "header.php";
include_once XOOPS_ROOT_PATH."/header.php";


//使用權限 
if(!chk_power("tad_lunch","1"))redirect_header(XOOPS_URL,3,_MD_LUNCH_NO_POWER);

//定義變數
$g_date = date(y-m-d);
$g_date = $_GET['pdf_date'];

//週次的變數
$weeks = "";


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


//取得日期的矩陣函數 
$d_ar = DtoAr($week_day);


// pdf head
require('fpdf/chinese.php');

$pdf=new PDF_Chinese();
$pdf->AddBig5hwFont();
$pdf->Open();
$pdf->SetSubject("week_lunch");
$pdf->SetTitle("week_lunch");
$pdf->SetAuthor($xoopsModuleConfig['secretary']);
$pdf->SetMargins(25, 10 ,25);
$pdf->AddPage('L','mm','A4');

// pdf body
$pdf->SetFont('Big5-hw','BU',30);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(0,25,$xoopsModuleConfig['title']._MD_P_WEEK_TITLE,0,1,'C');

// pdf title 取得學年 
$str_title2 = Num2CNum(get_gc_year($d_ar))." "._MD_LUNCH_SY." "._MD_LUNCH_S1." ".Num2CNum(get_gc_seme($d_ar))." ". _MD_LUNCH_S2." ".$weeks_show;
$pdf->SetFont('Big5-hw','B',25);

$pdf->Cell(0,20,$str_title2,0,1,'C');


// pdf table title 取得日期 
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_DAY,1,0,'C');
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,Num2CNum((int)$d[m])._MD_LUNCH_M.Num2CNum((int)$d[d])._MD_LUNCH_D,1,$n,'C');
};

//列出星期 
// pdf table title 取得星期
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_WEEKN,1,0,'C');
for($i = 0 ; $i < 7 ; $i++){
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,$weeks_arr[$i],1,$n,'C');
};


// (body) 食譜內容
//顯示一週的菜單 
//從資料庫抓出資料 
$sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates between '{$week_day}' and date_add('{$week_day}', interval 6 day)";
$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
while($wd=$xoopsDB->fetchArray($result)){
  $wid = $wd[week];
  $food[$wid]=$wd;
}

// show 菜單 
// show 主食 
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_DISH_MAIN,1,0,'C');
$pdf->SetFont('Big5-hw','',14);
for($i = 0 ; $i < 7 ; $i++){
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,$food[$i]["staple"],1,$n,'C');
};

// show 菜色 
$width_array=array(20,33,33,33,33,33,33,33);
$pdf->SetWidths($width_array);
$align_array=array("C","C","C","C","C","C","C","C");
$pdf->SetAligns($align_array);
// context
$fcode=array('Big5-hw','Big5-hw','Big5-hw','Big5-hw','Big5-hw','Big5-hw','Big5-hw','Big5-hw');
$fstyle=array('b','','','','','','','');
$fsize=array(16,14,14,14,14,14,14,14);
$staple_dish[0]=_MD_LUNCH_DISH_DISH;
for($i = 0 ; $i < 7 ; $i++){
      if(empty($food[$i]["dish1"])){
        $staple_dish[$i+1].="";
      }else{
        $staple_dish[$i+1].=$food[$i]["dish1"]."\n";
      }
      if(empty($food[$i]["dish2"])){
        $staple_dish[$i+1].="";
      }else{
        $staple_dish[$i+1].=$food[$i]["dish2"]."\n";
      }
      if(empty($food[$i]["dish3"])){
        $staple_dish[$i+1].="";
      }else{
        $staple_dish[$i+1].=$food[$i]["dish3"]."\n";
      }
      if(empty($food[$i]["dish4"])){
        $staple_dish[$i+1].="";
      }else{
        $staple_dish[$i+1].=$food[$i]["dish4"]."\n";
      }
      if(empty($food[$i]["dish5"])){
        $staple_dish[$i+1].="";
      }else{
        $staple_dish[$i+1].=$food[$i]["dish5"]."\n";
      }

};
$pdf->Row($staple_dish,$fcode,$fstyle,$fsize);

// show 湯 
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_DISH_SOUP,1,0,'C');
$pdf->SetFont('Big5-hw','',14);
for($i = 0 ; $i < 7 ; $i++){
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,$food[$i]["soup"],1,$n,'C');
};

// show 水果 
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_DISH_FRUIT,1,0,'C');
$pdf->SetFont('Big5-hw','',14);
for($i = 0 ; $i < 7 ; $i++){
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,$food[$i]["fruit"],1,$n,'C');
};

// show 備註
$pdf->SetFont('Big5-hw','B',16);
$pdf->Cell(20,10,_MD_LUNCH_DISH_REM,1,0,'C');
$pdf->SetFont('Big5-hw','',14);
for($i = 0 ; $i < 7 ; $i++){
  $n = ( $i == 6 )?'1':'0';
  $pdf->Cell(33,10,$food[$i]["rem"],1,$n,'C');
};

//$pdf->Ln();

// pdf body foot 
$pdf->SetFont('Big5-hw','B',20);
$pdf->Cell(30,25,_MD_P_MASTER,0,0,'C');
$pdf->SetFont('Big5-hw','',18);
$master = ($xoopsModuleConfig[master_j])? $xoopsModuleConfig['master'] : "";
$pdf->Cell(50,25,$master,0,0,'L');

$pdf->SetFont('Big5-hw','B',20);
$pdf->Cell(40,25,_MD_P_SECRETARY,0,0,'C');
$pdf->SetFont('Big5-hw','',18);
$secretary = ($xoopsModuleConfig[secretary_j])? $xoopsModuleConfig['secretary'] : ""; 
$pdf->Cell(50,25,$secretary,0,0,'L');

$pdf->SetFont('Big5-hw','B',20);
$pdf->Cell(30,25,_MD_P_DESIGN,0,0,'C');
$pdf->SetFont('Big5-hw','',18);
$pdf->Cell(50,25,"",0,0,'L');


/*-----------秀出結果區--------------*/
//輸出PDF
$pdf->Output();
?>
