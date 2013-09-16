<?php
function show_today_lunch(){
  global $xoopsDB;

//日期的取得
  $g_date = date("Y-m-d");

//從資料庫抓出資料 
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates = '{$g_date}' ";
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  $food=$xoopsDB->fetchArray($result);


// show 菜單 
if(!empty($food["staple"])){
  $main="<font color='#990000'>"._MB_LUNCH_DISH_MAIN."</font><br><br>".$food["staple"]."<br><br>";
}

if(!empty($food["dish1"])||!empty($food["dish2"])||!empty($food["dish3"])||!empty($food["dish4"])||!empty($food["dish5"])){
  $main.="<br><font color='#990000'>"._MB_LUNCH_DISH_DISH."</font><br><br>";
  if(!empty($food["dish1"])){
    $main.= $food["dish1"]."<br><br>";
  }
  if(!empty($food["dish2"])){
    $main.= $food["dish2"]."<br><br>";
  }
  if(!empty($food["dish3"])){
    $main.= $food["dish3"]."<br><br>";
  }
  if(!empty($food["dish4"])){
    $main.= $food["dish4"]."<br><br>";
  }
  if(!empty($food["dish5"])){
    $main.= $food["dish5"]."<br><br>";
  }
}
if(!empty($food["soup"])){
  $main.="<br><font color='#990000'>"._MB_LUNCH_DISH_SOUP."</font><br><br>".$food["soup"]."<br><br>";
}
if(!empty($food["fruit"])){
  $main.="<br><font color='#990000'>"._MB_LUNCH_DISH_FRUIT."</font><br><br>".$food["fruit"]."<br><br>";
}
if(!empty($food["rem"])){
  $main.="<br>".$food["rem"]."<br><br>";
}

  $block['main']=$main;
  return $block;
}
?>
