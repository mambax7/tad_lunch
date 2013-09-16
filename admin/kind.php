<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_lunch_adm_kind.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

function list_all(){
  global $xoopsDB,$xoopsTpl;

  $sql="select * from ".$xoopsDB->prefix("tad_lunch_kind");
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);

  $i=1;
  $all="";
  while($kind=$xoopsDB->fetchArray($result)){   
    $all[$i]['id']=$kind['id'];
    $all[$i]['sn']=$kind['sn'];
    $all[$i]['name']=$kind['name'];
    $i++;
  }
  $xoopsTpl->assign('all',$all);
}


function add_one_form($op_id=""){
  global $xoopsDB,$xoopsTpl;

  $kind="";
  //判斷是新增或修改
  if(!empty($op_id)){
    $sql="select * from ".$xoopsDB->prefix("tad_lunch_kind")." where id='{$op_id}'";
    $result=$xoopsDB->query($sql)or redirect_header($_SERVER['PHP_SELF'],3,_MA_ERR);
    $kind=$xoopsDB->fetchArray($result);
  }
  $xoopsTpl->assign('kind',$kind);
  $xoopsTpl->assign('op_id',$op_id);
  $xoopsTpl->assign('now_op','add_one_form');
}


//新增 
function add_kind(){
  global $xoopsDB;
  
	$myts =& MyTextSanitizer::getInstance();
	$sn=$myts->addSlashes($_POST['sn']);
	$name=$myts->addSlashes($_POST['name']);
  
  $sql="insert into ".$xoopsDB->prefix("tad_lunch_kind")." (sn,name) values('{$sn}','{$name}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],4,_TAD_ADD._MA_ERR._MA_ID_README);
}

//修改 
function modify_one($op_id=""){
  global $xoopsDB;
  
	$myts =& MyTextSanitizer::getInstance();
	$sn=$myts->addSlashes($_POST['sn']);
	$name=$myts->addSlashes($_POST['name']);
  
  $sql="update ".$xoopsDB->prefix("tad_lunch_kind")." set sn = '{$sn}', name = '{$name}' where id = '{$op_id}'";

  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],4,_TAD_EDIT._MA_ERR._MA_ID_README);
}
  
//刪除 
function del_one($op_id=""){
  global $xoopsDB;
  $sql="delete from ".$xoopsDB->prefix("tad_lunch_kind")." where id = '{$op_id}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_DEL_SQL_ERROR);
}

  
/*-----------執行動作判斷區--------------*/
$op=isset($_REQUEST['op'])?$_REQUEST['op']:"";
$op_id=isset($_REQUEST['op_id'])?$_REQUEST['op_id']:"";

switch($op){

  case "del_one":
  del_one($op_id);
  header("location:{$_SERVER['PHP_SELF']}");
	break;


  case "modify_one":
  modify_one($op_id);
  header("location:{$_SERVER['PHP_SELF']}");
	break;

  case "add":
  add_kind();
  header("location:{$_SERVER['PHP_SELF']}");
	break;
   

	default:
	list_all();
  add_one_form($op_id);
	break;
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
