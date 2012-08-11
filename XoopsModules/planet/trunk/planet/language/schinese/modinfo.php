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

if(defined($GLOBALS["VAR_PREFIXU"]."_LANG_EN_MODINFO")) return; define($GLOBALS["VAR_PREFIXU"]."_LANG_EN_MODINFO",1);

define($GLOBALS["VAR_PREFIXU"]."_MI_NAME","���²���");
define($GLOBALS["VAR_PREFIXU"]."_MI_DESC","XML feeds");

define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_INDEX","��ҳ");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_ARTICLE","����");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_ARCHIVE","�浵");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_LIST","�б�");

define($GLOBALS["VAR_PREFIXU"]."_MI_SUBMIT","�ύ");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE","����");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_CATEGORY","���");
define($GLOBALS["VAR_PREFIXU"]."_MI_CATEGORY_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG","Blog (��վ)");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_THEMESET","���");
define($GLOBALS["VAR_PREFIXU"]."_MI_THEMESET_DESC","Ӧ��������ģ��, ��������ã�ѡ�� '"._NONE."'");

define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT","ʱ����ʾ��ʽ");
define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_CUSTOM","����");

define($GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY","�������б�ҳ����ʾ��ժҪ����");
define($GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY_DESC","0 - ��ʾȫ��");

define($GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG","���õ���ģʽ");
define($GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE","����url��д����");
define($GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE_DESC","��Ҫ���� AcceptPathInfo (Apache2)");

define($GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING","��ʾ��һƪ/��һƪ");
define($GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE","ÿҳ��ʾ������");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE","ÿҳ��ʾ�б���");
define($GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE","ÿ�θ��µ�Blog����վ");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE","���¹���ʱ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE_DESC","��λ����");

define($GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT","��Ȩ");
define($GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_PING","Pings");
define($GLOBALS["VAR_PREFIXU"]."_MI_PING_DESC","ҪPING����ַ");

define($GLOBALS["VAR_PREFIXU"]."_MI_TRACKBACK_OPTION","��ȡTrackback��ѡ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_TRACKBACK_OPTION_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_MODERATION","��Ҫ����Ա���");
define($GLOBALS["VAR_PREFIXU"]."_MI_MEMBER","��Ա���Զ�ͨ��");

define($GLOBALS["VAR_PREFIXU"]."_MI_NEWBLOG_SUBMIT","�ύ��Blog����վ��Ȩ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_NEWBLOG_SUBMIT_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ANONYMOUSRATE","�����ο�����");
define($GLOBALS["VAR_PREFIXU"]."_MI_ANONYMOUSRATE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_PSEUDOCRON","����cron");
define($GLOBALS["VAR_PREFIXU"]."_MI_PSEUDOCRON_DESC","�û�����ģ��ʱ�Զ�����blog�ĸ���");

define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_INDEX","��ҳ");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_CATEGORY","������");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_BLOG","Blog����վ");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_ARTICLE","����");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_BLOCK","����");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_ABOUT","����");

define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NOTIFY","ȫ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NOTIFYDSC","ȫ��֪ͨѡ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_NOTIFY","Blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_NOTIFYDSC","Blog ֪ͨѡ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_NOTIFY","����");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_NOTIFYDSC","����֪ͨѡ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFY","�����ύ");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYCAP","�еȴ���˵�Blogʱ֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYDSC","������blog�ύʱ֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : ��Blog�ύ");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFY","��Blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYCAP","��Blog����ʱ֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYDSC","�������Blog������֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : ��Blog����");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFY","���¼���");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYCAP","֪ͨ���й�����һ���µı仯");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYDSC","����ҵ���һƪ�б仯֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : ����");

define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFY","Blogͨ�����");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYCAP","ͨ�����֪ͨ");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYDSC","������Blogͨ����ˣ�֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : blog ͨ�����");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFY","Blog ����");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYCAP","����֪ͨ");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYDSC","�����Blog�и��£�֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : blog �Ѹ���");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFY","���¼���");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYCAP","���±䶯֪ͨ");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYDSC","����������и��£�֪ͨ��");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE} �Զ�֪ͨ : �����Ѹ���");
?>