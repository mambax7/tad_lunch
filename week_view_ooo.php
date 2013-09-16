<?php
/*-----------引入檔案區--------------*/
include "header.php";
include_once XOOPS_ROOT_PATH."/header.php";


include_once "ooo_class.php";


//使用權限 
if(!chk_power("tad_lunch","4"))redirect_header(XOOPS_URL,3,_MD_LUNCH_NO_POWER);


//定義變數
$g_date = date(y-m-d);
$g_date = $_GET['pdf_date'];

//週次的變數
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
  $weeks_show = _MD_LUNCH_S1."".Num2CNum($weeks).""._MD_LUNCH_SW; 
}else{
  $weeks = ""; 
  $weeks_show = "";
}


//取得日期的矩陣函數 
$d_ar = DtoAr($week_day);


// 取得 ooo config
// 取得學校名稱
$title_c=$xoopsModuleConfig['title']." "._MD_P_WEEK_TITLE;
$a_title[0]=$title_c;
// 取得學年 
$str_title2 = Num2CNum(get_gc_year($d_ar))." "._MD_LUNCH_SY." "._MD_LUNCH_S1." ".Num2CNum(get_gc_seme($d_ar))." ". _MD_LUNCH_S2." ".$weeks_show;
$a_title[1]= $str_title2;
$a_title[2]= $xoopsModuleConfig['master'];
$a_title[3]= $xoopsModuleConfig['secretary'];

// ooo table
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);

// ooo table title 取得日期 
  $a_date[$i]= Num2CNum((int)$d[m])." "._MD_LUNCH_M." ".Num2CNum((int)$d[d])." "._MD_LUNCH_D." ";

// 每日菜色 
// $k 代表每日第 k 道菜
 $k=0;
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates = '{$ddate}'";
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  if($food=$xoopsDB->fetchArray($result)){
    
// ooo show_dish_items 材料 
    if(!empty($food["staple_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["staple_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);

      $array[$i][$k][0]= $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;
    }
    
    if(!empty($food["dish1_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish1_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;
    }
        
    if(!empty($food["dish2_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish2_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;
    }
        
    if(!empty($food["dish3_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish3_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;  
    }
        
    if(!empty($food["dish4_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish4_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;  
    }
        
    if(!empty($food["dish5_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish5_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit];
    }
    $k++;   
    }
 
    if(!empty($food["soup_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["soup_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish];
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit]; 
    }
    $k++;
    }
        
    if(!empty($food["fruit_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["fruit_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish]; 
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit]; 
    }
    $k++; 
    }
       
    if(!empty($food["rem_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["rem_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $array[$i][$k][0] = $food_ooo[dish]; 
      for($j=1;$j<11;$j++){
        $item_name="item_name_".$j;
        $item_number="item_number_".$j;
        $item_unit="item_unit_".$j;
        $array[$i][$k][1][$j]= $food_ooo[$item_name];
        $array[$i][$k][2][$j]= ($food_ooo[$item_number]*$food[numbers]/100).$food_ooo[$item_unit]; 
    } 
    }    
  }

};


$array_context=array($a_title,$a_date,$weeks_arr);


// print_r($array);  
//print_r($array_context);  
//exit;
 make_paper_ooo($array,$array_context);
//make_paper_ooo($array_context);

function  make_paper_ooo($array,$array_context){

	$ooo_path="ooo/view";

	//新增一個  zipfile  實例
	$ttt  =  new  zipfile;

	if (is_dir($ooo_path)) {
        if ($dh = opendir($ooo_path)) {
            while (($file = readdir($dh)) !== false) {
            	preg_match('/^(.)+\.odt$/',$file,$matches);
                if($file=="." or $file==".." or $file=="content.xml" or $matches[0]){
                    continue;
                }elseif(is_dir($ooo_path."/".$file)){
                    if($file=="Configurations2") $file_extname="odt";
                    if ($dh2 = opendir($ooo_path."/".$file)) {
                        while (($file2 = readdir($dh2)) !== false) {
                            if($file2=="." or $file2==".."){
                                continue;
                            }else{
                            	if($dh3 = opendir($ooo_path."/".$file."/".$file2)){
                            		while (($file3 = readdir($dh3)) !== false) {
                            			if($file3=="." or $file3==".."){
                                			//continue;
                            			}else{
                            				$data = $ttt->read_file($ooo_path."/".$file."/".$file2."/".$file3);
                                			$ttt->add_file($data,$file."/".$file2."/".$file3);
                            			}
                            		}
                            		 closedir($dh3);
                            	}else{
                                	$data = $ttt->read_file($ooo_path."/".$file."/".$file2);
                                	$ttt->add_file($data,$file."/".$file2);
                                }
                            }
                        }
                        closedir($dh2);
                    }
                }else{
                    $data = $ttt->read_file($ooo_path."/".$file);
                    $ttt->add_file($data,$file);
                }
            }
            closedir($dh);
        }
    }
	//讀出 content.xml
	$data = $ttt->read_file($ooo_path."/content.xml");
	//拆解 content.xml
	$arr1 = explode("<office:spreadsheet>",$data);
	//檔頭
	$con_head = $arr1[0]."<office:spreadsheet>";
	$arr2 = explode("</office:spreadsheet>",$arr1[1]);
	//資料內容
	$con_body = $arr2[0];
	//檔尾    換資料表需 </table:table></office:spreadsheet>
	$con_foot = "</office:spreadsheet>".$arr2[1];

// 處理 table sheet  spreadsheet
//  $bod_arr = explode("<table:table ",$con_body);
//  $tab_head=$bod_arr[0];
//  $bod_arr = explode("<table:table>",$bod_arr[1]);

	//開始套用資料
	//替換{循環開始}
	$p[0]="/(<table:table-row[^\>]*>{1})(<table:table-cell[^\>]*>{1})(<text:p[^>]*>{1})\{循環開始\}(<\/text:p><\/table:table-cell>)(<table:table-cell[^\>]*>)*(<\/table:table-row>)/";
	$p[1]="/(<table:table-row[^\>]*>{1})(<table:table-cell[^\>]*>{1})(<text:p[^>]*>{1})\{循環結束\}(<\/text:p><\/table:table-cell>)(<table:table-cell[^\>]*>)*(<\/table:table-row>)/";

	$r[0]="starting";
	$r[1]="ending";

	$con_body =iconv("UTF-8","Big5",$con_body);
	$con_body=preg_replace($p,$r, $con_body);
	$con_body =iconv("Big5","UTF-8",$con_body);

	//取出循環內容
	$arr_a=explode("starting",$con_body);
	$arr_b=explode("ending",$arr_a[1]);
	$con1_body=$arr_a[0];
	$loop_body=$arr_b[0];
	$con2_body=$arr_b[1];	

//  echo "<pre>";
//	print_r($array);
//	echo "</pre>";
//	exit;
	$loop_data="";
	$temp_arr_loop=array();
	foreach($array[0] as $val){
		$temp_arr_loop['dish'] = $val[0];
		$temp_arr_loop['item_name1'] = $val[1][1];
		$temp_arr_loop['item_number1'] = $val[2][1];
		
		$temp_arr_loop['item_name2'] = $val[1][2];
		$temp_arr_loop['item_number2'] = $val[2][2];
		
		$temp_arr_loop['item_name3'] = $val[1][3];
		$temp_arr_loop['item_number3'] = $val[2][3];
		
		$temp_arr_loop['item_name4'] = $val[1][4];
		$temp_arr_loop['item_number4'] = $val[2][4];
		
		$temp_arr_loop['item_name5'] = $val[1][5];
		$temp_arr_loop['item_number5'] = $val[2][5];
		
		$temp_arr_loop['item_name6'] = $val[1][6];
		$temp_arr_loop['item_number6'] = $val[2][6];
		
		$temp_arr_loop['item_name7'] = $val[1][7];
		$temp_arr_loop['item_number7'] = $val[2][7];
		
		$temp_arr_loop['item_name8'] = $val[1][8];
		$temp_arr_loop['item_number8'] = $val[2][8];
		
		$temp_arr_loop['item_name9'] = $val[1][9];
		$temp_arr_loop['item_number9'] = $val[2][9];
    		
		$temp_arr_loop['item_name10'] = $val[1][10];
		$temp_arr_loop['item_number10'] = $val[2][10];
    		
 		$loop_data.=$ttt->change_temp($temp_arr_loop,$loop_body,0);
	}
	

	$temp_arr=array();
	$temp_arr['tittle']=$array_context[0][0];
	$temp_arr['seme_week'] =$array_context[0][1];
	$temp_arr['date0'] =$array_context[1][0];
	$temp_arr['weekday'] =$array_context[2][0];	
	$temp_arr['master'] =$array_context[0][2];
	$temp_arr['secret'] =$array_context[0][3];
	$con1_data = $ttt->change_temp($temp_arr,$con1_body,0);
	$con2_data = $ttt->change_temp($temp_arr,$con2_body,0);

//echo $loop_data;
//exit;

	
	if($file_extname=="ods") $filename="ooo2.ods";
	else $filename="ooo.sxc";

	$replace_data = $con_head.$con1_data.$loop_data.$con2_data.$con_foot;
	
	//把一些多餘的標籤以空白取代
	$pattern[0]="/\{([^\}]*)\}/";
	$pattern[1]="/starting/";
	$pattern[2]="/ending/";
	$replacement[0]="";
	$replacement[1]="";
	$replacement[2]="";
	$replace_data=preg_replace($pattern, $replacement, $replace_data);
	$replace_data=str_replace ('<br />', '</text:p><text:p>', $replace_data);

	$ttt->add_file($replace_data,"content.xml");

	//產生  zip  檔
	$sss  =  $ttt->file();

	//以串流方式送出  ooo.sxw
	if(strpos($_SERVER['HTTP_USER_AGENT'] , 'MSIE') || strpos($_SERVER['HTTP_USER_AGENT'] , 'Opera')) $mimeType="application/x-download";
	elseif($file_extname=="odt") $mimeType="application/vnd.oasis.opendocument.spreadsheet";
	else $mimeType="application/vnd.sun.xml.calc";
	header("Content-disposition:  attachment;  filename=$filename");
	header("Content-type:  $mimeType ");

	echo  $sss;

	exit;
	return;
}
?>
