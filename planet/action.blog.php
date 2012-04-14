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

$op = !empty($_POST["op"])?$_POST["op"]:(!empty($_GET["op"])?$_GET["op"]:"");
$blog_id = !empty($_POST["blog"])?$_POST["blog"]:(!empty($_GET["blog"])?$_GET["blog"]:0);
$blog_id = is_array($blog_id)?array_map("intval", $blog_id):intval($blog_id);

if(empty($xoopsModuleConfig["newblog_submit"]) && (!is_object($xoopsUser) || !$xoopsUser->isAdmin())){
        redirect_header("index.php", 2, _NOPERM);
}

if($op=="save" && !empty($_POST["fetch"])){
	$op="edit";
}

if($op=="save" && !$GLOBALS['xoopsSecurity']->check()){
    redirect_header("javascript:history.go(-1);", 1, planet_constant("MD_INVALID").": security check failed");
    exit();
}
include XOOPS_ROOT_PATH."/header.php";
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);

switch($op){
	/* save a single blog */
	case "save":
		
        if ($blog_id) {
            $blog_obj =& $blog_handler->get($blog_id);
			if($xoopsUser->isAdmin()){
        		$blog_obj->setVar('blog_status', @$_POST["blog_status"]);
			}        	
        } else {
	        if($blog_exists = $blog_handler->getCount(new Criteria("blog_feed", $myts->addSlashes( trim($_POST['blog_feed']) )))){
		        redirect_header("index.php", 2, planet_constant("MD_BLOGEXISTS"));
		        exit();
	        }
	        
            $blog_obj =& $blog_handler->create();
        	$blog_obj->setVar('blog_submitter', is_object($xoopsUser)?$xoopsUser->getVar("uid"):planet_getIP(true));
        	
			switch($xoopsModuleConfig["newblog_submit"]){
			case 2:
				if(!is_object($xoopsUser)){
					$status = 0;
				}else{
					$status = 1;
				}
				break;
			case 0:
			case 3:
				$status = 1;
				break;
			case 1:
			default:
				if(!is_object($xoopsUser) || !$xoopsUser->isAdmin()){
					$status = 0;
				}else{
					$status = 1;
				}
				break;
			}
			
        	$blog_obj->setVar('blog_status', $status);
        }

        $blog_obj->setVar('blog_title', $_POST['blog_title']);
        $blog_obj->setVar('blog_desc', $_POST['blog_desc']);
        $blog_obj->setVar('blog_image', $_POST['blog_image']);
        $blog_obj->setVar('blog_feed', $_POST['blog_feed']);
        $blog_obj->setVar('blog_link', $_POST['blog_link']);
        $blog_obj->setVar('blog_language', $_POST['blog_language']);
        $blog_obj->setVar('blog_charset', $_POST['blog_charset']);
        $blog_obj->setVar('blog_trackback', $_POST['blog_trackback']);
        if($blog_obj->isNew()){
        	$blog_obj->setVar('blog_submitter', is_object($xoopsUser)?$xoopsUser->getVar("uid"):planet_getIP(true));
    	}

        if (!$blog_handler->insert($blog_obj)) {
        }elseif(!empty($_POST["categories"])){
	    	$blog_id = $blog_obj->getVar("blog_id");
			if(in_array(0, $_POST["categories"])) $_POST["categories"] = array();
			$blog_handler->setCategories($blog_id, $_POST["categories"]);
        }
        $message = planet_constant("MD_DBUPDATED");
        redirect_header("index.php".URL_DELIMITER."b".$blog_id, 2, $message);
        exit();	
        
    /* edit a single blog */
	case "edit":
	default:
        if(!empty($_POST["fetch"])){
        	$blog_obj =& $blog_handler->fetch($_POST["blog_feed"]);
        	$blog_obj->setVar("blog_id", $blog_id);	        
        }else{
        	$blog_obj =& $blog_handler->get($blog_id);
        }
	    $categories = isset($_POST["categories"])?$_POST["categories"]:array();	    
		if(in_array("-1", $categories)) $categories = array();
        if(empty($categories) && $blog_id>0){
	        $crit = new Criteria("bc.blog_id", $blog_id);
	    	$categories = array_keys($category_handler->getByBlog($crit));
        }
        if(empty($categories)) $categories = array(0=>_NONE);
       
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _EDIT . "</legend>";
        echo"<br />";
        if(empty($blog_id) && $blog_obj->getVar("blog_feed")){
	        $criteria = new Criteria("blog_feed", $blog_obj->getVar("blog_feed"));
	        $blogs_obj =& $blog_handler->getList($criteria);
	        if(count($blogs_obj)>0){
		        echo "<div class=\"errorMsg\">".planet_constant("MD_BLOGEXISTS");
		        foreach(array_keys($blogs_obj) as $bid){
			        echo "<br /><a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."b".$bid."\" target=\"_blank\">".$blogs_obj[$bid]."</a>";
		        }
		        echo "</div>";
	        	unset($blogs_obj, $criteria);
	        }
        }
        include XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/include/form.blog.php";
        echo "</fieldset>";
        break;	
}

include XOOPS_ROOT_PATH."/footer.php";
?>