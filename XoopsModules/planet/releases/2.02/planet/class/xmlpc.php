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
include_once dirname(dirname(__FILE__))."/include/vars.php";
mod_loadFunctions("", $GLOBALS["moddirname"]);

if(!class_exists("Xmlrpc_client")){
class Xmlrpc_client
{
    function Xmlrpc_client()
    {
    }

    function setObject(&$article)
    {
        $this->$var = $val;
    }

    function setVar($var, $val)
    {
        $this->$var = $val;
    }

    function getVar($var)
    {
        return $this->$var;
    }
}
}


if(!class_exists("Xmlrpc_server")){
class Xmlrpc_server
{

    function Xmlrpc_server()
    {
    }

    function setVar($var, $val)
    {
        $this->$var = $val;
    }

    function getVar($var)
    {
        return $this->$var;
    }
}
}

planet_parse_class('
class [CLASS_PREFIX]XmlrpcHandler
{
    function &get($type="c")
    {
		switch(strtolower($type)){
			case "s":
			case "server":
			return new Xmlrpc_server();
			case "c":
			case "client":
			return new Xmlrpc_client();
		}
    }

    function display(&$feed, $filename="")
    {
	    if(!is_object($feed)) return null;
	    $filename=empty($filename)?$feed->filename:$filename;
        echo $feed->saveFeed($feed->version, $filename);
    }

    function utf8_encode(&$feed)
    {
	    if(!is_object($feed)) return null;
		$text = xoops_utf8_encode(serialize($feed));
		$feed = unserialize($text);
    }
}
');
?>