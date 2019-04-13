<?php
//�ޤJTadTools���禡�w
if (!file_exists(XOOPS_ROOT_PATH . '/modules/tadtools/tad_function.php')) {
    redirect_header('http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50', 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . '/modules/tadtools/tad_function.php';

/* ��ƨ��o�\�� */

//���o�Ǧ~�A��J���x�}
function get_gc_year($dar = '')
{
    $gc_year = ($dar[m] >= 8) ? $dar[y] - 1911 : ($dar[y] - 1911) - 1;

    return $gc_year;
}

//���o�Ǵ��A��J���x�}
function get_gc_seme($dar = '')
{
    $gc_seme = ($dar[m] >= 8 or $dar[m] <= 1) ? 1 : 2;

    return $gc_seme;
}

//�ɶ����

function DtoCh($dday = '', $st = '-')
{
    if (!$dday) { //�ϥιw�]���
        $dday = date('Y-m-j');
    }
    //��褸����אּ������  $st�����j�Ÿ�
    $tok = strtok($dday, $st);
    $i = 0;
    while ($tok) {
        $d[$i] = $tok;
        $tok = strtok($st);
        $i = $i + 1;
    }
    $d[0] = $d[0] - 1911;

    $cday = $d[0] . '-' . $d[1] . '-' . $d[2];

    return $cday;
}

//���o������x�}���
function ChtoD($dday = '', $st = '-')
{
    //��������אּ�褸���  $st�����j�Ÿ�
    $tok = strtok($dday, $st);
    $i = 0;
    while ($tok) {
        $d[$i] = $tok;
        $tok = strtok($st);
        $i = $i + 1;
    }
    $d[0] = $d[0] + 1911;

    $cday = $d[0] . '-' . $d[1] . '-' . $d[2];

    return $cday;
}

//�x�}���O���o�~�B��B�� d[y],d[m],d[d]
function DtoAr($dday = '', $st = '-')
{
    if (!$dday) { //�ϥιw�]���
        $dday = date('Y-m-j');
    }
    //��褸����אּ�x�}���O���o�~�B��B��  $st�����j�Ÿ�

    //  echo $dday;
    $tok = strtok($dday, $st);
    $i = 0;
    while ($tok) {
        if (0 == $i) {
            $j = 'y';
        }
        if (1 == $i) {
            $j = 'm';
        }
        if (2 == $i) {
            $j = 'd';
        }

        $d[$j] = $tok;

        $tok = strtok($st);
        $i = $i + 1;
    }

    return $d;
}

function GetdayAdd($dday, $dayn, $st = '-')
{
    //������[����
    $tok = strtok($dday, $st);
    $i = 0;
    while ($tok) {
        $d[$i] = $tok;
        $tok = strtok($st);
        $i = $i + 1;
    }

    return date('Y-m-d', mktime(0, 0, 0, $d[1], $d[2] + $dayn, $d[0]));
}

//���o�g��
//�b�d��~����(�H�Ǵ����D)�A�Ǧ^�Ȭ�0�A�H�P���鬰�C�g���Ĥ@�� �A�Ĥ@�g���_�l�g
function weeks_ok($date_b = '', $date_e = '')
{
    if (!empty($date_b) && !empty($date_e)) {
        $d_b = DtoAr($date_b);
        $d_e = DtoAr($date_e);
        if (($d_b > $d_e) || (($d_e[y] - $d_b[y]) > 1)) {
            redirect_header($_SERVER['PHP_SELF'], 2, _MD_HB_ERROR_WEEKS);
        } elseif ($d_b[y] == $d_e[y]) {
            $week_days = date('w', mktime(0, 0, 0, 01, 01, $d_b[y]));

            $weeks_1 = ceil((date('z', mktime(0, 0, 0, $d_b[m], $d_b[d], $d_b[y])) + $week_days + 1) / 7);
            $weeks_2 = ceil((date('z', mktime(0, 0, 0, $d_e[m], $d_e[d], $d_e[y])) + $week_days + 1) / 7);

            $weeks = $weeks_2 - $weeks_1 + 1;
        } else {
            $week_days = date('w', mktime(0, 0, 0, 01, 01, $d_b[y]));

            $weeks_1 = ceil((date('z', mktime(0, 0, 0, $d_b[m], $d_b[d], $d_b[y])) + $week_days + 1) / 7);

            $weeks_days_end = date('z', mktime(0, 0, 0, 12, 31, $d_b[y])) + $week_days + 1;
            $weeks_2 = ceil((date('z', mktime(0, 0, 0, $d_e[m], $d_e[d], $d_e[y])) + $weeks_days_end + 1) / 7);

            $weeks = $weeks_2 - $weeks_1 + 1;
        }
    }

    return $weeks;
}

/* -------------------------------------------------- *)
(* Num2CNum  �N���ԧB�Ʀr�ন����Ʀr�r��
(* �ϥΥܨ�:
(*   Num2CNum(10002.34) ==> �@�U�s�G�I�T�|
(*
(* Author: Wolfgang Chien <wolfgang@ms2.hinet.net>
(* Date: 1996/08/04
(* Update Date:
(* -------------------------------------------------- */

// (* �N�r��ϦV, �Ҧp: �ǤJ '1234', �Ǧ^ '4321' *)
function ConvertStr($sBeConvert)
{
    $tt = '';
    for ($x = mb_strlen($sBeConvert) - 1; $x >= 0; $x--) {
        $tt .= mb_substr($sBeConvert, $x, 1);
    }

    return $tt;
}

function Num2CNum($dblArabic, $ChineseNumeric = '')
{
    $encoding = 'UTF-8';

    if ('' == $ChineseNumeric) {
        $ChineseNumeric = _MD_N2CN_NUMS;
    }
    $result = '';
    $bInZero = true;
    $sArabic = $dblArabic;
    if ('-' == mb_substr($sArabic, 0, 1)) {
        $bMinus = true;
        $sArabic = mb_substr($sArabic, 1, 254);
    } else {
        $bMinus = false;
    }

    $iPosOfDecimalPoint = mb_strpos($sArabic, '.');  //(* ���o�p���I����m *)

    //(* ���B�z��ƪ����� *)
    if (0 == $iPosOfDecimalPoint) {
        $sIntArabic = ConvertStr($sArabic);
    } else {
        $sIntArabic = ConvertStr(mb_substr($sArabic, 0, $iPosOfDecimalPoint));
    }

    //(* �q�Ӧ�ư_�H�C�|��Ƭ��@�p�` *)

    for ($iSection = 0; $iSection <= (int)((mb_strlen($sIntArabic) - 1) / 4); $iSection++) {
        $sSectionArabic = mb_substr($sIntArabic, $iSection * 4, 4);
        $sSection = '';

        //  (* �H�U�� i ����: �ӤQ�ʤd��|�Ӧ�� *)
        for ($i = 0; $i < mb_strlen($sSectionArabic); $i++) {
            $iDigit = ord(mb_substr($sSectionArabic, $i, 1)) - 48;

            if (0 == $iDigit) {
                //(* 1. �קK '�s' �����ХX�{ *)
                //(* 2. �Ӧ�ƪ� 0 �����ন '�s' *)
                if (!$bInZero and 0 != $i) {
                    $sSection = _MD_N2CN_REZO . $sSection;
                }
                $bInZero = true;
            } else {
                switch ($i) {
                    case 1: $sSection = _MD_N2CN_TEN . $sSection;
                    break;
                    case 2: $sSection = _MD_N2CN_HUND . $sSection;
                    break;
                    case 3: $sSection = _MD_N2CN_THOU . $sSection;
                    break;
                }

                //  �P�_ UTF-8 ? BIG5 ?
                //				$sSection = substr($ChineseNumeric, 2 * $iDigit, 2).$sSection;
                /*			  if ( true === mb_check_encoding ( $ChineseNumeric, $encoding ) ){
                              // UTF-8 is 3 byts
                          $sSection = substr($ChineseNumeric, 3 * $iDigit, 3).$sSection;
                        }
                        else{
                        // BIG5 is 2 bytes
                          $sSection = substr($ChineseNumeric, 2 * $iDigit, 2).$sSection;
                        }

                  */

                $bInZero = false;
            }
        }

        //(* �[�W�Ӥp�`����� *)

        if (0 == mb_strlen($sSection)) {
            if (mb_strlen($result) > 0 and _MD_N2CN_REZO != mb_substr($result, 0, 2)) {
                $result = _MD_N2CN_REZO . $result;
            }
        } else {
            switch ($iSection) {
                case 0: $result = $sSection;
                break;
                case 1: $result = $sSection . _MD_N2CN_TENTHOU . $result;
                break;
                case 2: $result = $sSection . _MD_N2CN_HUNDTHOU . $result;
                break;
                case 3: $result = $sSection . _MD_N2CN_MIL . $result;
                break;
            }
        }
    }

    //(* �B�z�p���I�k�䪺���� *)
    if ($iPosOfDecimalPoint > 0) {
        $result .= _MD_N2CN_DOT;
        for ($i = $iPosOfDecimalPoint + 1; $i < mb_strlen($sArabic); $i++) {
            $iDigit = ord(mb_substr($sArabic, $i, 1)) - 48;
            $result .= mb_substr($ChineseNumeric, 2 * $iDigit, 2);
        }
    }

    //(* ��L�ҥ~���p���B�z *)
    if (0 == mb_strlen($result)) {
        $result = _MD_N2CN_REZO;
    }
    if (_MD_N2CN_ONETEN == mb_substr($result, 0, 4)) {
        $result = mb_substr($result, 2, 254);
    }

    if (_MD_N2CN_REZO == mb_substr($result, 0, 2)) {
        $result = _MD_N2CN_REZO . $result;
    }

    //(* �O�_���t�� *)
    if ($bMinus) {
        $result = _MD_N2CN_MIU . $result;
    }

    return $result;
}

function select_date_form($date)
{
    if (empty($date)) {
        $date = date('Y-m-d');
    }

    $main = "
  <script type='text/javascript' src='" . TADTOOLS_URL . "/My97DatePicker/WdatePicker.js'></script>
  <form method='post' action='{$_SERVER['PHP_SELF']}'>
    <div class='controls controls-row'>
    <input type='text' name='d_date' class='span4' value='{$date}' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\">
    
    <button type='submit' class='btn btn-info'>" . _MD_LUNCH_CHANGE_SUBMIT . '</button>
    </div>
  </form>
  ';

    return $main;
}

/* ��L */

//�i���v���P�_
function chk_power($gperm_name = '', $gperm_itemid = '')
{
    global $xoopsUser,$xoopsModule;
    if (empty($gperm_name) or empty($gperm_itemid)) {
        redirect_header($_SERVER['PHP_SELF'], 5, _MD_HB_CANT_GET_POWER);
    }
    //�ݨϥΪ̬O�ݩ󤰻�s��
    if (empty($xoopsUser)) {
        $groups_id_arr = [3];
    } else {
        $groups_id_arr = &$xoopsUser->getGroups();
    }
    //�ѪR�C�Ӹs��
    foreach ($groups_id_arr as $gperm_groupid) {
        //���w�ӳ��v���p�s�զW��
        $gperm_modid = $xoopsModule->mid();
        $gperm_handler = &xoops_getHandler('groupperm');
        $CR = $gperm_handler->checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid);
        if ($CR) {
            $IhaveRight = '1';

            return true;
        }
    }

    return false;
}

// show ������
function show_dish($g_date)
{
    //�ܼ�
    global $xoopsDB;
    $main = '';

    $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_main') . " where dates = '{$g_date}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    if ($food = $xoopsDB->fetchArray($result)) {
        // ����
        $main .= "<tr style='font-size:12px;'>
        <td>" . _MD_LUNCH_DISH_DISH . '</td><td>' . _MD_LUNCH_ITEM_1 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_2 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_3 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_4 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_5 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_6 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_7 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_8 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_9 . '</td><td>' . _MD_LUNCH_NUMBER . '</td><td>' . _MD_LUNCH_ITEM_10 . '</td><td>' . _MD_LUNCH_NUMBER . '</td>
        </tr>';
        if (!empty($food['staple_sn'])) {
            $main .= show_dish_items($food['staple_sn'], $food['numbers']);
        }
        if (!empty($food['dish1_sn'])) {
            $main .= show_dish_items($food['dish1_sn'], $food['numbers']);
        }
        if (!empty($food['dish2_sn'])) {
            $main .= show_dish_items($food['dish2_sn'], $food['numbers']);
        }
        if (!empty($food['dish3_sn'])) {
            $main .= show_dish_items($food['dish3_sn'], $food['numbers']);
        }
        if (!empty($food['dish4_sn'])) {
            $main .= show_dish_items($food['dish4_sn'], $food['numbers']);
        }
        if (!empty($food['dish5_sn'])) {
            $main .= show_dish_items($food['dish5_sn'], $food['numbers']);
        }
        if (!empty($food['soup_sn'])) {
            $main .= show_dish_items($food['soup_sn'], $food['numbers']);
        }
        if (!empty($food['fruit_sn'])) {
            $main .= show_dish_items($food['fruit_sn'], $food['numbers']);
        }
        if (!empty($food['rem_sn'])) {
            $main .= show_dish_items($food['rem_sn'], $food['numbers']);
        }
    }

    return $main;
}

// show ������ �l��
function show_dish_items($id, $num)
{
    //�ܼ�
    global $xoopsDB;

    $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$id}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    $food = $xoopsDB->fetchArray($result);
    $main .= "<tr style='font-size:12px;'>
        <td>" . $food[dish] . '</td><td>' . $food[item_name_1] . '</td><td>' . ($food[item_number_1] * $num / 100) . $food[item_unit_1] . '</td><td>' . $food[item_name_2] . '</td><td>' . ($food[item_number_2] * $num / 100) . $food[item_unit_2] . '</td><td>' . $food[item_name_3] . '</td><td>' . ($food[item_number_3] * $num / 100) . $food[item_unit_3] . '</td><td>' . $food[item_name_4] . '</td><td>' . ($food[item_number_4] * $num / 100) . $food[item_unit_4] . '</td><td>' . $food[item_name_5] . '</td><td>' . ($food[item_number_5] * $num / 100) . $food[item_unit_5] . '</td><td>' . $food[item_name_6] . '</td><td>' . ($food[item_number_6] * $num / 100) . $food[item_unit_6] . '</td><td>' . $food[item_name_7] . '</td><td>' . ($food[item_number_7] * $num / 100) . $food[item_unit_7] . '</td><td>' . $food[item_name_8] . '</td><td>' . ($food[item_number_8] * $num / 100) . $food[item_unit_8] . '</td><td>' . $food[item_name_9] . '</td><td>' . ($food[item_number_9] * $num / 100) . $food[item_unit_9] . '</td><td>' . $food[item_name_10] . '</td><td>' . ($food[item_number_10] * $num / 100) . $food[item_unit_10] . '</td>
        </tr>';

    return $main;
}

function print_content($content = '')
{
    //�H��y�覡�e�X  ooo.sxw
    if (mb_strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || mb_strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
        $mimeType = 'application/x-download';
    } elseif ('odt' == $file_extname) {
        $mimeType = 'application/vnd.oasis.opendocument.text';
    } else {
        $mimeType = 'application/vnd.sun.xml.writer';
    }
    header("Content-disposition:  attachment;  filename=$filename");
    header("Content-type:  $mimeType ");

    echo  $content;

    exit;
}

?> 
