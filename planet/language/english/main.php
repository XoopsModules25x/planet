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


define($GLOBALS["VAR_PREFIXU"]."_MD_INVALID","Invalid action");
define($GLOBALS["VAR_PREFIXU"]."_MD_NOACCESS","No access");

define($GLOBALS["VAR_PREFIXU"]."_MD_TITLE","Title");
define($GLOBALS["VAR_PREFIXU"]."_MD_AUTHOR","Author");
define($GLOBALS["VAR_PREFIXU"]."_MD_SUMMARY","Summary");
define($GLOBALS["VAR_PREFIXU"]."_MD_BODY","Text body");
define($GLOBALS["VAR_PREFIXU"]."_MD_SORTBY","Sort");

define($GLOBALS["VAR_PREFIXU"]."_MD_SAVED","Data saved");;
//define($GLOBALS["VAR_PREFIXU"]."_MD_SUBMITTED","Submitted");;

define($GLOBALS["VAR_PREFIXU"]."_MD_ALREADYBOOKMARKED","You have already bookmarked the blog");
define($GLOBALS["VAR_PREFIXU"]."_MD_ALREADYRATED","You have already rated");
define($GLOBALS["VAR_PREFIXU"]."_MD_NOTSAVED","Not saved");

define($GLOBALS["VAR_PREFIXU"]."_MD_ACTIONDONE","Action succeeded");

define($GLOBALS["VAR_PREFIXU"]."_MD_CONTENT","Content");
define($GLOBALS["VAR_PREFIXU"]."_MD_ARTICLE","Article");
define($GLOBALS["VAR_PREFIXU"]."_MD_CATEGORY","Category");
define($GLOBALS["VAR_PREFIXU"]."_MD_INDEX","Index");
define($GLOBALS["VAR_PREFIXU"]."_MD_DISCLAIMER","Disclaimer");

define($GLOBALS["VAR_PREFIXU"]."_MD_DATE","Date");

define($GLOBALS["VAR_PREFIXU"]."_MD_SOURCE","Source");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_ARTICLE","Article XML");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_CATEGORY","XML for category %s");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_BOOKMARK","XML for bookmark %s");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_BLOG","XML for blog %s");
define($GLOBALS["VAR_PREFIXU"]."_MD_XMLDESC_INDEX","XML for index page");

define($GLOBALS["VAR_PREFIXU"]."_MD_TEXT","Text");

define($GLOBALS["VAR_PREFIXU"]."_MD_BLOG","Blog");
define($GLOBALS["VAR_PREFIXU"]."_MD_BOOKMARK","Bookmark");
//define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACKS","Trackback");
//define($GLOBALS["VAR_PREFIXU"]."_MD_NOTIFY_ON_APPROVAL","Notify of approval");

define($GLOBALS["VAR_PREFIXU"]."_MD_DESC","Description");
define($GLOBALS["VAR_PREFIXU"]."_MD_ORDER","Order");

define($GLOBALS["VAR_PREFIXU"]."_MD_RSS","RSS");
define($GLOBALS["VAR_PREFIXU"]."_MD_RDF","RDF");
define($GLOBALS["VAR_PREFIXU"]."_MD_ATOM","ATOM");
define($GLOBALS["VAR_PREFIXU"]."_MD_OPML","OPML");

define($GLOBALS["VAR_PREFIXU"]."_MD_ARTICLES","Articles");
define($GLOBALS["VAR_PREFIXU"]."_MD_FEATURED","Featured");
define($GLOBALS["VAR_PREFIXU"]."_MD_CATEGORIES","Categories");

define($GLOBALS["VAR_PREFIXU"]."_MD_LANGUAGE","Language");
define($GLOBALS["VAR_PREFIXU"]."_MD_CHARSET","Charset");
define($GLOBALS["VAR_PREFIXU"]."_MD_IMAGE","Image");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACKPATTERN","Trackback pattern");
define($GLOBALS["VAR_PREFIXU"]."_MD_STATUS","Status");
define($GLOBALS["VAR_PREFIXU"]."_MD_URL","URL");
define($GLOBALS["VAR_PREFIXU"]."_MD_LINK","Link");
define($GLOBALS["VAR_PREFIXU"]."_MD_FEED","Feed");
define($GLOBALS["VAR_PREFIXU"]."_MD_FETCH","Fetch");
define($GLOBALS["VAR_PREFIXU"]."_MD_UPDATE","Update");
define($GLOBALS["VAR_PREFIXU"]."_MD_LASTUPDATE","Update");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRACKBACK","Trackback");
define($GLOBALS["VAR_PREFIXU"]."_MD_SUBMITTER","Submitter");
define($GLOBALS["VAR_PREFIXU"]."_MD_VIEWS","Views");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATE","Rate");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATEIT","Rate it!");
define($GLOBALS["VAR_PREFIXU"]."_MD_TIME", "Time");

define($GLOBALS["VAR_PREFIXU"]."_MD_UPDATED", "The blog is updated with %s articles inserted");
define($GLOBALS["VAR_PREFIXU"]."_MD_DBUPDATED", "Database has been updated");

define($GLOBALS["VAR_PREFIXU"]."_MD_PREVIOUS", "<<");
define($GLOBALS["VAR_PREFIXU"]."_MD_NEXT", ">>");


define($GLOBALS["VAR_PREFIXU"]."_MD_PENDING","Pending");
define($GLOBALS["VAR_PREFIXU"]."_MD_ACTIVE","Active");
define($GLOBALS["VAR_PREFIXU"]."_MD_EXPIRED","Expired");

/*
define($GLOBALS["VAR_PREFIXU"]."_MD_TYPES", "Types");
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

define($GLOBALS["VAR_PREFIXU"]."_MD_COMMENTS","Comments");
define($GLOBALS["VAR_PREFIXU"]."_MD_CLICKTOCOPY","Click to copy");

define($GLOBALS["VAR_PREFIXU"]."_MD_SORT", "Sort");

define($GLOBALS["VAR_PREFIXU"]."_MD_FULLVIEW", "Fulltext");
define($GLOBALS["VAR_PREFIXU"]."_MD_LISTVIEW", "List");
define($GLOBALS["VAR_PREFIXU"]."_MD_RATING", "Rating");
define($GLOBALS["VAR_PREFIXU"]."_MD_DEFAULT", "Default");
define($GLOBALS["VAR_PREFIXU"]."_MD_BLOGS", "Blogs");
define($GLOBALS["VAR_PREFIXU"]."_MD_BOOKMARKS", "Bookmarks");
define($GLOBALS["VAR_PREFIXU"]."_MD_HOME", "Home");

define($GLOBALS["VAR_PREFIXU"]."_MD_BLOGEXISTS", "A blog with the feed already exists");
define($GLOBALS["VAR_PREFIXU"]."_MD_EMPTY_BLOG", "Empty");

define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER", "Transfer");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER_DESC", "Transfer the article to other applications");
define($GLOBALS["VAR_PREFIXU"]."_MD_TRANSFER_DONE","The action is done successully: %s");
?>