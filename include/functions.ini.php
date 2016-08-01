<?php
//
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
// URL: http://xoops.org                         //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

/*

The functions loaded on initializtion
*/

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
if (!defined('PLANET_INI')) {
    exit();
}

if (!defined('PLANET_FUNCTIONS_INI')):
    define('PLANET_FUNCTIONS_INI', 1);

    /**
     * @param $name
     * @return mixed
     */
    function planet_constant($name) {
        return mod_constant($name);
    }

    /**
     * @param      $name
     * @param bool $isRel
     * @return string
     */
    function planet_DB_prefix($name, $isRel = false) {
        return mod_DB_prefix($name, $isRel);
    }

    /**
     * @return bool
     */
    function planet_load_object() {
        return load_object();
    }

    /**
     * @return array|mixed
     */
    function planet_load_config() {
        static $moduleConfig;
        if (isset($moduleConfig)) {
            return $moduleConfig;
        }

        if (is_object($GLOBALS['xoopsModule'])
            && $GLOBALS['xoopsModule']->getVar('dirname') == $GLOBALS['moddirname']
        ) {
            if (isset($GLOBALS['xoopsModuleConfig'])) {
                $moduleConfig = $GLOBALS['xoopsModuleConfig'];
            }
        } else {
            $moduleHandler = xoops_getHandler('module');
            $module        = $moduleHandler->getByDirname($GLOBALS['moddirname']);

            $config_handler = xoops_getHandler('config');
            $criteria       = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
            $configs        = $config_handler->getConfigs($criteria);
            foreach (array_keys($configs) as $i) {
                $moduleConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
            }
            unset($configs);
        }
        if ($customConfig = @include XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['moddirname'] . '/include/plugin.php') {
            $moduleConfig = array_merge($moduleConfig, $customConfig);
        }

        return $moduleConfig;
    }

    function planet_define_url_delimiter() {
        if (defined('URL_DELIMITER')) {
            if (!in_array(URL_DELIMITER, array('?', '/'))) {
                die('Exit on security');
            }
        } else {
            $moduleConfig = planet_load_config();
            if (empty($moduleConfig['do_urw'])) {
                define('URL_DELIMITER', '?');
            } else {
                define('URL_DELIMITER', '/');
            }
        }
    }

endif;
