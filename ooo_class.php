<?php
// $Id: sxsooo_class.php,v 1.5 2005/05/19 03:46:56 cvsjrh Exp $
/*
���� zip �� class
*/
class zipfile 
{ 
  var $datasec = [];
  var $ctrl_dir = [];
  var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00"; 
  var $old_offset = 0; 

function add_dir($name) 
    { 
        $name = str_replace("\\", "/", $name); 

        $fr = "\x50\x4b\x03\x04"; 
        $fr .= "\x0a\x00"; 
        $fr .= "\x00\x00"; 
        $fr .= "\x00\x00"; 
        $fr .= "\x00\x00\x00\x00"; 

        $fr .= pack("V",0); 
        $fr .= pack("V",0); 
        $fr .= pack("V",0); 
        $fr .= pack("v", strlen($name) ); 
        $fr .= pack("v", 0 ); 
        $fr .= $name; 
        $fr .= pack("V", 0); 
        $fr .= pack("V", 0); 
        $fr .= pack("V", 0); 

        $this -> datasec[] = $fr ;
        $new_offset = strlen(implode("", $this->datasec)); 

     $cdrec = "\x50\x4b\x01\x02"; 
     $cdrec .="\x00\x00"; 
     $cdrec .="\x0a\x00"; 
     $cdrec .="\x00\x00"; 
     $cdrec .="\x00\x00"; 
     $cdrec .="\x00\x00\x00\x00"; 
     $cdrec .= pack("V",0); 
     $cdrec .= pack("V",0); 
     $cdrec .= pack("V",0); 
     $cdrec .= pack("v", strlen($name) ); 
     $cdrec .= pack("v", 0 ); 
     $cdrec .= pack("v", 0 ); 
     $cdrec .= pack("v", 0 ); 
     $cdrec .= pack("v", 0 ); 
     $ext = "\x00\x00\x10\x00"; 
     $ext = "\xff\xff\xff\xff"; 
     $cdrec .= pack("V", 16 ); 
     $cdrec .= pack("V", $this -> old_offset ); 
     $cdrec .= $name; 

     $this -> ctrl_dir[] = $cdrec; 
     $this -> old_offset = $new_offset; 
     return; 
} 

function add_file($data, $name) { 
   $name = str_replace("\\", "/", $name); 
   $unc_len = strlen($data); 
   $crc = crc32($data); 
   $zdata = gzcompress($data); 
   $zdate = substr ($zdata, 2, -4); 
   $c_len = strlen($zdata);
   
   $fr = "\x50\x4b\x03\x04"; 
        $fr .= "\x14\x00"; 
        $fr .= "\x00\x00"; 
        $fr .= "\x08\x00"; 
        $fr .= "\x00\x00\x00\x00"; 
        $fr .= pack("V",$crc); 
        $fr .= pack("V",$c_len); 
        $fr .= pack("V",$unc_len); 
        $fr .= pack("v", strlen($name) ); 
        $fr .= pack("v", 0 ); 
        $fr .= $name; 
        $fr .= $zdate; 
        $fr .= pack("V",$crc); 
        $fr .= pack("V",$c_len); 
        $fr .= pack("V",$unc_len); 

        $this -> datasec[] = $fr; 
        $fr = "\x50\x4b\x03\x04"; 
        $fr .= "\x14\x00"; 
        $fr .= "\x00\x00"; 
        $fr .= "\x08\x00"; 
        $fr .= "\x00\x00\x00\x00"; 
        $fr .= pack("V",$crc); 
        $fr .= pack("V",$c_len); 
        $fr .= pack("V",$unc_len); 
        $fr .= pack("v", strlen($name) ); 
        $fr .= pack("v", 0 ); 
        $fr .= $name; 
        $fr .= $zdata; 
        $fr .= pack("V",$crc); 
        $fr .= pack("V",$c_len); 
        $fr .= pack("V",$unc_len); 

        $this -> datasec[] = $fr; 
        $new_offset = strlen(implode("", $this->datasec)); 

  $cdrec = "\x50\x4b\x01\x02"; 
  $cdrec .="\x00\x00"; 
  $cdrec .="\x14\x00"; 
  $cdrec .="\x00\x00"; 
  $cdrec .="\x08\x00"; 
  $cdrec .="\x00\x00\x00\x00"; 
  $cdrec .= pack("V",$crc); 
  $cdrec .= pack("V",$c_len); 
  $cdrec .= pack("V",$unc_len); 
  $cdrec .= pack("v", strlen($name) ); 
  $cdrec .= pack("v", 0 ); 
  $cdrec .= pack("v", 0 ); 
  $cdrec .= pack("v", 0 ); 
  $cdrec .= pack("v", 0 ); 
  $cdrec .= pack("V", 32 ); 
  $cdrec .= pack("V", $this -> old_offset ); 

  $this -> old_offset = $new_offset; 

  $cdrec .= $name; 
  $this -> ctrl_dir[] = $cdrec; 
} 

function addFileAndRead ($file) {

    if (is_file($file))
      $this->add_file($this->read_file($file), $file);

  }




function file() { 
        $data = implode("", $this -> datasec); 
        $ctrldir = implode("", $this -> ctrl_dir); 

        return 
            $data. 
            $ctrldir. 
            $this -> eof_ctrl_dir. 
            pack("v", sizeof($this -> ctrl_dir)). 
            pack("v", sizeof($this -> ctrl_dir)). 
            pack("V", strlen($ctrldir)). 
            pack("V", strlen($data)). 
            "\x00\x00"; 
    } 

function read_file($file) {

        if (!($fp = fopen($file, 'r' ))) return false;

        $contents = fread($fp, filesize($file));

        fclose($fp);

        return $contents;
}
//�ഫ�r��
function change_str($source,$is_reference=1){
        $temp_str = $source;
        if ($is_reference){
                $ttt='';
                for($i=0;$i<strlen($temp_str);$i++)
                        $ttt .= $this->xml_reference_change($temp_str[$i]);
                $temp_str = $ttt;
        }
        $temp_str=(tool::isutf8()) ? $this->spec_uni($temp_str) : iconv("Big5","UTF-8", $this->spec_uni($temp_str));
        return $temp_str;
                                                                                                                            
}


function change_temp($arr,$source,$is_reference=1) {
	$temp_str = $source;
	while(list($id,$val) = each($arr)){
		$val = (string)$val;
		if ($is_reference && $val<>''){
			$tttt='';
			for($i=0;$i<strlen($val);$i++)
				$tttt .= $this->xml_reference_change($val[$i]);
			$val = $tttt;
		}
		$id=$this->spec_uni($id);
		$val=$this->spec_uni($val);
		//$id =(tool::isutf8()) ? $id : iconv("Big5","UTF-8",$id);
		$id = iconv("Big5","UTF-8",$id);
		//$val =(tool::isutf8()) ? $val : iconv("Big5","UTF-8",$val);
		 $val = iconv("Big5","UTF-8",$val);
		$temp_str = str_replace("{".$id."}", $val,$temp_str);
	}
	return $temp_str;
}

//��s�ഫ �L���G unicode �ΰ}�C
function change_sigle_temp($arr,$source) {
	$temp_str = $source;
	while(list($id,$val) = each($arr)){
		$temp_str = str_replace($id, $val,$temp_str);
	}
	return $temp_str;
}

//�S���ഫ UTF-8�A�Ҳղ��͵{���|�Ψ�C
function change_temp2($arr,$source) {
	$temp_str = $source;
	while(list($id,$val) = each($arr)){
		//$val =iconv("Big5","UTF-8",$val);
		$temp_str = str_replace("{".$id."}", $val,$temp_str);
	}
	return $temp_str;
}

 //XML ����ѷ��ഫ
function xml_reference_change($text){
	$sw = ["&" =>"&amp;", "<" =>"&lt;", ">" =>"&gt;", "\"" =>"&quot;", "'" =>"&apos;"];
	$all_word=array_keys($sw);
	foreach($all_word as $spec_uni){
		$text=str_replace($spec_uni,$sw[$spec_uni],$text);
	}
	return $text;
}




//iconv �L�k�઺�r
function spec_uni($text=""){
	$sw["��"]="&#30849;";
	$sw["��"]="&#31911;";
	$sw["��"]="&#35023;";
	$sw["��"]="&#22715;";
	$sw["��"]="&#24658;";
	$sw["��"]="&#37561;";
	$sw["��"]="&#23290;";
	$sw["��"]="&#9556;";
	$sw["��"]="&#9574;";
	$sw["��"]="&#9559;";
	$sw["��"]="&#9568;";
	$sw["��"]="&#9580;";
	$sw["��"]="&#9571;";
	$sw["��"]="&#9562;";
	$sw["��"]="&#9577;";
	$sw["��"]="&#9565;";
	$sw["��"]="&#9554;";
	$sw["��"]="&#9572;";
	$sw["��"]="&#9557;";
	$sw["��"]="&#9566;";
	$sw["��"]="&#9578;";
	$sw["��"]="&#9569;";
	$sw["��"]="&#9560;";
	$sw["��"]="&#9575;";
	$sw["��"]="&#9563;";
	$sw["��"]="&#9555;";
	$sw["��"]="&#9573;";
	$sw["��"]="&#9558;";
	$sw["��"]="&#9567;";
	$sw["��"]="&#9579;";
	$sw["��"]="&#9570;";
	$sw["��"]="&#9561;";
	$sw["��"]="&#9576;";
	$sw["��"]="&#9564;";
	$sw["��"]="&#9553;";
	$sw["��"]="&#9552;";
	$sw["��"]="&#9556;";
	$sw["��"]="&#9559;";
	$sw["��"]="&#9562;";
	$sw["��"]="&#9565;";
	$sw["�i"]="&#9608;";
	$all_word=array_keys($sw);
	foreach($all_word as $spec_uni){
		$text=str_replace($spec_uni,$sw[$spec_uni],$text);
	}
	return $text;
}

	//�P�_�r��O�_��utf8
	function isutf8($str) {
		$i=0;
		$len = strlen($str);
	
		for ($i=0;$i<$len;$i++) {
			$sbit = ord(substr($str,$i,1));
			if ($sbit < 128) {
			
			} else if($sbit > 191 && $sbit < 224) {
				$i++;
			} else if($sbit > 223 && $sbit < 240) {
				$i+=2;
			} else if($sbit > 239 && $sbit < 248) {
				$i+=3;
			} else {
				return 0;
			}
		}
		return 1;
  }

	//�v�r�ഫutf8�r�ꬰbig5
	function utf8_2_big5($utf8_str) {
		$i=0;
		$len = strlen($utf8_str);
		$big5_str="";
		for ($i=0;$i<$len;$i++) {
			$sbit = ord(substr($utf8_str,$i,1));
			//echo $sbit."<br>";
			if ($sbit < 128) {
				$big5_str.=substr($utf8_str,$i,1);
			} else if($sbit > 191 && $sbit < 224) {
				$new_word=iconv("UTF-8","Big5",substr($utf8_str,$i,2));
				$big5_str.=($new_word=="")?"��":$new_word;
				//echo $big5_str."<br>";
				$i++;
			} else if($sbit > 223 && $sbit < 240) {
				$new_word=iconv("UTF-8","Big5",substr($utf8_str,$i,3));
				$big5_str.=($new_word=="")?"��":$new_word;
				$i+=2;
			} else if($sbit > 239 && $sbit < 248) {
				$new_word=iconv("UTF-8","Big5",substr($utf8_str,$i,4));
				$big5_str.=($new_word=="")?"��":$new_word;
				$i+=3;
			}
		}
		return $big5_str;
  } 

  
}

?>
