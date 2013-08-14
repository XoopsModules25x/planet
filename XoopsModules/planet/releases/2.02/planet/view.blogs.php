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
include "header.php";

if(preg_match("/\/notification_update\.php/i", $_SERVER['REQUEST_URI'], $matches)){
	include XOOPS_ROOT_PATH.'/include/notification_update.php';
	exit();
}

if($REQUEST_URI_parsed = planet_parse_args($args_num, $args, $args_str)){
	$args["start"] = @$args_num[0];
	$args["sort"] = @$args_str[0];
}

/* Start */
$start = intval( empty($_GET["start"])?@$args["start"]:$_GET["start"] );
/* Specified Category */
$category_id = intval( empty($_GET["category"])?@$args["category"]:$_GET["category"] );
/* Specified Bookmar(Favorite) UID */
$uid = intval( empty($_GET["uid"])?@$args["uid"]:$_GET["uid"] );
/* Sort by term */
$sort = empty($_GET["sort"])?@$args["sort"]:$_GET["sort"];
/* Display as list */
$list = intval( empty($_GET["list"])?@$args["list"]:$_GET["list"] );
/*
// restore $_SERVER['REQUEST_URI']
if(!empty($REQUEST_URI_parsed)){
	$args_REQUEST_URI = array();
	$_args =array("start", "sort", "uid", "list");
	foreach($_args as $arg){
		if(!empty(${$arg})){
			$args_REQUEST_URI[] = $arg ."=". ${$arg};
		}
	}
	if(!empty($category_id)){
		$args_REQUEST_URI[] = "category=". $category_id;
	}
	$_SERVER['REQUEST_URI'] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php".
		(empty($args_REQUEST_URI)?"":"?".implode("&",$args_REQUEST_URI));
}
*/

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name"). " - " . planet_constant("MD_BLOGS");
$xoopsOption["template_main"] = planet_getTemplate("blogs");
include_once( XOOPS_ROOT_PATH . "/header.php" );
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

// Following part will not be executed after cache
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);

$limit = empty($list)? $xoopsModuleConfig["articles_perpage"] : $xoopsModuleConfig["list_perpage"];

$query_type = "";
$criteria = new CriteriaCompo();
$blog_prefix = "";
/* Specific category */
if($category_id >0){
	$category_obj = $category_handler->get($category_id);
	$criteria->add(new Criteria("bc.cat_id", $category_id));
	$uid = 0;
	$blog_id = 0;
	$category_data = array( "id" => $category_id, "title" => $category_obj->getVar("cat_title") );
	$query_type = "category";
	$blog_prefix = "b.";
}

/* User bookmarks(favorites) */
if($uid >0){
	$criteria->add(new Criteria("bm.bm_uid", $uid));
	$category_id = 0;
	$blog_id = 0;
	$bookmark_handler =& xoops_getmodulehandler("bookmark", $GLOBALS["moddirname"]);
	$user_data = array(
		"uid"	=> $uid, 
		"name"	=> XoopsUser::getUnameFromID($uid),
		"marks"	=> $bookmark_handler->getCount(new Criteria("bm_uid", $uid))
		);
	$query_type = "bookmark";
	$blog_prefix = "b.";
}

$criteria->add(new Criteria($blog_prefix."blog_status", 0, ">"));

/* Sort */
$order = "DESC";
$sort = empty($sort) ? "default" : $sort;
switch($sort){
	case "marks":
		$sortby = $blog_prefix."blog_marks";
		break;
	case "rating":
		$sortby = $blog_prefix."blog_rating";
		break;
	case "time":
		$sortby = $blog_prefix."blog_time";
		break;
	case "default":
	default:
		$sort = "default";
		$sortby = $blog_prefix."blog_id";
		break;
}
$criteria->setSort($sortby);
$criteria->setOrder($order);
$criteria->setStart($start);
$criteria->setLimit($limit);

$tags = empty($list) ? "" : array($blog_prefix."blog_title", $blog_prefix."blog_time");
switch($query_type){
case "category":
	$blogs_obj =& $blog_handler->getByCategory($criteria, $tags);
	$count_blog = $blog_handler->getCountByCategory($criteria);
	break;
case "bookmark":
	$blogs_obj =& $blog_handler->getByBookmark($criteria, $tags);
	$count_blog = $blog_handler->getCountByBookmark($criteria);
	break;
default:
	$blogs_obj =& $blog_handler->getAll($criteria, $tags);
	$count_blog = $blog_handler->getCount($criteria);
	break;
}

/* Objects to array */
$blogs = array();
foreach (array_keys($blogs_obj) as $id) {
	$_blog = array(
		"id"	=> $id,
		"title"	=> $blogs_obj[$id]->getVar("blog_title"),
		"time"	=> $blogs_obj[$id]->getTime()
		);
	if(empty($list)){
	$_blog = array_merge($_blog, array(
		"image"	=> $blogs_obj[$id]->getImage(),
		"feed"	=> $blogs_obj[$id]->getVar("blog_feed"),
		"link"	=> $blogs_obj[$id]->getVar("blog_link"),
		"desc"	=> $blogs_obj[$id]->getVar("blog_desc"),
		"star"	=> $blogs_obj[$id]->getStar(),
		"rates"	=> $blogs_obj[$id]->getVar("blog_rates"),
		"marks"	=> $blogs_obj[$id]->getVar("blog_marks")
		)
		);
	}
	$blogs[] = $_blog;
	unset($_blog);
}
unset($blogs_obj);

if ( $count_blog > $limit) {
	include(XOOPS_ROOT_PATH."/class/pagenav.php");
	$start_link = array();
	if($sort) $start_link[] = "sort=".$sort;
	if($category_id) $start_link[] = "category=".$category_id;
	if($list) $start_link[] = "list=".$list;
	$nav = new XoopsPageNav($count_blog, $limit, $start, "start", implode("&amp;", $start_link));
	$pagenav = $nav->renderNav(4);
} else {
	$pagenav = "";
}

$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"] );
$xoopsTpl -> assign("link_home", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php\" title=\"".planet_constant("MD_HOME")."\" target=\"_self\">".planet_constant("MD_HOME")."</a>");

if($category_id || $uid){
	$xoopsTpl -> assign("link_index", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php\" title=\"".planet_constant("MD_INDEX")."\" target=\"_self\">".planet_constant("MD_INDEX")."</a>");

	$link_articles = "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".
		(empty($category_id)?"":"/c".$category_id).
		(empty($uid)?"":"/u".$uid).
		"\" title=\"".planet_constant("MD_ARTICLES")."\">".planet_constant("MD_ARTICLES")."</a>";
	$xoopsTpl -> assign("link_articles", $link_articles);
}

$link_switch = "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php".
	(empty($category_id)?"":"/c".$category_id).
	(empty($uid)?"":"/u".$uid).
	(empty($list)?"/l1":"").
	"\" title=\"".(empty($list)?planet_constant("MD_LISTVIEW"):planet_constant("MD_FULLVIEW"))."\">".(empty($list)?planet_constant("MD_LISTVIEW"):planet_constant("MD_FULLVIEW"))."</a>";
$xoopsTpl -> assign("link_switch", $link_switch);

if(empty($uid) && is_object($xoopsUser)){
	$xoopsTpl -> assign("link_bookmark", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php".URL_DELIMITER."u".$xoopsUser->getVar("uid")."\" title=\"".planet_constant("MD_BOOKMARKS")."\" target=\"_self\">".planet_constant("MD_BOOKMARKS")."</a>");
}

if($xoopsModuleConfig["newblog_submit"]==1 || is_object($xoopsUser)){
	$xoopsTpl -> assign("link_submit", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/action.blog.php\" title=\""._SUBMIT."\" target=\"_blank\">"._SUBMIT."</a>");
}

$xoopsTpl -> assign("pagetitle", $xoopsModule->getVar("name")."::".planet_constant("MD_BLOGS"));
$xoopsTpl -> assign("category", @$category_data);
$xoopsTpl -> assign("user", @$user_data);
$xoopsTpl -> assign("blogs", $blogs);
$xoopsTpl -> assign("pagenav", $pagenav);
$xoopsTpl -> assign("count_blog", $count_blog);
$xoopsTpl -> assign("is_list", !empty($list));

$xoopsTpl -> assign("user_level", !is_object($xoopsUser)?0:($xoopsUser->isAdmin()?2:1));
if(empty($xoopsModuleConfig["anonymous_rate"]) && !is_object($xoopsUser)){
}elseif(!$list){
	$xoopsTpl -> assign("canrate", 1);
}

$sort_link = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php" . URL_DELIMITER;
$vars = array();
if(!empty($category_id)) $vars[] = "c".$category_id;
if(!empty($uid)) $vars[] = "u".$uid;
if(!empty($list)) $vars[] = "li";
if(!empty($vars)) $sort_link .= implode("/", $vars)."/";
$sortlinks = array();
$valid_sorts = array( "marks" => planet_constant("MD_BOOKMARKS"), "rating" => planet_constant("MD_RATING"), "time" => planet_constant("MD_TIME"), "default" => planet_constant("MD_DEFAULT") );
foreach($valid_sorts as $val => $name){
	if($val == $sort) continue;
	$sortlinks[] = "<a href=\"".$sort_link. $val."\">".$name."</a>";
}
$xoopsTpl -> assign("link_sort", implode(" | ", $sortlinks));

include_once "footer.php";
?>