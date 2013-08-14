<?php
// $Id$
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

include dirname(__FILE__)."/include/vars.php";

$modversion = array(
	"name"			=> planet_constant("MI_NAME"),
	"version"		=> 2.02,
	"description"	=> planet_constant("MI_DESC"),
	"credits" 		=> "The Xoops Project",
	"image"			=> "images/logo.png",
	"dirname"		=> $GLOBALS["moddirname"],
	"author"		=> "D.J. (phppp)",
	"help" 			=> XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/readme.html"
	);

$modversion["help"] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/readme.html";
$modversion["license"] = "GNU see LICENSE";
$modversion["license_file"] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/gpl.txt";
$modversion["release"] = "2006-01-29";

$modversion["author_website_url"] = "http://xoopsforge.com";
$modversion["author_website_name"] = "Xoops Forge";
$modversion["author_word"] = "
";

$modversion["module_status"] = "stable";
$modversion["module_team"] = "
";
$modversion["module_website_url"] = "http://xoopsforge.com/modules/planet/";
$modversion["module_website_name"] = "XOOPS FORGE";


// database tables
$modversion["sqlfile"]["mysql"] = "sql/mysql.sql";
$modversion["tables"] = array(
	$GLOBALS["MOD_DB_PREFIX"]."_category",
	$GLOBALS["MOD_DB_PREFIX"]."_article",
	$GLOBALS["MOD_DB_PREFIX"]."_blog",
	$GLOBALS["MOD_DB_PREFIX"]."_blogcat",
	$GLOBALS["MOD_DB_PREFIX"]."_bookmark",
	$GLOBALS["MOD_DB_PREFIX"]."_rate"
);

// Admin things
$modversion["hasAdmin"] = 1;
$modversion["adminindex"] = "admin/index.php";
$modversion["adminmenu"] = "admin/menu.php";

// Menu
$modversion["hasMain"] = 1;
$modversion["pages"][2] = array("url"=>"index.php", "name"=>planet_constant("MI_PAGE_INDEX"));
$modversion["pages"][3] = array("url"=>"view.article.php", "name"=>planet_constant("MI_PAGE_ARTICLE"));
$modversion["pages"][4] = array("url"=>"view.archive.php", "name"=>planet_constant("MI_PAGE_ARCHIVE"));
$modversion["pages"][5] = array("url"=>"view.list.php", "name"=>planet_constant("MI_PAGE_LIST"));
$modversion["sub"][1]	= array("name" => planet_constant("MI_SUBMIT"), "url"=>"action.blog.php");

// Use smarty
$modversion["use_smarty"] = 1;

$modversion["onInstall"] = "include/action.module.php";
$modversion["onUpdate"] = "include/action.module.php";

/**
* Templates
*/
$modversion['templates'][] = array( "file" => $GLOBALS["VAR_PREFIX"]."_index.html", "description"=>"");
$modversion['templates'][] = array( "file" => $GLOBALS["VAR_PREFIX"]."_article.html", "description"=>"");
$modversion['templates'][] = array( "file" => $GLOBALS["VAR_PREFIX"]."_archive.html", "description"=>"");
$modversion['templates'][] = array( "file" => $GLOBALS["VAR_PREFIX"]."_blogs.html", "description"=>"");
$modversion['templates'][] = array( "file" => $GLOBALS["VAR_PREFIX"]."_search.html", "description"=>"");

//module css
$modversion['css'] = 'templates/style.css';

// Blocks
$i=0;

$i++;
$modversion["blocks"][$i]["file"] = "block.php";
$modversion["blocks"][$i]["name"] = planet_constant("MI_ARTICLE");
$modversion["blocks"][$i]["description"] = planet_constant("MI_ARTICLE_DESC");
$modversion["blocks"][$i]["show_func"] = $GLOBALS["VAR_PREFIX"]."_article_show";
$modversion["blocks"][$i]["options"] = "time|10|0|0"; // type|MaxItems|TitleLength|SummaryLength
$modversion["blocks"][$i]["edit_func"] = $GLOBALS["VAR_PREFIX"]."_article_edit";
$modversion["blocks"][$i]["template"] = $GLOBALS["VAR_PREFIX"]."_block_article.html";

$i++;
$modversion["blocks"][$i]["file"] = "block.php";
$modversion["blocks"][$i]["name"] = planet_constant("MI_CATEGORY");
$modversion["blocks"][$i]["description"] = planet_constant("MI_CATEGORY_DESC");
$modversion["blocks"][$i]["show_func"] = $GLOBALS["VAR_PREFIX"]."_category_show";
$modversion["blocks"][$i]["template"] = $GLOBALS["VAR_PREFIX"]."_block_category.html";

$i++;
$modversion["blocks"][$i]["file"] = "block.php";
$modversion["blocks"][$i]["name"] = planet_constant("MI_BLOG");
$modversion["blocks"][$i]["description"] = planet_constant("MI_BLOG_DESC");
$modversion["blocks"][$i]["show_func"] = $GLOBALS["VAR_PREFIX"]."_blog_show";
$modversion["blocks"][$i]["options"] = "feature|10|0|1"; // type|MaxItems|TitleLength|ShowDesc
$modversion["blocks"][$i]["edit_func"] = $GLOBALS["VAR_PREFIX"]."_blog_edit";
$modversion["blocks"][$i]["template"] = $GLOBALS["VAR_PREFIX"]."_block_blog.html";

// Search
$modversion["hasSearch"] = 1;
$modversion["search"]["file"] = "include/search.inc.php";
$modversion["search"]["func"] = $GLOBALS["VAR_PREFIX"]."_search";

// Comments
$modversion["hasComments"] = 1;
//$modversion["comments"]["pageName"] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php";
$modversion["comments"]["pageName"] = "view.article.php";
$modversion["comments"]["itemName"] = "article";

// Comment callback functions
$modversion["comments"]["callbackFile"] = "include/comment.inc.php";
$modversion["comments"]["callback"]["approve"] = $GLOBALS["VAR_PREFIX"]."_com_approve";
$modversion["comments"]["callback"]["update"] = $GLOBALS["VAR_PREFIX"]."_com_update";

// Configs
// Config items
$modversion["config"][] = array(
	"name" 			=> "do_debug",
	"title" 		=> $GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG",
	"description" 	=> $GLOBALS["VAR_PREFIXU"]."_MI_DODEBUG_DESC",
	"formtype" 		=> "yesno",
	"valuetype" 	=> "int",
	"default" 		=> 1
	);

$modversion["config"][] = array(
	"name" 			=> "do_urw",
	"title" 		=> $GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE",
	"description" 	=> $GLOBALS["VAR_PREFIXU"]."_MI_DOURLREWRITE_DESC",
	"formtype" 		=> "yesno",
	"valuetype" 	=> "int",
	"default" 		=> in_array(php_sapi_name(), array("apache", "apache2handler"))
	);

$modversion["config"][] = array(
	"name" => "theme_set",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_THEMESET",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_THEMESET_DESC",
	"formtype"=> "select",
	"valuetype" => "text",
	"options"=> array(_NONE=>"0"),
	"default" => ""
	);

$modversion["config"][] = array(
	"name" => "timeformat",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_DESC",
	"formtype" => "select",
	"valuetype" 	=> "text",
	'options' 		=> array(
					_DATESTRING=>"l",
					_MEDIUMDATESTRING=>"m",
					_SHORTDATESTRING=>"s",
					$GLOBALS["VAR_PREFIXU"]."_MI_TIMEFORMAT_CUSTOM"=>"c"),
	"default" 		=> "c"
	);

$modversion["config"][] = array(
	"name" => "articles_perpage",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_ARTICLESPERPAGE_DESC",
	"formtype" => "textbox",
	"valuetype" => "int",
	"default" => 10
	);

$modversion["config"][] = array(
	"name" => "list_perpage",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_LISTPERPAGE_DESC",
	"formtype" => "textbox",
	"valuetype" => "int",
	"default" => 20
	);

$modversion["config"][] = array(
	"name" => "blogs_perupdate",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_BLOGSPERUPDATE_DESC",
	"formtype" => "textbox",
	"valuetype" => "int",
	"default" => 10
	);

$modversion["config"][] = array(
	"name" => "article_expire",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE_DESC",
	"formtype" => "textbox",
	"valuetype" => "int",
	"default" => 30
	);

$modversion["config"][] = array(
	"name" => "display_summary",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY_DESC",
	"formtype" => "textbox",
	"valuetype" => "int",
	"default" => 0
	);

$modversion["config"][] = array(
	"name" 			=> "do_sibling",
	"title" 		=> $GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING",
	"description" 	=> $GLOBALS["VAR_PREFIXU"]."_MI_DOSIBLING_DESC",
	"formtype" 		=> "yesno",
	"valuetype" 	=> "int",
	"default" 		=> 1
	);

$modversion["config"][] = array(
	"name" 			=> "pings",
	"title" 		=> $GLOBALS["VAR_PREFIXU"]."_MI_PING",
	"description" 	=> $GLOBALS["VAR_PREFIXU"]."_MI_PING_DESC",
	"formtype" 		=> "textarea",
	"valuetype" 	=> "text",
	"default" 		=> ""
	);

$modversion['config'][] = array(
	'name' 			=> 'trackback_option',
	'title' 		=> $GLOBALS["VAR_PREFIXU"].'_MI_TRACKBACK_OPTION',
	'description' 	=> $GLOBALS["VAR_PREFIXU"].'_MI_TRACKBACK_OPTION_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'int',
	'default' 		=> 0,
	'options' 		=> array(planet_constant("MI_MODERATION")=>0, _ALL=>1, _NONE=>2)
	);

$modversion["config"][] = array(
	"name" => "copyright",
	"title" => $GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT",
	"description" => $GLOBALS["VAR_PREFIXU"]."_MI_COPYRIGHT_DESC",
	"formtype" => "textbox",
	"valuetype" => "text",
	"default" => "Copyright&copy; %s & ".$xoopsConfig["sitename"]
	);

$modversion['config'][] = array(
	'name' 			=> 'newblog_submit',
	'title' 		=> $GLOBALS["VAR_PREFIXU"].'_MI_NEWBLOG_SUBMIT',
	'description' 	=> $GLOBALS["VAR_PREFIXU"].'_MI_NEWBLOG_SUBMIT_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'int',
	'default' 		=> 2,
	'options' 		=> array(_NONE=>0, planet_constant("MI_MODERATION")=>1, planet_constant("MI_MEMBER")=>2, _ALL=>3)
		// 0 - Only admin; 1 - all but need approval; 2 - members auto approved; 3 - all
	);

$modversion['config'][] = array(
	'name' => 'anonymous_rate',
	'title' => $GLOBALS["VAR_PREFIXU"].'_MI_ANONYMOUSRATE',
	'description' => $GLOBALS["VAR_PREFIXU"].'_MI_ANONYMOUSRATE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'do_pseudocron',
	'title' => $GLOBALS["VAR_PREFIXU"].'_MI_PSEUDOCRON',
	'description' => $GLOBALS["VAR_PREFIXU"].'_MI_PSEUDOCRON_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

// Notification

$modversion["hasNotification"] = 1;
$modversion["notification"]["lookup_file"] = "include/notification.inc.php";
$modversion["notification"]["lookup_func"] = $GLOBALS["VAR_PREFIX"]."_notify_iteminfo";

$i=0;
$i++;
$modversion["notification"]["category"][$i]["name"] = "global";
$modversion["notification"]["category"][$i]["title"] = planet_constant("MI_GLOBAL_NOTIFY");
$modversion["notification"]["category"][$i]["description"] = planet_constant("MI_GLOBAL_NOTIFYDSC");
$modversion["notification"]["category"][$i]["subscribe_from"] = array("index.php");
$modversion["notification"]["category"][$i]["allow_bookmark"] = 1;

$i++;
$modversion["notification"]["category"][$i]["name"] = "blog";
$modversion["notification"]["category"][$i]["title"] = planet_constant("MI_BLOG_NOTIFY");
$modversion["notification"]["category"][$i]["description"] = planet_constant("MI_BLOG_NOTIFYDSC");
$modversion["notification"]["category"][$i]["subscribe_from"] = array("index.php");
$modversion["notification"]["category"][$i]["item_name"] = "blog";
$modversion["notification"]["category"][$i]["allow_bookmark"] = 1;

$i++;
$modversion["notification"]["category"][$i]["name"] = "article";
$modversion["notification"]["category"][$i]["title"] = planet_constant("MI_ARTICLE_NOTIFY");
$modversion["notification"]["category"][$i]["description"] = planet_constant("MI_ARTICLE_NOTIFYDSC");
$modversion["notification"]["category"][$i]["subscribe_from"] = array("view.article.php");
$modversion["notification"]["category"][$i]["item_name"] = "article";
$modversion["notification"]["category"][$i]["allow_bookmark"] = 1;

$i=0;
$i++;
$modversion["notification"]["event"][$i]["name"] = "blog_submit";
$modversion["notification"]["event"][$i]["category"] = "global";
$modversion["notification"]["event"][$i]["admin_only"] = 1;
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_GLOBAL_BLOGSUBMIT_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_GLOBAL_BLOGSUBMIT_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_GLOBAL_BLOGSUBMIT_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "global_blogsubmit_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_GLOBAL_BLOGSUBMIT_NOTIFYSBJ");

$i++;
$modversion["notification"]["event"][$i]["name"] = "article_monitor";
$modversion["notification"]["event"][$i]["category"] = "global";
$modversion["notification"]["event"][$i]["invisible"] = 1;
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_GLOBAL_ARTICLEMONITOR_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_GLOBAL_ARTICLEMONITOR_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_GLOBAL_ARTICLEMONITOR_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "global_articlemonitor_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_GLOBAL_ARTICLEMONITOR_NOTIFYSBJ");

$i++;
$modversion["notification"]["event"][$i]["name"] = "blog_new";
$modversion["notification"]["event"][$i]["category"] = "global";
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_GLOBAL_NEWBLOG_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_GLOBAL_NEWBLOG_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_GLOBAL_NEWBLOG_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "global_newblog_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_GLOBAL_NEWBLOG_NOTIFYSBJ");

$i++;
$modversion["notification"]["event"][$i]["name"] = "blog_approve";
$modversion["notification"]["event"][$i]["category"] = "blog";
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_BLOG_BLOGAPPROVE_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_BLOG_BLOGAPPROVE_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_BLOG_BLOGAPPROVE_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "blog_approve_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_BLOG_BLOGAPPROVE_NOTIFYSBJ");

$i++;
$modversion["notification"]["event"][$i]["name"] = "blog_update";
$modversion["notification"]["event"][$i]["category"] = "blog";
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_BLOG_BLOGUPATE_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_BLOG_BLOGUPATE_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_BLOG_BLOGUPATE_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "blog_update_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_BLOG_BLOGUPATE_NOTIFYSBJ");

$i++;
$modversion["notification"]["event"][$i]["name"] = "article_monitor";
$modversion["notification"]["event"][$i]["category"] = "article";
$modversion["notification"]["event"][$i]["title"] = planet_constant("MI_ARTICLE_ARTICLEMONITOR_NOTIFY");
$modversion["notification"]["event"][$i]["caption"] = planet_constant("MI_ARTICLE_ARTICLEMONITOR_NOTIFYCAP");
$modversion["notification"]["event"][$i]["description"] = planet_constant("MI_ARTICLE_ARTICLEMONITOR_NOTIFYDSC");
$modversion["notification"]["event"][$i]["mail_template"] = "article_monitor_notify";
$modversion["notification"]["event"][$i]["mail_subject"] = planet_constant("MI_ARTICLE_ARTICLEMONITOR_NOTIFYSBJ");
?>