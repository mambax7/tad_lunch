<?php

/*-----------function��--------------*/
//�Ĥ@�ӰѼƬO���w����A�ĤG�ӰѼƬO���e�Ω��᪺��� 
function main_func($g_date="",$days="0"){
// main

//�ܼ�
global $xoopsDB,$weeks_arr,$xoopsModuleConfig,$weeks;


// ��������o
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


//�g�����ܼƳB�z
//�Ǵ���A�Ǵ����A�P�g����
//�Ǵ���A���ӬP�����Ĥ@�� 
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

//��g��  ��� ( �~-��-��)
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

// �� ��� ( �~-��-��)
$main.= select_date_form();
      
$main.="</td>
  </tr>
  ";


//���o������x�}��� 
$d_ar = DtoAr($week_day);


//table
//�e�b�� 
$main.="
<table border='5' cellpadding='1' cellspacing='1' bgcolor='#99FF00'>
  <tr>
    <td colspan='8' align='center'>".Num2CNum(get_gc_year($d_ar))." "._MD_LUNCH_SY." "._MD_LUNCH_S1." ".Num2CNum(get_gc_seme($d_ar))." ". _MD_LUNCH_S2." ".$weeks_show."</td>
  </tr>
  <tr>
  ";

//���o��� 
$main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DAY."</td>";
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);
  $main.="<td align='center' bgcolor='#FFFFFF'>".Num2CNum((int)$d[m])." "._MD_LUNCH_M." ".Num2CNum((int)$d[d])." "._MD_LUNCH_D."</td>";
}; 

//���� 
$main.="</tr><tr>";

//�C�X�P�� 
$main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_WEEKN."</td>";
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);
  $main.="<td align='center' bgcolor='#FFFFFF'>".$weeks_arr[$i]."</td>";
};
//�P��(�Ӧ�)���� 
$main.="</tr>"; 

// (body) ���Ф��e
//��ܤ@�g����� 
//�q��Ʈw��X��� 
$sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates between '{$week_day}' and date_add('{$week_day}', interval 6 day)";
$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
while($wd=$xoopsDB->fetchArray($result)){
  $wid = $wd[week];
  $food[$wid]=$wd;
}
//�P�_�������O�_��ܡA1 �N��O�A0 �N��_ 
//�w�]����� 
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
// show ��� 
if($staple_YESNO){
  $main.="<td align='center' bgcolor='#FFFFFF'>"._MD_LUNCH_DISH_MAIN."</td>";
  for($i = 0 ; $i < 7 ; $i++){
    if(empty($food[$i]["staple"])){
      $main.="<td align='center' bgcolor='#FFFFFF'></td>";
    }else{
      $main.="<td align='center' bgcolor='#FFFFFF'>".$food[$i]["staple"]."</td>";
    }
  }
//���� 
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
//���� 
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
//���� 
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
//���� 
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
//���� 
  $main.="</tr><tr>";  
}

//��b�� 
$main.="</table>";

return $main;
}


function show_week(){
//�ŧi 
/*-----------�ޤJ�ɮװ�--------------*/

include_once XOOPS_ROOT_PATH."/mainfile.php";

//�ܼ�
global $xoopsDB,$weeks_arr;

//�ޤJ���Ҳժ��@�Pfunction�ɮ�

include_once XOOPS_ROOT_PATH."/modules/tad_lunch/function.php";



//�w�q�ܼ�


//�w�q�x�}
$weeks_arr = [
    "0"=>_MD_LUNCH_WEEK0 ,
    "1"=>_MD_LUNCH_WEEK1 ,
    "2"=>_MD_LUNCH_WEEK2 ,
    "3"=>_MD_LUNCH_WEEK3 ,
    "4"=>_MD_LUNCH_WEEK4 ,
    "5"=>_MD_LUNCH_WEEK5 ,
    "6"=>_MD_LUNCH_WEEK6
];

//�g�����ܼ�
$weeks = "";


/*-----------����ʧ@�P�_��--------------*/

	show_main($_REQUEST['d_date'],$_REQUEST['add_days']);


/*-----------�q�X���G��--------------*/
  $block['show']=$main;
  return $block;
}
?>

