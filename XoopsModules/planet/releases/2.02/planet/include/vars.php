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
 
if(!defined("PLANET_INI")) define("PLANET_INI",1);

/* 
 * The prefix for database table name prefix
 * You can change to any term but be consistent with the table names in /sql/mysql.sql, and be unique , no conflict with other modules
 */
$GLOBALS["MOD_DB_PREFIX"] = "planet";

/* You are not supposed to modify following contents */
defined("FRAMEWORKS_ART_FUNCTIONS_INI") || require_once(XOOPS_ROOT_PATH."/Frameworks/art/functions.ini.php");
$GLOBALS["moddirname"] = mod_getDirname(__FILE__);

/* 
 * The prefix for module variables
 * You can change to any term but be unique, no conflict with other modules
 */
$GLOBALS["VAR_PREFIX"] = $GLOBALS["moddirname"];

/* 
 * The prefix for module language constants
 * You can chnage to any term but be capital and unique, no conflict with other modules
 */
$GLOBALS["VAR_PREFIXU"] = strtoupper($GLOBALS["moddirname"]);
require_once(XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/include/functions.ini.php");


// include customized variables
if( is_object($GLOBALS["xoopsModule"]) && $GLOBALS["moddirname"] == $GLOBALS["xoopsModule"]->getVar("dirname", "n") ) {
	$GLOBALS["xoopsModuleConfig"] = planet_load_config();
}

planet_load_object();
?>