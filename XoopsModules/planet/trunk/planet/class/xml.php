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


/*** GENERAL USAGE *********************************************************
$xml_handler =& xoops_getmodulehandler("xml", $xoopsModule->getVar("dirname"));
$xml = $xml_handler->create("RSS0.91");
$xml->setVar("title", $title);
$xml->setVar("description", $description);
$xml->setVar("descriptionHtmlSyndicated", true);
$xml->setVar("link", $link);
$xml->setVar("syndicationURL", $syndicationURL);

$image = array(
	"width" => $imagewidth,
	"height" => $height,
	"title" => $imagetitle,
	"url" => $imageurl,
	"link" => $imagelink,
	"description" => $imagedesc
	);

$item = array(
	"title" => $datatitle,
    "link" => $dataurl,
    "description" => $datadesc,
    "descriptionHtmlSyndicated" => true,
    "date" => $datadate,
    "source" => $datasource,
    "author" => $dataauthor
    );

$xml->setImage($image);
$xml->addItem($item);

$xml_handler->display($xml);
*/

// your local timezone, set to "" to disable or for GMT
$server_TZ = abs(intval($GLOBALS['xoopsConfig']['server_TZ']*3600.0));
$prefix = ($GLOBALS['xoopsConfig']['server_TZ']<0)?"-":"+";
$TIME_ZONE = $prefix.date("H:i",$server_TZ);
define("TIME_ZONE", $TIME_ZONE);
// Version string.
define("FEEDCREATOR_VERSION", "ARTICLE @ XOOPS powered by FeedCreator");

require_once(dirname(__FILE__)."/feedcreator.class.php");

/**
 * Description
 *
 * @param type $var description
 * @return type description
 * @link
 */
if(!class_exists("Xmlfeed")){
class Bxmlfeed extends UniversalFeedCreator
{
    var $version;
    var $filename= "";

    function Bxmlfeed($version)
    {
    	$this->filename= XOOPS_CACHE_PATH."/feed.xml";
        $this->version = $version;
    }

    function setVar($var, $val, $encoding = false)
    {
	    if(!empty($encoding)) $val = $this->convert_encoding($val);
        $this->$var = $val;
    }
    
    function convert_encoding($val)    
    {
	    if(is_array($val)){
		    foreach(array_keys($val) as $key){
			    $val[$key] = $this->convert_encoding($val[$key]);
		    }
	    }else{
		    $val = XoopsLocal::convert_encoding($val, $this->encoding, _CHARSET);
	    }
	    return $val;
    }

    function getVar($var)
    {
        return $this->$var;
    }

    function setImage(&$img)
    {
	    $image = new FeedImage();
	    foreach($img as $key=>$val){
		    $image->$key = $this->convert_encoding($val);
	    }
	    $this->setVar("image", $image);
    }

    function _addItem(&$itm)
    {
    	$item = new FeedItem();
	    foreach($itm as $key=>$val){
		    $item->$key = $this->convert_encoding($val);
	    }
	    $this->addItem($item);
    }

    function addItems(&$items)
    {
	    if(!is_array($items) || count($items)==0) return;
	    foreach($items as $item){
		    $this->_addItem($item);
	    }
    }
}
}

planet_parse_class('
class [CLASS_PREFIX]XmlHandler
{
    function &create($format = "RSS0.91")
    {
        $xmlfeed = new Bxmlfeed($format);
        return $xmlfeed;
    }

    function display(&$feed, $filename="", $display=false)
    {
	    if(!is_object($feed)) return null;
	    $filename=empty($filename)?$feed->filename:$filename;
	    if($display){
        	$feed->saveFeed($feed->version, $filename);
    	}else{
        	$feed->saveFeed($feed->version, $filename, false);
        	$content = implode("",file($filename));
        	return trim($content);
    	}
    }

    function insert(&$feed)
    {
	    $xml_data = array();
		$xml_data["version"] = $feed->version;
		$xml_data["encoding"] = $feed->encoding;
		$xml_data["image"] = $feed->image;
		$xml_data["items"] = $feed->items;

		return $xml_data;
    }

    function &get(&$feed)
    {
	    $xml_data = array();
		$xml_data["version"] = $feed->version;
		$xml_data["encoding"] = $feed->encoding;
		$xml_data["image"] = $feed->image;
		$xml_data["items"] = $feed->items;

		return $xml_data;
    }
}
');
?>