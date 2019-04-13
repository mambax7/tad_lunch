<?php
include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";
define('_TAD_NEED_TADTOOLS', " 需要 tadtools 模組，可至<a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad教材網</a>下載。");

// index 檔
define('_MA_LUNCH_UPDATA', '匯入');
define('_MA_LUNCH_UPDATA_TEMP', '匯入樣板');
define('_MA_LUNCH_OUTDATA_TEMP', '匯出樣板');
define('_MA_LUNCH_UPDATA_README', '種類編號說明');
define('_MA_LUNCH_README_BODY', '種類編號原則<br> 0 ~ 9 保留<br> 10 ~ 19 主食<br> 20 ~ 29 菜色<br> 30 ~ 39 湯<br> 40 ~ 49 水果<br>  50 ~ 59 備註<br> 60 ~99 此範圍則全部欄位都看的到');

define('_MA_LUNCH_NV', '菜名');
define('_MA_LUNCH_ERRMSG', '未存檔，請檢查您所匯入的檔案編號，請參考');
define('_MA_LUNCH_ITEMS', '筆');
define('_MA_LUNCH_HAVE', '有');
define('_MA_LUNCH_SQLMSG', '筆編號不符，未存入!');
define('_MA_LUNCH_NUMBERS', '編號');
define('_MA_LUNCH_TMPERRMSG', '未存檔，請檢查您所匯入的檔案編號，請參考');
define('_MA_LUNCH_UPDATA_BROWS', '請按『瀏覽』選擇匯入檔案來源：');
define('_MA_LUNCH_UPDATA_SUBVAL', '批次建立資料');
define('_MA_LUNCH_UPDATA_README1L', '食物資料批次建檔說明：');
define('_MA_LUNCH_UPDATA_CSV', 'csv 檔格式');
define('_MA_LUNCH_UPDATA_EXAMPLE', '範例');
define('_MA_LUNCH_UPDATA_README2L', 'csv檔第一行抬頭請保留');
define('_MA_LUNCH_UPDATA_README3L', '格式：種類,菜名,材料,數量 (100人份),單位,材料,數量 (100人份),單位,....');
define('_MA_LUNCH_UPDATA_README4L', '匯入之後請自行修正相關資料');
define('_MA_LUNCH_UPDATA_README5L', '請你相同的資料只匯入一次，不要重複匯入，否則相同的食物會有兩筆以上。');
define('_MA_LUNCH_UPTEMP_README', '若你原來有資料，則會因編號相同 ( 1 ~ 159 )，而覆蓋舊資料。');
define('_MA_LUNCH_UPTEMP_READMESURE', '你確定嗎?');

// 匯入使用者資料
define('_MA_LUNCH_IN_ID', '編號');
define('_MA_LUNCH_ITEM', '材料');
define('_MA_LUNCH_NUMBER', '數量 (100人份)');
define('_MA_LUNCH_IN_ERR', "本介面不支持您所匯入的格式<br>請檢查您所匯入的檔案格式，並<font color='red'>保留第一列標題</font>！");

//add fun
//title
define('_MA_LUNCH_ADD_STAPLE', '主食');
define('_MA_LUNCH_ADD_DISH', '菜色');
define('_MA_LUNCH_ADD_SOUP', '湯');
define('_MA_LUNCH_ADD_FRUIT', '水果');
define('_MA_LUNCH_ADD_REM', '備註');
//dish sql
define('_MA_LUNCH_ADD_ONE', '新增一筆');
define('_MA_DISH_UNIT_README', '此處的數量皆一百人份');
define('_MA_LUNCH_ADD_ID', '種類');
define('_MA_LUNCH_ADD_ITEM_1', '材料一');
define('_MA_LUNCH_ADD_ITEM_2', '材料二');
define('_MA_LUNCH_ADD_ITEM_3', '材料三');
define('_MA_LUNCH_ADD_ITEM_4', '材料四');
define('_MA_LUNCH_ADD_ITEM_5', '材料五');
define('_MA_LUNCH_ADD_ITEM_6', '材料六');
define('_MA_LUNCH_ADD_ITEM_7', '材料七');
define('_MA_LUNCH_ADD_ITEM_8', '材料八');
define('_MA_LUNCH_ADD_ITEM_9', '材料九');
define('_MA_LUNCH_ADD_ITEM_10', '材料十');
define('_MA_LUNCH_ADD_NUMBER', '數量');
define('_MA_LUNCH_ADD_UNIT', '單位');
define('_MA_LUNCH_EXE', '執行');

define('_MA_SQL_ERR', '查詢錯誤！');
define('_MA_DEL_SQL_ERROR', '未刪除成功！');
define('_MA_DEL_SQL_SAVEOK', '刪除動作已完成！');
define('_MA_ERR', '錯誤！');
define('_MA_OK', '成功！');
define('_MA_ID_README', '種類編號重複，請看編號說明');

// kind 檔
define('_MA_LUNCH_KIND_SN', '種類編號');
define('_MA_LUNCH_KIND_NAME', '種類名稱');

// power 檔
define('_MA_LUNCH_SHOW', '觀看菜單');
define('_MA_LUNCH_ADD', '午餐新增(表單)');
define('_MA_LUNCH_ADD_MENU', '午餐新增(選單)');
define('_MA_LUNCH_VIEW_MENU', '菜單細表');
define('_MA_LUNCH_SET_POWER', '營養午餐管理使用權限設定');
define('_MA_LUNCH_README', '您若是希望只有老師可以使用「菜單設計」功能，那麼請自行新增一個群組，例如「教師」。<br>然後，將老師的帳號加入該群組中，接著再把「菜單設計」權限開放給該群組即可。');

// config 檔
define('_MA_CONFIG_TITLE', '請輸入貴校全銜');
define('_MA_CONFIG_MASTER', '請輸入校長名字');
define('_MA_CONFIG_MASTER_J', '是否要在報表上出現校長名字');
define('_MA_CONFIG_SECRETARY', '請輸入貴校午餐執行秘書');
define('_MA_CONFIG_SECRETARY_J', '是否要在報表上出現午餐執行秘書的名字');
define('_MA_CONFIG_DATE_B', '請輸入貴校本學期開學的日子');
define('_MA_CONFIG_DATE_E', '請輸入貴校本學期結束的日子');
define('_MA_CONFIG_DATE_BEX', '例:2005-02-17');
define('_MA_CONFIG_DATE_EEX', '例:2005-06-30');
define('_MA_CONFIG_CHECKER_J', '是否要在報表上出現驗收者名字');
define('_MA_CONFIG_DESIGN_J', '是否要在報表上出現設計者名字');
define('_MA_CONFIG_NUMBERS', '請輸入學校供應營養午餐的人數');
define('_MA_CONFIG_PEOPLE', '人');

define('_MA_CONFIG_HAVE_XBASE_README', '您有安裝 X 學務系統, 是否要引入 X 學務系統最新的相關資料? <br>  你確定嗎?');
define('_MA_CONFIG_UPDATA', '引入 X 學務系統最新的相關資料');

define('_MA_CONFIG_DATE_ERROR', '日期輸入錯誤！');
define('_MA_CONFIG_SELECT_ERROR', '無法取得使用權！');
define('_MA_CONFIG_SELECT_SAVEOK', '修改動作已完成！');

define('_MA_SQL_ERROR', '匯入動作未成功，請檢查您所匯入的檔案格式！');
define('_MA_SQL_SAVEOK', '匯入動作已完成！');

define('_AC_MASTER', '校長');
define('_AC_NURSE', '護士');

define('_MA_LUNCH_RESET', '重寫');
