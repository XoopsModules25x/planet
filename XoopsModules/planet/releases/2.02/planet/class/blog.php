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
/**
 * @package module::blogline
 * @copyright copyright &copy; 2005 XoopsForge.com
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}
include_once dirname(dirname(__FILE__))."/include/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

/**
 * Xtopic 
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/
if(!class_exists("Bblog")):

class Bblog extends ArtObject
{
    /**
     * Constructor
     */
    function Bblog()
    {
	    $this->ArtObject();
        $this->table = planet_DB_prefix("blog");
        $this->initVar("blog_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("blog_title", XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar("blog_desc", XOBJ_DTYPE_TXTBOX, null);
        /* rss URI */
        $this->initVar("blog_feed", XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar("blog_language", XOBJ_DTYPE_TXTBOX, null);
        $this->initVar("blog_charset", XOBJ_DTYPE_TXTBOX, null);
        /* blog website */
        $this->initVar("blog_link", XOBJ_DTYPE_TXTBOX, null);
        $this->initVar("blog_image", XOBJ_DTYPE_TXTBOX, null);
        
        /* regexp for blog article trackback
         * From article url to article trackback URI
         *
         * For example: http://www.example.com/blog/111.html => http://www.example.com/blog/trackback/111.html
         * The input shall be: pattern[SPACE]replacement
         *                     (.*blog/)([\d]+\.html$) $1trackback/$2      
         *
         * For example: http://www.example.com/modules/wordpress/?p=123 => http://www.example.com/modules/wordpress/wp-trackback.php?p=123
         * The input shall be: pattern[SPACE]replacement
         *                     (.*wordpress/)(index.php)?(\?p.*) $1wp-trackback/$3      
         */
        $this->initVar("blog_trackback", XOBJ_DTYPE_TXTBOX, "");
        
        /* blog submitter: is_numeric - uid; is_string - IP */
        $this->initVar("blog_submitter", XOBJ_DTYPE_TXTBOX, "");
        
        /* blog status: 0 - pending; 1 - active; 2 - featured */ 
        $this->initVar("blog_status", XOBJ_DTYPE_INT, 1);
        
        /* key for blog content */
        $this->initVar("blog_key", XOBJ_DTYPE_TXTBOX, "");
        
        $this->initVar("blog_time", XOBJ_DTYPE_INT, 0);
        $this->initVar("blog_rating", XOBJ_DTYPE_INT, 0);
        $this->initVar("blog_rates", XOBJ_DTYPE_INT, 0);
        /* bookmark times */
        $this->initVar("blog_marks", XOBJ_DTYPE_INT, 0);
    }

    /**
     * get formatted publish time of the article
     * 
 	 * {@link Config} 
 	 *
     * @param string $format format of time
     * @return string
     */
    function getTime($format ="")
    {
	    $time = planet_formatTimestamp($this->getVar("blog_time"), $format);
		return $time;
    }
    
    /**
     * get verified image url of the category
     * 
     * @return 	string
     */
    function getImage()
    {
		$image = $this->getVar("blog_image");
		return $image;
    }
    
    /**
     * get rating average of the article
     * 
     * @param int $decimals decimal length
     * @return numeric
     */
    function getRatingAverage($decimals = 1)
    {
	    $ave=3;
	    if($this->getVar("blog_rates")){
	    	$ave = number_format($this->getVar("blog_rating")/$this->getVar("blog_rates"),$decimals);
    	}
	    return $ave;
    }

    function getStar()
    {
	    return $this->getRatingAverage(0);
    }
}
endif;
/**
* Topic object handler class.  
* @package module::article
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2005 The XOOPS Project
*
* {@link XoopsPersistableObjectHandler} 
*
* @param CLASS_PREFIX variable prefix for the class name
*/

planet_parse_class('
class [CLASS_PREFIX]BlogHandler extends ArtObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function [CLASS_PREFIX]BlogHandler(&$db) {
        $this->ArtObjectHandler($db, planet_DB_prefix("blog", true), "Bblog", "blog_id", "blog_title");
    }

    /**
     * Fetch blog info by parsing given feed
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of blogs {@link Bblog}
     */
    function &fetch($feed)
    {
	    $feed = formatURL($feed);
	    $blog =& $this->create();
	    $content = planet_remote_content($feed);
	    if(empty($content)){
		    return $blog;
	    }
		if (preg_match("/<\?xml.*encoding=[\'\"](.*?)[\'\"].*\?>/m", $content, $match)) {
			$charset = strtoupper($match[1]);
		}else {
			$charset = "UTF-8";
		}
		$res = $this->parse($content, $charset, array("channel", "image"));
		
		$blog->setVar("blog_feed", $feed);
		$blog->setVar("blog_charset", $charset);
		$blog->setVar("blog_language", @$res["channel"]["language"]);
		$blog->setVar("blog_title", $res["channel"]["title"]);
		$blog->setVar("blog_desc", $res["channel"]["description"]);
		$blog->setVar("blog_link", $res["channel"]["link"]);
		$blog->setVar("blog_image", @$res["image"]["url"]);
		
		return $blog;
    }
    
    /**
     * check if content has been updated according to a stored key (md5)
     * 
     * @param 	object	$blog 	
     * @param 	string	$content 	fetched content
     * @param 	bool	$update 	update articles
     * @return 	mixed	key or updated article count
     */
    function do_update(&$blog, $update = true)
    {
	    $content = planet_remote_content($blog->getVar("blog_feed"));
	    if(empty($content)){
		    planet_message("Empty content");
		    return false;
	    }
		
	    /* quick fetch items */
	    $is_rss = true;
	    if( !$pos_end = planet_strrpos($content, "</item>") ){
	    	if(!$pos_end = planet_strrpos($content, "</entry>")) {
		    	planet_message("blog ID ".$blog->getVar("blog_id").": No item/entry found!");
		    	return false;
	    	}
	    	$is_rss = false;
	    }
	    if(!empty($is_rss)){
	    	if(!$pos_start = strpos($content, "<item>")) {
		    	if(!$pos_start = strpos($content, "<item ")) {
		    		planet_message("blog ID ".$blog->getVar("blog_id").": No item found!");
			    	return false;
		    	}
	    	}
	    }elseif((!$pos_start = strpos($content, "<entry>")) && (!$pos_start = strpos($content, "<entry "))){ 
		    planet_message("blog ID ".$blog->getVar("blog_id").": No entry found!");
		    return false;
	    }
	    
	    /* check if content has changed */
	    $key = md5(substr($pos_start, $pos_end, $content));
	    if($key == $blog->getVar("blog_key")) {
		    planet_message("key identical!");
		    return false;
	    }
	    if(empty($update)) return $key;
	    
	    
	    /* parse items */
	    $res = $this->parse($content, $blog->getVar("blog_charset"), array("items"));
	    $items = $res["items"];
	    $blog_time = 0;
	    $crit = $blog->getVar("blog_time");
	    $articles = array();
	    $times = array();
	    foreach($items as $item){
		    if(is_numeric($item["date_timestamp"]) && $item["date_timestamp"] <= $crit) continue;
		    if(is_numeric($item["date_timestamp"]) && $item["date_timestamp"] > $blog_time) {
			    $blog_time = $item["date_timestamp"];
		    }
		    $_article = array(
		    	"blog_id"		=> $blog->getVar("blog_id"),
		    	"art_link"		=> $item["link"],
		    	"art_time"		=> $item["date_timestamp"],
		    	"art_title"		=> $item["title"],
		    	"art_content"	=> empty($item["content"]["encoded"]) ? @$item["description"] : $item["content"]["encoded"]
		    	);
		    if(!empty($item["author"])){
			    $_article["art_author"] = $item["author"];
	    	}elseif(!empty($item["author"]["name"])){
			    $_article["art_author"] = $item["author"]["name"];
		    }elseif(!empty($item["author_name"])){
			    $_article["art_author"] = $item["author_name"];
		    }elseif(!empty($item["dc"]["creator"])){
			    $_article["art_author"] = $item["dc"]["creator"];
		    }else{
			    $_article["art_author"] = "";
		    }
		    $articles[] = $_article;
		    $times[] = $item["date_timestamp"];
	    }
	    array_multisort($articles, $times, SORT_ASC, SORT_NUMERIC);
	    
		//xoops_message($articles);
		
	    /* set blog last article time */
	    if($blog_time>0){
		    $blog->setVar("blog_time", $blog_time, true);
		    $this->insert($blog, true);
	    }
	    
	    /* update articles */
		$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
		$count = $article_handler->do_update($articles);

		if($count>0 && !empty($GLOBALS["xoopsModuleConfig"]["notification_enabled"])){
			$notification_handler =& xoops_gethandler("notification");
			$tags = array();
			$tags["BLOG_TITLE"] = $blog->getVar("blog_title");
			$tags["BLOG_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["moddirname"] . "/index.php".URL_DELIMITER."b" .$blog->getVar("blog_id");
			$notification_handler->triggerEvent("blog", $blog->getVar("blog_id"), "blog_update", $tags);
		}
		return $count;
    }
    
    /**
     * parse articles
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of blogs {@link Bblog}
     */
    function &parse(&$content, $charset = "UTF-8", $tags = array())
    {
	    $res = array();
	    if(empty($content)){
		    return $res;
	    }
		require_once XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/class/xmlparser.php";
		
		$parser = new XmlParser( $content, $charset, empty($xlanguage["charset_base"]) ? _CHARSET : $xlanguage["charset_base"], $tags );
		if (!$parser) {
			return $res;
		}
		foreach($tags as $tag){
			$res[$tag] = $parser->{$tag};
		}
		return $res;
    }
    
    /**
     * get a list of blogs matching a condition of a category
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of blogs {@link Bblog}
     */
   	function &getByCategory($criteria = null, $tags = null, $asObject=true)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array($this->keyName, $tags)) $tags[] = "b.".$this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select".
        		" FROM " . $this->table. " AS b".
        		" LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON b.blog_id = bc.blog_id";
        		//" LEFT JOIN (SELECT blog_id,  FROM ".planet_DB_prefix("blogcat").") AS bc ON blog_id = bc.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY b.".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $object =& $this->create(false);
            $object->assignVars($myrow);
            if($asObject){
            	$ret[$myrow[$this->keyName]] = $object;
        	}else{
	        	foreach($myrow as $key=>$val){
            		$ret[$myrow[$this->keyName]][$key] = ($object->vars[$key]["changed"])?$object->getVar($key):$val;
        		}
        	}
            unset($object);
        }
        return $ret;
    }

    /**
     * count blogs matching a condition of a category (categories)
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of blogs
     */
   	function getCountByCategory($criteria = null)
    {
        $sql = "SELECT COUNT(*) AS count".
        		" FROM " . $this->table. " AS b".
        		" LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON b.blog_id = bc.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }
    
   	function getCountsByCategory($criteria = null)
    {
        $sql = "SELECT cat_id, COUNT(*)".
        		" FROM ".planet_DB_prefix("blogcat");
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $sql .= " GROUP BY cat_id"; 
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $ret = array();
        while (list($id, $count) = $this->db->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }
    
    /**
     * get a list of blogs matching a condition of user bookmark
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of blogs {@link Bblog}
     */
   	function &getByBookmark($criteria = null, $tags = null, $asObject = true)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array($this->keyName, $tags)) $tags[] = "b.".$this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select".
        		" FROM " . $this->table. " AS b".
        		" LEFT JOIN ".planet_DB_prefix("bookmark")." AS bm ON b.blog_id = bm.blog_id";
        		//" LEFT JOIN (SELECT blog_id,  FROM ".planet_DB_prefix("blogcat").") AS bc ON blog_id = bc.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY b.".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $object =& $this->create(false);
            $object->assignVars($myrow);
            if($asObject){
            	$ret[$myrow[$this->keyName]] = $object;
        	}else{
	        	foreach($myrow as $key=>$val){
            		$ret[$myrow[$this->keyName]][$key] = ($object->vars[$key]["changed"])?$object->getVar($key):$val;
        		}
        	}
            unset($object);
        }
        return $ret;
    }

    /**
     * count blogs matching a condition of user bookmark
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of blogs
     */
   	function getCountByBookmark($criteria = null)
    {
        $sql = "SELECT COUNT(*) AS count".
        		" FROM " . $this->table. " AS b".
        		" LEFT JOIN ".planet_DB_prefix("bookmark")." AS bm ON b.blog_id = bm.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }
    
    function delete(&$blog, $force=false)
    {
        $queryFunc = empty($force)?"query":"queryF";
        
	    /* remove bookmarks */
		$bookmark_handler =& xoops_getmodulehandler("bookmark", $GLOBALS["moddirname"]);
	    $bookmark_handler->deleteAll(new Criteria("blog_id", $blog->getVar("blog_id")));
	    
	    /* remove category-blog links */
        $sql = "DELETE FROM ".planet_DB_prefix("blogcat")." WHERE blog_id = ".$blog->getVar("blog_id");
        if (!$result = $this->db->{$queryFunc}($sql)) {
        }
	    
	    /* remove articles */
		$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
	    $arts_obj =& $article_handler->getAll(new Criteria("blog_id", $blog->getVar("blog_id")));
	    foreach(array_keys($arts_obj) as $id){
	    	$article_handler->delete($arts_obj[$id]);
	    }

        xoops_notification_deletebyitem($GLOBALS["xoopsModule"]->getVar("mid"), "blog", $blog->getVar("blog_id"));
	    
	    /* Remove cat-blog links */
	    parent::delete($blog, $force);
    }
    
    function do_empty(&$blog)
    {
	    /* remove articles */
		$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
	    $arts_obj =& $article_handler->getAll(new Criteria("blog_id", $blog->getVar("blog_id")));
	    foreach(array_keys($arts_obj) as $id){
	    	$article_handler->delete($arts_obj[$id]);
	    }
	    $blog->setVar("blog_time", 0);
	    $blog->setVar("blog_key", "");
	    $this->insert($blog, true);
	    return true;
    }
    
    /**
     * get categories of a blog
     * 
     * @param 	int		$blog 		blog ID
     * @param 	array	$categories 		array of category IDs
     * @return 	bool
     */
   	function setCategories($blog, $categories)
    {
		$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);
        $crit = new Criteria("bc.blog_id", $blog);
    	$cats = array_keys($category_handler->getByBlog($crit));
	    $cats_add = array_diff($categories, $cats);
	    $cats_rmv = array_diff($cats, $categories);
	    if(count($cats_add)>0){
		    $_values = array();
		    foreach($cats_add as $cat){
			    $_values[] = "(".intval($blog).", ".intval($cat).")";
	        }
			$values = implode(",",$_values);
	        $sql = "INSERT INTO ".planet_DB_prefix("blogcat")." (blog_id, cat_id) VALUES ". $values;
	        if (!$result = $this->db->queryF($sql)) {
	            planet_message("Insert blog-cat error:" . $sql);
	        }
  		}
	    if(count($cats_rmv)>0){
	        $sql = "DELETE FROM ".planet_DB_prefix("blogcat")." WHERE ( blog_id=".intval($blog)." AND cat_id IN (".implode(",", $cats_rmv).") )";
	        if (!$result = $this->db->queryF($sql)) {
	            planet_message("remove blog-cat error:" . $sql);
	        }
  		}
        
        return count($cats_add);
    }
}
'
);
?>