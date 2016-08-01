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

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
include_once dirname(__DIR__) . '/include/vars.php';
mod_loadFunctions('', $GLOBALS['moddirname']);

if (!class_exists('Xmlrpc_client')) {
    /**
     * Class Xmlrpc_client
     */
    class Xmlrpc_client
    {
        /**
         * Xmlrpc_client constructor.
         */
        public function __construct() {
        }

        /**
         * @param $article
         */
        public function setObject(&$article) {
            $this->$var = $val;
        }

        /**
         * @param $var
         * @param $val
         */
        public function setVar($var, $val) {
            $this->$var = $val;
        }

        /**
         * @param $var
         * @return mixed
         */
        public function getVar($var) {
            return $this->$var;
        }
    }
}

if (!class_exists('Xmlrpc_server')) {
    /**
     * Class Xmlrpc_server
     */
    class Xmlrpc_server
    {
        /**
         * Xmlrpc_server constructor.
         */
        public function __construct() {
        }

        /**
         * @param $var
         * @param $val
         */
        public function setVar($var, $val) {
            $this->$var = $val;
        }

        /**
         * @param $var
         * @return mixed
         */
        public function getVar($var) {
            return $this->$var;
        }
    }
}

planet_parse_class('
class [CLASS_PREFIX]XmlrpcHandler
{
    public function &get($type="c")
    {
        switch (strtolower($type)) {
            case "s":
            case "server":
            return new Xmlrpc_server();
            case "c":
            case "client":
            return new Xmlrpc_client();
        }
    }

    public function display(&$feed, $filename="")
    {
        if(!is_object($feed)) return null;
        $filename=empty($filename)?$feed->filename:$filename;
        echo $feed->saveFeed($feed->version, $filename);
    }

    public function utf8_encode(&$feed)
    {
        if(!is_object($feed)) return null;
        $text = xoops_utf8_encode(serialize($feed));
        $feed = unserialize($text);
    }
}
');
