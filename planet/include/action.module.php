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

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

include dirname(__FILE__)."/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

planet_parse_function('
function xoops_module_install_[DIRNAME](&$module)
{
    @$GLOBALS["xoopsDB"]->queryFromFile(XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/sql/mysql.data.sql");
	return true;
}

function xoops_module_pre_install_[DIRNAME](&$module)
{
	$mod_tables = $module->getInfo("tables");
	foreach($mod_tables as $table){
		$GLOBALS["xoopsDB"]->queryF("DROP TABLE IF EXISTS ".$GLOBALS["xoopsDB"]->prefix($table).";");
	}
	return [DIRNAME]_setModuleConfig($module);
}

function xoops_module_pre_update_[DIRNAME](&$module)
{
	return [DIRNAME]_setModuleConfig($module);
}

function xoops_module_update_[DIRNAME](&$module)
{
	load_functions("config");
	mod_clearConfg($module->getVar("dirname", "n"));

	return true;
}

function [DIRNAME]_setModuleConfig(&$module)
{

	$modconfig =& $module->getInfo("config");
	$count = count($modconfig);
	$flag=0;
	for($i=0;$i<$count;$i++){
		if($modconfig[$i]["name"]=="theme_set"){
			$modconfig[$i]["options"][_NONE] = "0";			
		    foreach ($GLOBALS["xoopsConfig"]["theme_set_allowed"] as $theme) {
				$modconfig[$i]["options"][$theme] = $theme;
		    }
			$flag ++;
		}
		if($flag>=1) {
			break;
		}
	}
	//$module->setInfo("config", $modconfig);
	return true;	
}
');
?>