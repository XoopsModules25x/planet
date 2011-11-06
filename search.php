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

$xoopsOption["pagetype"] = "search";
include "header.php";
$xoopsModule->loadLanguage("main");
$config_handler =& xoops_gethandler("config");
$xoopsConfigSearch =& $config_handler->getConfigsByCat(XOOPS_CONF_SEARCH);
if (empty($xoopsConfigSearch["enable_search"])) {
    redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php", 2, planet_constant("MD_NOACCESS"));
    exit();
}

$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
$xoopsOption["template_main"] = planet_getTemplate("search");
include XOOPS_ROOT_PATH."/header.php";
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

include_once XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/include/search.inc.php";
$limit = $xoopsModuleConfig["articles_perpage"];

$queries = array();
$andor = isset($_POST["andor"]) ? $_POST["andor"] : (isset($_GET["andor"]) ? $_GET["andor"] : "");
$start = isset($_GET["start"]) ? $_GET["start"] : 0;
$category = intval( isset($_POST["category"]) ? $_POST["category"] : (isset($_GET["category"]) ? $_GET["category"] : null) );
$blog = intval( isset($_POST["blog"]) ? $_POST["blog"] : (isset($_GET["blog"]) ? $_GET["blog"] : null) );
$uid = intval( isset($_POST["uid"]) ? $_POST["uid"] : (isset($_GET["uid"]) ? $_GET["uid"] : null) );
$searchin = isset($_POST["searchin"]) ? $_POST["searchin"] : (isset($_GET["searchin"]) ? explode("|", $_GET["searchin"]) : array());
$sortby = isset($_POST["sortby"]) ? $_POST["sortby"] : (isset($_GET["sortby"]) ? $_GET["sortby"] : null);
$term = isset($_POST["term"]) ? $_POST["term"] : (isset($_GET["term"]) ? $_GET["term"] : "");

$andor = (in_array(strtoupper($andor), array("OR", "AND", "EXACT")))?strtoupper($andor):"OR";
$sortby = (in_array(strtolower($sortby), array("a.art_id desc", "a.art_time desc", "a.art_title", "a.blog_id", "b.blog_id", "b.blog_feed", "b.blog_title", "b.blog_time"))) ? strtolower($sortby) :  "";

if ( !( empty($_POST["submit"]) && empty($_GET["term"])) ) {
    $next_search["category"] = $category;
    $next_search["blog"] = $blog;
    $next_search["uid"] = $uid;
    $next_search["andor"] = $andor;

    $next_search["term"] = $term;
    $query = trim($term);

    if ( $andor != "EXACT" ) {
        $ignored_queries = array(); // holds kewords that are shorter than allowed minmum length
        $temp_queries = preg_split("/[\s,]+/", $query);
        foreach ($temp_queries as $q) {
            $q = trim($q);
            if (strlen($q) >= $xoopsConfigSearch["keyword_min"]) {
                $queries[] = $myts->addSlashes($q);
            } else {
                $ignored_queries[] = $myts->addSlashes($q);
            }
        }
        if (count($queries) == 0) {
            redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/search.php", 2, sprintf(_SR_KEYTOOSHORT, $xoopsConfigSearch["keyword_min"]));
            exit();
        }
    } else {
        if (strlen($query) < $xoopsConfigSearch["keyword_min"]) {
            redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/search.php", 2, sprintf(_SR_KEYTOOSHORT, $xoopsConfigSearch["keyword_min"]));
            exit();
        }
        $queries = array($myts->addSlashes($query));
    }

    $next_search["sortby"] = $sortby;
    $next_search["searchin"] = implode("|", $searchin);
    
    /* To be added: year-month 
     * see view.archive.php
     */
	if (!empty($time)) {
		$extra = "";
	}else{
		$extra = "";
	}

    $results = planet_search($queries, $andor, $limit, $start, 
    	$uid, $category, $blog,
    	$sortby, $searchin, $extra);

    /*
    if ( count($results) < 1 ) {
    	redirect_header("javascript:history.go(-1);", 2, _SR_NOMATCH);
    }
    else 
    */
    {
        $xoopsTpl->assign("results", $results);

        if(count($next_search)>0){
	        $items = array();
	        foreach($next_search as $para => $val){
		        if(!empty($val)) $items[] = "$para=$val";
	        }
	        if(count($items)>0) $paras = implode("&",$items);
	        unset($next_search);
	        unset($items);
        }
      	$search_url = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/search.php?".$paras;

      	/*
       	$next_results =& planet_search($queries, $andor, 1, $start + $limit, $uid, $category, $sortby, $searchin, $extra);
        $next_count = count($next_results);
        $has_next = false;
        if (is_array($next_results) && $next_count >0) {
            $has_next = true;
        }
        if (false != $has_next)
        */
        if (count($results))
        {
            $next = $start + $limit;
            $queries = implode(",",$queries);
            $search_url_next = $search_url."&start=$next";
            $search_next = "<a href=\"".htmlspecialchars($search_url_next)."\">"._SR_NEXT."</a>";
			$xoopsTpl->assign("search_next", $search_next);
        }
        if ( $start > 0 ) {
            $prev = $start - $limit;
            $search_url_prev = $search_url."&start=$prev";
            $search_prev = "<a href=\"".htmlspecialchars($search_url_prev)."\">"._SR_PREVIOUS."</a>";
			$xoopsTpl->assign("search_prev", $search_prev);
        }
    }

    unset($results);
	$search_info = _SR_KEYWORDS.": ".$myts->htmlSpecialChars($term);
	$xoopsTpl->assign("search_info", $search_info);
}

/* type */
$type_select = "<select name=\"andor\">";
$type_select .= "<option value=\"OR\"";
	if("OR" == $andor) $type_select .= " selected=\"selected\"";
	$type_select .= ">"._SR_ANY."</option>";
$type_select .= "<option value=\"AND\"";
	if("AND" == $andor) $type_select .= " selected=\"selected\"";
	$type_select .= ">"._SR_ALL."</option>";
$type_select .= "<option value=\"EXACT\"";
	if("exact" == $andor) $type_select .= " selected=\"selected\"";
	$type_select .= ">"._SR_EXACT."</option>";
$type_select .= "</select>";

/* scope */
$searchin_select = "";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"title\"";
	if(in_array("title", $searchin)) $searchin_select .= " checked";
	$searchin_select .= " />".planet_constant("MD_TITLE")."&nbsp;&nbsp;";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"text\"";
	if(in_array("text", $searchin)) $searchin_select .= " checked";
	$searchin_select .= " />".planet_constant("MD_BODY")."&nbsp;&nbsp;||&nbsp;&nbsp;";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"blog\"";
	if(in_array("blog", $searchin)) $searchin_select .= " checked";
	$searchin_select .= " />".planet_constant("MD_BLOG")."&nbsp;&nbsp;";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"feed\"";
	if(in_array("feed", $searchin)) $searchin_select .= " checked";
	$searchin_select .= " />".planet_constant("MD_FEED")."&nbsp;&nbsp;";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"desc\"";
	if(in_array("desc", $searchin)) $searchin_select .= " checked";
	$searchin_select .= " />".planet_constant("MD_DESC")."&nbsp;&nbsp;";
$searchin_select .= "<input type=\"checkbox\" name=\"searchin[]\" value=\"all\"";
	if(empty($searchin)) $searchin_select .= " checked";
	$searchin_select .= " />"._ALL."&nbsp;&nbsp;";

/* sortby */
$sortby_select = "<select name=\"sortby\">";
$sortby_select .= "<option value=\"\"";
	if(empty($sortby)) $sortby_select .= " selected=\"selected\"";
	$sortby_select .= ">"._NONE."</option>";
$sortby_select .= "<option value=\"a.art_time\"";
	if("a.art_time" == $sortby) $sortby_select .= " selected=\"selected\"";
	$sortby_select .= ">".planet_constant("MD_TIME")."</option>";
$sortby_select .= "<option value=\"a.art_title\"";
	if("a.art_title" == $sortby) $sortby_select .= " selected=\"selected\"";
	$sortby_select .= ">".planet_constant("MD_TITLE")."</option>";
$sortby_select .= "<option value=\"\">&nbsp;&nbsp;----&nbsp;&nbsp;</option>";
$sortby_select .= "<option value=\"a.blog_title\"";
	if("a.blog_title" == $sortby) $sortby_select .= " selected=\"selected\"";
	$sortby_select .= ">".planet_constant("MD_BLOG")."</option>";
$sortby_select .= "<option value=\"a.blog_time\"";
	if("b.blog_time" == $sortby) $sortby_select .= " selected=\"selected\"";
	$sortby_select .= ">".planet_constant("MD_UPDATE")."</option>";
$sortby_select .= "</select>";

$xoopsTpl->assign("type_select", $type_select);
$xoopsTpl->assign("searchin_select", $searchin_select);
$xoopsTpl->assign("sortby_select", $sortby_select);
$xoopsTpl->assign("search_term", $term);

$xoopsTpl->assign("modname", $xoopsModule->getVar("name"));

$xoopsTpl->assign("category", $category);
$xoopsTpl->assign("blog", $blog);
$xoopsTpl->assign("uid", $uid);

if ($xoopsConfigSearch["keyword_min"] > 0) {
	$xoopsTpl->assign("search_rule", sprintf(_SR_KEYIGNORE, $xoopsConfigSearch["keyword_min"]));
}

include XOOPS_ROOT_PATH."/footer.php";
?>