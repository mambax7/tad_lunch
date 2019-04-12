<?php
/*-----------�ޤJ�ɮװ�--------------*/
$xoopsOption['template_main'] = "tad_lunch_adm_power.html";
include_once "header.php";
include_once "../function.php";

include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';


$module_id = $xoopsModule->getVar('mid');

$item_list = [
	'1' => _MA_LUNCH_SHOW,
  '2' => _MA_LUNCH_ADD,
  '3' => _MA_LUNCH_ADD_MENU,
  '4' => _MA_LUNCH_VIEW_MENU
];
$title_of_form = _MA_LUNCH_SET_POWER;
$perm_name = 'tad_lunch';
$formi = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);
foreach ($item_list as $item_id => $item_name) {
	$formi->addItem($item_id, $item_name);
}

$main=_MA_LUNCH_README.$formi->render();

/*-----------�q�X���G��--------------*/
$xoopsTpl->assign('main',$main);
include_once 'footer.php';
?>
