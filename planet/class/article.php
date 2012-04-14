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
 * @package module::article
 * @copyright copyright &copy; 2005 XoopsForge.com
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}
include_once dirname(dirname(__FILE__))."/include/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

/**
 * Article 
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/
if(!class_exists("Barticle")):

class Barticle extends ArtObject
{
    /**
     * Constructor
     *
     * @param int $id ID of the article
     */
    function Barticle($id = null)
    {
	    $this->ArtObject();
        $this->table = planet_DB_prefix("article");
        $this->initVar("art_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("blog_id", XOBJ_DTYPE_INT, 0, true);

        $this->initVar("art_title", XOBJ_DTYPE_TXTBOX, "");
        $this->initVar("art_content", XOBJ_DTYPE_TXTAREA, "");
        $this->initVar("art_link", XOBJ_DTYPE_TXTBOX, "");
        $this->initVar("art_time", XOBJ_DTYPE_INT, 0);
        $this->initVar("art_author", XOBJ_DTYPE_TXTBOX, "");

        $this->initVar("art_views", XOBJ_DTYPE_INT, 0);
        $this->initVar("art_rating", XOBJ_DTYPE_INT, 0);
        $this->initVar("art_rates", XOBJ_DTYPE_INT, 0);
        $this->initVar("art_comments", XOBJ_DTYPE_INT, 0);

        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 0);
    }

    /**
     * get title of the article
     * 
     * @return string
     */
    function getTitle()
    {
	    $title = $this->getVar("art_title");
		return $title;
    }

    /**
     * get formatted publish time of the article
     * 
 	 * {@link Config} 
 	 *
     * @param string $format format of time
     * @return string
     */
    function getTime($format = "c")
    {
	    $time = $this->getVar("art_time");
	    if(empty($time)) $time = time();
	    $time = planet_formatTimestamp($time, $format);
		return $time;
    }

    
    /**
     * get summary of the article
     * 
     * @param bool 	$actionOnEmpty flag for truncating content if summary is empty
     * @return string
     */
    function &getSummary($length = 0)
    {
	    $content = $this->getVar("art_content");
		$summary = planet_html2text($content);
		if(empty($length)){
			$length = $GLOBALS["xoopsModuleConfig"]["display_summary"];
		}
		if(!empty($length)){
			$summary = xoops_substr($summary, 0, $length);
		}
	    return $summary;
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
	    if($this->getVar("art_rates")){
	    	$ave = number_format($this->getVar("art_rating")/$this->getVar("art_rates"),$decimals);
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
* Article object handler class.  
* @package module::article
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link XoopsPersistableObjectHandler} 
*
* @param CLASS_PREFIX variable prefix for the class name
*/

planet_parse_class('
class [CLASS_PREFIX]ArticleHandler extends ArtObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function [CLASS_PREFIX]ArticleHandler(&$db) {
        $this->ArtObjectHandler($db, planet_DB_prefix("article", true), "Barticle", "art_id", "art_title");
    }
    
    /**
     * insert new articles if content is changed
     * 
     * @param 	array	$articles 	
     * @param 	int		$blog_id
     * @return 	int		inserted article count
     */
    function do_update(&$articles, $blog_id = 0)
    {
		if($blog_id>0){
	    	$crit_blog = new Criteria("blog_id", $blog_id);
    	}else{
	    	$crit_blog = null;
    	}
    	$count = 0;
	    foreach($articles as $article){
			$criteria = new CriteriaCompo();
			if($article["blog_id"]){
				$criteria->add(new Criteria("blog_id", $article["blog_id"]));
			}else{
				$criteria->add($crit_blog);
			}
			$criteria->add(new Criteria("art_link", $article["art_link"]));
			$_count = $this->getCount($criteria);
			unset($criteria);
			if($_count>0) continue;
	    	$article_obj =& $this->create();
	    	$article_obj->setVars($article, true);
	    	$this->insert($article_obj, true);
	    	unset($article_obj);
	    	$count ++;
    	}
		
		return $count;
    }
    
    /**
     * get a list of articles matching a condition of a category
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of articles {@link Barticle}
     */
   	function &getByCategory($criteria = null, $tags = null, $asObject=true)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array($this->keyName, $tags)) $tags[] = $this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select".
        		" FROM " . $this->table. " AS a".
        		//" LEFT JOIN (SELECT blog_id, cat_id FROM ".planet_DB_prefix("blogcat").") AS bc ON a.blog_id = bc.blog_id";
        		" LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON a.blog_id = bc.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY ".$this->keyName." DESC";
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
     * count articles matching a condition of a category (categories)
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of articles
     */
   	function getCountByCategory($criteria = null)
    {
        $sql = "SELECT COUNT(DISTINCT a.art_id) AS count".
        		" FROM " . $this->table. " AS a".
        		//" LEFT JOIN (SELECT blog_id, cat_id FROM ".planet_DB_prefix("blogcat").") AS bc ON a.blog_id = bc.blog_id";
        		" LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON a.blog_id = bc.blog_id";
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
        $sql = "SELECT bc.cat_id, COUNT(*)".
        		" FROM " . $this->table. " AS a".
        		//" LEFT JOIN (SELECT blog_id, cat_id FROM ".planet_DB_prefix("blogcat").") AS bc ON a.blog_id = bc.blog_id";
        		" LEFT JOIN ".planet_DB_prefix("blogcat")." AS bc ON a.blog_id = bc.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $sql .=" GROUP BY bc.cat_id";
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
     * get a list of articles matching a condition of user bookmark
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of articles {@link Barticle}
     */
   	function &getByBookmark($criteria = null, $tags = null, $asObject=true)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array($this->keyName, $tags)) $tags[] = $this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select".
        		" FROM " . $this->table. " AS a".
        		//" LEFT JOIN (SELECT blog_id, bm_uid FROM ".planet_DB_prefix("bookmark").") AS bm ON a.blog_id = bm.blog_id";
        		" LEFT JOIN ".planet_DB_prefix("bookmark")." AS bm ON a.blog_id = bm.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY ".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $object =& $this->create(false);
            $object->assignVars($myrow);
            if($asObject){
            	$ret[$myrow[$this->keyName]] = $object;
        	}else{
	        	foreach($myrow as $key=>$val){
            		$ret[$myrow[$this->keyName]][$key] = $val;
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
        $sql = "SELECT COUNT(DISTINCT a.art_id) AS count".
        		" FROM " . $this->table. " AS a".
        		//" LEFT JOIN (SELECT blog_id, bm_uid FROM ".planet_DB_prefix("bookmark").") AS bm ON a.blog_id = bm.blog_id";
        		" LEFT JOIN ".planet_DB_prefix("bookmark")." AS bm ON a.blog_id = bm.blog_id";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }
    /**
     * Get the previous article and the next article of an article
     * 
     * @param   object	$article	reference to the article
     * @param   int		$blog	blog ID
     * @return  array
     **/
    // To be optimized
    function &getSibling(&$article, $blog = 0)
    {
        $ret = array();
        
		$crit_prev = new CriteriaCompo(new Criteria("art_id", $article->getVar("art_id"), "<"));
		if($blog>0) {
			$crit_prev->add(new Criteria("blog_id", $blog));
		}
		$crit_prev->setSort("art_id");
		$crit_prev->setOrder("DESC");
		$crit_prev->setLimit(1);		
		$art_prev = $this->getObjects($crit_prev);
		if(count($art_prev)>0){
			$ret["previous"] = array("id"=>$art_prev[0]->getVar("art_id"),"title"=>$art_prev[0]->getVar("art_title"));
			unset($art_prev);
		}
        
		$crit_next = new CriteriaCompo(new Criteria("art_id", $article->getVar("art_id"), ">"));
		if($blog>0) {
			$crit_next->add(new Criteria("blog_id", $blog));
		}
		$crit_next->setSort("art_id");
		$crit_next->setOrder("DESC");
		$crit_next->setLimit(1);		
		$art_next = $this->getObjects($crit_next);
		if(count($art_next)>0){
			$ret["next"] = array("id"=>$art_next[0]->getVar("art_id"),"title"=>$art_next[0]->getVar("art_title"));
			unset($art_next);
		}

	    return $ret;
    }

    /**
     * Update comment count of the article
     * 
     * @param	object	$article 	{@link Article} reference to Article
     * @param	int		$total 		total comment count
     * @return 	bool 	true on success
     */
    function updateComments(&$article, $total)
    {
	    $article->setVar("art_comments", intval($total), true);
	    return $this->insert($article, true);
    }

    /**
     * delete an article from the database
     * 
     * {@link Text}
     *
     * @param	object	$article 	{@link Article} reference to Article
     * @param 	bool 	$force 		flag to force the query execution despite security settings
     * @return 	bool 	true on success
     */
    function delete(&$article, $force = true)
    {
        $rate_handler =& xoops_getmodulehandler("rate", $GLOBALS["moddirname"]);
	    $rate_handler->deleteAll(new Criteria("art_id", $article->getVar("art_id")));

        xoops_comment_delete($GLOBALS["xoopsModule"]->getVar("mid"), $article->getVar("art_id"));
        xoops_notification_deletebyitem($GLOBALS["xoopsModule"]->getVar("mid"), "article", $article->getVar("art_id"));

        parent::delete($article, $force);

        $article = null;
        unset($article);
        return true;
    }
}
'
);
?>