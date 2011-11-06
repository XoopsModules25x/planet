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
include("header.php");
require_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");

xoops_cp_header();
require XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
planet_adminmenu(1);

$op = !empty($_POST["op"])?$_POST["op"]:(!empty($_GET["op"])?$_GET["op"]:"");
$cat_id = !empty($_POST["category"])?$_POST["category"]:(!empty($_GET["category"])?$_GET["category"]:0);
$cat_id = is_array($cat_id)?array_map("intval", $cat_id):intval($cat_id);

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);

switch($op){
	case "save":
        if ($cat_id) {
            $category_obj =& $category_handler->get($cat_id);
        } else {
            $category_obj =& $category_handler->create();
        }

        $category_obj->setVar('cat_title', $_POST['cat_title']);
        $category_obj->setVar('cat_order', $_POST['cat_order']);

        if (!$category_handler->insert($category_obj)) {
        	$message = planet_constant("AM_ERROR");
        }else{
        	$message = planet_constant("AM_DBUPDATED");
    	}
        redirect_header("admin.category.php", 2, $message);
        exit();	
        
	case "del":
		if(!is_array($cat_id)) $cat_id = array($cat_id);
		foreach($cat_id as $cid){
	        $category_obj =& $category_handler->get($cid);
	        if (!$category_handler->delete($category_obj)) {
	        }
       	}
        $message = planet_constant("AM_DBUPDATED");
        redirect_header("admin.category.php", 2, $message);
        exit();	
        
	case "order":
		$count = count($_POST['cat_order']);
		for($i=0; $i < $count; $i++){
        	$category_obj =& $category_handler->get($_POST['cat'][$i]);
        	$category_obj->setVar("cat_order", $_POST['cat_order'][$i]);
        	$category_handler->insert($category_obj, true);
        	unset($category_obj);
		}
        $message = planet_constant("AM_DBUPDATED");
        redirect_header("admin.category.php", 2, $message);
        exit();	
        
	case "edit":
        $category_obj =& $category_handler->get($cat_id);
        $form = new XoopsThemeForm(_EDIT, "edit", xoops_getenv('PHP_SELF'));
	    $form->addElement(new XoopsFormText(planet_constant("AM_TITLE"), 'cat_title', 50, 80, $category_obj->getVar('cat_title', 'E')), true);
	    $form->addElement(new XoopsFormText(planet_constant("AM_ORDER"), 'cat_order', 5, 10, $category_obj->getVar('cat_order')), false);
	    $form->addElement(new XoopsFormHidden('category', $cat_id));
	    $form->addElement(new XoopsFormHidden('op', 'save'));
	
	    $button_tray = new XoopsFormElementTray('', '');
	    $butt_save = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
	    $button_tray->addElement($butt_save);
        $butt_cancel = new XoopsFormButton('', '', _CANCEL, 'reset');
        $button_tray->addElement($butt_cancel);
	    $form->addElement($button_tray);
        
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _EDIT . "</legend>";
        echo"<br />";
        $form->display();
        echo "</fieldset>";
        break;	
        
	default:
		$crit = new Criteria("1", 1);
		$crit->setSort("cat_order");
		$crit->setOrder("ASC");
		$categories = $category_handler->getList($crit);
		$blog_counts = $blog_handler->getCountsByCategory();
		foreach(array_keys($categories) as $cid){
			if(!empty($blog_counts[$cid])){
				$categories[$cid] .= " (".intval($blog_counts[$cid]).")";
			}
		}
		
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . planet_constant("AM_LIST") . "</legend>";
        echo "<br style=\"clear:both\" />";

        echo "<form name='list' method='post'>";
        echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
        echo "<tr align='center'>";
        echo "<td class='bg3' width='5%'>" . planet_constant("AM_ORDER") . "</td>";
        echo "<td class='bg3' width='5%'>" . _EDIT . "</td>";
        echo "<td class='bg3' width='5%'>" . _DELETE . "</td>";
        echo "<td class='bg3' width='80%'>" . planet_constant("AM_TITLE") . "</td>";
        echo "<td class='bg3' width='5%'>" . planet_constant("AM_BLOGCOUNT") . "</td>";
        echo "</tr>";
        
        $ii = 0;
		foreach(array_keys($categories) as $cid){
            echo "<tr class='odd' align='left'>";
            echo "<td><input type='hidden' name='cat[]' value='".$cid."' />";
            echo "<input type='text' name='cat_order[]' value='".($ii*10)."' /></td>";
            echo "<td><a href='admin.category.php?op=edit&amp;category=".$cid."' title='"._EDIT."' />"._EDIT."</a></td>";
            echo "<td><a href='admin.category.php?op=del&amp;category=".$cid."' title='"._DELETE."' />"._DELETE."</a></td>";
            echo "<td>".$categories[$cid]."</td>";
            echo "<td>".@$blog_counts[$cid]."</td>";
            echo "</tr>";			
            $ii++;
		}
        echo "<tr class='even' align='center'>";
        echo "<td colspan='5'>";
        echo "<input name='submit' value='"._SUBMIT."' type='submit' />";
        echo "<input name='' value='"._CANCEL."' type='reset' />";
        echo "<input name='op' value='order' type='hidden' />";
        echo "</td>";
        echo "</tr>";			
        echo "</table></form>";
        echo "</fieldset><br style='clear:both;'>";
        
        $form = new XoopsThemeForm(_ADD, "mod", xoops_getenv('PHP_SELF'));
	    $form->addElement(new XoopsFormText(planet_constant("AM_TITLE"), 'cat_title', 50, 80), true);
	    $form->addElement(new XoopsFormText(planet_constant("AM_ORDER"), 'cat_order', 5, 10), false);
	    $form->addElement(new XoopsFormHidden('op', 'save'));
	
	    $button_tray = new XoopsFormElementTray('', '');
	    $butt_save = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
	    $button_tray->addElement($butt_save);
        $butt_cancel = new XoopsFormButton('', '', _CANCEL, 'reset');
        $button_tray->addElement($butt_cancel);
	    $form->addElement($button_tray);
        
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _ADD . "</legend>";
        echo"<br />";
        $form->display();
        echo "</fieldset>";
        break;		
}

xoops_cp_footer();
?>