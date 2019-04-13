<?php
$modversion = [];

//---�Ҳհ򥻸�T---//
$modversion['name'] = _MI_LUNCH_NAME;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_LUNCH_DESC;
$modversion['author'] = 'tad0616 (tad0616@gmail.com)';
$modversion['credits'] = 'sds3 (xumingia@gmail.com)';
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));

//---�Ҳժ��A��T---//
$modversion['release_date'] = '2013/08/29';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.2;
$modversion['min_xoops'] = '2.5';

//---paypal��T---//
$modversion ['paypal'] = [];
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';

//---�Ҳո�ƪ�[�c---//
$modversion['sqlfile']['mysql'] = "sql/lunch_{$xoopsConfig['language']}.sql";
$modversion['tables'][0] = 'tad_lunch_config';
$modversion['tables'][1] = 'tad_lunch_main';
$modversion['tables'][2] = 'tad_lunch_dish';
$modversion['tables'][3] = 'tad_lunch_kind';

//---��x�ϥΨt�ο��---//
$modversion['system_menu'] = 1;

//---��x�޲z�����]�w---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---�e�x�D���]�w---//
$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_LUNCH_SHOW;
$modversion['sub'][1]['url'] = 'index.php';

$modversion['sub'][2]['name'] = _MI_LUNCH_VIEW_ADD_MENU;
$modversion['sub'][2]['url'] = 'view_add_menu.php';

//---�Ҳզ۰ʥ\��---//
//$modversion['onInstall'] = "include/install.php";
//$modversion['onUpdate'] = "include/update.php";
//$modversion['onUninstall'] = "include/onUninstall.php";

//---���n�]�w---//
$modversion['config'] = [];
$i = 0;
$modversion['config'][$i]['name'] = 'title';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_TITLE';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_TITLE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'master';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_MASTER';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_MASTER_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'master_j';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_MASTER_J';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_MASTER_J_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';

$i++;
$modversion['config'][$i]['name'] = 'secretary';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_SECRETARY';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_SECRETARY_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'secretary_j';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_SECRETARY_J';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_SECRETARY_J_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';

$i++;
$modversion['config'][$i]['name'] = 'date_b';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_DATE_B';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_DATE_B_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = date('Y-m-d');

$i++;
$modversion['config'][$i]['name'] = 'date_e';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_DATE_E';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_DATE_E_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = date('Y-m-d');

$i++;
$modversion['config'][$i]['name'] = 'numbers';
$modversion['config'][$i]['title'] = '_MI_LUNCH_CONFIG_NUMBERS';
$modversion['config'][$i]['description'] = '_MI_LUNCH_CONFIG_NUMBERS_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '300';

//---�j�M---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "�j�M��ƦW��";

//---�϶��]�w---//
$modversion['blocks'] = [];
$i = 1;
$modversion['blocks'][$i]['file'] = 'show_today_lunch.php';
$modversion['blocks'][$i]['name'] = _MI_LUNCH_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_LUNCH_BDESC1;
$modversion['blocks'][$i]['show_func'] = 'show_today_lunch';
$modversion['blocks'][$i]['template'] = 'show_today_lunch.html';

$i++;
$modversion['blocks'][$i]['file'] = 'show_today_lunch.php';
$modversion['blocks'][$i]['name'] = _MI_LUNCH_BNAME2;
$modversion['blocks'][$i]['description'] = _MI_LUNCH_BDESC2;
$modversion['blocks'][$i]['show_func'] = 'show_today_lunch';
$modversion['blocks'][$i]['template'] = 'show_today_lunch_scroll.html';

$i++;
$modversion['blocks'][$i]['file'] = 'show_week_lunch.php';
$modversion['blocks'][$i]['name'] = _MI_LUNCH_BNAME3;
$modversion['blocks'][$i]['description'] = _MI_LUNCH_BDESC3;
$modversion['blocks'][$i]['show_func'] = 'show_week';
$modversion['blocks'][$i]['template'] = 'show_week_lunch.html';

//---�˪O�]�w---//
$modversion['templates'] = [];
$i = 1;
$modversion['templates'][$i]['file'] = 'tad_lunch_view_add_menu.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_view_add_menu.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_lunch_index.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_index.html';
$i++;
$modversion['templates'][$i]['file'] = 'tad_lunch_adm_main.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_adm_main.html';
$i++;
$modversion['templates'][$i]['file'] = 'tad_lunch_adm_kind.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_adm_kind.html';
$i++;
$modversion['templates'][$i]['file'] = 'tad_lunch_adm_power.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_adm_power.html';
$i++;
$modversion['templates'][$i]['file'] = 'tad_lunch_adm_import.html';
$modversion['templates'][$i]['description'] = 'tad_lunch_adm_import.html';

//---����---//
//$modversion['hasComments'] = 1;
//$modversion['comments']['pageName'] = '��@����.php';
//$modversion['comments']['itemName'] = '�D�s��';

//---�q��---//
//$modversion['hasNotification'] = 1;
