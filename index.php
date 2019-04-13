<?php
/*-----------引入檔案區--------------*/
include 'header.php';
$xoopsOption['template_main'] = 'tad_lunch_index.html';
include_once XOOPS_ROOT_PATH . '/header.php';

/*-----------function區--------------*/

//第一個參數是指定日期，第二個參數是往前或往後的日數
function show_main($g_date = '', $days = '0')
{
    global $xoopsDB,$weeks_arr,$xoopsModuleConfig,$xoopsTpl;

    $read_power = chk_power('tad_lunch', '1');
    $xoopsTpl->assign('read_power', $read_power);

    $weeks = '';
    // 日期的取得
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

    $xoopsTpl->assign('week_day', $week_day);
    $xoopsTpl->assign('rem', $rem);

    // echo $g_date;

    //週次的變數處理
    //學期初，學期末，同週都算
    //學期初，那個星期的第一天
    $d = DtoAr($xoopsModuleConfig['date_b']);
    $week_days = date('w', mktime(0, 0, 0, $d[m], $d[d], $d[y]));
    $seme_week_day = GetdayAdd($xoopsModuleConfig['date_b'], -$week_days);
    if (($week_day >= $seme_week_day) & ($week_day <= $xoopsModuleConfig['date_e'])) {
        $weeks = weeks_ok($seme_week_day, $week_day);
        $weeks_show = _MD_LUNCH_S1 . '' . $weeks . '' . _MD_LUNCH_SW;
    } else {
        $weeks = '';
        $weeks_show = '';
    }

    // 選 日期 ( 年-月-日)
    $xoopsTpl->assign('select_date_form', select_date_form());
    $xoopsTpl->assign('weeks', $weeks);

    //取得日期的矩陣函數
    $d_ar = DtoAr($week_day);

    $xoopsTpl->assign('get_gc_year', get_gc_year($d_ar));
    $xoopsTpl->assign('get_gc_seme', get_gc_seme($d_ar));

    $allmd = $allw = '';
    for ($i = 0; $i < 7; $i++) {
        $ddate = GetdayAdd($week_day, $i);
        $d = DtoAr($ddate);

        $allmd[$i]['m'] = $d['m'];
        $allmd[$i]['d'] = $d['d'];
        $allmd[$i]['ddate'] = $ddate;
        $allmd[$i]['week'] = $weeks_arr[$i];
    }
    $xoopsTpl->assign('allmd', $allmd);

    //從資料庫抓出資料
    $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_main') . " where dates between '{$week_day}' and date_add('{$week_day}', interval 6 day)";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    while ($wd = $xoopsDB->fetchArray($result)) {
        $wid = $wd[week];
        $food[$wid] = $wd;
    }

    //判斷哪些欄位是否顯示，1 代表是，0 代表否
    //預設不顯示
    $staple_YESNO = $dish_YESNO = $soup_YESNO = $fruit_YESNO = $rem_YESNO = 0;
    // show 菜單
    $staple = $dish = $soup = $fruit = $rem = '';
    for ($i = 0; $i < 7; $i++) {
        $staple[$i]['food'] = $food[$i]['staple'];
        $dish[$i]['dish1'] = $food[$i]['dish1'];
        $dish[$i]['dish2'] = $food[$i]['dish2'];
        $dish[$i]['dish3'] = $food[$i]['dish3'];
        $dish[$i]['dish4'] = $food[$i]['dish4'];
        $dish[$i]['dish5'] = $food[$i]['dish5'];
        $soup[$i]['soup'] = $food[$i]['soup'];
        $fruit[$i]['fruit'] = $food[$i]['fruit'];
        $rem[$i]['rem'] = $food[$i]['rem'];
        if (!empty($food[$i]['staple'])) {
            $staple_YESNO = 1;
        }
        if (!empty($food[$i]['dish1']) || !empty($food[$i]['dish2']) || !empty($food[$i]['dish3']) || !empty($food[$i]['dish4']) || !empty($food[$i]['dish5'])) {
            $dish_YESNO = 1;
        }
        if (!empty($food[$i]['soup'])) {
            $soup_YESNO = 1;
        }
        if (!empty($food[$i]['fruit'])) {
            $fruit_YESNO = 1;
        }
        if (!empty($food[$i]['rem'])) {
            $rem_YESNO = 1;
        }
    }

    $xoopsTpl->assign('staple_YESNO', $staple_YESNO);
    $xoopsTpl->assign('staple', $staple);
    $xoopsTpl->assign('dish_YESNO', $dish_YESNO);
    $xoopsTpl->assign('dish', $dish);
    $xoopsTpl->assign('soup_YESNO', $soup_YESNO);
    $xoopsTpl->assign('soup', $soup);
    $xoopsTpl->assign('fruit_YESNO', $fruit_YESNO);
    $xoopsTpl->assign('fruit', $fruit);
    $xoopsTpl->assign('rem_YESNO', $rem_YESNO);
    $xoopsTpl->assign('rem', $rem);
}

//新增表單
function add_form($g_day = '')
{
    global $xoopsDB, $weeks_arr, $xoopsModuleConfig,$xoopsTpl;

    $add_form_power = chk_power('tad_lunch', '2');
    $xoopsTpl->assign('add_form_power', $add_form_power);

    $add_menu_power = chk_power('tad_lunch', '3');
    $xoopsTpl->assign('add_menu_power', $add_menu_power);

    $d = DtoAr($g_day);
    $week_days = date('w', mktime(0, 0, 0, $d[m], $d[d], $d[y]));

    //當天若有資料，從資料庫抓出資料
    $sql = 'select * from ' . $xoopsDB->prefix('tad_lunch_main') . " where dates = '{$g_day}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    $food = $xoopsDB->fetchArray($result);

    if ($add_menu_power) {
        $staple_sn = select_menu('staple_sn', $food['staple_sn'], $food['staple'], '10', '19');
        $dish1_sn = select_menu('dish1_sn', $food['dish1_sn'], $food['dish1'], '20', '29');
        $dish2_sn = select_menu('dish2_sn', $food['dish2_sn'], $food['dish2'], '20', '29');
        $dish3_sn = select_menu('dish3_sn', $food['dish3_sn'], $food['dish3'], '20', '29');
        $dish4_sn = select_menu('dish4_sn', $food['dish4_sn'], $food['dish4'], '20', '29');
        $dish5_sn = select_menu('dish5_sn', $food['dish5_sn'], $food['dish5'], '20', '29');
        $soup_sn = select_menu('soup_sn', $food['soup_sn'], $food['soup'], '30', '39');
        $fruit_sn = select_menu('fruit_sn', $food['fruit'], $food['fruit'], '40', '49');
        $rem_sn = select_menu('rem_sn', $food['rem_sn'], $food['rem'], '50', '59');

        $xoopsTpl->assign('staple_sn', $staple_sn);
        $xoopsTpl->assign('dish1_sn', $dish1_sn);
        $xoopsTpl->assign('dish2_sn', $dish2_sn);
        $xoopsTpl->assign('dish3_sn', $dish3_sn);
        $xoopsTpl->assign('dish4_sn', $dish4_sn);
        $xoopsTpl->assign('dish5_sn', $dish5_sn);
        $xoopsTpl->assign('soup_sn', $soup_sn);
        $xoopsTpl->assign('fruit_sn', $fruit_sn);
        $xoopsTpl->assign('rem_sn', $rem_sn);
    }

    if ($add_form_power) {
        $xoopsTpl->assign('food_staple', $food['staple']);
        $xoopsTpl->assign('food_dish1', $food['dish1']);
        $xoopsTpl->assign('food_dish2', $food['dish2']);
        $xoopsTpl->assign('food_dish3', $food['dish3']);
        $xoopsTpl->assign('food_dish4', $food['dish4']);
        $xoopsTpl->assign('food_dish5', $food['dish5']);
        $xoopsTpl->assign('food_soup', $food['soup']);
        $xoopsTpl->assign('food_fruit', $food['fruit']);
        $xoopsTpl->assign('food_rem', $food['rem']);
    }

    if ($add_form_power or $add_menu_power) {
        $xoopsTpl->assign('dd', $d['d']);
        $xoopsTpl->assign('dm', $d['m']);
        $xoopsTpl->assign('week_days1', $weeks_arr[$week_days]);
        $xoopsTpl->assign('numbers', $xoopsModuleConfig['numbers']);
        $xoopsTpl->assign('g_day', $g_day);
        $xoopsTpl->assign('week_days', $week_days);
        $xoopsTpl->assign('now_op', 'add_form');
    }
}

//選單資料
function select_menu($name = '', $dish_id_b = '', $dish_name_b = '', $id_b = '', $id_e = '')
{
    global $xoopsDB;

    $sql = 'select id, dish from ' . $xoopsDB->prefix('tad_lunch_dish') . " where  kind between '{$id_b}' and '{$id_e}' order by  change_date DESC";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    $i = 1;
    $main = "
  <select name='" . $name . "'>
  <option value='" . $dish_id_b . "' selected>" . $dish_name_b . '</option>';
    while ($food = $xoopsDB->fetchArray($result)) {
        $food_menu[$i] = $food;
        $main .= "<option value='" . $food['id'] . "'>" . $food['dish'] . '</option>';
    }

    // 共同區
    $sql = 'select id, dish from ' . $xoopsDB->prefix('tad_lunch_dish') . " where  kind between '60' and '99' order by  change_date DESC";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, _MD_SQL_ERROR);
    $i = 1;
    while ($food = $xoopsDB->fetchArray($result)) {
        $main .= "<option value='" . $food['id'] . "'>" . $food['dish'] . '</option>';
    }

    $main .= '</select>';

    return $main;
}

function save_lunch()
{
    global $xoopsDB;

    $myts = &MyTextSanitizer::getInstance();
    $staple = $myts->addSlashes($_POST['staple']);
    $dish1 = $myts->addSlashes($_POST['dish1']);
    $dish2 = $myts->addSlashes($_POST['dish2']);
    $dish3 = $myts->addSlashes($_POST['dish3']);
    $dish4 = $myts->addSlashes($_POST['dish4']);
    $dish5 = $myts->addSlashes($_POST['dish5']);
    $soup = $myts->addSlashes($_POST['soup']);
    $fruit = $myts->addSlashes($_POST['fruit']);
    $rem = $myts->addSlashes($_POST['rem']);

    $staple = (isset($_POST['staple_sn'])) ? cd_dish_return($_POST['staple_sn']) : $staple;
    $dish1 = (isset($_POST['dish1_sn'])) ? cd_dish_return($_POST['dish1_sn']) : $dish1;
    $dish2 = (isset($_POST['dish2_sn'])) ? cd_dish_return($_POST['dish2_sn']) : $dish2;
    $dish3 = (isset($_POST['dish3_sn'])) ? cd_dish_return($_POST['dish3_sn']) : $dish3;
    $dish4 = (isset($_POST['dish4_sn'])) ? cd_dish_return($_POST['dish4_sn']) : $dish4;
    $dish5 = (isset($_POST['dish5_sn'])) ? cd_dish_return($_POST['dish5_sn']) : $dish5;
    $soup = (isset($_POST['soup_sn'])) ? cd_dish_return($_POST['soup_sn']) : $soup;
    $fruit = (isset($_POST['fruit_sn'])) ? cd_dish_return($_POST['fruit_sn']) : $fruit;
    $rem = (isset($_POST['rem_sn'])) ? cd_dish_return($_POST['rem_sn']) : $rem;

    $sql = '
  replace into ' . $xoopsDB->prefix('tad_lunch_main') . "
  (`weeks`, `staple_sn`, `staple`, `dish1_sn`, `dish1`, `dish2_sn`, `dish2`, `dish3_sn`, `dish3`, `dish4_sn`, `dish4`, `dish5_sn`, `dish5`, `soup_sn`, `soup`, `fruit_sn`, `fruit`, `rem_sn`, `rem`, `master`, `secretary`, `dates`, `week`, `numbers`)
  values
  ('{$_POST['weeks']}','{$_POST['staple_sn']}','{$staple}','{$_POST['dish1_sn']}','{$dish1}','{$_POST['dish2_sn']}','{$dish2}','{$_POST['dish3_sn']}','{$dish3}','{$_POST['dish4_sn']}','{$dish4}','{$_POST['dish5_sn']}','{$dish5}','{$_POST['soup_sn']}','{$soup}','{$_POST['fruit_sn']}','{$fruit}','{$_POST['rem_sn']}','{$rem}','{$xoopsModuleConfig[master]}','{$xoopsModuleConfig[secretary]}','{$_POST['s_date']}','{$_POST['week']}','{$_POST['numbers']}')
  ";

    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'] . "?op=add_one&s_date={$_POST['dates']}", 2, _MD_SQL_ERROR);
}

// 更新 dish 表 日期  並 傳回名稱
function cd_dish_return($id = '')
{
    global $xoopsDB;
    $sql = 'update ' . $xoopsDB->prefix('tad_lunch_dish') . " set change_date = now() where  id = '{$id}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, '1' . _MD_SQL_ERROR);
    $xoopsDB->fetchArray($result);

    $sql = 'select dish from ' . $xoopsDB->prefix('tad_lunch_dish') . " where  id = '{$id}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, '2' . _MD_SQL_ERROR);
    $food = $xoopsDB->fetchArray($result);

    return $food[dish];
}

/*-----------執行動作判斷區--------------*/

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
$s_date = isset($_REQUEST['s_date']) ? $_REQUEST['s_date'] : '';

switch ($op) {
    case 'add_one':
    show_main($s_date);
    add_form($s_date);
    break;
  case 'save':
  save_lunch();
  header("location:{$_SERVER['PHP_SELF']}?op=add_next&s_date={$s_date}");
    break;
    case 'add_next':
  $s_date = GetdayAdd($s_date, 1);
    show_main($s_date);
    add_form($s_date);
    break;
    default:
    show_main($_REQUEST['d_date'], $_REQUEST['add_days']);
    break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', get_bootstrap());
$xoopsTpl->assign('jquery', get_jquery(true));
$xoopsTpl->assign('isAdmin', $isAdmin);

include_once XOOPS_ROOT_PATH . '/footer.php';
