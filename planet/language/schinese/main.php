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

if(defined($GLOBALS["VAR_PREFIXU"]."_LANG_EN_MAIN")) return; define($GLOBALS["VAR_PREFIXU"]."_LANG_EN_MAIN",1);


define($GLOBALS["VAR_PREFIXU"]."_MD_INVALID","��Ч����");
define($GLOBALS["VAR_PREFIXU"]."_MD_NOACCESS","��ֹ����");

define($GLOBALS["VAR_PREFIXU"]."_MD_TITLE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_AUTHOR","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_SUMMARY","ժҪ");
define($GLOBALS["VAR_PREFIXU"]."_MD_BODY","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_SORTBY","����");

define($GLOBALS["VAR_PREFIXU"]."_MD_SAVED","�����ѱ���");;
//define($GLOBALS["VAR_PREFIXU"]."_MD_SUBMITTED","�ύ");;

define($GLOBALS["VAR_PREFIXU"]."_MD_ALREADYBOOKMARKED","���Ѿ��ղ��˸�Blog");
define($GLOBALS["VAR_PREFIXU"]."_MD_ALREADYRATED","���Ѿ�Ͷ��Ʊ");
define($GLOBALS["VAR_PREFIXU"]."_MD_NOTSAVED","����δ�ܱ���");

define($GLOBALS["VAR_PREFIXU"]."_MD_ACTIONDONE","�����ɹ�");

define($GLOBALS["VAR_PREFIXU"]."_MD_CONTENT","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_ARTICLE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_CATEGORY","���");
define($GLOBALS["VAR_PREFIXU"]."_MD_INDEX","��ҳ");
define($GLOBALS["VAR_PREFIXU"]."_MD_DISCLAIMER","��������");

define($GLOBALS["VAR_PREFIXU"]."_MD_DATE","����");

define($GLOBALS["VAR_PREFIXU"]."_MD_SOURCE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_ARTICLE","���� XML");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_CATEGORY","��� %s ��XML");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_BOOKMARK","%s �ղص�XML");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_BLOG","Blog %s ��XML");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_INDEX","��ҳ XML");

define($GLOBALS["VAR_PREFIXU"]."_MD_TEXT","�ı�����");

define($GLOBALS["VAR_PREFIXU"]."_MD_BLOG","Blog");
define($GLOBALS["VAR_PREFIXU"]."_MD_BOOKMARK","�ղ�");
//define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACKS","Trackback");
//define($GLOBALS["VAR_PREFIXU"]."_MD_NOTIFY_ON_APPROVAL","Notify of approval");

define($GLOBALS["VAR_PREFIXU"]."_MD_DESC","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_ORDER","����");

define($GLOBALS["VAR_PREFIXU"]."_MD_RSS","RSS");
define($GLOBALS["VAR_PREFIXU"]."_MD_RDF","RDF");
define($GLOBALS["VAR_PREFIXU"]."_MD_ATOM","ATOM");
define($GLOBALS["VAR_PREFIXU"]."_MD_OPML","OPML");

define($GLOBALS["VAR_PREFIXU"]."_MD_ARTICLES","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_FEATURED","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_CATEGORIES","���");

define($GLOBALS["VAR_PREFIXU"]."_MD_LANGUAGE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_CHARSET","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_IMAGE","ͼ��");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACKPATTERN","Trackback ģʽ");
define($GLOBALS["VAR_PREFIXU"]."_MD_STATUS","״̬");
define($GLOBALS["VAR_PREFIXU"]."_MD_URL","URL");
define($GLOBALS["VAR_PREFIXU"]."_MD_LINK","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_FEED","Feed");
define($GLOBALS["VAR_PREFIXU"]."_MD_FETCH","ץȡ");
define($GLOBALS["VAR_PREFIXU"]."_MD_UPDATE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_LASTUPDATE","������");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACK","Trackback");
define($GLOBALS["VAR_PREFIXU"]."_MD_SUBMITTER","�ύ��");
define($GLOBALS["VAR_PREFIXU"]."_MD_VIEWS","���");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATEIT","ͶƱ!");
define($GLOBALS["VAR_PREFIXU"]."_MD_TIME","ʱ��");

define($GLOBALS["VAR_PREFIXU"]."_MD_UPDATED","��Blog�Ѹ��£��� %s ƪ������ӵ����ݿ���");
define($GLOBALS["VAR_PREFIXU"]."_MD_DBUPDATED","���ݿ��Ѹ���");

define($GLOBALS["VAR_PREFIXU"]."_MD_PREVIOUS","<<");
define($GLOBALS["VAR_PREFIXU"]."_MD_NEXT",">>");


define($GLOBALS["VAR_PREFIXU"]."_MD_PENDING","�����");
define($GLOBALS["VAR_PREFIXU"]."_MD_ACTIVE","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_EXPIRED","����");

/*
define($GLOBALS["VAR_PREFIXU"]."_MD_TYPES","Types");
define($GLOBALS["VAR_PREFIXU"]."_MD_APPROVED","Approved");
define($GLOBALS["VAR_PREFIXU"]."_MD_DELETED","Deleted");
define($GLOBALS["VAR_PREFIXU"]."_MD_EXPIRATION","Expiration date");
define($GLOBALS["VAR_PREFIXU"]."_MD_APPROVE","Approve");
define($GLOBALS["VAR_PREFIXU"]."_MD_ACTIONS","Actions");

define($GLOBALS["VAR_PREFIXU"]."_MD_SUBMISSION","Submission date");
define($GLOBALS["VAR_PREFIXU"]."_MD_PUBLISH","Publish date");
define($GLOBALS["VAR_PREFIXU"]."_MD_REGISTER","Register date");
define($GLOBALS["VAR_PREFIXU"]."_MD_FEATURE","Featured date");
define($GLOBALS["VAR_PREFIXU"]."_MD_VIEWALL","View full text");
*/

define($GLOBALS["VAR_PREFIXU"]."_MD_COMMENTS","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_CLICKTOCOPY","�������");

define($GLOBALS["VAR_PREFIXU"]."_MD_SORT","����");

define($GLOBALS["VAR_PREFIXU"]."_MD_FULLVIEW","ȫ��");
define($GLOBALS["VAR_PREFIXU"]."_MD_LISTVIEW","�б�");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATING","����");
define($GLOBALS["VAR_PREFIXU"]."_MD_DEFAULT","ȱʡ");
define($GLOBALS["VAR_PREFIXU"]."_MD_BLOGS","Blogs");
define($GLOBALS["VAR_PREFIXU"]."_MD_BOOKMARKS","�ղ�");
define($GLOBALS["VAR_PREFIXU"]."_MD_HOME","��ҳ");

define($GLOBALS["VAR_PREFIXU"]."_MD_BLOGEXISTS","�Ѿ��и�Blog����");
define($GLOBALS["VAR_PREFIXU"]."_MD_EMPTY_BLOG","���");

define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER","������");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER_DESC","��������ת������Ӧ����");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER_DONE","�����ѳɹ�ִ��: %s");
?>