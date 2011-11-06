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

/**
 * The comment detection scripts should be removed once absolute url is used in comment_view.php
 * The notification detection scripts should be removed once absolute url is used in notification_select.php
 *
 */
if(preg_match("/(\/comment_[^\.]*\.php\?.*=.*)/i", $_SERVER["REQUEST_URI"], $matches)){
	header("location: ".XOOPS_URL."/modules/".$GLOBALS["moddirname"].$matches[1]);
	exit();
}
if(preg_match("/\/notification_update\.php/i", $_SERVER['REQUEST_URI'], $matches)){
	include XOOPS_ROOT_PATH.'/include/notification_update.php';
	exit();
}

if($REQUEST_URI_parsed = planet_parse_args($args_num, $args, $args_str)){
	$args["article"] = @$args_num[0];
	$args["blog"] = @$args["blog"];
}

$article_id = intval( empty($_GET["article"])?@$args["article"]:$_GET["article"] );
$blog_id = intval( empty($_GET["blog"])?@$args["blog"]:$_GET["blog"] );

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
$article_obj =& $article_handler->get($article_id);
$blog_obj =& $blog_handler->get($article_obj->getVar("blog_id"));

// restore $_SERVER['REQUEST_URI']
if(!empty($REQUEST_URI_parsed)){
	$_SERVER['REQUEST_URI'] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".
		(empty($article_id)?"":"?article=".$article_id);
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name"). " - " .$article_obj->getVar("art_title");
$xoopsOption["template_main"] = planet_getTemplate("article");
include_once( XOOPS_ROOT_PATH . "/header.php" );
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

$article_data = array(
	"id" => $article_id,
	"title" => $article_obj->getVar("art_title"),
	"content" => $article_obj->getVar("art_content"),
	"author" => $article_obj->getVar("art_author"),
	"time" => $article_obj->getTime(),
	"link" => $article_obj->getVar("art_link"),
	"views"=> $article_obj->getVar("art_views"),
	"comments"=> $article_obj->getVar("art_comments"),
	"star"=> $article_obj->getStar(),
	"rates"=> $article_obj->getVar("art_rates"),
	"blog"=> array("id"=>$article_obj->getVar("blog_id"), "title"=>$blog_obj->getVar("blog_title"))
	);

if(!empty($xoopsModuleConfig["do_sibling"])){
	$articles_sibling =& $article_handler->getSibling($article_obj, $blog_id);
	if(!empty($articles_sibling["previous"])) {
		$articles_sibling["previous"]["url"] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".URL_DELIMITER."".$articles_sibling["previous"]["id"]."/b".$blog_id;
		$articles_sibling["previous"]["title"] = $articles_sibling["previous"]["title"];
	}
	if(!empty($articles_sibling["next"])){
		$articles_sibling["next"]["url"] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".URL_DELIMITER."".$articles_sibling["next"]["id"]."/b".$blog_id;
		$articles_sibling["next"]["title"] = $articles_sibling["next"]["title"];
	}
}

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));

$xoopsTpl -> assign("article", $article_data);
$xoopsTpl -> assign("sibling", $articles_sibling);

$xoopsTpl -> assign("user_level", !is_object($xoopsUser)?0:($xoopsUser->isAdmin()?2:1));
if(empty($xoopsModuleConfig["anonymous_rate"]) && !is_object($xoopsUser)){
}else{
	$xoopsTpl -> assign("canrate", 1);
}

if($transferbar = @include(XOOPS_ROOT_PATH."/Frameworks/transfer/bar.transfer.php")){
	$xoopsTpl->assign('transfer', $transferbar);
}

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

// for comment and notification
//$_SERVER['REQUEST_URI'] = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php";
$_GET["article"] = $article_id;
include XOOPS_ROOT_PATH."/include/comment_view.php";

include_once "footer.php";
?>