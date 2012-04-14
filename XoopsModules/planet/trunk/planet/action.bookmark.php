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

include 'header.php';

$blog_id = intval( isset($_GET["blog"]) ? $_GET["blog"] : (isset($_POST["blog"]) ? $_POST["blog"]: 0) );

if(!is_object($xoopsUser) || empty($blog_id)){
    redirect_header("javascript:history.go(-1);", 1, planet_constant("MD_INVALID"));
    exit();
}

$bookmark_handler =& xoops_getmodulehandler("bookmark", $GLOBALS["moddirname"]);
$uid = (is_object($xoopsUser))?$xoopsUser->getVar("uid"):0;
$criteria = new CriteriaCompo(new Criteria("blog_id", $blog_id));
$criteria->add(new Criteria("bm_uid", $uid));
if($count=$bookmark_handler->getCount($criteria)){
	$message = planet_constant("MD_ALREADYBOOKMARKED");
	redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."u".$uid, 2, $message);
	exit();
}
$bookmark_obj =& $bookmark_handler->create();
$bookmark_obj->setVar("blog_id", $blog_id);
$bookmark_obj->setVar("bm_uid", $uid);
if(!$bookmark_id = $bookmark_handler->insert($bookmark_obj, true)){
	redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."b".$blog_id, 2, planet_constant("MD_NOTSAVED"));
    exit();
}
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
$blog_obj =& $blog_handler->get($blog_id);
$marks = $blog_obj->getVar("blog_marks")+1;
$blog_obj->setVar("blog_marks", $blog_obj->getVar("blog_marks")+1);
$blog_handler->insert($blog_obj, true);
$message = planet_constant("MD_ACTIONDONE");
redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php".URL_DELIMITER."b".$blog_id, 2, $message);
include 'footer.php';
?>