<?php
// $Id: ooo_ab_paper.php,v 1.7 2005/05/26 08:20:30 cvsjrh Exp $

include_once "ooo_class.php";


$array= [
    ["���j�Y", "7234451", "a1@mail.tnc.edu.tw", "�x�n���Ψ���w�訽�Φw�F��6��"],
    ["���G�Y", "7234452", "a2@mail.tnc.edu.tw", "�x�n���Ψ���w�訽�Φw�F��7��"],
    ["���T�Y", "7234453", "a3@mail.tnc.edu.tw", "�x�n���Ψ���w�訽�Φw�F��8��"],
    ["���|�Y", "7234454", "a4@mail.tnc.edu.tw", "�x�n���Ψ���w�訽�Φw�F��9��"],
    ["���p�Y", "7234455", "a5@mail.tnc.edu.tw", "�x�n���Ψ���w�訽�Φw�F��10��"],
];


make_paper_ooo($array);

function  make_paper_ooo($array){

	$ooo_path="ooo/view";

	//�s�W�@��  zipfile  ���
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
	//Ū�X content.xml
	$data = $ttt->read_file($ooo_path."/content.xml");
	//��� content.xml
	$arr1 = explode("<office:body>",$data);
	//���Y
	$con_head = $arr1[0]."<office:body>";
	$arr2 = explode("</office:body>",$arr1[1]);
	//��Ƥ��e
	$con_body = $arr2[0];
	//�ɧ�
	$con_foot = "</office:body>".$arr2[1];


	//�}�l�M�θ��
	//����{�`���}�l}
	$p[0]="/(<table:table-row[^\>]*>{1})(<table:table-cell[^\>]*>{1})(<text:p[^>]*>{1})\{�`���}�l\}(<\/text:p><\/table:table-cell>)(<table:table-cell[^\>]*>)*(<\/table:table-row>)/";
	$p[1]="/(<table:table-row[^\>]*>{1})(<table:table-cell[^\>]*>{1})(<text:p[^>]*>{1})\{�`������\}(<\/text:p><\/table:table-cell>)(<table:table-cell[^\>]*>)*(<\/table:table-row>)/";

	$r[0]="starting";
	$r[1]="ending";

	$con_body =iconv("UTF-8","Big5",$con_body);
	$con_body=preg_replace($p,$r, $con_body);
	$con_body =iconv("Big5","UTF-8",$con_body);

	//���X�`�����e
	$arr_a=explode("starting",$con_body);
	$arr_b=explode("ending",$arr_a[1]);
	$con1_body=$arr_a[0];
	$loop_body=$arr_b[0];
	$con2_body=$arr_b[1];	

	//print_r($array);
	$loop_data="";
	$temp_arr_loop= [];
	foreach($array as $val){
		$temp_arr_loop['dish'] = $val[0] ;
		$temp_arr_loop['item_name1'] = $val[1] ;
		$temp_arr_loop['item_number1'] = $val[2] ;
		$temp_arr_loop['item_name2'] = $val[3] ;
		$loop_data.=$ttt->change_temp($temp_arr_loop,$loop_body,0);
		$temp_arr_loop= [];
	}

	$temp_arr= [];
	$temp_arr['school']="�h�]��p";
	$temp_arr['class'] ="�|�~�C�Z" ;
	$temp_arr['date'] =date("Y-m-d") ;
	$con1_data = $ttt->change_temp($temp_arr,$con1_body,0);
	$con2_data = $ttt->change_temp($temp_arr,$con2_body,0);

	
	if($file_extname=="ods") $filename="ooo2.ods";
	else $filename="ooo.sxc";

	$replace_data = $con_head.$con1_data.$loop_data.$con2_data.$con_foot;
	
	//��@�Ǧh�l�����ҥH�ťը��N
	$pattern[0]="/\{([^\}]*)\}/";
	$pattern[1]="/starting/";
	$pattern[2]="/ending/";
	$replacement[0]="";
	$replacement[1]="";
	$replacement[2]="";
	$replace_data=preg_replace($pattern, $replacement, $replace_data);
	$replace_data=str_replace ('<br />', '</text:p><text:p>', $replace_data);

	$ttt->add_file($replace_data,"content.xml");

	//����  zip  ��
	$sss  =  $ttt->file();

	//�H��y�覡�e�X  ooo.sxw
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
