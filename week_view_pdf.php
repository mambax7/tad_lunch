<?php
/*-----------引入檔案區--------------*/
include 'header.php';
include_once XOOPS_ROOT_PATH . '/header.php';

//使用權限
if (!chk_power('tad_lunch', '4')) {
    redirect_header(XOOPS_URL, 3, _MD_LUNCH_NO_POWER);
}

//定義變數
$g_date = date(y - m - d);
$g_date = $_GET['pdf_date'];

//週次的變數
$weeks = '';

//日期的取得
if (empty($g_date)) {
    $g_date = date('Y-m-d');
    $week_days = date('w');
    $week_day = GetdayAdd($g_date, -$week_days);
} else {
    $d = DtoAr($g_date);
    $week_days = date('w', mktime(0, 0, 0, $d[m], $d[d], $d[y]));
    $days = $days - $week_days;
    $week_day = GetdayAdd($g_date, $days);
}

//週次的變數處理
//學期初，學期末，同週都算
//學期初，那個星期的第一天
  $d = DtoAr($xoopsModuleConfig['date_b']);
  $week_days = date('w', mktime(0, 0, 0, $d[m], $d[d], $d[y]));
  $seme_week_day = GetdayAdd($xoopsModuleConfig['date_b'], -$week_days);
if (($week_day >= $seme_week_day) & ($week_day <= $xoopsModuleConfig['date_e'])) {
    $weeks = weeks_ok($seme_week_day, $week_day);
    $weeks_show = _MD_LUNCH_S1 . '' . Num2CNum($weeks) . '' . _MD_LUNCH_SW;
} else {
    $weeks = '';
    $weeks_show = '';
}

//取得日期的矩陣函數
$d_ar = DtoAr($week_day);

// pdf head
require('fpdf/chinese.php');

$pdf = new PDF_Chinese();
$pdf->AddBig5hwFont();
$pdf->Open();
$pdf->SetSubject('week_lunch');
$pdf->SetTitle('week_lunch');
$pdf->SetAuthor($xoopsModuleConfig['secretary']);
$pdf->SetMargins(15, 10, 15);
$pdf->AddPage('L', 'mm', 'A4');

// pdf body
$pdf->SetFont('Big5-hw', 'BU', 30);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(0, 25, $xoopsModuleConfig['title'] . _MD_P_WEEK_TITLE, 0, 1, 'C');

// pdf title 取得學年
$str_title2 = Num2CNum(get_gc_year($d_ar)) . ' ' . _MD_LUNCH_SY . ' ' . _MD_LUNCH_S1 . ' ' . Num2CNum(get_gc_seme($d_ar)) . ' ' . _MD_LUNCH_S2 . ' ' . $weeks_show;
$pdf->SetFont('Big5-hw', 'B', 25);

$pdf->Cell(0, 20, $str_title2, 0, 1, 'C');

// pdf table
for ($i = 0; $i < 7; $i++) {
    $ddate = GetdayAdd($week_day, $i);
    $d = DtoAr($ddate);

    // pdf table title 取得日期
    $pdf->SetFont('Big5-hw', 'B', 16);
    $pdf->Cell(270, 10, Num2CNum((int)$d[m]) . ' ' . _MD_LUNCH_M . ' ' . Num2CNum((int)$d[d]) . ' ' . _MD_LUNCH_D . ' ' . $weeks_arr[$i], 1, 1, 'C');

    // 每日菜色
    $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_main') . " where dates = '{$ddate}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    if ($food = $xoopsDB->fetchArray($result)) {
        // 項目 title
        $pdf->SetFont('Big5-hw', 'B', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(225, 225, 255);
        $pdf->Cell(20, 10, _MD_LUNCH_DISH_DISH, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_1, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_2, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_3, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_4, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_5, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_6, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_7, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_8, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_9, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 0, 'C', 1);
        $pdf->Cell(15, 10, _MD_LUNCH_ITEM_10, 1, 0, 'C', 1);
        $pdf->Cell(10, 10, _MD_LUNCH_NUMBER, 1, 1, 'C', 1);

        $pdf->SetFont('Big5-hw', '', 9);

        // pdf show_dish_items 材料
        if (!empty($food['staple_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['staple_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['dish1_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['dish1_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['dish2_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['dish2_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['dish3_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['dish3_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['dish4_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['dish4_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['dish5_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['dish5_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['soup_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['soup_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['fruit_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['fruit_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
        if (!empty($food['rem_sn'])) {
            $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_dish') . " where id = '{$food['rem_sn']}'";
            $result_pdf = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
            $food_pdf = $xoopsDB->fetchArray($result_pdf);

            $pdf->Cell(20, 10, $food_pdf[dish], 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_1], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_1] * $food[numbers] / 100) . $food_pdf[item_unit_1]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_2], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_2] * $food[numbers] / 100) . $food_pdf[item_unit_2]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_3], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_3] * $food[numbers] / 100) . $food_pdf[item_unit_3]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_4], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_4] * $food[numbers] / 100) . $food_pdf[item_unit_4]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_5], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_5] * $food[numbers] / 100) . $food_pdf[item_unit_5]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_6], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_6] * $food[numbers] / 100) . $food_pdf[item_unit_6]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_7], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_7] * $food[numbers] / 100) . $food_pdf[item_unit_7]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_8], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_8] * $food[numbers] / 100) . $food_pdf[item_unit_8]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_9], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_9] * $food[numbers] / 100) . $food_pdf[item_unit_9]), 1, 0, 'C');
            $pdf->Cell(15, 10, $food_pdf[item_name_10], 1, 0, 'C');
            $pdf->Cell(10, 10, (($food_pdf[item_number_10] * $food[numbers] / 100) . $food_pdf[item_unit_10]), 1, 1, 'C');
        }
    }

    $pdf->Ln();
}

// pdf body foot
$pdf->SetFont('Big5-hw', 'B', 20);
$pdf->Cell(30, 25, _MD_P_MASTER, 0, 0, 'C');
$pdf->SetFont('Big5-hw', '', 18);
$master = ($xoopsModuleConfig[master_j]) ? $xoopsModuleConfig['master'] : '';
$pdf->Cell(50, 25, $master, 0, 0, 'L');

$pdf->SetFont('Big5-hw', 'B', 20);
$pdf->Cell(40, 25, _MD_P_SECRETARY, 0, 0, 'C');
$pdf->SetFont('Big5-hw', '', 18);
$secretary = ($xoopsModuleConfig[secretary_j]) ? $xoopsModuleConfig['secretary'] : '';
$pdf->Cell(50, 25, $secretary, 0, 0, 'L');

$pdf->SetFont('Big5-hw', 'B', 20);
$pdf->Cell(30, 25, _MD_P_DESIGN, 0, 0, 'C');
$pdf->SetFont('Big5-hw', '', 18);
$pdf->Cell(50, 25, '', 0, 0, 'L');

/*-----------秀出結果區--------------*/
//輸出PDF
$pdf->Output();
