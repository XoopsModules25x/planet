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

if (!defined("XOOPS_ROOT_PATH")){ exit(); }

include dirname(__FILE__)."/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

planet_parse_function('
function [VAR_PREFIX]_com_update($art_id, $count, $com_id)
{
	$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
	$article_obj =& $article_handler->get($art_id);
	if (!$article_handler->updateComments($article_obj, $count)) {
		return false;
	}
	return true;
}

function [VAR_PREFIX]_com_approve(&$comment)
{
	planet_define_url_delimiter();
	if (!empty($GLOBALS["xoopsModuleConfig"]["notification_enabled"])){
		$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
		$article_obj =& $article_handler->get($comment->getVar("com_itemid"));
		$notification_handler =& xoops_gethandler("notification");
		$tags = array();
		$tags["ARTICLE_TITLE"] = $article_obj->getVar("art_title");
		$tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["moddirname"] . "/view.article.php".URL_DELIMITER."" .$article_obj->getVar("art_id")."#comment".$comment->getVar("com_id");
		$tags["ARTICLE_ACTION"] = planet_constant("MD_NOT_ACTION_COMMENT");
		$notification_handler->triggerEvent("article", $article_obj->getVar("art_id"), "article_monitor", $tags);
		$notification_handler->triggerEvent("global", 0, "article_monitor", $tags);
		planet_com_trackback($article_obj, $comment);
	}
}
');
?>