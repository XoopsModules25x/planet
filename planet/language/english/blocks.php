<?php
// $Id$
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

define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE","Type");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_TIME","Publish time");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_VIEWS","Views");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RATES","Rate times");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RATING","Rating");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_RANDOM","Random");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_BOOKMARKS","Bookmarks");
define($GLOBALS["VAR_PREFIXU"]."_MB_TYPE_FEATURED","Featured");
define($GLOBALS["VAR_PREFIXU"]."_MB_ITEMS","Item count");
define($GLOBALS["VAR_PREFIXU"]."_MB_TITLE_LENGTH","Title length");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIMEFORMAT","Time format");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIMEFORMAT_CUSTOM","Custom");
define($GLOBALS["VAR_PREFIXU"]."_MB_SUMMARY_LENGTH","Show summary length");
define($GLOBALS["VAR_PREFIXU"]."_MB_SHOWDESC","Show description");
define($GLOBALS["VAR_PREFIXU"]."_MB_CATEGORYLIST","Allowed categories");

define($GLOBALS["VAR_PREFIXU"]."_MB_AUTHOR","Author");
define($GLOBALS["VAR_PREFIXU"]."_MB_TIME","Time");
?>