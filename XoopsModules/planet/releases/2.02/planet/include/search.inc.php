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

if (!defined("XOOPS_ROOT_PATH")){ exit(); }

include dirname(__FILE__)."/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

planet_parse_function('
function &[VAR_PREFIX]_search($queryarray, $andor, $limit, $offset, 
	$uid = 0, $category = 0, $blog = 0,
	$sortby = "", $searchin = "", $extra = "")
{
	global $xoopsDB, $xoopsConfig, $myts, $xoopsUser;

	planet_define_url_delimiter();
	
	$searchin = empty($searchin)?array():(is_array($searchin)?$searchin:array($searchin));
	if(empty($searchin)){
		$searchin = array("title", "text");
	}
	if(in_array("title", $searchin) || in_array("text", $searchin)){
		$isArticle = true;
		if(!in_array($sortby, array("a.art_id", "a.art_time", "a.art_title"))) $sortby = "a.art_id DESC";
	}
	elseif(in_array("blog", $searchin) || in_array("feed", $searchin) || in_array("desc", $searchin)){
		$isBlog = true;
		if(!in_array($sortby, array("a.blog_id", "a.blog_time", "a.blog_title"))) $sortby = "a.blog_id DESC";
	}
	if(empty($isArticle) && empty($isBlog)) return false;
	
    /* Blog search */
    if(empty($isArticle)):
 	$sql = "SELECT".
    		" DISTINCT a.blog_id, a.blog_title, a.blog_feed, a.blog_time, a.blog_desc";
    $sql .= " FROM".
    		" ".planet_DB_prefix("blog")." AS a";
    /* regular search */
    else:
 	$sql = "SELECT".
    		" DISTINCT a.art_id, a.art_title, a.art_time";
    if(in_array("text", $searchin)){
	    $sql .= ", a.art_content";
    }
    $sql .= " FROM".
    		" ".planet_DB_prefix("article")." AS a";
    endif;
    
    if(!empty($category)):
    $sql .= " LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON bc.blog_id =a.blog_id";
    endif;
    if(!empty($uid)):
    $sql .= " LEFT JOIN ".planet_DB_prefix("bookmark")." AS bm ON bm.blog_id =a.blog_id";
    endif;
    
	$sql .= " WHERE 1=1";
    if(!empty($category)):
    $sql .= " AND bc.cat_id=".intval($category);
    endif;
    if(!empty($uid)):
    $sql .= " AND bm.bm_uid=".intval($uid);
    endif;
    if(!empty($blog)):
    $sql .= " AND a.blog_id=".intval($blog);
    endif;

	$count = count($queryarray);
	if ( is_array($queryarray) && $count > 0) {
		foreach($queryarray as $query){
			$query_array["title"][] = "a.art_title LIKE ".$xoopsDB->quoteString("%".$query."%");
			$query_array["text"][] = "a.art_content LIKE ".$xoopsDB->quoteString("%".$query."%");
			$query_array["blog"][] = "a.blog_title LIKE ".$xoopsDB->quoteString("%".$query."%");
			$query_array["feed"][] = "a.blog_feed LIKE ".$xoopsDB->quoteString("%".$query."%");
			$query_array["desc"][] = "a.blog_desc LIKE ".$xoopsDB->quoteString("%".$query."%");
		}
		foreach($query_array as $term => $terms){
			$querys[$term] = "(".implode(" $andor ", $terms).")";
		}
		foreach($searchin as $term){
			$query_term[] = $querys[$term];
		}
	    $sql .= " AND (".implode(" OR ",$query_term).") ";
	}

	if (empty($sortby)) {
	    $sortby = (empty($isArticle)?"a.art_id":"a.blog_id")." DESC";
	}
	$sql .= $extra." ORDER BY ".$sortby;
	
	$result = $xoopsDB->query($sql,$limit,$offset);
	
	$ret = array();
	$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
	$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
 	while($myrow = $xoopsDB->fetchArray($result)){
		if(empty($isArticle)):
        $object =& $blog_handler->create(false);
        else:
        $object =& $article_handler->create(false);
        endif;
        $object->assignVars($myrow);
        
        $sanitized_text = "";
    	if(in_array("text", $searchin) || in_array("desc", $searchin)):
    	if($object->getVar("art_content")):
		$text = $object->getVar("art_content");
    	else:
		$text = $object->getVar("blog_desc");
		endif;
		$reg = "(".implode("|", $queryarray).")";
		if(preg_match_all("/".$reg."/usi", $text, $matches)){
			$q = $queryarray[0];
			$p = strpos($text,$q);
			$f = $p - 100;
			$l = strlen($q) + 200;
			if($f < 0) $f = 0;
			$snippet = " ... ".	xoops_substr($text,$f,$l, "");
			$sanitized_text = preg_replace("#".$reg."#si", "<span class=\"highlight\">$1</span>", $snippet);
		}
		endif;
		
		if(empty($isArticle)):
        $ret[] = array(
        	"link" => "index.php".URL_DELIMITER."b".$myrow["blog_id"],
			"title" => $myrow["blog_title"],
			"time" => $myrow["blog_time"],
			"uid" => 1,
			"res_title" => $object->getTitle(),
			"res_time" => $object->getTime(),
			"res_text" => $sanitized_text
		);
		else:
        $ret[] = array(
        	"link" => "view.article.php".URL_DELIMITER."".$myrow["art_id"],
			"title" => $myrow["art_title"],
			"time" => $myrow["art_time"],
			"uid" => 1,
			"res_title" => $object->getTitle(),
			"res_time" => $object->getTime(),
			"res_text" => $sanitized_text
		);
		endif;
		unset($object, $sanitized_text, $matches);
	}

	return $ret;
}
');
?>