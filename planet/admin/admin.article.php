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

xoops_cp_header();
/*
 * To restore basic parameters in case cloned modules are installed
 * reported by programfan
 *
 * This is a tricky fix for incomplete solution of module cone
 * it is expected to have a better solution in article 1.0
 */
require XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
planet_adminmenu(3);

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
if(!empty($xoopsModuleConfig["article_expire"])){
	$criteria = new Criteria("art_time", time()-$xoopsModuleConfig["article_expire"]*60*60*24, "<");
	if(!empty($_GET["purge"])){
		$crit = new CriteriaCompo($criteria);
		$crit->add(new Criteria("art_comments", 0));
		$article_expires =& $article_handler->getObjects($criteria);
		foreach($article_expires as $id=>$article_obj){
			$article_handler->delete($article_obj);
		}
	}
	$article_count_expire = $article_handler->getCount($criteria);
}else{
	$article_count_expire = 0;
}
$article_count = $article_handler->getCount();

echo "<fieldset><legend style=\"font-weight: bold; color: #900;\">" . planet_constant("AM_ARTICLES") . "</legend>";
echo "<div style=\"padding: 8px;\">";
echo "<br clear=\"all\" />" . planet_constant("AM_COUNT").": ". $article_count;
echo "<br clear=\"all\" />";
if($article_count_expire>0){
	echo "<br clear=\"all\" /><a href=\"".XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/admin/admin.article.php?purge=1\" >" . planet_constant("AM_EXPIRED").": ".$article_count_expire."</a>";
	echo "<br clear=\"all\" />";
}
echo "</div>";
echo "</fieldset><br clear=\"all\" />";

xoops_cp_footer();
?>