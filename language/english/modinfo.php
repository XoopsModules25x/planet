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

define($GLOBALS["VAR_PREFIXU"]."_MI_NAME","Planet");
define($GLOBALS["VAR_PREFIXU"]."_MI_DESC","Feed Planet For Xoops");

define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_INDEX", "Index");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_ARTICLE", "Article");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_ARCHIVE", "Archive");
define($GLOBALS["VAR_PREFIXU"]."_MI_PAGE_LIST", "List");

define($GLOBALS["VAR_PREFIXU"]."_MI_SUBMIT","Submit");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE","Articles");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_CATEGORY","Categories");
define($GLOBALS["VAR_PREFIXU"]."_MI_CATEGORY_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG","BLogs");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_THEMESET", "Theme set");
define($GLOBALS["VAR_PREFIXU"]."_MI_THEMESET_DESC", "Module-wide, select '"._NONE."' will use site-wide theme");

define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT","Time format for display");
define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_DESC","");
define($GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_CUSTOM","Custom");

define($GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY", "Display summary length on article list");
define($GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY_DESC", "0 for full text");

define($GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG","Enable debug");
define($GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE","Enable URL rewrite");
define($GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE_DESC","AcceptPathInfo On for Apache2 is required");

define($GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING","Enable sibling articles");
define($GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE","Articles on one page");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE","Lists on one page");
define($GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE","Blogs for each update");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE","Time for article to expire");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE_DESC","In days");

define($GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT","Copyright");
define($GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_PING","Pings");
define($GLOBALS["VAR_PREFIXU"]."_MI_PING_DESC","URLs to ping");

define($GLOBALS["VAR_PREFIXU"]."_MI_TRACKBACK_OPTION","Option for recieved trackbacks");
define($GLOBALS["VAR_PREFIXU"]."_MI_TRACKBACK_OPTION_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_MODERATION","Moderator to approve");
define($GLOBALS["VAR_PREFIXU"]."_MI_MEMBER","Member atuo-approve");

define($GLOBALS["VAR_PREFIXU"]."_MI_NEWBLOG_SUBMIT","Right for submitting new blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_NEWBLOG_SUBMIT_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_ANONYMOUSRATE","Allow anonymous to rate");
define($GLOBALS["VAR_PREFIXU"]."_MI_ANONYMOUSRATE_DESC","");

define($GLOBALS["VAR_PREFIXU"]."_MI_PSEUDOCRON","Pseudo cron");
define($GLOBALS["VAR_PREFIXU"]."_MI_PSEUDOCRON_DESC","Use pseudo cron to update blogs");

define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_INDEX","Index");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_CATEGORY","Category");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_BLOG","Blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_ARTICLE","Article");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_BLOCK","Block");
define($GLOBALS["VAR_PREFIXU"]."_MI_ADMENU_ABOUT","About");

define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NOTIFY", "Global");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NOTIFYDSC", "Global notification options");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_NOTIFY", "Blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_NOTIFYDSC", "Blog notification options");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_NOTIFY", "Article");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_NOTIFYDSC", "Article notification options");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFY", "Article submission");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYCAP", "Notify me of any pending blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYDSC", "Receive notification when a new blog is submitted");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_BLOGSUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New blog submitted");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFY", "New blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYCAP", "Notify of any new blog published");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYDSC", "Receive notification when a new blog is published");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_NEWBLOG_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New blog published");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFY", "Article monitor");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYCAP", "Notify me of all actions on my articles");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYDSC", "Receive notification when an action is taken over my articles");
define($GLOBALS["VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New action");

define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFY", "Blog approved");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYCAP", "Notify me of approval of this blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYDSC", "Receive notification when the blog is approved");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGAPPROVE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : blog approved");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFY", "Blog updated");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYCAP", "Notify me of update of this blog");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYDSC", "Receive notification when the blog is upated");
define($GLOBALS["VAR_PREFIXU"]."_MI_BLOG_BLOGUPDATE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : blog updated");

define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFY", "Article monitor");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYCAP", "Notify me of any action taken on this article");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYDSC", "Receive notification when an action is taken on this article");
define($GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published");
?>