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
 * Bookmark 
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/
if(!class_exists("Bookmark")):

class Bookmark extends ArtObject
{
    /**
     * Constructor
     */
    function Bookmark()
    {
	    $this->ArtObject();
        $this->table = planet_DB_prefix("bookmark");
        $this->initVar("bm_id", XOBJ_DTYPE_INT, null, false);
        /* user ID */
        $this->initVar("bm_uid", XOBJ_DTYPE_INT, 0, true);
        /* blog ID */
        $this->initVar("blog_id", XOBJ_DTYPE_INT, 0, true);
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
class [CLASS_PREFIX]BookmarkHandler extends ArtObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function [CLASS_PREFIX]BookmarkHandler(&$db) {
        $this->ArtObjectHandler($db, planet_DB_prefix("bookmark", true), "Bookmark", "bm_id");
    }
}
'
);
?>