<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_lunch_adm_main.html";
include_once "header.php";
include_once "../function.php";




//變數
$act=$_REQUEST['act'];
$id=$_REQUEST['op_id'];

/*--------------  輸入 sql 資料 區  --------------*/ 

// 匯入使用者資料 
  if($act=="upfile" && $_FILES['userdata']['size'] > 0 && $_FILES['userdata']['name']!=""){

    $fd = fopen ($_FILES['userdata']['tmp_name'],"r");

		rewind($fd);
		$i=0; //存入筆數 
		$j=0; //錯誤筆數 
		while ($tt = fgetcsv ($fd, 2000, ",")) {
			if ($i++ == 0){ //第一筆為抬頭
				if(trim($tt[0])!=_MA_LUNCH_ADD_ID || trim($tt[1])!=_MA_LUNCH_NV  || trim($tt[2])!=_MA_LUNCH_ITEM || trim($tt[3])!=_MA_LUNCH_NUMBER || trim($tt[4])!=_MA_LUNCH_ADD_UNIT || trim($tt[5])!=_MA_LUNCH_ITEM || trim($tt[6])!=_MA_LUNCH_NUMBER || trim($tt[7])!=_MA_LUNCH_ADD_UNIT || trim($tt[8])!=_MA_LUNCH_ITEM || trim($tt[9])!=_MA_LUNCH_NUMBER || trim($tt[10])!=_MA_LUNCH_ADD_UNIT || trim($tt[11])!=_MA_LUNCH_ITEM || trim($tt[12])!=_MA_LUNCH_NUMBER || trim($tt[13])!=_MA_LUNCH_ADD_UNIT || trim($tt[14])!=_MA_LUNCH_ITEM || trim($tt[15])!=_MA_LUNCH_NUMBER || trim($tt[16])!=_MA_LUNCH_ADD_UNIT || trim($tt[17])!=_MA_LUNCH_ITEM || trim($tt[18])!=_MA_LUNCH_NUMBER || trim($tt[19])!=_MA_LUNCH_ADD_UNIT || trim($tt[20])!=_MA_LUNCH_ITEM || trim($tt[21])!=_MA_LUNCH_NUMBER || trim($tt[22])!=_MA_LUNCH_ADD_UNIT || trim($tt[23])!=_MA_LUNCH_ITEM || trim($tt[24])!=_MA_LUNCH_NUMBER || trim($tt[25])!=_MA_LUNCH_ADD_UNIT || trim($tt[26])!=_MA_LUNCH_ITEM || trim($tt[27])!=_MA_LUNCH_NUMBER || trim($tt[28])!=_MA_LUNCH_ADD_UNIT || trim($tt[29])!=_MA_LUNCH_ITEM || trim($tt[30])!=_MA_LUNCH_NUMBER || trim($tt[31])!=_MA_LUNCH_ADD_UNIT) redirect_header($_SERVER[PHP_SELF], 10, _MA_LUNCH_IN_ERR);
         	continue ;
			}

      if($tt[0] < 10 || $tt[0] > 99){
        $err_msg.=" "._MA_LUNCH_ADD_ID." ".$tt[0]." "._MA_LUNCH_NV." ".$tt[1]."<font color='red'> "._MA_LUNCH_ERRMSG." "._MA_LUNCH_UPDATA_README." !</font><br>";
        $j++;
        $i--;
        continue ;
     }

  		$sql="
    	replace into ".$xoopsDB->prefix("tad_lunch_dish")."
    	(kind,dish,item_name_1,item_number_1,item_unit_1,item_name_2,item_number_2,item_unit_2,item_name_3,item_number_3,item_unit_3,item_name_4,item_number_4,item_unit_4,item_name_5,item_number_5,item_unit_5,item_name_6,item_number_6,item_unit_6,item_name_7,item_number_7,item_unit_7,item_name_8,item_number_8,item_unit_8,item_name_9,item_number_9,item_unit_9,item_name_10,item_number_10,item_unit_10,change_date)
     	values
    	('{$tt[0]}','{$tt[1]}','{$tt[2]}','{$tt[3]}','{$tt[4]}','{$tt[5]}','{$tt[6]}','{$tt[7]}','{$tt[8]}','{$tt[9]}','{$tt[10]}','{$tt[11]}','{$tt[12]}','{$tt[13]}','{$tt[14]}','{$tt[15]}','{$tt[16]}','{$tt[17]}','{$tt[18]}','{$tt[19]}','{$tt[20]}','{$tt[21]}','{$tt[22]}','{$tt[23]}','{$tt[24]}','{$tt[25]}','{$tt[26]}','{$tt[27]}','{$tt[28]}','{$tt[29]}','{$tt[30]}','{$tt[31]}',now())
    	";
  		$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF']."?op=updata",4,_MA_SQL_ERROR);

		}
    $msg.=_MA_SQL_SAVEOK."<br> "._MA_OK." "._MA_LUNCH_UPDATA.--$i." "._MA_LUNCH_ITEMS."<br>".$err_msg." "._MA_LUNCH_HAVE." ".$j." "._MA_LUNCH_SQLMSG."<br>";
    fclose($fd);
    
	}

// 匯入樣版檔 
  if($act=="updata_temp"){

    $fd = fopen ("../sql/lunch_txt_{$xoopsConfig['language']}.csv","r") ;

		rewind($fd);
		$i=0; //存入筆數 
		$j=0; //錯誤筆數 
		while ($tt = fgetcsv ($fd, 2000, ",")) {
			if ($i++ == 0){ //第一筆為抬頭
				if(trim($tt[0])!=_MA_LUNCH_IN_ID || trim($tt[1])!=_MA_LUNCH_ADD_ID || trim($tt[2])!=_MA_LUNCH_NV  || trim($tt[3])!=_MA_LUNCH_ITEM || trim($tt[4])!=_MA_LUNCH_NUMBER || trim($tt[5])!=_MA_LUNCH_ADD_UNIT || trim($tt[6])!=_MA_LUNCH_ITEM || trim($tt[7])!=_MA_LUNCH_NUMBER || trim($tt[8])!=_MA_LUNCH_ADD_UNIT || trim($tt[9])!=_MA_LUNCH_ITEM || trim($tt[10])!=_MA_LUNCH_NUMBER || trim($tt[11])!=_MA_LUNCH_ADD_UNIT || trim($tt[12])!=_MA_LUNCH_ITEM || trim($tt[13])!=_MA_LUNCH_NUMBER || trim($tt[14])!=_MA_LUNCH_ADD_UNIT || trim($tt[15])!=_MA_LUNCH_ITEM || trim($tt[16])!=_MA_LUNCH_NUMBER || trim($tt[17])!=_MA_LUNCH_ADD_UNIT || trim($tt[18])!=_MA_LUNCH_ITEM || trim($tt[19])!=_MA_LUNCH_NUMBER || trim($tt[20])!=_MA_LUNCH_ADD_UNIT || trim($tt[21])!=_MA_LUNCH_ITEM || trim($tt[22])!=_MA_LUNCH_NUMBER || trim($tt[23])!=_MA_LUNCH_ADD_UNIT || trim($tt[24])!=_MA_LUNCH_ITEM || trim($tt[25])!=_MA_LUNCH_NUMBER || trim($tt[26])!=_MA_LUNCH_ADD_UNIT || trim($tt[27])!=_MA_LUNCH_ITEM || trim($tt[28])!=_MA_LUNCH_NUMBER || trim($tt[29])!=_MA_LUNCH_ADD_UNIT || trim($tt[30])!=_MA_LUNCH_ITEM || trim($tt[31])!=_MA_LUNCH_NUMBER || trim($tt[32])!=_MA_LUNCH_ADD_UNIT) redirect_header($_SERVER[PHP_SELF], 10, _MA_LUNCH_IN_ERR);
         	continue ;
			}

      if($tt[1] < 10 || $tt[1] > 99){
        $err_msg.=" "._MA_LUNCH_NUMBERS." ".$tt[0]." "._MA_LUNCH_NV." ".$tt[2]."<font color='red'> "._MA_LUNCH_TMPERRMSG." "._MA_LUNCH_UPDATA_README." !</font><br>";
        $j++;
        $i--;
        continue ;
     }

  		$sql="
    	replace into ".$xoopsDB->prefix("tad_lunch_dish")."
    	(id,kind,dish,item_name_1,item_number_1,item_unit_1,item_name_2,item_number_2,item_unit_2,item_name_3,item_number_3,item_unit_3,item_name_4,item_number_4,item_unit_4,item_name_5,item_number_5,item_unit_5,item_name_6,item_number_6,item_unit_6,item_name_7,item_number_7,item_unit_7,item_name_8,item_number_8,item_unit_8,item_name_9,item_number_9,item_unit_9,item_name_10,item_number_10,item_unit_10,change_date)
     	values
    	('{$tt[0]}','{$tt[1]}','{$tt[2]}','{$tt[3]}','{$tt[4]}','{$tt[5]}','{$tt[6]}','{$tt[7]}','{$tt[8]}','{$tt[9]}','{$tt[10]}','{$tt[11]}','{$tt[12]}','{$tt[13]}','{$tt[14]}','{$tt[15]}','{$tt[16]}','{$tt[17]}','{$tt[18]}','{$tt[19]}','{$tt[20]}','{$tt[21]}','{$tt[22]}','{$tt[23]}','{$tt[24]}','{$tt[25]}','{$tt[26]}','{$tt[27]}','{$tt[28]}','{$tt[29]}','{$tt[30]}','{$tt[31]}','{$tt[32]}',now())
    	";
  		$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF']."?op=updata",4,_MA_SQL_ERROR);

		}
    $msg.=_MA_SQL_SAVEOK."<br> "._MA_OK." "._MA_LUNCH_UPDATA.--$i." "._MA_LUNCH_ITEMS."<br>".$err_msg." "._MA_LUNCH_HAVE." ".$j." "._MA_LUNCH_SQLMSG."<br>";
    fclose($fd);
    
	}

//刪除 
if($act=="del_one"){
  $sql="delete from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$id}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF']."?op=add",3,_MA_DEL_SQL_ERROR);
  redirect_header($_SERVER['PHP_SELF']."?op=add",2,_MA_DEL_SQL_SAVEOK);
}

//修改 
if(isset($_POST['op_sql']) && ($_POST['op_sql'] == 'modify_one')){
  		$sql="
    	replace into ".$xoopsDB->prefix("tad_lunch_dish")."
    	(id,kind,dish,item_name_1,item_number_1,item_unit_1,item_name_2,item_number_2,item_unit_2,item_name_3,item_number_3,item_unit_3,item_name_4,item_number_4,item_unit_4,item_name_5,item_number_5,item_unit_5,item_name_6,item_number_6,item_unit_6,item_name_7,item_number_7,item_unit_7,item_name_8,item_number_8,item_unit_8,item_name_9,item_number_9,item_unit_9,item_name_10,item_number_10,item_unit_10,change_date)
     	values
    	('{$_POST['id']}','{$_POST['kind']}','{$_POST['dish']}','{$_POST['item_name_1']}','{$_POST['item_number_1']}','{$_POST['item_unit_1']}','{$_POST['item_name_2']}','{$_POST['item_number_2']}','{$_POST['item_unit_2']}','{$_POST['item_name_3']}','{$_POST['item_number_3']}','{$_POST['item_unit_3']}','{$_POST['item_name_4']}','{$_POST['item_number_4']}','{$_POST['item_unit_4']}','{$_POST['item_name_5']}','{$_POST['item_number_5']}','{$_POST['item_unit_5']}','{$_POST['item_name_6']}','{$_POST['item_number_6']}','{$_POST['item_unit_6']}','{$_POST['item_name_7']}','{$_POST['item_number_7']}','{$_POST['item_unit_7']}','{$_POST['item_name_8']}','{$_POST['item_number_8']}','{$_POST['item_unit_8']}','{$_POST['item_name_9']}','{$_POST['item_number_9']}','{$_POST['item_unit_9']}','{$_POST['item_name_10']}','{$_POST['item_number_10']}','{$_POST['item_unit_10']}',now())
    	";
  		$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF']."?op=add",4,_TAD_EDIT._MA_ERR);
      redirect_header($_SERVER['PHP_SELF']."?op=add",2,_TAD_EDIT._MA_OK);
}

//新增 
if(isset($_POST['op_sql']) && ($_POST['op_sql'] == 'add')){
  		$sql="
    	insert into ".$xoopsDB->prefix("tad_lunch_dish")."
    	(kind,dish,item_name_1,item_number_1,item_unit_1,item_name_2,item_number_2,item_unit_2,item_name_3,item_number_3,item_unit_3,item_name_4,item_number_4,item_unit_4,item_name_5,item_number_5,item_unit_5,item_name_6,item_number_6,item_unit_6,item_name_7,item_number_7,item_unit_7,item_name_8,item_number_8,item_unit_8,item_name_9,item_number_9,item_unit_9,item_name_10,item_number_10,item_unit_10,change_date)
     	values
    	('{$_POST['kind']}','{$_POST['dish']}','{$_POST['item_name_1']}','{$_POST['item_number_1']}','{$_POST['item_unit_1']}','{$_POST['item_name_2']}','{$_POST['item_number_2']}','{$_POST['item_unit_2']}','{$_POST['item_name_3']}','{$_POST['item_number_3']}','{$_POST['item_unit_3']}','{$_POST['item_name_4']}','{$_POST['item_number_4']}','{$_POST['item_unit_4']}','{$_POST['item_name_5']}','{$_POST['item_number_5']}','{$_POST['item_unit_5']}','{$_POST['item_name_6']}','{$_POST['item_number_6']}','{$_POST['item_unit_6']}','{$_POST['item_name_7']}','{$_POST['item_number_7']}','{$_POST['item_unit_7']}','{$_POST['item_name_8']}','{$_POST['item_number_8']}','{$_POST['item_unit_8']}','{$_POST['item_name_9']}','{$_POST['item_number_9']}','{$_POST['item_unit_9']}','{$_POST['item_name_10']}','{$_POST['item_number_10']}','{$_POST['item_unit_10']}',now())
    	";
  		$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF']."?op=add",4,_TAD_ADD._MA_ERR._MA_ID_README);
      redirect_header($_SERVER['PHP_SELF']."?op=add",2,_TAD_ADD._MA_OK);
}


/*-----------function區--------------*/


function add(){
  global $xoopsDB,$xoopsTpl;

  $jquery=get_jquery(true);  //TadTools引入jquery ui
  $xoopsTpl->assign('jquery',$jquery);

  
  
  //主食
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where kind between '10' and '19' order by kind";
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);

    
  $i=0;
  $all1="";
  while($food=$xoopsDB->fetchArray($result)){   
    $all1[$i]=$food;
    $i++;
  }
  $xoopsTpl->assign('all1',$all1);


  //菜色
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where kind between '20' and '29' order by kind";
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);

  $i=0;
  $all2="";
  while($food=$xoopsDB->fetchArray($result)){   
    $all2[$i]=$food;
    $i++;
  }
  $xoopsTpl->assign('all2',$all2);

  //湯
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where kind between '30' and '39' order by kind";
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);
  $i=0;
  $all3="";
  while($food=$xoopsDB->fetchArray($result)){   
    $all3[$i]=$food;
    $i++;
  }
  $xoopsTpl->assign('all3',$all3);



  //水果
	$sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where kind between '40' and '49' order by kind";
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);

  $i=0;
  $all4="";
  while($food=$xoopsDB->fetchArray($result)){   
    $all4[$i]=$food;
    $i++;
  }
  $xoopsTpl->assign('all4',$all4);


  //備註
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where kind between '50' and '99' order by kind";
	$result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MA_SQL_ERR);

  $i=0;
  $all5="";
  while($food=$xoopsDB->fetchArray($result)){   
    $all5[$i]=$food;
    $i++;
  }
  $xoopsTpl->assign('all5',$all5);
  
}


// 新增表單 
function add_one_form(){

//變數
global $xoopsDB;


$main.="
<form method='post' action='{$_SERVER['PHP_SELF']}'>
  <table width='' height='600' border='5' cellpadding='1' cellspacing='1' bgcolor='#99FF00'>
    <tr> 
      <td height='4%' align='center' colspan='2'> "._MA_LUNCH_ADD_ONE." ( "._MA_DISH_UNIT_README." )</td>
    </tr>
    <tr> 
       <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ID."</td>
      <td width='50%'>
      
      <select name='kind'>
      <option value='' selected></option>";
      
  $sql="select sn, name from ".$xoopsDB->prefix("tad_lunch_kind");
  $result=$xoopsDB->query($sql)or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  while($kind=$xoopsDB->fetchArray($result)){

  $main.="<option value='".$kind['sn']."'>".$kind['name']."</option>";

  }
      
$main.="</td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_DISH."</td>
      <td width='50%'><input name='dish' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_1."</td>
      <td width='50%'><input name='item_name_1' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_1' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_1' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_2."</td>
      <td width='50%'><input name='item_name_2' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_2' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_2' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_3."</td>
      <td width='50%'><input name='item_name_3' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_3' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_3' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_4."</td>
      <td width='50%'><input name='item_name_4' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_4' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_4' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_5."</td>
      <td width='50%'><input name='item_name_5' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_5' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_5' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_6."</td>
      <td width='50%'><input name='item_name_6' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_6' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_6' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_7."</td>
      <td width='50%'><input name='item_name_7' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_7' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_7' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_8."</td>
      <td width='50%'><input name='item_name_8' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_8' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_8' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_9."</td>
      <td width='50%'><input name='item_name_9' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_9' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_9' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_10."</td>
      <td width='50%'><input name='item_name_10' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_10' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_1o' value='' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='10%' align='center'><input type='reset' name='rewrite' value="._MA_LUNCH_RESET."></td>
      <td width='50%' height='10%' align='center'><input type='submit' name='save' value="._TAD_SAVE."></td>
    </tr>
  </table>
<input name='op_sql' type='hidden' value='add'>
</form>
  ";

  return $main;
}


// 修改表單 
function modify_one_form(){

//變數
global $xoopsDB;


// 取得修改該筆之資料 
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id='{$_REQUEST['op_id']}'";
  $result=$xoopsDB->query($sql)or redirect_header($_SERVER['PHP_SELF'],3,_MA_ERR);
  $food=$xoopsDB->fetchArray($result);


$main.="
<form method='post' action='{$_SERVER['PHP_SELF']}'>
  <table width='' height='600' border='5' cellpadding='1' cellspacing='1' bgcolor='#99FF00'>
    <tr> 
      <td height='4%' align='center' colspan='2'> ID $food[id] ( "._MA_DISH_UNIT_README." )</td>
    </tr>
    <tr> 
       <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ID."</td>
      <td width='50%'>
      
      <select name='kind'>
      <option value='".$food[kind]."' selected>".$food[kind]."</option>";
      
  $sql="select sn, name from ".$xoopsDB->prefix("tad_lunch_kind");
  $result_kind=$xoopsDB->query($sql)or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  while($kind=$xoopsDB->fetchArray($result_kind)){

  $main.="<option value='".$kind['sn']."'>".$kind['name']."</option>";

  }
      
$main.="</td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_DISH."</td>
      <td width='50%'><input name='dish' value='".$food[dish]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_1."</td>
      <td width='50%'><input name='item_name_1' value='".$food[item_name_1]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_1' value='".$food[item_number_1]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_1' value='".$food[item_unit_1]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_2."</td>
      <td width='50%'><input name='item_name_2' value='".$food[item_name_2]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_2' value='".$food[item_number_2]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_2' value='".$food[item_unit_2]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_3."</td>
      <td width='50%'><input name='item_name_3' value='".$food[item_name_3]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_3' value='".$food[item_number_3]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_3' value='".$food[item_unit_3]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_4."</td>
      <td width='50%'><input name='item_name_4' value='".$food[item_name_4]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_4' value='".$food[item_number_4]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_4' value='".$food[item_unit_4]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_5."</td>
      <td width='50%'><input name='item_name_5' value='".$food[item_name_5]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_5' value='".$food[item_number_5]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_5' value='".$food[item_unit_5]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_6."</td>
      <td width='50%'><input name='item_name_6' value='".$food[item_name_6]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_6' value='".$food[item_number_6]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_6' value='".$food[item_unit_6]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_7."</td>
      <td width='50%'><input name='item_name_7' value='".$food[item_name_7]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_7' value='".$food[item_number_7]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_7' value='".$food[item_unit_7]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_8."</td>
      <td width='50%'><input name='item_name_8' value='".$food[item_name_8]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_8' value='".$food[item_number_8]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_8' value='".$food[item_unit_8]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_9."</td>
      <td width='50%'><input name='item_name_9' value='".$food[item_name_9]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_9' value='".$food[item_number_9]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_9' value='".$food[item_unit_9]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#CCFF99'>"._MA_LUNCH_ADD_ITEM_10."</td>
      <td width='50%'><input name='item_name_10' value='".$food[item_name_10]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_NUMBER."</td>
      <td width='50%'><input name='item_number_10' value='".$food[item_number_10]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='3%' align='center' bgcolor='#FFFFFF'>"._MA_LUNCH_ADD_UNIT."</td>
      <td width='50%'><input name='item_unit_1o' value='".$food[item_unit_10]."' type='text' size='50' maxlength='30' style='font-size:16'></td>
    </tr>
    <tr> 
      <td width='50%' height='10%' align='center'><input type='reset' name='rewrite' value="._MA_LUNCH_RESET."></td>
      <td width='50%' height='10%' align='center'><input type='submit' name='save' value="._TAD_SAVE."></td>
    </tr>
  </table>
<input name='id' type='hidden' value='".$food[id]."'>
<input name='op_sql' type='hidden' value='modify_one'>
</form>
  ";

  return $main;
}

function updata(){
  global $xoopsConfig,$xoopsTpl;
  $xoopsTpl->assign('now_op','updata');
  $xoopsTpl->assign('language',$xoopsConfig['language']);
}


function updata_temp(){
  $main="
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr><td valign='top' bgcolor='#DFF8FF'>
		<font color='#FF0000'> "._MA_LUNCH_UPTEMP_README."<br>
    "._MA_LUNCH_UPTEMP_READMESURE."</font><br> 
			<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
			<input type='submit' value='"._MA_LUNCH_UPDATA_TEMP."'>
			<input type='hidden' name='act' value='updata_temp'><br>
			</form>
			</td>
		</tr>
		</table>";
	return $main;
}



/*-----------執行動作判斷區--------------*/
$op = (!isset($_REQUEST['op']))? "" :$_REQUEST['op'];

switch($op){

	case "add_one";	
  $main.=add_one_form();
	break;
	
	case "modify_one";	
  $main.=modify_one_form();
	break;

 	case "updata";	
  $main.=updata();
	break;

	case "updata_temp";	
  $main.=updata_temp();
	break;
	
	default:
  add();
	break;
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
