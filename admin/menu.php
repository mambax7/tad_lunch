<?php
$adminmenu = [];
$icon_dir=substr(XOOPS_VERSION,6,3)=='2.6'?"":"images/";

$i = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME ;
$adminmenu[$i]['link'] = 'admin/index.php' ;
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC ;
$adminmenu[$i]['icon'] = 'images/admin/home.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_LUNCH_ADMENU1;
$adminmenu[$i]['link'] = "admin/main.php";
$adminmenu[$i]['desc'] = _MI_LUNCH_ADMENU1 ;
$adminmenu[$i]['icon'] = "images/admin/sup.png";

$i++;
$adminmenu[$i]['title'] = _MI_LUNCH_ADMENU2;
$adminmenu[$i]['link'] = "admin/kind.php";
$adminmenu[$i]['desc'] = _MI_LUNCH_ADMENU2 ;
$adminmenu[$i]['icon'] = "images/admin/toast_titanium.png";

$i++;
$adminmenu[$i]['title'] = _MI_LUNCH_ADMENU3;
$adminmenu[$i]['link'] = "admin/power.php";
$adminmenu[$i]['desc'] = _MI_LUNCH_ADMENU3 ;
$adminmenu[$i]['icon'] = "images/admin/groups.png";

$i++;
$adminmenu[$i]['title'] = _MI_LUNCH_ADMENU4;
$adminmenu[$i]['link'] = "admin/import.php";
$adminmenu[$i]['desc'] = _MI_LUNCH_ADMENU4 ;
$adminmenu[$i]['icon'] = "images/admin/import.png";


$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';




?>
