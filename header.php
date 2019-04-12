<?php
include_once "../../mainfile.php";
include_once "function.php";

//�P�_�O�_��ӼҲզ��޲z�v��
$isAdmin=false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin=$xoopsUser->isAdmin($module_id);
}

$interface_menu[_MD_LUNCH_SHOW]="index.php";
$interface_menu[_MD_LUNCH_VIEW_ADD_MENU]="view_add_menu.php";
if($isAdmin){
  $interface_menu[_TAD_TO_ADMIN]="admin/main.php";
}

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


?>
