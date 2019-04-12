<?php
/*-----------�ޤJ�ɮװ�--------------*/
include "header.php";
include_once XOOPS_ROOT_PATH."/header.php";


include_once "ooo_class.php";


//�ϥ��v�� 
if(!chk_power("tad_lunch","1"))redirect_header(XOOPS_URL,3,_MD_LUNCH_NO_POWER);


//�w�q�ܼ�
$g_date = date(y-m-d);
$g_date = $_GET['pdf_date'];

//�g�����ܼ�
$weeks = "";


//��������o
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


//���o������x�}��� 
$d_ar = DtoAr($week_day);


// ���o ooo config
// ���o�ǮզW��
$title_c=$xoopsModuleConfig['title']." "._MD_P_WEEK_TITLE;
$a_title[1]=$title_c;
// ���o�Ǧ~ 
$str_title2 = Num2CNum(get_gc_year($d_ar))." "._MD_LUNCH_SY." "._MD_LUNCH_S1." ".Num2CNum(get_gc_seme($d_ar))." ". _MD_LUNCH_S2." ".$weeks_show;
$a_title[2]= $str_title2;
$a_title[3]= $xoopsModuleConfig['master'];
$a_title[4]= $xoopsModuleConfig['secretary'];

// ooo table
for($i = 0 ; $i < 7 ; $i++){
  $ddate = GetdayAdd($week_day ,$i);
  $d = DtoAr($ddate);

// ooo table title ���o��� 
  $a_date[$i]= Num2CNum((int)$d[m])." "._MD_LUNCH_M." ".Num2CNum((int)$d[d])." "._MD_LUNCH_D;

// �C���� 
  $sql="select * from ".$xoopsDB->prefix("tad_lunch_main")." where dates = '{$ddate}'";
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
  if($food=$xoopsDB->fetchArray($result)){
    
// pdf show_dish_items ���� 
    if(!empty($food["staple_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["staple_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);

      $a_staple[$i]= $food_ooo[dish];    
    }
    if(!empty($food["dish1_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish1_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $dish_food = $food_ooo[dish];

    }    
    if(!empty($food["dish2_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish2_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $dish_food .= "</text:p>  <text:p text:style-name='P9'>".$food_ooo[dish];

    }    
    if(!empty($food["dish3_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish3_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $dish_food .= "</text:p>  <text:p text:style-name='P9'>".$food_ooo[dish];
      
    }    
    if(!empty($food["dish4_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish4_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $dish_food .= "</text:p>  <text:p text:style-name='P9'>".$food_ooo[dish];
      
    }    
    if(!empty($food["dish5_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["dish5_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $dish_food .= "</text:p>  <text:p text:style-name='P9'>".$food_ooo[dish];
       
    }
    
    $a_dish[$i] = $dish_food;
        
    if(!empty($food["soup_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["soup_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $a_soup[$i] = $food_ooo[dish]; 

    }    
    if(!empty($food["fruit_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["fruit_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $a_fruit[$i] = $food_ooo[dish]; 

    }    
    if(!empty($food["rem_sn"])){
      $sql="select * from ".$xoopsDB->prefix("tad_lunch_dish")." where id = '{$food["rem_sn"]}'";
      $result_ooo=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3,_MD_SQL_ERROR);
      $food_ooo=$xoopsDB->fetchArray($result_ooo);
  
      $a_rem[$i] = $food_ooo[dish]; 

    }    
  }

};



$array= [$a_title, $a_date, $a_staple, $a_dish, $a_soup, $a_fruit, $a_rem];

//print_r($array);  

make_paper_ooo($array);

function  make_paper_ooo($array){

	$ooo_path="ooo/week";

	//�s�W�@��  zipfile  ���
	$ttt  =  new  zipfile;

	if (is_dir($ooo_path)) {
		if ($dh = opendir($ooo_path)) {
			while (($file = readdir($dh)) !== false) {
				if($file=="." or $file==".." or $file=="content.xml"){
					continue;
				}elseif(is_dir($ooo_path."/".$file)){
					if($file=="Configurations2") $file_extname="odt";
					if ($dh2 = opendir($ooo_path."/".$file)) {
						while (($file2 = readdir($dh2)) !== false) {
							if($file2=="." or $file2==".."){
								continue;
							}else{
								$data = $ttt->read_file($ooo_path."/".$file."/".$file2);
								$ttt->add_file($data,$file."/".$file2);
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
	//Ū�X content.xml
	$data = $ttt->read_file($ooo_path."/content.xml");
	//�[�J���� tag
    if($file_extname=="odt"){
        //��� content.xml
        $arr1 = explode("<office:body><office:text>",$data);
        //���Y
        $con_head = $arr1[0]."<office:body><office:text>";
        $arr2 = explode("</office:text></office:body>",$arr1[1]);
        //��Ƥ��e
        $con_body = $arr2[0];
        //�ɧ�
        $con_foot = "</office:text></office:body>".$arr2[1];
    }else{
        //��� content.xml
        $arr1 = explode("<office:body>",$data);
        //���Y
        $con_head = $arr1[0]."<office:body>";
        $arr2 = explode("</office:body>",$arr1[1]);
        //��Ƥ��e
        $con_body = $arr2[0];
        //�ɧ�
        $con_foot = "</office:body>".$arr2[1];
    }


// ��X ooo �ܼ�
// ��X ooo title
	$temp_arr['school'] =$array[0][1];
	$temp_arr['date-title'] =$array[0][2];
  $temp_arr['mastername'] =$array[0][3];
  $temp_arr['activename'] =$array[0][4];
  	
// ��X ooo �j��
  for($j=0; $j<7; $j++){
    $date_c="date".$j;
    $staple_c="staple".$j;
    $dish_c="dish".$j;
    $soup_c="soup".$j;
    $fruit_c="fruit".$j;
    $rem_c="rem".$j;
     	
  	$temp_arr[$date_c]   =$array[1][$j];
  	$temp_arr[$staple_c] =$array[2][$j];
  	$temp_arr[$dish_c]   =$array[3][$j];
  	$temp_arr[$soup_c]   =$array[4][$j];
  	$temp_arr[$fruit_c]  =$array[5][$j];
  	$temp_arr[$rem_c]    =$array[6][$j];
  	
  };	

	$replace_data .= $ttt->change_temp($temp_arr,$con_body,0);

	
	if($file_extname=="odt") $filename="lunch.odt";
	else $filename="ooo.sxw";

	$replace_data = $con_head.$replace_data.$con_foot;

	//��@�Ǧh�l�����ҥH�ťը��N
	
	$pattern[]="/\{([^\}]*)\}/";
	$replacement[]="";

	$replace_data=preg_replace($pattern, $replacement, $replace_data);
	$replace_data=str_replace ('<br />', '</text:p><text:p text:style-name=\'Standard\'>', $replace_data);

	$ttt->add_file($replace_data,"content.xml");

	//����  zip  ��
	$sss  =  $ttt->file();

	//�H��y�覡�e�X  ooo.sxw
	if(strpos($_SERVER['HTTP_USER_AGENT'] , 'MSIE') || strpos($_SERVER['HTTP_USER_AGENT'] , 'Opera')) $mimeType="application/x-download";
	elseif($file_extname=="odt") $mimeType="application/vnd.oasis.opendocument.text";
	else $mimeType="application/vnd.sun.xml.writer";
	header("Content-disposition:  attachment;  filename=$filename");
	header("Content-type:  $mimeType ");

	echo  $sss;

	exit;
	return;
}

?>
