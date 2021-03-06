<?php
//
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                  Copyright (c) 2000-2016 XOOPS.org                        //
//                       <http://xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include __DIR__ . '/vars.php';
mod_loadFunctions('', $GLOBALS['moddirname']);

planet_parse_function('
function [VAR_PREFIX]_notify_iteminfo($category, $item_id)
{
    planet_define_url_delimiter();
    $item_id = (int)($item_id);

    switch ($category) {
    case "blog":
        $blog_handler = xoops_getModuleHandler("blog", $GLOBALS["moddirname"]);
        $blog_obj = $blog_handler->get($item_id);
        if (!is_object($blog_obj)) {
            redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php", 2, planet_constant("MD_NOACCESS"));

        }
        $item["name"] = $blog_obj->getVar("blog_title");
        $item["url"] = XOOPS_URL . "/modules/" . $GLOBALS["moddirname"] . "/index.php".URL_DELIMITER."b" . $item_id;
        break;
    case "article":
        $article_handler = xoops_getModuleHandler("article", $GLOBALS["moddirname"]);
        $article_obj = $article_handler->get($item_id);
        if (!is_object($article_obj)) {
            redirect_header(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/index.php", 2, planet_constant("MD_NOACCESS"));

        }
        $item["name"] = $article_obj->getVar("art_title");
        $item["url"] = XOOPS_URL . "/modules/" . $GLOBALS["moddirname"] . "/view.article.php".URL_DELIMITER."" . $item_id;
        break;
    case "global":
    default:
        $item["name"] = "";
        $item["url"] = "";
        break;
    }

    return $item;
}
');
