<?php
// $Id: ooo_ab_paper.php,v 1.7 2005/05/26 08:20:30 cvsjrh Exp $

include_once "ooo_class.php";


$array=array(
array("王大頭","7234451","a1@mail.tnc.edu.tw","台南縣佳里鎮安西里佳安東路6號"),
array("王二頭","7234452","a2@mail.tnc.edu.tw","台南縣佳里鎮安西里佳安東路7號"),
array("王三頭","7234453","a3@mail.tnc.edu.tw","台南縣佳里鎮安西里佳安東路8號"),
array("王四頭","7234454","a4@mail.tnc.edu.tw","台南縣佳里鎮安西里佳安東路9號"),
array("王小頭","7234455","a5@mail.tnc.edu.tw","台南縣佳里鎮安西里佳安東路10號"),
);


make_paper_ooo($array);

function  make_paper_ooo($array){

	$ooo_path="ooo/view";

	//新增一個  zipfile  實例
	$ttt  =  new  zipfile;

	if (is_dir($ooo_path)) {
		if ($dh = opendir($ooo_path)) {
			while (($file = readdir($dh)) !== false) {
				if($file=="." or $file==".." or $file=="content.xml"){
					continue;
				}elseif(is_dir($ooo_path."/".$file)){
					if($file=="Configurations2") $file_extname="ods";
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
	//讀出 content.xml
	$data = $ttt->read_file($ooo_path."/content.xml");
	//拆解 content.xml
	$arr1 = explode("<office:body>",$data);
	//檔頭
	$con_head = $arr1[0]."<office:body>";
	$arr2 = explode("</office:body>",$arr1[1]);
	//資料內容
	$con_body = $arr2[0];
	//檔尾
	$con_foot = "</office:body>".$arr2[1];


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

	//print_r($array);
	$loop_data="";
	$temp_arr_loop=array();
	foreach($array as $val){
		$temp_arr_loop['dish'] = $val[0] ;
		$temp_arr_loop['item_name1'] = $val[1] ;
		$temp_arr_loop['item_number1'] = $val[2] ;
		$temp_arr_loop['item_name2'] = $val[3] ;
		$loop_data.=$ttt->change_temp($temp_arr_loop,$loop_body,0);
		$temp_arr_loop=array();
	}

	$temp_arr=array();
	$temp_arr['school']="多魔國小";
	$temp_arr['class'] ="四年七班" ;
	$temp_arr['date'] =date("Y-m-d") ;
	$con1_data = $ttt->change_temp($temp_arr,$con1_body,0);
	$con2_data = $ttt->change_temp($temp_arr,$con2_body,0);

	
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
