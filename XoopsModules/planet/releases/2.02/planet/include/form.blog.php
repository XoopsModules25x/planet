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
if (!defined("XOOPS_ROOT_PATH")) exit();

require_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["moddirname"]);

$form = new XoopsThemeForm(_EDIT, "formblog", xoops_getenv('PHP_SELF'), "POST", true);

$form->addElement(new XoopsFormText(planet_constant("MD_FEED"), 'blog_feed', 50, 255, $blog_obj->getVar('blog_feed', 'E')), true);
$form->addElement(new XoopsFormText(planet_constant("MD_TITLE"), 'blog_title', 50, 255, $blog_obj->getVar('blog_title', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_DESC"), 'blog_desc', 50, 255, $blog_obj->getVar('blog_desc', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_LINK"), 'blog_link', 50, 255, $blog_obj->getVar('blog_link', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_LANGUAGE"), 'blog_language', 50, 255, $blog_obj->getVar('blog_language', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_CHARSET"), 'blog_charset', 50, 255, $blog_obj->getVar('blog_charset', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_TRACKBACKPATTERN"), 'blog_trackback', 80, 255, $blog_obj->getVar('blog_trackback', 'E')));
$form->addElement(new XoopsFormText(planet_constant("MD_IMAGE"), 'blog_image', 50, 255, $blog_obj->getVar('blog_image', 'E')));

$categories_option = $category_handler->getList();
natsort($categories_option);
if(count($categories_option)) {
	$cat_option_tray = new XoopsFormElementTray(planet_constant("MD_CATEGORY"), "<br />");
	$options = array(0=>_NONE);
	foreach($categories_option as $id=>$title){
		$options[$id] = $title;
	}
	$cat_select = new XoopsFormSelect("", "categories", $categories, 3, true);
	$cat_select->addOptionArray($options);
	$cat_option_tray->addElement($cat_select);
	$form->addElement($cat_option_tray);
}

/* For admin only */
if(is_object($xoopsUser) && $xoopsUser->isAdmin()){
	$status_option_tray = new XoopsFormElementTray(planet_constant("MD_STATUS"), "<br />");
	$status_select = new XoopsFormSelect("", "blog_status", $blog_obj->getVar("blog_status"));
	$status_select->addOptionArray(array("0"=>planet_constant("MD_PENDING"), "1"=>planet_constant("MD_ACTIVE"), "2"=>planet_constant("MD_FEATURED")));
	$status_option_tray->addElement($status_select);
	$form->addElement($status_option_tray);
}

$form->addElement(new XoopsFormHidden('blog', $blog_id));
$form->addElement(new XoopsFormHidden('op', 'save'));

$button_tray = new XoopsFormElementTray('', '');
$butt_fetch = new XoopsFormButton('', 'fetch', planet_constant("MD_FETCH"), 'submit');
$button_tray->addElement($butt_fetch);
$butt_save = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
$button_tray->addElement($butt_save);
$butt_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
$butt_cancel->setExtra("onclick='window.document.location=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."b".intval($blog_id)."\"'");
$button_tray->addElement($butt_cancel);
$form->addElement($button_tray);
$form->display();
?>