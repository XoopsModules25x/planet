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

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH . "/modules/".$url_arr[2]."/include/vars.php";
include_once(XOOPS_ROOT_PATH . "/modules/".$GLOBALS["moddirname"]."/include/functions.php");

/**
 * Functions handling module blocks 
 * @package module::article
 *
 * @author  D.J. (phppp)
 * @copyright copyright &copy; 2000 The XOOPS Project
 *
 * @param VAR_PREFIX variable prefix for the function name
 */

planet_parse_function('
/**#@+
 * Function to display articles
 *
 * {@link article} 
 *
 * @param	array 	$options: 
 *						0 - criteria for fetching articles; 
 *						1 - limit for article count; 
 *						2 - title length; 
 *						3 - summary length; 
 */
function [VAR_PREFIX]_article_show($options)
{
    global $xoopsDB;
    planet_define_url_delimiter();

    $block = array();
    $select = "art_id";
    $disp_tag = "";
    $from = "";
    $where = "";
    $order = "art_time DESC";
    switch ($options[0]) {
        case "views":
            $select .= ", art_views";
            $order = "art_views DESC";
            $disp_tag = "art_views";
            break;
        case "rates":
            $select .= ", art_rates";
            $order = "art_rates DESC";
            $disp_tag = "art_rates";
            break;
        case "rating":
            $select .= ", art_rating/art_rates AS ave_rating";
            $order = "ave_rating DESC";
            $disp_tag = "ave_rating";
            break;
        case "random":
        	$order = "RAND()";
        	$mysql_version = substr(trim(mysql_get_server_info()), 0, 3);
        	/* for MySQL 4.1+ */
        	if($mysql_version >= "4.1"){
            	$from = " LEFT JOIN (SELECT art_id AS aid FROM ".planet_DB_prefix("article")." LIMIT 1000 ORDER BY art_id DESC) AS random ON art_id = random.aid";
            }
            break;
        case "time":
        default:
            $order = "art_time DESC";
            break;
    }
    $select .= ", blog_id, art_title, art_time";
	if($options[3]>0){
		$select .=", art_content";
	}
	
    $query = "SELECT $select FROM " . planet_DB_prefix("article"). $from;
    $query .= " ORDER BY " . $order;
    $result = $xoopsDB->query($query, $options[1], 0);
    if (!$result) {
        return false;
    }
    $rows = array();
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
    while ($row = $xoopsDB->fetchArray($result)) {
	    if(!empty($row["ave_rating"])) $row["art_rating"] = $row["ave_rating"];
        $article =& $article_handler->create(false);
        $article->assignVars($row);
        $_art = array();
        foreach($row as $tag=>$val) {
            $_art[$tag] = @$article->getVar($tag);
        }
        $_art["time"] = $article->getTime();
        if(!empty($disp_tag)){
	        $_art["disp"] = @$article->getVar($disp_tag);
	        if(!empty($row[$disp_tag]) && empty($_art["disp"])) $_art["disp"] = $row[$disp_tag];
        }
        if(!empty($options[2])){
	        $_art["art_title"] = xoops_substr($_art["art_title"], 0, $options[2]);
        }
        if(!empty($options[3])){
	        $_art["summary"] = $article->getSummary($options[3]);
        }
        $arts[] = $_art;
        unset($article, $_art);
        $bids[$row["blog_id"]] = 1;
    }

    $blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
    $blogs =& $blog_handler->getList(new Criteria("blog_id", "(".implode(",", array_keys($bids)).")", "IN"));

	for($i=0;$i<count($arts);$i++){
		$arts[$i]["blog"] = @$blogs[$arts[$i]["blog_id"]];
	}
	$block["articles"] = $arts;

    $block["dirname"] = $GLOBALS["moddirname"];
    return $block;
}

function [VAR_PREFIX]_article_edit($options)
{
    $form = planet_constant("MB_TYPE")."&nbsp;&nbsp;<select name=\"options[0]\">";
    $form .= "<option value=\"time\"";
	    if($options[0]=="time") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_TIME")."</option>\n";
    $form .= "<option value=\"views\"";
	    if($options[0]=="views") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_VIEWS")."</option>\n";
    $form .= "<option value=\"rates\"";
	    if($options[0]=="rates") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RATES")."</option>\n";
    $form .= "<option value=\"rating\"";
	    if($options[0]=="rating") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RATING")."</option>\n";
    $form .= "<option value=\"random\"";
	    if($options[0]=="random") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RANDOM")."</option>\n";
    $form .= "</select><br /><br />";

    $form .= planet_constant("MB_ITEMS")."&nbsp;&nbsp;<input type=\"text\" name=\"options[1]\" value=\"" . $options[1] . "\" /><br /><br />";
    $form .= planet_constant("MB_TITLE_LENGTH")."&nbsp;&nbsp;<input type=\"text\" name=\"options[2]\" value=\"" . $options[2] . "\" /><br /><br />";
    $form .= planet_constant("MB_SUMMARY_LENGTH")."&nbsp;&nbsp;<input type=\"text\" name=\"options[3]\" value=\"" . $options[3] . "\" /><br /><br />";

    return $form;
}

/**#@+
 * Function to display blogs
 *
 * {@link blog} 
 *
 * @param	array 	$options: 
 *						0 - criteria for fetching blogs; 
 *						1 - limit for blog count; 
 *						2 - title length; 
 *						3 - show desc; 
 */
function [VAR_PREFIX]_blog_show($options)
{
    global $xoopsDB;
    planet_define_url_delimiter();

    $block = array();
    $select = "blog_id";
    $disp_tag = "";
    $from = "";
    $where = "AND blog_status > 0";
    $order = "blog_id DESC";
    switch ($options[0]) {
        case "featured":
            $where = "AND blog_status=2";
            break;
        case "bookmark":
            $select .= ", blog_marks";
            $order = "blog_marks DESC";
            $disp_tag = "blog_marks";
            break;
        case "time":
            $select .= ", blog_time";
            $order = "blog_time DESC";
            break;
        case "rates":
            $select .= ", blog_rates";
            $order = "blog_rates DESC";
            $disp_tag = "blog_rates";
            break;
        case "rating":
            $select .= ", blog_rating/blog_rates AS ave_rating";
            $order = "ave_rating DESC";
            $disp_tag = "ave_rating";
            break;
        case "random":
        	$order = "RAND()";
        	$mysql_version = substr(trim(mysql_get_server_info()), 0, 3);
        	/* for MySQL 4.1+ */
        	if($mysql_version >= "4.1"){
	            $from = " LEFT JOIN (SELECT blog_id AS aid FROM ".planet_DB_prefix("blog")." LIMIT 1000 ORDER BY blog_id DESC) AS random ON blog_id = random.aid";
            }
            break;
        default:
            $order = "blog_id DESC";
            break;
    }
    $select .= ", blog_title";
    if(!empty($options[3])){
	    $select .=", blog_desc";
    }

    $query = "SELECT $select FROM " . planet_DB_prefix("blog"). $from;
    $query .= " WHERE 1=1 " . $where;
    $query .= " ORDER BY " . $order;
    $result = $xoopsDB->query($query, $options[1], 0);
    if (!$result) {
        return false;
    }
    $rows = array();
    $blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
    while ($row = $xoopsDB->fetchArray($result)) {
	    if(!empty($row["ave_rating"])) $row["art_rating"] = $row["ave_rating"];
        $blog =& $blog_handler->create(false);
        $blog->assignVars($row);
        $_art = array();
        foreach($row as $tag=>$val) {
            $_art[$tag] = @$blog->getVar($tag);
        }
        $_art["time"] = $blog->getTime();
        if(!empty($disp_tag)){
	        $_art["disp"] = @$blog->getVar($disp_tag);
	        if(!empty($row[$disp_tag]) && empty($_art["disp"])) $_art["disp"] = $row[$disp_tag];
        }
        if(!empty($options[2])){
	        $_art["blog_title"] = xoops_substr($_art["blog_title"], 0, $options[2]);
        }
        if(!empty($options[3])){
	        $_art["summary"] = $_art["blog_desc"];
        }        
        $blogs[] = $_art;
        unset($blog, $_art);
    }
	$block["blogs"] = $blogs;

    $block["dirname"] = $GLOBALS["moddirname"];
    return $block;
}

function [VAR_PREFIX]_blog_edit($options)
{
    $form = planet_constant("MB_TYPE")."&nbsp;&nbsp;<select name=\"options[0]\">";
    $form .= "<option value=\"featured\"";
	    if($options[0]=="featured") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_FEATURED")."</option>\n";
    $form .= "<option value=\"bookmarks\"";
	    if($options[0]=="bookmarks") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_BOOKMARKS")."</option>\n";
    $form .= "<option value=\"time\"";
	    if($options[0]=="time") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_TIME")."</option>\n";
    $form .= "<option value=\"views\"";
	    if($options[0]=="views") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_VIEWS")."</option>\n";
    $form .= "<option value=\"rates\"";
	    if($options[0]=="rates") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RATES")."</option>\n";
    $form .= "<option value=\"rating\"";
	    if($options[0]=="rating") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RATING")."</option>\n";
    $form .= "<option value=\"random\"";
	    if($options[0]=="random") $form .= " selected=\"selected\" ";
	    $form .= ">".planet_constant("MB_TYPE_RANDOM")."</option>\n";
    $form .= "</select><br /><br />";

    $form .= planet_constant("MB_ITEMS")."&nbsp;&nbsp;<input type=\"text\" name=\"options[1]\" value=\"" . $options[1] . "\" /><br /><br />";
    $form .= planet_constant("MB_TITLE_LENGTH")."&nbsp;&nbsp;<input type=\"text\" name=\"options[2]\" value=\"" . $options[2] . "\" /><br /><br />";
    $form .= planet_constant("MB_SHOWDESC")."&nbsp;&nbsp;<input type=\"text\" name=\"options[3]\" value=\"" . $options[3] . "\" /><br /><br />";

    return $form;
}

/**#@-*/

/**#@+
 * Function to display categories
 *
 * {@link Xcategory} 
 * {@link config} 
 *
 * @param	array 	$options (not used) 
 */
function [VAR_PREFIX]_category_show($options)
{
    planet_define_url_delimiter();
    $block = array();
	$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);
	$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
	$crit = new Criteria("1", 1);
	$crit->setSort("cat_order");
	$crit->setOrder("ASC");
	$categories = $category_handler->getList($crit);
	$blog_counts = $blog_handler->getCountsByCategory();
	foreach($categories as $id=>$cat){
		$block["categories"][]=array("id"=>$id, "title"=>$cat, "blogs"=> @intval($blog_counts[$id]));
	}
    $block["dirname"] = $GLOBALS["moddirname"];
    unset($categories, $cats_stats);
    return $block;
}
/**#@-*/
');
?>