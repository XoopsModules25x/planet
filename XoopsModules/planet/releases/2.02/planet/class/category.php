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
 * Xcategory 
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/
if(!class_exists("Bcategory")):

class Bcategory extends ArtObject
{
    /**
     * Constructor
     */
    function Bcategory()
    {
	    $this->ArtObject();
        $this->table = planet_DB_prefix("category");
        $this->initVar("cat_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("cat_title", XOBJ_DTYPE_TXTBOX, "", true);
        $this->initVar("cat_order", XOBJ_DTYPE_INT, 1, false);
    }
}

endif;
/**
* Category object handler class.  
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
class [CLASS_PREFIX]CategoryHandler extends ArtObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function [CLASS_PREFIX]CategoryHandler(&$db) {
        $this->ArtObjectHandler($db, planet_DB_prefix("category", true), "Bcategory", "cat_id", "cat_title");
    }
    
    function delete(&$category)
    {
        xoops_notification_deletebyitem($GLOBALS["xoopsModule"]->getVar("mid"), "category", $category->getVar("cat_id"));
	    
	    /* remove category-blog links */
        $sql = "DELETE FROM ".planet_DB_prefix("blogcat")." WHERE cat_id = ".$category->getVar("cat_id");
        if (!$result = $this->db->queryF($sql)) {
        }
        
	    parent::delete($category, true);
    }
    
    /**
     * get a list of categories including a blog
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of categories {@link Bcategory}
     */
   	function &getByBlog($criteria = null, $asObject = false)
    {
        $sql = "SELECT bc.cat_id".
        		" FROM " . planet_DB_prefix("blogcat")." AS bc";
        $limit = null;
        $start = null;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY cat_id DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$myrow["cat_id"]] = 1;
        }
        if(!empty($asObject)) {
	        $crit = new Criteria("cat_id", "(".implode(",",array_keys($ret)).")", "IN");
	        $ret =& $this->getObjects($crit);
        }
        return $ret;
    }
    
    /**
     * get a list of blogs to a category
     * 
     * @param 	int		$category 	category ID
     * @param 	array	$blogs 		array of blog IDs
     * @return 	bool
     */
   	function addBlogs($category, $blogs)
    {
	    $_values = array();
	    foreach($blogs as $blog){
        	$sql = "SELECT COUNT(*)".
        		" FROM ".planet_DB_prefix("blogcat").
        		" WHERE cat_id=".intval($category)." AND blog_id=".intval($blog); 
	        if (!$result = $this->db->query($sql)) {
	            continue;
	        }
    		list($count) = $this->db->fetchRow($result);
    		if($count>0) continue;
		    $_values[] = "(".intval($blog).", ".intval($category).")";
        }
		$values = implode(",",$_values);
        $sql = "INSERT INTO ".planet_DB_prefix("blogcat")." (blog_id, cat_id) VALUES ". $values;
        if (!$result = $this->db->queryF($sql)) {
            planet_message("Insert blog-cat error:" . $sql);
            return false;
        }
        
        return count($_values);
    }
    /**
     * remove a list of blogs from a category
     * 
     * @param 	int		$category 	category ID
     * @param 	array	$blogs 		array of blog IDs
     * @return 	bool
     */
   	function removeBlogs($category, $blogs)
    {
	    if(count($blogs)>0){
	        $sql = "DELETE FROM ".planet_DB_prefix("blogcat")." WHERE cat_id=".intval($category)." AND blog_id IN (".implode(",", $blogs).")";
	        if (!$result = $this->db->queryF($sql)) {
	            planet_message("remove blog-cat error:" . $sql);
	        }
  		}
        
        return count($blogs);
    }
}
'
);
?>