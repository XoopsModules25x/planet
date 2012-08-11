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

if(defined($GLOBALS["VAR_PREFIXU"]."_LANG_EN_ADMIN")) return; define($GLOBALS["VAR_PREFIXU"]."_LANG_EN_ADMIN",1);

define($GLOBALS["VAR_PREFIXU"]."_AM_ARTICLES","���¹���");

define($GLOBALS["VAR_PREFIXU"]."_AM_TITLE","����");
define($GLOBALS["VAR_PREFIXU"]."_AM_CATEGORY","����");

//define($GLOBALS["VAR_PREFIXU"]."_AM_CATEGORIES","Categories");
//define($GLOBALS["VAR_PREFIXU"]."_AM_ADDCATEGORY","Add Category");

define($GLOBALS["VAR_PREFIXU"]."_AM_ARTICLE","����");
define($GLOBALS["VAR_PREFIXU"]."_AM_ACTION","����");

define($GLOBALS["VAR_PREFIXU"]."_AM_PREFERENCES","ģ�����");
define($GLOBALS["VAR_PREFIXU"]."_AM_ON","����");
define($GLOBALS["VAR_PREFIXU"]."_AM_OFF","�ر�");
define($GLOBALS["VAR_PREFIXU"]."_AM_SAFEMODE","safemod");
define($GLOBALS["VAR_PREFIXU"]."_AM_REGISTERGLOBALS","register_globals");
define($GLOBALS["VAR_PREFIXU"]."_AM_MAGICQUOTESGPC","magic_quotes_gpc");
define($GLOBALS["VAR_PREFIXU"]."_AM_MAXPOSTSIZE","post_max_size");
define($GLOBALS["VAR_PREFIXU"]."_AM_MAXINPUTTIME","max_input_time");
define($GLOBALS["VAR_PREFIXU"]."_AM_OUTPUTBUFFERING","output_buffering");

define($GLOBALS["VAR_PREFIXU"]."_AM_XML_EXTENSION","xml");
define($GLOBALS["VAR_PREFIXU"]."_AM_MB_EXTENSION","mbstring");
define($GLOBALS["VAR_PREFIXU"]."_AM_CURL","curl_init");
define($GLOBALS["VAR_PREFIXU"]."_AM_FSOCKOPEN","fsockopen");
define($GLOBALS["VAR_PREFIXU"]."_AM_URLFOPEN","allow_url_fopen");

define($GLOBALS["VAR_PREFIXU"]."_AM_STATS","ͳ����Ϣ");
define($GLOBALS["VAR_PREFIXU"]."_AM_TOTAL_CATEGORIES","�ܷ���");
define($GLOBALS["VAR_PREFIXU"]."_AM_TOTAL_BLOGS","��Blog");
define($GLOBALS["VAR_PREFIXU"]."_AM_TOTAL_ARTICLES","������");

define($GLOBALS["VAR_PREFIXU"]."_AM_DBUPDATED","���ݿ��Ѹ���");
define($GLOBALS["VAR_PREFIXU"]."_AM_ERROR","����");

define($GLOBALS["VAR_PREFIXU"]."_AM_COUNT","��Ŀ");
define($GLOBALS["VAR_PREFIXU"]."_AM_ORDER","˳��");
define($GLOBALS["VAR_PREFIXU"]."_AM_LIST","�б�");
define($GLOBALS["VAR_PREFIXU"]."_AM_BLOGCOUNT","Blogs");
define($GLOBALS["VAR_PREFIXU"]."_AM_ARTICLECOUNT","����");

define($GLOBALS["VAR_PREFIXU"]."_AM_EXPIRED","����");
define($GLOBALS["VAR_PREFIXU"]."_AM_PENDING","�����");
define($GLOBALS["VAR_PREFIXU"]."_AM_STATUS","״̬");
define($GLOBALS["VAR_PREFIXU"]."_AM_FEED","Feed");

define($GLOBALS["VAR_PREFIXU"]."_AM_REGISTER","�ύ");
define($GLOBALS["VAR_PREFIXU"]."_AM_APPROVE","���");
define($GLOBALS["VAR_PREFIXU"]."_AM_FEATURE","��ʶ����");
define($GLOBALS["VAR_PREFIXU"]."_AM_UPDATE","����");
define($GLOBALS["VAR_PREFIXU"]."_AM_REMOVE","ɾ��");

define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_RELEASEDATE","Release date");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_AUTHOR","Author");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_CREDITS","Credits");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_LICENSE","License");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_WEBSITE","Homepage");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_MODULE_INFO","Module info");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_MODULE_STATUS","Status");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_MODULE_TEAM","Team members");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_INFO","Author info");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_NAME","Author name");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_WORD","Author's word");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_DISCLAIMER","Disclaimer");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_DISCLAIMER_TEXT","GPL-licensed");
define($GLOBALS["VAR_PREFIXU"]."_AM_ABOUT_CHANGELOG","Changelog");

define($GLOBALS["VAR_PREFIXU"]."_AM_BLOGEXISTS","�Ѿ��и�Blog����");
?>