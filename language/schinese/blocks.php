<?php
// $Id: blocks.php,v 1.1.1.1 2005/11/14 00:33:51 phppp Exp $
// _LANGCODE: en
// _CHARSET : ISO-8859-1
// Translator: D.J., http://xoopsforge.com, http://xoops.org.cn

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["VAR_PREFIXU"]."_LANG_EN_BLOCKS")) return; 
define($GLOBALS["VAR_PREFIXU"]."_LANG_EN_BLOCKS",1);

define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE","����");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_TIME","����ʱ��");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_VIEWS","���");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RATES","���ִ���");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RATING","�÷�ƽ��");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RANDOM","���");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_BOOKMARKS","���ղش���");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_FEATURED","����");
define($GLOBALS["VAR_PREFIXU"]."_MB_ITEMS","��Ŀ");
define($GLOBALS["VAR_PREFIXU"]."_MB_TITLE_LENGTH","���ⳤ��");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIMEFORMAT","ʱ���ʽ");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIMEFORMAT_CUSTOM","����");
define($GLOBALS["VAR_PREFIXU"]."_MB_SUMMARY_LENGTH","ժҪ����");
define($GLOBALS["VAR_PREFIXU"]."_MB_SHOWDESC","��ʾ˵��");
define($GLOBALS["VAR_PREFIXU"]."_MB_CATEGORYLIST","����ķ���");

define($GLOBALS["VAR_PREFIXU"]."_MB_AUTHOR","����");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIME","ʱ��");
?>