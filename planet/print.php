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

error_reporting(0);
include 'header.php';
error_reporting(0);

if(empty($_POST["print_data"])){

if(planet_parse_args($args_num, $args, $args_str)){
	$args["article"] = @$args_num[0];
}

$article_id = intval( empty($_GET["article"])?@$args["article"]:$_GET["article"] );

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
$article_obj =& $article_handler->get($article_id);

$article_data = array();

// title
$article_data["title"] = $article_obj->getVar("art_title");

$article_data["author"] = $article_obj->getVar("art_author");

// source
$article_data["source"] = $article_obj->getVar("art_link");

// publish time
$article_data["time"] = $article_obj->getTime("l");

// summary
$article_data["summary"] =& $article_obj->getSummary();

// text of page
$article_data["text"] = $article_obj->getVar("art_content");

$print_data["title"] = $article_data["title"];
$print_data["author"] = $article_data["author"];
$print_data["date"] = $article_data["time"];
$print_data["summary"] = empty($article_data["summary"]) ? "" : planet_constant("MD_SUMMARY").": ".$article_data["summary"];
$print_data["content"] = $article_data["text"];
$print_data["url"] = XOOPS_URL."/modules/" . $xoopsModule->getVar("dirname") . "/view.article.php".URL_DELIMITER."c".$category_id."/".$article_id."/p".$page;

}else{
	$print_data = unserialize(base64_decode($_POST["print_data"]));
}

$print_data["image"] = XOOPS_URL . "/modules/" . $xoopsModule->getVar("dirname") . "/" . $xoopsModule->getInfo( 'image' );
$print_data["module"] = $xoopsModule->getVar( 'name' )." V".$xoopsModule->getInfo( 'version' );

	header('Content-Type: text/html; charset='._CHARSET); 
	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
    echo "<html>\n<head>\n";
    echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
    echo "<meta name='AUTHOR' content='" . $myts->htmlspecialchars($xoopsConfig['sitename']) . "' />\n";
    echo "<meta name='COPYRIGHT' content='Copyright (c) ".date('Y')." by " . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='DESCRIPTION' content='" . $myts->htmlspecialchars($xoopsConfig['slogan']) . "' />\n";
    echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
    echo "<style type='text/css'>
			body {
				color:#000000;
				background-color:#EFEFEF;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12pt;
				margin:10px;
				line-height: 120%;
			}
			a, a:visited, a:active {
				color:#000000;
				text-decoration: none;
			}
    		</style>\n";
   	echo "</head>\n";
    echo "<body style='background-color:#ffffff; color:#000000; font-family: Arial' onload='window.print()'>\n".
 		 "<div style='float:center; width: 750px; border: 1px solid #000; padding: 20px;'>\n".
			"<div style='text-align: center; display: block; margin: 0 0 6px 0; padding: 5px;'>\n".
			"<img src='" . $print_data["image"] . "' border='0' alt='".$print_data["module"]."' />\n".
			"<h2>".$print_data["title"]."</h2>\n".
			"</div>\n".
			"<div style='margin-top: 12px; margin-bottom: 12px; border-top: 2px solid #ccc;'></div>\n";
	echo	( empty($print_data["author"]) ? "" : 
			"<div>" .planet_constant("MD_AUTHOR").": ".$print_data["author"]."</div>\n"
			).
			"<div>" .planet_constant("MD_DATE").": ".$print_data["date"]."</div>\n".
			( empty($article_data["summary"]) ? "" : 
			"<div style='margin-top: 12px; margin-bottom: 12px; border-top: 1px solid #ccc;'></div>\n".
			"<div>".$print_data["summary"]."</div>\n"
			).
			"<div style='margin-top: 12px; margin-bottom: 12px; border-top: 1px solid #ccc;'></div>\n".
			"<div>".$print_data["content"]."</div>\n".
			"<div style='margin-top: 12px; margin-bottom: 12px; border-top: 2px solid #ccc;'></div>\n".
			"<div>".$print_data["module"]."</div>\n".
			"<div>URL: ".$print_data["url"]."</div>\n".
	    "</div>\n".
        "</body>\n</html>\n";
exit();        
?>