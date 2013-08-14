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
/* Specified Blog */
$blog_id = intval( empty($_GET["blog"])?@$args["blog"]:$_GET["blog"] );
/* Specified Bookmar(Favorite) UID */
$uid = intval( empty($_GET["uid"])?@$args["uid"]:$_GET["uid"] );
/* Sort by term */
$sort = empty($_GET["sort"])?@$args["sort"]:$_GET["sort"];
/* Display as list */
$list = intval( empty($_GET["list"])?@$args["list"]:$_GET["list"] );

// restore $_SERVER['REQUEST_URI']
if(!empty($REQUEST_URI_parsed)){
	$args_REQUEST_URI = array();
	$_args =array("start", "sort", "uid", "list");
	foreach($_args as $arg){
		if(!empty(${$arg})){
			$args_REQUEST_URI[] = $arg ."=". ${$arg};
		}
	}
	if(!empty($blog_id)){
		$args_REQUEST_URI[] = "blog=". $blog_id;
	}
	if(!empty($category_id)){
		$args_REQUEST_URI[] = "category=". $category_id;
	}
	$_SERVER['REQUEST_URI'] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".
		(empty($args_REQUEST_URI)?"":"?".implode("&",$args_REQUEST_URI));
}

$xoopsOption["template_main"] = planet_getTemplate("index");
$xoops_module_header = '
	<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').' rss" href="'.XOOPS_URL.'/modules/'.$GLOBALS["moddirname"].'/xml.php".URL_DELIMITER."rss/c'.$category_id.'/b'.$blog_id.'/u'.$uid.'" />
	<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').' rdf" href="'.XOOPS_URL.'/modules/'.$GLOBALS["moddirname"].'/xml.php".URL_DELIMITER."rdf/c'.$category_id.'/b'.$blog_id.'/u'.$uid.'" />
	<link rel="alternate" type="application/atom+xml" title="'.$xoopsModule->getVar('name').' atom" href="'.XOOPS_URL.'/modules/'.$GLOBALS["moddirname"].'/xml.php".URL_DELIMITER."atom/c'.$category_id.'/b'.$blog_id.'/u'.$uid.'" />
	';

$xoopsOption["xoops_module_header"] = $xoops_module_header;
include_once( XOOPS_ROOT_PATH . "/header.php" );
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

// Following part will not be executed after cache
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);

$limit = empty($list)? $xoopsModuleConfig["articles_perpage"] : $xoopsModuleConfig["list_perpage"];
$query_type = "";
$criteria = new CriteriaCompo();
$article_prefix = "";
/* Specific category */
if($category_id >0){
	$category_obj = $category_handler->get($category_id);
	$criteria->add(new Criteria("bc.cat_id", $category_id));
	$uid = 0;
	$blog_id = 0;
	$category_data = array("id"=>$category_id, "title"=>$category_obj->getVar("cat_title"));
	$query_type = "category";
	$article_prefix = "a.";
}
/* Specific blog */	
if($blog_id>0){
	$blog_obj =& $blog_handler->get($blog_id);
	if($blog_obj->getVar("blog_status") || 
		(is_object($xoopsUser) && $xoopsUser->getVar("uid")== $blog_obj->getVar("blog_submitter"))
		){
		$criteria->add(new Criteria("blog_id", $blog_id));
		$category_id = 0;
		$uid = 0;
		$bookmark_handler =& xoops_getmodulehandler("bookmark", $GLOBALS["moddirname"]);
		$blog_data = array(
			"id"=>$blog_id,
			"title"=>$blog_obj->getVar("blog_title"),
			"image"=>$blog_obj->getImage(),
			"title"=>$blog_obj->getVar("blog_title"),
			"feed"=>$blog_obj->getVar("blog_feed"),
			"link"=>$blog_obj->getVar("blog_link"),
			"desc"=>$blog_obj->getVar("blog_desc"),
			"time"=>$blog_obj->getTime(),
			"star"=>$blog_obj->getStar(),
			"rates"=>$blog_obj->getVar("blog_rates"),
			"marks"=>$blog_obj->getVar("blog_marks")
			);
	}
	$query_type = "blog";
	$article_prefix = "";
}
/* User bookmarks(favorites) */
if($uid >0){
	$criteria->add(new Criteria("bm.bm_uid", $uid));
	$category_id = 0;
	$blog_id = 0;
	$bookmark_handler =& xoops_getmodulehandler("bookmark", $GLOBALS["moddirname"]);
	$user_data = array(
		"uid"=>$uid, 
		"name"=>XoopsUser::getUnameFromID($uid),
		"marks"=>$bookmark_handler->getCount(new Criteria("bm_uid", $uid))
		);
	$query_type = "bookmark";
	$article_prefix = "a.";
}

/* Sort */
$order = "DESC";
$sort = empty($sort)?"time":$sort;
switch($sort){
	case "views":
		$sortby = $article_prefix."art_views";
		break;
	case "rating":
		$sortby = $article_prefix."art_rating";
		break;
	case "time":
		$sortby = $article_prefix."art_time";
		break;		
	case "default":
	default:
		$sortby = "";
		break;		
}
$criteria->setSort($sortby);
$criteria->setOrder($order);
$criteria->setStart($start);
$criteria->setLimit($limit);

$tags = empty($list)?"":array($article_prefix."art_title", $article_prefix."blog_id", $article_prefix."art_time");
switch($query_type){
case "category":
	$articles_obj =& $article_handler->getByCategory($criteria, $tags);
	$count_article = $article_handler->getCountByCategory($criteria);
	break;
case "bookmark":
	$articles_obj =& $article_handler->getByBookmark($criteria, $tags);
	$count_article = $article_handler->getCountByBookmark($criteria);
	break;
default:
	$articles_obj =& $article_handler->getAll($criteria, $tags);
	$count_article = $article_handler->getCount($criteria);
	break;
}

if(!empty($blog_data)){
	$blogs[$blog_data["id"]] = $blog_data["title"];
}else{
	$blog_array = array();
	foreach (array_keys($articles_obj) as $id) {
		$blog_array[$articles_obj[$id]->getVar("blog_id")] = 1;
	}
	$criteria_blog = new Criteria("blog_id", "(".implode(",", array_keys($blog_array)).")", "IN");
	$blogs = $blog_handler->getList($criteria_blog);
}

/* Objects to array */
$articles = array();
foreach (array_keys($articles_obj) as $id) {
	$_article = array(
		"id" => $id,
		"title" => $articles_obj[$id]->getVar("art_title"),
		"time" => $articles_obj[$id]->getTime(),
		"blog"=> array("id"=>$articles_obj[$id]->getVar("blog_id"), "title"=>$blogs[$articles_obj[$id]->getVar("blog_id")])
		);
	if(empty($list)){
		$_article = array_merge($_article, array(
			"author" => $articles_obj[$id]->getVar("art_author"),
			"views"=> $articles_obj[$id]->getVar("art_views"),
			"comments"=> $articles_obj[$id]->getVar("art_comments"),
			"star"=> $articles_obj[$id]->getStar(),
			"rates"=> $articles_obj[$id]->getVar("art_rates")
			)
		);
		if(!empty($xoopsModuleConfig["display_summary"])){
			$_article["content"] = $articles_obj[$id]->getSummary();
		}else{
			$_article["content"] = $articles_obj[$id]->getVar("art_content");
		}
	}
	$articles[] = $_article;
	unset($_article);
}
unset($articles_obj);

if ( $count_article > $limit) {
	include(XOOPS_ROOT_PATH."/class/pagenav.php");
	$start_link = array();
	if($sort) $start_link[] = "sort=".$sort;
	if($category_id) $start_link[] = "category=".$category_id;
	if($blog_id) $start_link[] = "blog=".$blog_id;
	if($list) $start_link[] = "list=".$list;
	$nav = new XoopsPageNav($count_article, $limit, $start, "start", implode("&amp;", $start_link));
	$pagenav = $nav->renderNav(4);
} else {
	$pagenav = "";
}

$xoopsTpl -> assign("xoops_module_header", $xoops_module_header );
$xoopsTpl -> assign("dirname", $GLOBALS["moddirname"] );

if($category_id || $blog_id || $uid){
	$xoopsTpl -> assign("link_index", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php\" title=\"".planet_constant("MD_INDEX")."\" target=\"_self\">".planet_constant("MD_INDEX")."</a>");
}

$link_switch = "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".
	(empty($category_id)?"":"/c".$category_id).
	(empty($uid)?"":"/u".$uid).
	(empty($blog_id)?"":"/b".$blog_id).
	(empty($list)?"/l1":"").
	"\" title=\"".(empty($list)?planet_constant("MD_LISTVIEW"):planet_constant("MD_FULLVIEW"))."\">".(empty($list)?planet_constant("MD_LISTVIEW"):planet_constant("MD_FULLVIEW"))."</a>";
$xoopsTpl -> assign("link_switch", $link_switch);

$link_blogs = "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.blogs.php".
	(empty($category_id)?"":"/c".$category_id).
	(empty($uid)?"":"/u".$uid).
	"\" title=\"".planet_constant("MD_BLOGS")."\">".planet_constant("MD_BLOGS").
	"</a>";
$xoopsTpl -> assign("link_blogs", $link_blogs);

if(empty($uid) && is_object($xoopsUser)){
	$xoopsTpl -> assign("link_bookmark", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."u".$xoopsUser->getVar("uid")."\" title=\"".planet_constant("MD_BOOKMARKS")."\" target=\"_self\">".planet_constant("MD_BOOKMARKS")."</a>");
}

if($xoopsModuleConfig["newblog_submit"]==1 || is_object($xoopsUser)){
	$xoopsTpl -> assign("link_submit", "<a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/action.blog.php\" title=\""._SUBMIT."\" target=\"_blank\">"._SUBMIT."</a>");
}

$xoopsTpl -> assign("pagetitle", $xoopsModule->getVar("name")."::".planet_constant("MD_ARTICLES"));
$xoopsTpl -> assign("category", @$category_data);
$xoopsTpl -> assign("blog", @$blog_data);
$xoopsTpl -> assign("user", @$user_data);
$xoopsTpl -> assign("articles", $articles);
$xoopsTpl -> assign("pagenav", $pagenav);
$xoopsTpl -> assign("is_list", !empty($list));

$xoopsTpl -> assign("user_level", !is_object($xoopsUser)?0:($xoopsUser->isAdmin()?2:1));
if(empty($xoopsModuleConfig["anonymous_rate"]) && !is_object($xoopsUser)){
}elseif($blog_id>0){
	$xoopsTpl -> assign("canrate", 1);
}

$sort_link = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".
	(empty($category_id)?"":"/c".$category_id).
	(empty($uid)?"":"/u".$uid).
	(empty($blog_id)?"":"/b".$blog_id).
	(empty($list)?"":"/l1");
$valid_sorts = array("views"=>planet_constant("MD_VIEWS"), "rating"=>planet_constant("MD_RATING"), "time"=>planet_constant("MD_TIME"), "default"=>planet_constant("MD_DEFAULT"));
$sortlinks = array();
foreach($valid_sorts as $val=>$name){
	if($val == $sort) continue;
	$sortlinks[] = "<a href=\"".$sort_link."/".$val."\">".$name."</a>";
}
$xoopsTpl -> assign("link_sort", implode(" | ", $sortlinks));
$xoopsTpl->assign('version', $xoopsModule->getVar("version"));

$xoopsTpl->assign('do_pseudocron', $xoopsModuleConfig["do_pseudocron"]);

// for notification
if(!empty($blog_id)){
	//$_SERVER['REQUEST_URI'] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php";
	$_GET["blog"] = $blog_id;
}

include_once "footer.php";
?>