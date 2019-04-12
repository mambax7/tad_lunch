<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_lunch_adm_import.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

function list_all(){
  global $xoopsDB,$xoopsTpl;
  
  $tbl_arr= ['lunch_config', 'lunch_main', 'lunch_dish', 'lunch_kind'];
  $i=0;
  foreach($tbl_arr as $tbl){
    $sql="select count(*) from ".$xoopsDB->prefix("sxs_{$tbl}");
    $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);
    list($count)=$xoopsDB->fetchRow($result);
    
    $counter1[$i]['count']=$count;
    $counter1[$i]['tblname']="sxs_{$tbl}";
  
    
    $sql="select count(*) from ".$xoopsDB->prefix("tad_{$tbl}");
    $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);
    list($count)=$xoopsDB->fetchRow($result);
    
    $counter1[$i]['count2']=$count;
    $counter1[$i]['tblname2']="tad_{$tbl}";
    $i++;
  }
  
    $xoopsTpl->assign('count1',$counter1);
}


//匯入 
function import($tbl=""){
  global $xoopsDB;
  foreach($tbl as $tbl_name){
 
    if($tbl_name=="sxs_lunch_config"){
    
    }else{
      $now_table=str_replace("sxs_lunch","tad_lunch",$tbl_name);
      
      //先清空原資料
      $sql="delete from `".$xoopsDB->prefix($now_table)."`";
      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_DEL_SQL_ERROR);
      
      //資料複製
      $sql="insert into `".$xoopsDB->prefix($now_table)."` select * from `".$xoopsDB->prefix($tbl_name)."`";        
      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_DEL_SQL_ERROR);
    }
  }
}

  
/*-----------執行動作判斷區--------------*/
$op=isset($_REQUEST['op'])?$_REQUEST['op']:"";
$op_id=isset($_REQUEST['op_id'])?$_REQUEST['op_id']:"";

switch($op){


  case "import":
  import($_POST['tbl']);
  header("location:{$_SERVER['PHP_SELF']}");
	break;
   

	default:
	list_all();
	break;
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
