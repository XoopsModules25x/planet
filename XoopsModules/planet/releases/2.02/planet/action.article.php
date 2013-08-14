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

$art_id = intval( isset($_GET["article"]) ? $_GET["article"] : (isset($_POST["article"]) ? $_POST["article"]: 0) );
if(empty($art_id)){
    redirect_header("javascript:history.go(-1);", 1, planet_constant("MD_INVALID"));
    exit();
}
if (!$xoopsUser->isAdmin()){
    redirect_header("javascript:history.go(-1);", 2, _NOPERM);
    exit();
}
include XOOPS_ROOT_PATH."/header.php";
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
$article_obj = $article_handler->get($art_id);

$op = isset($_POST["op"]) ? $_POST["op"] : "";

if ( $op == "del" || !empty($_POST["del"])) {
	$article_handler->delete($article_obj);
	$redirect = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php";
	$message = planet_constant("MD_SAVED");
	redirect_header($redirect,2,$message);
}elseif ( $op == "save" ) {
	
	if(empty($_POST["art_content"])){
	    redirect_header("javascript:history.go(-1);", 1, planet_constant("MD_TEXTEMPTY"));
	    exit();
	}

	foreach(array(
	    "art_title",
	    "art_link",
	    "art_author",
	    "art_content"
		) as $tag){
		if(@$_POST[$tag] != $article_obj->getVar($tag))
    	$article_obj->setVar($tag, @$_POST[$tag]);
	}

    $art_id_new = $article_handler->insert($article_obj);
	if(!$article_obj->getVar("art_id")){
		$redirect = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php";
	    $message = planet_constant("MD_INSERTERROR");
	}else{
	    $redirect = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".URL_DELIMITER."".$article_obj->getVar("art_id");
	    $message = planet_constant("MD_SAVED");
    }
	redirect_header($redirect,2,$message);
}else{
	require_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
	
	$form = new XoopsThemeForm(_EDIT, "formarticle", xoops_getenv('PHP_SELF'));
	
	$form->addElement(new XoopsFormText(planet_constant("MD_TITLE"), 'art_title', 50, 255, $article_obj->getVar('art_title', 'E')), true);
	$form->addElement(new XoopsFormText(planet_constant("MD_LINK"), 'art_link', 50, 255, $article_obj->getVar('art_link', 'E')), true);
	$form->addElement(new XoopsFormText(planet_constant("MD_AUTHOR"), 'art_author', 80, 255, $article_obj->getVar('art_author', 'E')));
	$form->addElement(new XoopsFormTextArea(planet_constant("MD_CONTENT"), "art_content", $article_obj->getVar("art_content", "E")), true);

	$form->addElement(new XoopsFormHidden('article', $art_id));
	$form->addElement(new XoopsFormHidden('op', 'save'));
	
	$button_tray = new XoopsFormElementTray('', '');
	$butt_save = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
	$button_tray->addElement($butt_save);
	$butt_del = new XoopsFormButton('', 'del', _DELETE, 'submit');
	$butt_del->setExtra("onClick='document.forms.formarticle.op.value=del'");
	$button_tray->addElement($butt_del);
	$butt_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
	$butt_cancel->setExtra("onclick='window.document.location=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".URL_DELIMITER."".intval($art_id)."\"'");
	$button_tray->addElement($butt_cancel);
	$form->addElement($button_tray);
	$form->display();	
}
include XOOPS_ROOT_PATH."/footer.php";
?>