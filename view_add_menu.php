<?php
/*-----------�ޤJ�ɮװ�--------------*/
include 'header.php';
$xoopsOption['template_main'] = 'tad_lunch_view_add_menu.html';
include_once XOOPS_ROOT_PATH . '/header.php';

//�ϥ��v��
if (!chk_power('tad_lunch', '4')) {
    redirect_header(XOOPS_URL, 3, _MD_LUNCH_NO_POWER);
}

/*-----------function��--------------*/
//�Ĥ@�ӰѼƬO���w����A�ĤG�ӰѼƬO���e�Ω��᪺���
function show_detail($g_date, $days = '0')
{
    global $xoopsDB,$weeks_arr,$xoopsModuleConfig,$xoopsTpl;

    $weeks = '';

    //��������o
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

    //�g�����ܼƳB�z
    //�Ǵ���A�Ǵ����A�P�g����
    //�Ǵ���A���ӬP�����Ĥ@��
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

    $xoopsTpl->assign('week_day', $week_day);
    $xoopsTpl->assign('select_date_form', select_date_form());

    //���o������x�}���
    $d_ar = DtoAr($week_day);

    $xoopsTpl->assign('get_gc_year', get_gc_year($d_ar));
    $xoopsTpl->assign('get_gc_seme', get_gc_seme($d_ar));

    //table �C�� ( �P�� )
    for ($i = 0; $i < 7; $i++) {
        $ddate = GetdayAdd($week_day, $i);
        $d = DtoAr($ddate);

        $allmd[$i]['m'] = $d['m'];
        $allmd[$i]['d'] = $d['d'];
        $allmd[$i]['ddate'] = $ddate;
        $allmd[$i]['week'] = $weeks_arr[$i];
        //table �C�� body
        $allmd[$i]['show_dish'] = show_dish($ddate);
    }

    $xoopsTpl->assign('allmd', $allmd);
    $xoopsTpl->assign('show_dish', $show_dish);
}

/*-----------����ʧ@�P�_��--------------*/
show_detail($_REQUEST['d_date'], $_REQUEST['add_days']);

/*-----------�q�X���G��--------------*/
$xoopsTpl->assign('toolbar', toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', get_bootstrap());
$xoopsTpl->assign('jquery', get_jquery(true));
$xoopsTpl->assign('isAdmin', $isAdmin);

$xoopsTpl->assign('content', $main);
include_once XOOPS_ROOT_PATH . '/footer.php';
