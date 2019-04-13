<?php
// �^�� sfs3 �� ��Ʈw �μW�[
// $Id: sfs_case_PLlib.php,v 1.10.4.1 2004/01/10 04:48:02 hami Exp $
// ���N PLlib.php

/*
 * ��Ʈw
 * �@��
 * prolin  http://sy3es.tnc.edu.tw/~prolin
 * hami    cik@mail.wpes.tcc.edu.tw
*/

//������
//$PLlib_VERSON = 2.0;
//$PLlib_DATE = "2001-10-1";

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

function ChtoD($dday, $st = '-')
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

function Getday($dday, $st = '-')
{
    //��褸��������o���  $st�����j�Ÿ�
    $tok = strtok($dday, $st);
    $i = 0;
    while ($tok) {
        $d[$i] = $tok;
        $tok = strtok($st);
        $i = $i + 1;
    }
    //$d[0] = $d[0] - 1911 ;

    //�ର�Ʀr�Ǧ^
    return (int)$d[2];
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
